<?php
namespace kght6123\ossnote\Module;

use BEAR\Package\AbstractAppModule;
use BEAR\Package\PackageModule;
// AuraRouterを追加
use BEAR\Package\Provide\Router\AuraRouterModule;
// DI対象を追加
use kght6123\ossnote\MyLogger;
use kght6123\ossnote\MyLoggerInterface;
// Interceptorを追加
use kght6123\ossnote\Annotation\BenchMark;
use kght6123\ossnote\Interceptor\BenchMarker;
// AuraSQLを追加
use Ray\AuraSqlModule\AuraSqlModule;

class AppModule extends AbstractAppModule
{
	/**
	 * {@inheritdoc}
	 */
	protected function configure()
	{
		$appDir = $this->appMeta->appDir;
		require_once $appDir . '/env.php';
		// AuraRouterをインストールする（ルータスクリプトを読み込み）
		$this->install(new AuraRouterModule($appDir . '/var/conf/aura.route.php'));
		// DIをbindする
		$this->bind(MyLoggerInterface::class)->to(MyLogger::class);
		// Interceptorをbindする
		$this->bindInterceptor(
			$this->matcher->any(),                           // どのクラスでも
			$this->matcher->annotatedWith(BenchMark::class), // @BenchMarkとアノテートされているメソッドに
			[BenchMarker::class]                             // BenchMarkerインターセプターを適用
		);
		// Database
		$this->install(new AuraSqlModule('sqlite:' . dirname(dirname(__DIR__)) . '/var/db/todo.sqlite3'
			//,'username'
			//,'password'
			//,'slave1,slave2,slave3' // optional slave server list
		));
		$this->install(new PackageModule);
	}
}
