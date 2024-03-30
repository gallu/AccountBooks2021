<?php   // Csrf.php
declare(strict_types=1);

/**
// 入力側
$token = Csrf::createToken();

// 出力側
$r = Csrf::isValid();
if (false === $r) {
    // CSRF的にNGだった
}
 */
class Csrf {
    //
    public static function createToken() : string {
        // CSRF用のtokenを作成してセッションに仕込む
        $token = bin2hex(random_bytes(32)); // 16バイト以上、くらいで
        // セッションに格納
        $_SESSION['users']['csrf_token'] = $token;
        //
        return $token;
    }
    
    //
    public static function isValid() : bool {
        // CSRF tokenのチェック
        $session_token = $_SESSION['users']['csrf_token'] ?? '';
        unset($_SESSION['users']['csrf_token']); // XXX
        //
        $form_token = strval($_POST['csrf_token'] ?? '');
        //
        return hash_equals($session_token, $form_token);
    }
}
