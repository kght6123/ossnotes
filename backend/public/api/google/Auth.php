<?php
declare(strict_types=1);

// namespace はベンダー名\アプリ名\パッケージ名\クラス名 間違うとエラー
namespace kght6123\ossnote\api\google;

const HOME = "/../../../";

require __DIR__ . HOME . 'vendor/autoload.php';

use Google_Client;
use Google_Service_Drive;
use Google_Service_Tasks;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Authクラス
 *   GoogleにOAuth認証するクラス
 * 
 * http://localhost:18080/api/google/login.php?userid=koga&password=koga
 * 
 * curl -i "http://localhost:18080/api/google/login.php?userid=kght6123&password=kght6123"
 * curl -i "http://localhost:18080/api/google/login.php" -X POST -d "todo=think"
 * 
 */
class Auth {
	private $logger;
	private $credentialsFilePath;
	
	function __construct() {
		$this->credentialsFilePath = __DIR__ . HOME . 'credentials.json';
		$this->logger = new Logger('api\google\login');
		$this->logger->pushHandler(
				new StreamHandler('php://stdout', Logger::DEBUG)
		);
	}

	/**
	 * ossnoteにログインするgetを呼び出す
	 */
	public function doLogin(string $userid, string $password): array {

		if(empty($userid))
			return ['result' => 'false', 'auth' => 'false', message => "not found userid."];
		if(empty($password))
			return ['result' => 'false', 'auth' => 'false', message => "not found password."];
		
		$login = (new \BEAR\Package\Bootstrap)
			->getApp('kght6123\ossnote', PHP_SAPI === 'cli' ? 'cli-hal-api-app' : 'hal-api-app', __DIR__ . HOME)
			->resource->get->uri('app://self/login')(['userid' => $userid, 'password' => $password])
			->body;
		
		return $login;
	}

	/**
	 * ossnoteにログインした結果をチェック
	 */
	public function isLogin(array $login): bool {
		if(strcmp($login['result'], 'true') == 0) {
			$this->logger->info(sprintf('login ok [%s]', var_export($login, true)));
			return true;
		} else {
			$this->logger->error(sprintf('login ng. [%s]', $login['result']));
			return false;
		}
	}

	/**
	 * ossnoteのログイン情報からGoogle_Clientを作成する
	 */
	public function getClient(array $login): ?Google_Client {

		if (file_exists($this->credentialsFilePath)) {
			$this->logger->info('credentialsFile ok');

			$client = new Google_Client();
			$client->setApplicationName('kght6123/ossnote');
			$client->addScope(Google_Service_Drive::DRIVE);
			$client->addScope(Google_Service_Tasks::TASKS);
			$client->setIncludeGrantedScopes(true);
			$client->setAuthConfig($this->credentialsFilePath);
			$client->setAccessType('offline');
			$client->setPrompt('select_account consent');
			$client->setRedirectUri(
				(empty($_SERVER['HTTPS']) ? 'http://' : 'https://')
				 . $_SERVER['HTTP_HOST'] // . ':' . $_SERVER['SERVER_PORT']
				 . strtok($_SERVER["REQUEST_URI"],'?'));
			
			if(empty($login['gtoken']) == false) {
				$this->logger->info('set AccessToken.');
				$client->setAccessToken(json_decode($login['gtoken'], true));
			}
			return $client;
		} else {
			$this->logger->error(sprintf('not found credentialsFile. [%s]', $this->credentialsFilePath));
			return null;
		}
	}

	public function doAuth(string $userid, string $password, string $authCode): array {

		// ログイン認証＆ログイン情報取得
		$login = 
			$this->doLogin($userid, $password);
		
		if($this->isLogin($login)) {
			// 認証OK Google認証クライアント作成
			$client = $this->getClient($login);
			if (isset($client)) {
				// Google認証クライアント作成OK
				if ($client->isAccessTokenExpired()) {
					$this->logger->info('expired AccessToken.');
					
					if ($client->getRefreshToken()) {
						$this->logger->info('refresh AccessToken.');
						$client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
						$this->doUpdateAccessToken($client->getAccessToken(), $login, $password);
						
					} else if(empty($authCode) == false) {
						$this->logger->info('set authCode.');
						$accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
						
						if (array_key_exists('error', $accessToken)) {
							$this->logger->error(sprintf('accessToken error. [%s]', join(', ', $accessToken)));
						} else {
							$this->logger->info('update accessToken.');
							//$client->setAccessToken($accessToken);
							$this->doUpdateAccessToken($accessToken, $login, $password);
						}
					} else {
						$this->logger->info('create AuthUrl.');
						$login['authUrl'] = $client->createAuthUrl();
						$this->logger->info("authUrl={$login['authUrl']}");
					}
				}
			}
		}
		return $login;
	}

	private function doUpdateAccessToken(array $accessToken, array $login, string $password) {
		$gtoken = json_encode($accessToken);
		$body = (new \BEAR\Package\Bootstrap)
			->getApp('kght6123\ossnote', PHP_SAPI === 'cli' ? 'cli-hal-api-app' : 'hal-api-app', __DIR__ . HOME)
			->resource->put->uri('app://self/login')([
				'userid' => $login['userid'],
				'password' => $password,
				'newPassword' => $password,
				'email' => $login['email'],
				'markdown' => $login['markdown'],
				'gtoken' => $gtoken])
			->body;

		if(strcmp($body['result'], 'true') == 0) {
			$this->logger->info(sprintf('update AccessToken ok [%s]', $gtoken));
		} else {
			$this->logger->error(sprintf('update AccessToken error [%s][%s]', $gtoken, $body['result']));
		}
	}
}