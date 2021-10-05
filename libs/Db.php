<?php   // Db.php
declare(strict_types=1);

// 基準になるディレクトリ(最後の / はない形式で)
if (false === defined('BASEPATH')) {
    define('BASEPATH', realpath(__DIR__ . '/..'));
}
//
require_once(BASEPATH . '/libs/Config.php');

class Db {
    //
    public static function getHandle() {
        //
        static $dbh = null;
        //
        if (null === $dbh) {
            $db_conf = Config::get('db');
            //var_dump($db_conf);
            $dsn = "mysql:host={$db_conf['host']};dbname={$db_conf['dbname']};charset={$db_conf['charset']}";
            $options = [
                \PDO::ATTR_EMULATE_PREPARES => false,  // エミュレート無効
                \PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,  // 複文無効
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,  // エラー時に例外を投げる(好み)
            ];
            //var_dump($dsn, $db_conf['user'], $db_conf['pass']);
            //
            try {
                $dbh = new \PDO($dsn, $db_conf['user'], $db_conf['pass'], $options);
            } catch (\PDOException $e){
                echo $e->getMessage(); // XXX 実際は出力はしない(logに書くとか)
                exit;
            }
        }
        //
        return $dbh;
    }
}
/*
$dbh = Db::getHandle();
var_dump($dbh);
$dbh = Db::getHandle();
var_dump($dbh);
*/



