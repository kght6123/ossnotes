<?php
namespace kght6123\ossnote\Module;

use BEAR\Package\AbstractAppModule;
use BEAR\Package\PackageModule;
// AuraRouter��ǉ�
use BEAR\Package\Provide\Router\AuraRouterModule;
// Interceptor��ǉ�
use kght6123\ossnote\Annotation\BenchMark;
use kght6123\ossnote\Interceptor\BenchMarker;
// AuraSQL��ǉ�
use Ray\AuraSqlModule\AuraSqlModule;
// DI(monolog)�Ώۂ�ǉ�
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
		// AuraRouter���C���X�g�[������i���[�^�X�N���v�g��ǂݍ��݁j
		$this->install(new AuraRouterModule($appDir . '/var/conf/aura.route.php'));
		// Interceptor��bind����
		$this->bindInterceptor(
			$this->matcher->any(),                           // �ǂ̃N���X�ł�
			$this->matcher->annotatedWith(BenchMark::class), // @BenchMark�ƃA�m�e�[�g����Ă��郁�\�b�h��
			[BenchMarker::class]                             // BenchMarker�C���^�[�Z�v�^�[��K�p
		);
		// Logger(DI)��bind����
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
