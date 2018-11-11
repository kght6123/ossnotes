<?php
namespace kght6123\ossnote\Interceptor;

use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;

// logger
use Psr\Log\LoggerInterface;
use Ray\Di\Di\Inject;

class BenchMarker implements MethodInterceptor {

	private $logger;// FIXME php7.4 から型指定ができる
	
	public function __construct(LoggerInterface $logger) {
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
		$message = sprintf('%s: %s: %0.5f(µs)', $invocation->getMethod()->getDeclaringClass()->getName(), $invocation->getMethod()->getName(), $time);
		$this->logger->info($message);
		return $result;
	}
}