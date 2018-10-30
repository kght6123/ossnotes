<?php

// namespace はベンダー名\アプリ名\パッケージ名\クラス名 テスト対象と合わせる
namespace kght6123\ossnote\Resource\App;

use BEAR\Package\AppInjector;
use PHPUnit\Framework\TestCase;
use kght6123\ossnote\Resource\App\LoginTest;

/** 
 * GloginTestクラス
 */
class GloginTest extends LoginTest {
	/*
	public function testOnGet(): void {
		$url = 'app://self/glogin';
	
		// ユーザ登録
		$this->regist('kght6123', 'kght6123');

		$logger = $this->resource->newInstance($url)->getLogger();

		// Glogin
		$ro = $this->resource->post($url, ['userid' => 'kght6123', 'password' => 'kght6123', 'path' => '/aaa/bbb/ccc.md']);
		
		$this->assertSame(201, $ro->code);
		$this->assertSame('true', $ro->body['auth']);

		$logger->info(sprintf("glogin post body = %s", var_export($ro->body, true)));

		// ユーザ削除 OK
		$this->remove('kght6123', 'kght6123', "true");
	}*/
}