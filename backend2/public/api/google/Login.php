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

require_once __DIR__ . '/../../Common.php';
use kght6123\ossnote\Common;

/**
 * Loginクラス
 *   GoogleにOAuth認証するクラス
 * 
 * http://localhost:18080/api/google/Login.php?userid=koga&password=koga
 * 
 * curl -i "http://localhost:18080/api/google/login.php?userid=kght6123&password=kght6123"
 * curl -i "http://localhost:18080/api/google/login.php" -X POST -d "todo=think"
 */
session_start();

$common = new Common();

$code = $common->getParamString('code');
$error = $common->getParamString('error');
$login = new Auth();

if(empty($code) == false) {
	$userid = $_SESSION['userid'];
	$password = $_SESSION['password'];
	$json = 
	$login->doAuth(
		$userid,
		$password,
		$code);
	
} else if(empty($error) == false) {
	$json = [
		'error' => $error,
		'userid' => $_SESSION['userid'],
		'password' => $_SESSION['password']];

} else {
	$userid = $common->getParamString('userid');
	$password = $common->getParamString('password');
	// $login = (new \BEAR\Package\Bootstrap)
	// 			->getApp('kght6123\ossnote', PHP_SAPI === 'cli' ? 'cli-hal-api-app' : 'hal-api-app', __DIR__ . HOME)
	// 			->resource->post->uri('app://self/login')(['userid' => $userid, 'password' => $password, 'email' => 'a@a.com', 'markdown' => '# AAA' ])
	// 			->body;
	$json = 
		$login->doAuth(
			$userid,
			$password,
			'');
	
	$_SESSION['userid']   = $userid;
	$_SESSION['password'] = $password;
}

header("Content-Type: application/json; charset=utf-8");
header("X-Content-Type-Options: nosniff");
echo json_encode($json);
