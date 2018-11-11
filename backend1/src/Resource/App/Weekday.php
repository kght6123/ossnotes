<?php
// namespace はベンダー名\アプリ名\パッケージ名\クラス名 間違うとエラー
namespace kght6123\ossnote\Resource\App;

use BEAR\Resource\ResourceObject;
use kght6123\ossnote\Annotation\BenchMark;

// logger
use Psr\Log\LoggerInterface;
use Ray\Di\Di\Inject;

/** 
 * Weekdayクラス（検証用）
 * 
 *  $ php bin/app.php get /weekday # Error 引数不足のため
 *  $ php bin/app.php get '/weekday?year=2001&month=1&day=1' # OK
 *  $ php bin/app.php get '/weekday/2015/05/28' # OK AuraRouterのインストール＆設定後
 *  $ php bin/page.php get '/?year=1991&month=8&day=1' #OK Twigインストール＆設定後
 *  $ curl -i 'http://127.0.0.1:8080/weekday?year=2001&month=1&day=1' # Build-in Server (GET)
 *  $ curl -i -X POST 'http://127.0.0.1:8080/weekday?year=2001&month=1&day=1' # Build-in Server (POST)
 *  $ curl -i -X OPTIONS http://127.0.0.1:8080/weekday # Build-in Server パラメータ詳細
 * 
 *  http://127.0.0.1:8080/?year=2001&month=1&day=1 # Build-in Server HTML(Twig)
 */
class Weekday extends ResourceObject
{
	public $headers = ['access-control-allow-origin' => '*']; // これがないとCrossDomainエラー
	private $logger;// FIXME php7.4 から型指定ができる

	public function __construct(LoggerInterface $logger) {
		$this->logger = $logger;
	}

	/**
	 * @BenchMark
	 */
	public function onGet(int $year, int $month, int $day) : ResourceObject {
		$weekday = \DateTime::createFromFormat('Y-m-d', "$year-$month-$day")->format('D');
		$this->body = [
			'weekday' => $weekday
		];
		$this->logger->info("$year-$month-$day {$weekday}");
		return $this;
	}
}