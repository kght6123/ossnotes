<?php
// namespace はベンダー名\アプリ名\パッケージ名\クラス名 テスト対象と合わせる
namespace kght6123\ossnote\Resource\App;

use BEAR\Package\AppInjector;
use BEAR\Resource\ResourceInterface;
use PHPUnit\Framework\TestCase;

// Logger
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/** 
 * LoginTestクラス
 */
class BaseTestCase extends TestCase {
	
	/**
	 * @var ResourceInterface
	 */
	protected $resource;
	protected $logger;

	protected function setUp(): void {
		$this->resource = (new AppInjector('kght6123\ossnote', 'app'))->getInstance(ResourceInterface::class);

		$this->logger = new Logger('test');
		$this->logger->pushHandler(
			new StreamHandler('php://stdout', Logger::DEBUG)
		);
	}
}