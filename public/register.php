<?php   // register.php
declare(strict_types=1);

//
require_once(__DIR__ . '/../libs/init.php');

//var_dump($_SESSION);
$data = $_SESSION['flash']['data'] ?? [];
$error_messages = $_SESSION['flash']['error_messages'] ?? [];
//var_dump($data, $error_messages);

// セッションの情報は削除する
unset( $_SESSION['flash'] );

// CSRF用のtokenを作成してセッションに仕込む
$csrf_token = Csrf::createToken();

//
$template_filename = 'register.twig';
$context = [
    'data' => $data,
    'error_messages' => $error_messages,
    // CSRF用
    'csrf_token' => $csrf_token,
];

// 出力
require_once(BASEPATH . '/libs/fin.php');
