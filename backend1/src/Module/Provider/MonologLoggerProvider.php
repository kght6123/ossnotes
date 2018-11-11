<?php
namespace kght6123\ossnote\Module\Provider;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Ray\Di\ProviderInterface;
use BEAR\AppMeta\AbstractAppMeta;

/**
 * monolog㝮Provider
 */
class MonologLoggerProvider implements ProviderInterface
{
	private $logFile;
	public function __construct(AbstractAppMeta $meta) {
		//$this->logFile = $meta->logDir . '/monolog.log';
		$this->logFile = 'php://stdout';
	}
	public function get() {
		$log = new Logger('monolog');
		$log->pushHandler(
				new StreamHandler($this->logFile, Logger::DEBUG)
		);
		return $log;
	}
}