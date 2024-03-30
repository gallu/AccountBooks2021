<?php   // login.php
declare(strict_types=1);
//
require_once(__DIR__ . '/../libs/init.php');

try {
    // emailとパスワードを取得
    $email = strval($_POST['email'] ?? '');
    $pw = strval($_POST['pw'] ?? '');
    //var_dump($email, $pw);exit;

    // 軽めにvalidate
    if ( ('' === $email)||('' === $pw) ) {
        throw new \Exception('');
    }

    // CSRF tokenのチェック
    if (false === Csrf::isValid()) {
        throw new \Exception('CSRF');
    }

    // DBから対象レコードを取得
    // XXX 一旦、SQLダイレクトに書く
    $sql = 'SELECT * FROM users WHERE email=:email;';
    $pre = Db::getHandle()->prepare($sql);
    //
    $pre->bindValue('email', $email);
    $pre->execute();
    $users = $pre->fetch(PDO::FETCH_ASSOC);
    if (false === $users) {
        throw new \Exception('');
    }
//var_dump($users);

    // パスワードを比較
    if (false === password_verify($pw, $users['password'])) {
//echo "password error\n"; exit;
        throw new \Exception('');
    }

} catch(\Throwable $e) {
//var_dump($e->getMessage()); exit;

    // データの持ち回り
    $_SESSION['flash']['email'] = $email;
    $_SESSION['flash']['error'] = true;

    // 非ログインTopPageに遷移
    header('Location: ./index.php');
    exit;
}

// XXX ここまで来たら「認証OK」
session_regenerate_id(true); // セッション固定攻撃からの防御

// 認可をonにする
unset($users['password']); // passwordは削除
$_SESSION['users']['auth'] = $users;

// top pageにLocation
header('Location: ./top.php');



