<?php

// namespace はベンダー名\アプリ名\パッケージ名\クラス名 テスト対象と合わせる
namespace kght6123\ossnote\Resource\App;

use BEAR\Package\AppInjector;
use BEAR\Resource\ResourceInterface;
use PHPUnit\Framework\TestCase;
use kght6123\ossnote\Resource\App\BaseTestCase;

/** 
 * LoginTestクラス
 */
class LoginTest extends BaseTestCase {

	private $url = 'app://self/login';

	protected function regist(string $userid, string $password): void {
		$ro = $this->resource->delete($this->url, ['userid' => $userid, 'password' => $password]);
		$this->assertSame(201, $ro->code);
		$this->logger->info(sprintf("初期化 %s", var_export($ro->body, true)));

		$ro = $this->resource->post($this->url, ['userid' => $userid, 'password' => $password, 'email' => 'i.feeling.song@gmail.com', 'markdown' => '# AAAA', 'gtoken' => '']);
		$this->assertSame(201, $ro->code);
		$this->logger->info(sprintf("ユーザ登録 %s", var_export($ro->body, true)));
	}

	protected function remove(string $userid, string $password, string $result): void {
		$ro = $this->resource->delete($this->url, ['userid' => $userid, 'password' => $password]);
		$this->assertSame(201, $ro->code);
		$this->logger->info(sprintf("ユーザ削除 %s", var_export($ro->body, true)));
		$this->assertSame($result, $ro->body['result']);
	}

	public function testOnGet(): void {
		$this->regist('kght6123', 'kght6123');

		$ro = $this->resource->get($this->url, ['userid' => 'kght6123', 'password' => 'aaa']);
		$this->assertSame(200, $ro->code);
		$this->logger->info(sprintf("ユーザ認証 NG %s", var_export($ro->body, true)));
		$this->assertSame("false", $ro->body['result']);

		$ro = $this->resource->get($this->url, ['userid' => 'kght6123', 'password' => 'kght6123']);
		$this->assertSame(200, $ro->code);
		$this->logger->info(sprintf("ユーザ認証 OK %s", var_export($ro->body, true)));
		$this->assertSame("true", $ro->body['result']);

		$ro = $this->resource->put($this->url, ['userid' => 'kght6123', 'password' => 'aaa', 'newPassword' => 'bbb', 'email' => 'i.feeling.song+note@gmail.com', 'markdown' => '# BBBB', 'gtoken' => '']);
		$this->assertSame(204, $ro->code);
		$this->logger->info(sprintf("ユーザ更新 NG %s", var_export($ro->body, true)));
		$this->assertSame("false", $ro->body['result']);

		$ro = $this->resource->put($this->url, ['userid' => 'kght6123', 'password' => 'kght6123', 'newPassword' => 'kght6123a', 'email' => 'i.feeling.song+note@gmail.com', 'markdown' => '# BBBB', 'gtoken' => '']);
		$this->assertSame(204, $ro->code);
		$this->logger->info(sprintf("ユーザ更新 OK %s", var_export($ro->body, true)));
		$this->assertSame("true", $ro->body['result']);

		$ro = $this->resource->get($this->url, ['userid' => 'kght6123', 'password' => 'kght6123a']);
		$this->assertSame(200, $ro->code);
		$this->logger->info(sprintf("ユーザ認証 OK パスワード変更後 %s", var_export($ro->body, true)));
		$this->assertSame("true", $ro->body['result']);

		// ユーザ削除 NG
		$this->remove('kght6123', 'kght6123', "false");
		
		// ユーザ削除 OK
		$this->remove('kght6123', 'kght6123a', "true");
	}
}