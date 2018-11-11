<?php
/* @var \Aura\Router\Map $map */

// weekdayパスに、year,month,dayのパラメータをパスでマッピングする
$map->route('/weekday', '/weekday/{year}/{month}/{day}');
