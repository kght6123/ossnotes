<?php
require dirname(__DIR__) . '/autoload.php';
//require dirname(__DIR__) . '/vendor/autoload.php';
exit((require dirname(__DIR__) . '/bootstrap.php')(PHP_SAPI === 'cli' ? 'cli-html-app' : 'html-app'));
