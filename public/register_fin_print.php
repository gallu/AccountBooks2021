<?php  // register_fin_print.php
declare(strict_types=1);

//
require_once(__DIR__ . '/../libs/init.php');

// XXX 本来は絶対にやらないこと！！ 学校のサーバ状況でやむなくやってます！！
$activation_token = $_SESSION['activation_token'] ?? '';
unset($_SESSION['activation_token']);
var_dump($activation_token);

//
$template_filename = 'register_fin_print.twig';
$context = [];

// 出力
require_once(BASEPATH . '/libs/fin.php');
