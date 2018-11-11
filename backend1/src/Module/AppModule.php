<?php
namespace kght6123\ossnote\Module;

use BEAR\Package\AbstractAppModule;
use BEAR\Package\PackageModule;
// AuraRouterを追加
use BEAR\Package\Provide\Router\AuraRouterModule;
// Interceptorを追加
use kght6123\ossnote\Annotation\BenchMark;
use kght6123\ossnote\Interceptor\BenchMarker;
// AuraSQLを追加
use Ray\AuraSqlModule\AuraSqlModule;
// DI(monolog)対象を追加
use Psr\Log\LoggerInterface;
use kght6123\ossnote\Module\Provider\MonologLoggerProvider;

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
		// Interceptorをbindする
		$this->bindInterceptor(
			$this->matcher->any(),                           // どのクラスでも
			$this->matcher->annotatedWith(BenchMark::class), // @BenchMarkとアノテートされているメソッドに
			[BenchMarker::class]                             // BenchMarkerインターセプターを適用
		);
		// Logger(DI)をbindする
		$this->bind(LoggerInterface::class)->toProvider(MonologLoggerProvider::class);
		// Database
		$this->install(new AuraSqlModule('sqlite:' . dirname(dirname(__DIR__)) . '/var/db/todo.sqlite3'
			//,'username'
			//,'password'
			//,'slave1,slave2,slave3' // optional slave server list
		));
		$this->install(new PackageModule);
	}
}
