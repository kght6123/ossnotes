<?php
declare(strict_types=1);

// namespace はベンダー名\アプリ名\パッケージ名 間違うとエラー
namespace kght6123\ossnote\Resource;

use BEAR\Package\Annotation\ReturnCreatedResource;
use BEAR\RepositoryModule\Annotation\Cacheable;
use BEAR\Resource\ResourceObject;

// 他のResourceを呼ぶためのResourceInjectをインポート
use BEAR\Sunday\Inject\ResourceInject;

// logger
use Psr\Log\LoggerInterface;
use Ray\Di\Di\Inject;

/**
 * BaseResourceObjectクラス
 * 
 * 全てのBaseの根底となるクラス
 * 
 *  $ php bin/app.php post '/glogin?path=welcome.md' # 取得
 */
class BaseResourceObject extends ResourceObject
{
	use ResourceInject;
	public  $headers = ['access-control-allow-origin' => '*']; // これがないとCrossDomainエラー
	protected $logger;

	/**
	 * @Inject
	 */
	public function __construct(LoggerInterface $logger) {
		$this->logger = $logger;
	}
	public function getLogger(): LoggerInterface {
		return $this->logger;
	}
	
}