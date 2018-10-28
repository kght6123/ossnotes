<?php
declare(strict_types=1);

// namespace はベンダー名\アプリ名\パッケージ名\クラス名 間違うとエラー
namespace kght6123\ossnote\Resource\App;

//require_once '/Users/kogahirotaka/develop/bear.sunday/kght6123.ossnotes/backend/vendor/autoload.php';

use BEAR\Package\Annotation\ReturnCreatedResource;
use BEAR\RepositoryModule\Annotation\Cacheable;
use BEAR\Resource\ResourceObject;
use BEAR\AppMeta\AbstractAppMeta;

// 他のResourceを呼ぶためのResourceInjectをインポート
use BEAR\Sunday\Inject\ResourceInject;

// logger
use Psr\Log\LoggerInterface;
use Ray\Di\Di\Inject;

//use google\apiclient\Google_Client;
//use Google\Service\Google_Client;
//use Google\Client;

use kght6123\ossnote\Annotation\BenchMark;
use kght6123\ossnote\Resource\BaseResourceObject;

//require_once (dirname(__FILE__) . '/../../../autoload.php');
//require __DIR__ . '/../../../autoload.php';
//require __DIR__ . '/../../../vendor/autoload.php';
//require __DIR__ . '/../../../vendor/google/apiclient/src/Google/autoload.php';

//composer dumpautoload
//composer dumpautoload -o

/**
 * Gloginクラス
 * 
 * Googleにログインするクラス
 * 
 *  $ php bin/app.php post '/glogin?path=welcome.md' # 取得
 */
class Glogin extends BaseResourceObject
{
	use ResourceInject;
	//use Google_Client;
	
	private $credentialsFilePath;
	//private $autoloadFilePath;

	/**
	 * @Inject
	 */
	function __construct(LoggerInterface $logger, AbstractAppMeta $meta) {
		parent::__construct($logger);
		$this->credentialsFilePath = $meta->appDir . '/credentials.json';
		//$this->autoloadFilePath = $meta->appDir . '/vendor/autoload.php';
	}

	/**
	 * @BenchMark
	 */
	public function onPost(string $userid, string $password, string $path): ResourceObject {
		// Insert
		// user/pass必須 毎回、認証する
		$this->body = [
			'login' => $this->resource->get('app://self/login', ['userid' => $userid, 'password' => $password])->body
		];
		if(strcmp($this->body['login']['result'], 'true') == 0) {
			$this->logger->info('login ok.');
			
			if (file_exists($this->credentialsFilePath)) {
				//$this->logger->info("create client. $this->autoloadFilePath");

				//include_once $this->autoloadFilePath;

				$client = new Google_Client();
				$client->setApplicationName('kght6123/ossnote');
				$client->addScope(Google_Service_Drive::DRIVE);
				$client->addScope(Google_Service_Tasks::TASKS);
				$client->setAuthConfig($this->credentialsFilePath);
				$client->setAccessType('offline');
				$client->setPrompt('select_account consent');
				
				if(empty($this->body['login']['gtoken']) == false) {
					$this->logger->info('set gtoken.');
					$client->setAccessToken(json_decode($this->body['login']['gtoken'], true));
				}
				if ($client->isAccessTokenExpired()) {
					$this->logger->info('expired AccessToken.');
					
					if ($client->getRefreshToken()) {
						$this->logger->info('refresh AccessToken.');
						$client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
	
					} else {
						$this->logger->info('create AuthUrl.');
						$this->body['authUrl'] = $client->createAuthUrl();
	
						// printf("Open the following link in your browser:\n%s\n", $authUrl);
						// print 'Enter verification code: ';
						// $authCode = trim(fgets(STDIN));
			
						// // Exchange authorization code for an access token.
						// $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
						// $client->setAccessToken($accessToken);
			
						// // Check to see if there was an error.
						// if (array_key_exists('error', $accessToken)) {
						// 		throw new Exception(join(', ', $accessToken));
						// }
					}
					$this->body['auth'] = 'true';// とりあえずココでOK

					// Save the token to a file.
					// if (!file_exists(dirname($tokenPath))) {
					// 	mkdir(dirname($tokenPath), 0700, true);
					// }
					// file_put_contents($tokenPath, json_encode($client->getAccessToken()));
				}
			} else {
				$this->logger->error(sprintf('not found credentialsFile. [%s]', $credentialsFilePath));
			}
		} else {
			$this->logger->error(sprintf('login ng. [%s]', $this->body['login']['result']));
		}
		
		// login情報にtokenあって期限が切れてなければOK返す。
		// tokenなかったり有効期限がキレてたら、authUrlとNGを返す。
		// $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . ':' . $_SERVER['SERVER_PORT'] . '/〜.php');を設定。
		//  （$_SERVER['HTTPS']はSSLならば空以外、80・443ならばポート番号指定は要らないかも）
		// Redirectされて、authCodeがあったらtoken作ってDBに保管する。
		//   authCodeがなければエラー

		$this->code = 201;
		return $this;
	}
	public function onPut(string $path, string $file): ResourceObject {
		// Update
		return $this;
	}
	public function onDelete(string $path): ResourceObject {
		// Delete
		return $this;
	}
}