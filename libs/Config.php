<?php  // Config.php
declare(strict_types=1);

// 基準になるディレクトリ(最後の / はない形式で)
if (false === defined('BASEPATH')) {
    define('BASEPATH', realpath(__DIR__ . '/..'));
}
//
class Config {
    //
    public static function get(string $name, $default = null) {
        // null(初回アクセス)ならconfigの読み込み
        if (null === static::$config) {
            //
            $common = require(BASEPATH . '/common.config');
            $env = require(BASEPATH . '/environment.config');
            //
            static::$config = $env + $common;
        }
        //
        return static::$config[$name] ?? $default;
    }
    //
    private static $config = null;
}
/*
// XXX 後でtestsに移動させる
$s = Config::get('hoge');
var_dump($s);
*/




