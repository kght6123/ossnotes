<?php
declare(strict_types=1);

// namespace はベンダー名\アプリ名\パッケージ名\クラス名 間違うとエラー
namespace kght6123\ossnote\Resource\App;

use BEAR\Package\Annotation\ReturnCreatedResource;
use BEAR\RepositoryModule\Annotation\Cacheable;
use BEAR\Resource\ResourceObject;

/**
 * Gloginクラス
 * 
 * GoogleDriveを操作するクラス
 * 
 *  $ php bin/app.php post '/glogin?path=welcome.md' # 取得
 */
class Glogin extends ResourceObject
{
	public $headers = ['access-control-allow-origin' => '*']; // これがないとCrossDomainエラー

	public function onGet(string $path): ResourceObject {
		// Select セキュリティ的に使わない
		return $this;
	}
	public function onPost(string $path): ResourceObject {
		// Insert user/pass必須 毎回、認証する
		// login情報にtokenあって期限が切れてなければOK返す。
		// tokenなかったり有効期限がキレてたら、authUrlとNGを返す。
		// $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . ':' . $_SERVER['SERVER_PORT'] . '/〜.php');を設定。
		//  （$_SERVER['HTTPS']はSSLならば空以外、80・443ならばポート番号指定は要らないかも）
		// Redirectされて、authCodeがあったらtoken作ってDBに保管する。
		//   authCodeがなければエラー
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