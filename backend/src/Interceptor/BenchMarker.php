<?php
namespace kght6123\ossnote\Interceptor;

use kght6123\ossnote\MyLoggerInterface;
use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;

class BenchMarker implements MethodInterceptor {

	private $logger;// FIXME php7.4 から型指定ができる
	
	public function __construct(MyLoggerInterface $logger) {
		$this->logger = $logger;
	}
	/** 元のメソッドの処理を横取りして実行する */
	public function invoke(MethodInvocation $invocation) {
		// 処理開始の取得
		$start = microtime(true);
		// 元のメソッドの実行
		$result = $invocation->proceed();
		// 処理時間の取得
		$time = microtime(true) - $start;
		// 処理時間の標準出力＆ログ出力
		$message = sprintf('%s: %0.5f(µs)', $invocation->getMethod()->getName(), $time);
		$this->logger->log($message);
		return $result;
	}
}