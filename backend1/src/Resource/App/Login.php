<?php
declare(strict_types=1);

// namespace はベンダー名\アプリ名\パッケージ名\クラス名 間違うとエラー
namespace kght6123\ossnote\Resource\App;

use BEAR\Package\Annotation\ReturnCreatedResource;
use BEAR\RepositoryModule\Annotation\Cacheable;
use BEAR\Resource\ResourceObject;
use Ray\AuraSqlModule\AuraSqlInject;

use kght6123\ossnote\Resource\BaseResourceObject;

/**
 * Loginクラス
 * 
 *  $ mkdir var/db
 *  $ sqlite3 var/db/todo.sqlite3 # DB作成＆接続
 *  sqlite> create table if not exists user(userid text primary key not null, password text not null, email text, markdown blob, gtoken blob, create_dt text not null, update_dt text not null); # Table作成
 *  sqlite> .exit
 *  
 *  $ php bin/app.php post '/todos?todo=shopping' # 登録 /todo/?id=1
 *  $ php bin/app.php get '/todos?id=1' # 取得
 *  $ php bin/app.php put '/todos?id=1&todo=shopping2' # 更新
 *  $ php bin/app.php get '/todos?id=1' # 取得
 *  $ php bin/app.php delete '/todos?id=1' # 削除
 *  $ php bin/app.php get '/todos?id=1' # 取得
 *  
 *  $ curl -i "http://127.0.0.1:8080/todos?id=1"
 *  $ curl -i "http://127.0.0.1:8080/todos" -X POST -d "todo=think"
 *  $ curl -i "http://127.0.0.1:8080/todos?id=1"
 * 
 *  $ curl -i "http://127.0.0.1:8080/todos" -X PUT -H 'Content-Type: application/json' -d '{"id": "1", "todo":"think2" }'
 *  $ curl -i "http://127.0.0.1:8080/todos?id=1"
 */
class Login extends BaseResourceObject
{
	use AuraSqlInject;
	
	private function init(): void {
		$statement = $this->pdo->prepare('create table if not exists user (userid text primary key not null, password text not null, email text, markdown blob, gtoken blob, create_dt text not null, update_dt text not null);');
		$statement->execute();
	}
	
	public function auth(string $userid, string $password): ?array {
		$sql = 'select * from user where userid = :user';
		$bind = ['user' => $userid];
		$user = 
				$this->pdo->fetchOne($sql, $bind);
		
		if (empty($user) || !password_verify($password, $user['password']))
			return null;
		else {
			return $user;
		}
	}

	private function ok(): void {
		$this->body['result'] = 'true';
	}
	private function ng(): void {
		$this->body['result'] = 'false';
	}

	public function onGet(string $userid, string $password): ResourceObject {
		$this->init();
		$user = $this->auth($userid, $password);
		
		if (is_null($user))
			$this->ng();// bodyにログインNGを格納
		else {
			$this->body = $user;
			$this->ok();
		}
		$this->code = 200;
		return $this;
	}
	public function onPost(string $userid, string $password, string $email, string $markdown, string $gtoken): ResourceObject {
		$this->init();

		$sql = 'insert into user (userid, password, email, markdown, gtoken, create_dt, update_dt) values (:user, :pass, :email, :markdown, :gtoken, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)';
		$bind = [
			'user'     => $userid,
			'pass'     => password_hash($password, PASSWORD_DEFAULT),
			'email'    => $email,
			'markdown' => $markdown,
			'gtoken'   => $gtoken,
		];
		$statement = $this->pdo->prepare($sql);
		$statement->execute($bind);

		$this->code = 201;
		return $this;
	}
	public function onPut(string $userid, string $password, string $newPassword, string $email, string $markdown, string $gtoken): ResourceObject {
		$this->init();
		$user = $this->auth($userid, $password);

		if (is_null($user)) {
			// 認証NG
			$this->ng();
		} else {
			// 認証OK
			$sql = 'update user set password = :pass, email = :email, markdown = :markdown, gtoken = :gtoken, update_dt = CURRENT_TIMESTAMP where userid = :user';
			$bind = [
				'user'     => $userid,
				'pass'     => password_hash($newPassword, PASSWORD_DEFAULT),
				'email'    => $email,
				'markdown' => $markdown,
				'gtoken'   => $gtoken,
			];
			$statement = $this->pdo->prepare($sql);
			$statement->execute($bind);
			$this->ok();
		}
		$this->code = 204;
		return $this;
	}
	public function onDelete(string $userid, string $password): ResourceObject {
		$this->init();
		$user = $this->auth($userid, $password);
		
		if (is_null($user)) {
			// 認証NG
			$this->ng();
		} else {
			// 認証OK
			$sql = 'delete from user where userid = :user';
			$bind = ['user' => $userid];
			$statement = $this->pdo->prepare($sql);
			$statement->execute($bind);
			$this->ok();
		}
		$this->code = 201;
		return $this;
	}
}