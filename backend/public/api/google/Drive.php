<?php
declare(strict_types=1);

// namespace はベンダー名\アプリ名\パッケージ名\クラス名 間違うとエラー
namespace kght6123\ossnote\api\google;

use Google_Client;
use Google_Service_Drive;
use Google_Service_Tasks;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

require_once __DIR__ . '/Auth.php';
use kght6123\ossnote\api\google\Auth;

/**
 * Driveクラス
 *   Google Driveにアクセスするクラス
 * 
 * http://localhost:18080/api/google/Drive.php?userid=koga&password=koga
 * 
 * curl -i "http://localhost:18080/api/google/login.php?userid=kght6123&password=kght6123"
 * curl -i "http://localhost:18080/api/google/login.php" -X POST -d "todo=think"
 * 
 */
class Drive {
	private $logger;
	
	function __construct() {
		$this->logger = new Logger('api\google\drive');
		$this->logger->pushHandler(
				new StreamHandler('php://stdout', Logger::DEBUG)
		);
	}

	function doAction(string $userid, string $password) {
		
		$this->logger->info('auth ossnote.');
		$glogin = new Auth();
		$login = 
			$glogin->doLogin(
				$userid,
				$password);

		if($glogin->isLogin($login)) {
			$this->logger->info('create Google_Client.');
			$client = $glogin->getClient($login);

			if (isset($client)) {
				$this->logger->info('create Google_Service_Drive.');
				$service = new Google_Service_Drive($client);
				
				$method = $_SERVER["REQUEST_METHOD"];
				
				if (strcmp($method, "GET") == 0) {
					$this->logger->info('get Drive.');

				} elseif (strcmp($method, "POST") == 0) {
					$this->logger->info('post Drive.');

				}
				return $login;

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
			}
		}
		return $login;
	}
}
session_start();

$userid = (string)filter_input(INPUT_GET, 'userid');
$password = (string)filter_input(INPUT_GET, 'password');

$drive = new Drive();
$json = $drive->doAction($userid, $password);

header("Content-Type: application/json; charset=utf-8");
header("X-Content-Type-Options: nosniff");
echo json_encode($json);
