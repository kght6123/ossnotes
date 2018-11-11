<?php
declare(strict_types=1);

// namespace はベンダー名\アプリ名\パッケージ名\クラス名 間違うとエラー
namespace kght6123\ossnote\api\google;

use Google_Client;
use Google_Service_Drive;
use Google_Service_Tasks;
use Google_Service_Drive_DriveFile;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

require_once __DIR__ . '/Auth.php';
use kght6123\ossnote\api\google\Auth;

require_once __DIR__ . '/../../Common.php';
use kght6123\ossnote\Common;

/**
 * Driveクラス
 *   Google Driveにアクセスするクラス
 * 
 * http://localhost:18080/api/google/Drive.php?userid=koga&password=koga&q=%27root%27%20in%20parents&pageSize=10&fields=nextPageToken%2c%20files%28id%2cname%2cwebViewLink%2cmimeType%29
 * 
 * http://localhost:18080/api/google/Drive.php?userid=koga&password=koga&fileId=1HaYg3IV7wzdasuuo6bL4Lc4ZgDQhWZuA&fields=id%2cname%2cparents%2cwebContentLink%2cwebViewLink%2cdescription%2cmimeType
 * 
 * curl -i "http://localhost:18080/api/google/Drive.php" -X POST -d "userid=koga&password=koga&fileId=1HaYg3IV7wzdasuuo6bL4Lc4ZgDQhWZuA&fields=id%2cname%2cparents%2cwebContentLink%2cwebViewLink%2cdescription%2cmimeType&data=HelloworldUpdate"
 * 
 * curl -i "http://localhost:18080/api/google/Drive.php" -X PUT -d "userid=koga&password=koga&name=folder&mimeType=application%2fvnd%2egoogle%2dapps%2efolder&parents=root&description=&fields=id%2cname%2cparents"
 * 
 * curl -i "http://localhost:18080/api/google/Drive.php" -X PUT -d "userid=koga&password=koga&name=sample.md&mimeType=text%2fmarkdown&parents=root&description=&fields=id%2cname%2cparents&data=Helloworld&uploadType=multipart&useContentAsIndexableText=true"
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
				$common = new Common();
				$stdOptKeys = array('alt', 'fields', 'prettyPrint', 'quotaUser', 'userIp' );

				switch ($_SERVER['REQUEST_METHOD']) {
				case 'POST':
					$this->logger->info('post Drive.');
					$this->logger->debug(json_encode($common->getRequestParameter()));

					// ファイルIDを取得
					$fileId = $common->getParamString('fileId');

					// リクエストパラメータから、updateのパラメータを取り出す
					$updateOptKeys = array('addParents', 'keepRevisionForever', 'ocrLanguage', 'removeParents', 'supportsTeamDrives', 'useContentAsIndexableText', 'data');
					$updateOpts = $common->getParamArrayString(array_merge($stdOptKeys, $updateOptKeys));

					// updateを実行
					$file = $service->files->update($fileId, $this->getDriveFile(), $updateOpts);

					// updateの結果を格納
					$this->setDriveFile($file, $login);
					break;
					
				case 'PUT':
					$this->logger->info('put Drive.');
					$this->logger->debug(json_encode($common->getRequestParameter()));

					// リクエストパラメータから、createのパラメータを取り出す
					$createOptKeys = array('ignoreDefaultVisibility', 'keepRevisionForever', 'ocrLanguage', 'supportsTeamDrives', 'useContentAsIndexableText', 'data');
					$createOpts = $common->getParamArrayString(array_merge($stdOptKeys, $createOptKeys));

					// createを実行
					$file = $service->files->create($this->getDriveFile(), $createOpts);

					// createの結果を格納
					$this->setDriveFile($file, $login);
					break;

				case 'DELETE':
					$this->logger->info('delete Drive.');
					$this->logger->debug(json_encode($common->getRequestParameter()));

					// ファイルIDを取得
					$fileId = $common->getParamString('fileId');

					// リクエストパラメータから、deleteのパラメータを取り出す
					$deleteOptKeys = array('supportsTeamDrives');
					$deleteOpts = $common->getParamArrayString(array_merge($stdOptKeys, $deleteOptKeys));

					// delete
					$service->files->delete($fileId, $deleteOpts);
					break;

				case 'GET':
					$this->logger->info('get Drive.');
					$this->logger->debug(json_encode($common->getRequestParameter()));

					// ファイルIDを取得
					$fileId = $common->getParamString('fileId');

					if (empty($fileId)) {
						$this->logger->info('get Drive -> listfiles.');

						// GETリクエストパラメータから、listFilesのパラメータだけ取り出す。
						// https://developers.google.com/resources/api-libraries/documentation/drive/v3/php/latest/class-Google_Service_Drive_Files_Resource.html#_listFiles
						$optParamKeys = array('corpora', 'corpus', 'includeTeamDriveItems', 'orderBy', 'pageSize', 'pageToken', 'q', 'spaces', 'supportsTeamDrives',  'teamDriveId');
						$optParams = $common->getParamArrayString(array_merge($stdOptKeys, $optParamKeys));
						$this->logger->debug(json_encode($optParams));

						// qパラメータの詳細
						// https://developers.google.com/drive/api/v3/reference/query-ref
						
						// listFilesの実行
						// https://developers.google.com/resources/api-libraries/documentation/drive/v3/php/latest/class-Google_Service_Drive_Files_Resource.html
						$filelist = $service->files->listFiles($optParams);
						
						// ファイルリストから、結果を取り出して連想配列にする。
						$filelistTmp = array();
						// https://developers.google.com/resources/api-libraries/documentation/drive/v3/php/latest/class-Google_Service_Drive_FileList.html
						foreach ($filelist->getFiles() as $item) {
							// https://developers.google.com/resources/api-libraries/documentation/drive/v3/php/latest/class-Google_Service_Drive_DriveFile.html
							$filelistTmp[] = array(
								// fieldsで指定された属性だけ返す？
								'name' => $item->name,
								'id' => $item->id,
								'kind' => $item->getKind(),
								'webViewLink' => $item->getWebViewLink(),
								'mimeType' => $item->getMimeType(),
								'description' => $item->getDescription(),
								'iconLink' => $item->getIconLink(),
								'size' => $item->getSize(),
								'thumbnailLink' => $item->getThumbnailLink(),
								'webContentLink' => $item->getWebContentLink(),
							);
						}
						$login['filelist'] = $filelistTmp;
					} else {
						$this->logger->info("get Drive -> get(fileId=$fileId).");

						// リクエストパラメータから、getのパラメータを取り出す
						$getOptKeys = array('acknowledgeAbuse', 'supportsTeamDrives');
						$getOpts = $common->getParamArrayString(array_merge($stdOptKeys, $getOptKeys));
						$this->logger->debug(json_encode($getOpts));

						// get -> ファイルの内容は「webContentLink」からダウンロード？
						$file = $service->files->get($fileId, $getOpts);
						$this->logger->debug(json_encode($file));

						// getの結果を格納
						$this->setDriveFile($file, $login);
					}
					break;
				}
			}
		}
		return $login;
	}

	function getDriveFile(): Google_Service_Drive_DriveFile {

		$common = new Common();

		// リクエストパラメータから、DriveFileのパラメータだけ取り出す。
		$driveFileOptKeys = array('name', 'mimeType', 'parents', 'description');
		$driveFileOpts = $common->getParamArrayString($driveFileOptKeys);

		return new Google_Service_Drive_DriveFile($driveFileOpts);
	}

	function setDriveFile(Google_Service_Drive_DriveFile $file, array &$login/* 参照渡し */): void {
		$login['id'] = $file->id;
		$login['name'] = $file->name;
		$login['parents'] = $file->parents;
		$login['mimeType'] = $file->mimeType;
		$login['description'] = $file->description;
		$login['webContentLink'] = $file->webContentLink;
		$login['webViewLink'] = $file->webViewLink;
	}
}
session_start();

$common = new Common();
$userid = $common->getParamString('userid');
$password = $common->getParamString('password');

$drive = new Drive();
$json = $drive->doAction($userid, $password);

header("Content-Type: application/json; charset=utf-8");
header("X-Content-Type-Options: nosniff");
echo json_encode($json);
