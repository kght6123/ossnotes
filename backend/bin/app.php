<?php
if (php_sapi_name() == 'cli-server' && preg_match('/\.php$/', strtok($_SERVER["REQUEST_URI"],'?'))) {
	// ビルドインサーバかつ、拡張子が.phpの時はREQUEST_URIをそのまま呼ぶ
	return false;
}
require dirname(__DIR__) . '/autoload.php';
//require dirname(__DIR__) . '/vendor/autoload.php';
exit((require dirname(__DIR__) . '/bootstrap.php')(PHP_SAPI === 'cli' ? 'cli-hal-api-app' : 'hal-api-app'));
