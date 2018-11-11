<?php

// namespace はベンダー名\アプリ名\パッケージ名\クラス名 テスト対象と合わせる
namespace kght6123\ossnote\Resource\App;

use BEAR\Package\AppInjector;
use BEAR\Resource\ResourceInterface;
use PHPUnit\Framework\TestCase;

/** 
 * WeekdayTestクラス（検証用）
 */
class WeekdayTest extends TestCase {
	/**
	 * @var ResourceInterface
	 */
	private $resource;

	protected function setUp() {
		$this->resource = (new AppInjector('kght6123\ossnote', 'app'))->getInstance(ResourceInterface::class);
	}
	public function testOnGet() {
		$ro = $this->resource->get('app://self/weekday', ['year' => '2001', 'month' => '1', 'day' => '1']);
		$this->assertSame(200, $ro->code);
		$this->assertSame('Mon', $ro->body['weekday']);
	}
}