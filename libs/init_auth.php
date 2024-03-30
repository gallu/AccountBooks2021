<?php   // init_auth.php
/*
 * init + 認可処理
 */
//
require_once(__DIR__ . '/init.php');
require_once(BASEPATH . '/model/AccountsModel.php');

// 認可処理
if (false === isset($_SESSION['users']['auth'])) {
    // 非ログインTopPageに遷移
    header('Location: ./index.php');
    exit;
}
