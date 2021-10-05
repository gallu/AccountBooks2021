<?php  // config_test.php
declare(strict_types=1);

//
$common = require(__DIR__ . '/common.config');
$env = require(__DIR__ . '/environment.config');
//var_dump($common, $env);

// configの加算
$config = $env + $common;
var_dump($config);
