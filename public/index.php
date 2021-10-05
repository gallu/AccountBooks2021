<?php  // index.php
declare(strict_types=1);

//
require_once(__DIR__ . '/../libs/init.php');

//
$template_filename = 'index.twig';
$context = [];

// 出力
require_once(BASEPATH . '/libs/fin.php');
