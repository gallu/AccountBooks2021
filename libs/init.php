<?php  // init.php
declare(strict_types=1);

// セッション開始
ob_start();
session_start();

// 基準になるディレクトリ(最後の / はない形式で)
define('BASEPATH', realpath(__DIR__ . '/..'));
//var_dump( __DIR__ . '/..' );
//var_dump( realpath(__DIR__ . '/..') );

//
require_once(BASEPATH . '/vendor/autoload.php');

//
require_once(BASEPATH . '/libs/Config.php');
require_once(BASEPATH . '/libs/Db.php');
require_once(BASEPATH . '/libs/Csrf.php');

// Twigインスタンスを生成
$templte_config = Config::get('template');
$path = BASEPATH . $templte_config['dir'];
$twig = new \Twig\Environment( new \Twig\Loader\FilesystemLoader($path) );





