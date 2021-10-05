<?php   // db.php
declare(strict_types=1);

//
$dsn = 'mysql:host=localhost;dbname=AccountBooks2021;charset=utf8mb4';
$username = 'AccountBooks2021';
$password = 'AccountBooks2021';
$options = [
    \PDO::ATTR_EMULATE_PREPARES => false,  // エミュレート無効
    \PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,  // 複文無効
    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,  // エラー時に例外を投げる(好み)
];

//
try {
    $dbh = new \PDO($dsn, $username, $password, $options);
} catch (\PDOException $e){
    echo $e->getMessage(); // XXX 実際は出力はしない(logに書くとか)
    exit;
}
var_dump($dbh);




