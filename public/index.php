<?php  // index.php
declare(strict_types=1);

//
require_once(__DIR__ . '/../libs/init.php');

// 情報があったら受け取る
$session = $_SESSION['flash'] ?? [];
unset($_SESSION['flash']); // flashデータなんで速やかに削除
//var_dump($session);

// CSRF用のtokenを作成してセッションに仕込む
$token = Csrf::createToken();

//
$template_filename = 'index.twig';
$context = [
    'login_email' => $session['email'] ?? '',
    'login_error' => $session['error'] ?? false,
    // CSRF用のtokenを仕込む
    'csrf_token' => $token,
];

// 出力
require_once(BASEPATH . '/libs/fin.php');
