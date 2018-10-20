<?php
// php sample/drive/quickstart.php
require __DIR__ . '/../../vendor/autoload.php';

if (php_sapi_name() != 'cli') {
    throw new Exception('This application must be run on the command line.');
}

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient()
{
	$client = new Google_Client();
	$client->setApplicationName('Google Drive API PHP Quickstart');
	$client->addScope(Google_Service_Drive::DRIVE);// DRIVE,DRIVE_FILE(このアプリで作った情報のみ),DRIVE_METADATA_READONLY
	$client->addScope(Google_Service_Tasks::TASKS);
	$client->setAuthConfig('credentials.json');
	$client->setAccessType('offline');
	$client->setPrompt('select_account consent');

	// Load previously authorized token from a file, if it exists.
	$tokenPath = 'token.json';
	if (file_exists($tokenPath)) {
		$accessToken = json_decode(file_get_contents($tokenPath), true);
		$client->setAccessToken($accessToken);
	}

	// If there is no previous token or it's expired.
	if ($client->isAccessTokenExpired()) {
		// Refresh the token if possible, else fetch a new one.
		if ($client->getRefreshToken()) {
			$client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
		} else {
			// Request authorization from the user.
			$authUrl = $client->createAuthUrl();
			printf("Open the following link in your browser:\n%s\n", $authUrl);
			print 'Enter verification code: ';
			$authCode = trim(fgets(STDIN));

			// Exchange authorization code for an access token.
			$accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
			$client->setAccessToken($accessToken);

			// Check to see if there was an error.
			if (array_key_exists('error', $accessToken)) {
					throw new Exception(join(', ', $accessToken));
			}
		}
		// Save the token to a file.
		if (!file_exists(dirname($tokenPath))) {
			mkdir(dirname($tokenPath), 0700, true);
		}
		file_put_contents($tokenPath, json_encode($client->getAccessToken()));
	}
	return $client;
}

// Get the API client and construct the service object.
$client = getClient();

// Drive
$service = new Google_Service_Drive($client);

// Create Upload Folder MetaData.
$fileMetadata = new Google_Service_Drive_DriveFile(array(
	'name' => 'sample',
	'mimeType' => 'application/vnd.google-apps.folder',
	'parents' => array('root'),// 親フォルダのID
));

// Start Create Upload Folder
$folder = $service->files->create($fileMetadata, array(
	'fields'=>'id,name,parents'));

printf("Folder ID: %s\n", $folder->id);
printf("Name: %s\n", $folder->name);
printf("Parents ID: %s\n", $folder->parents[0]);

// Create Upload File MetaData.
$fileMetadata = new Google_Service_Drive_DriveFile(array(
	'name' => 'photo.jpg',
	'mimeType' => 'image/jpeg',
	'parents' => array($folder->id),
));

// Get Upload Contents.
$content = file_get_contents(__DIR__ . '/files/photo.jpg');

// Start Upload
$upFile = $service->files->create($fileMetadata, array(
	'data' => $content,
	'mimeType' => 'image/jpeg',
	'uploadType' => 'multipart',
	'fields' => 'id,name,parents'));

printf("File ID: %s\n", $upFile->id);
printf("Name: %s\n", $upFile->name);
printf("Parents ID: %s\n", $upFile->parents[0]);

// Print the names and IDs for up to 10 files.
$optParams = array(
	'q' => "'root' in parents",
	'pageSize' => 10,
	'fields' => 'nextPageToken, files(id,name,webViewLink,mimeType)',
	// 'pageToken' => pageToken, // 次のページのToken
);
// https://developers.google.com/resources/api-libraries/documentation/drive/v3/php/latest/class-Google_Service_Drive_Files_Resource.html
$results = $service->files->listFiles($optParams);

// https://developers.google.com/resources/api-libraries/documentation/drive/v3/php/latest/class-Google_Service_Drive_FileList.html
if (count($results->getFiles()) == 0) {
	print "No files found.\n";
} else {
	print "Files:\n";
	foreach ($results->getFiles() as $item) {
		// https://developers.google.com/resources/api-libraries/documentation/drive/v3/php/latest/class-Google_Service_Drive_DriveFile.html
		printf("%s (%s,%s,%s)\n", $item->name, $item->id, $item->getWebViewLink(), $item->getMimeType());
	}
}

// Tasks
$service = new Google_Service_Tasks($client);

// Print the first 10 task lists.
$optParams = array(
  'maxResults' => 100,
);

// getTasklists
// https://developers.google.com/resources/api-libraries/documentation/tasks/v1/php/latest/class-Google_Service_Tasks_Tasklists_Resource.html#_listTasklists
$tasklists = $service->tasklists->listTasklists($optParams);

if (count($tasklists->getItems()) == 0) {
	print "No task lists found.\n";
} else {
	print "Task lists:\n";
	foreach ($tasklists->getItems() as $tasklist) {
		// https://developers.google.com/resources/api-libraries/documentation/tasks/v1/php/latest/class-Google_Service_Tasks_TaskList.html
		printf("%s (%s)\n", $tasklist->getTitle(), $tasklist->getId());

		// getTasks
		// https://developers.google.com/resources/api-libraries/documentation/tasks/v1/php/latest/class-Google_Service_Tasks_Tasks_Resource.html
		$tasks = $service->tasks->listTasks($tasklist->getId(), $optParams);
		foreach ($tasks->getItems() as $task) {
			// https://developers.google.com/resources/api-libraries/documentation/tasks/v1/php/latest/class-Google_Service_Tasks_Task.html
			printf("\t Task: %s %s (%s)\n", $task->getTitle(), $task->getId(), $task->getNotes());

			// getLinks
			foreach ($task->getLinks() as $link) {
				// https://developers.google.com/resources/api-libraries/documentation/tasks/v1/php/latest/class-Google_Service_Tasks_TaskLinks.html
				printf("\t\t Task link: %s %s\n", $link->getLink(), $link->setDescription());
			}
		}
	}
}