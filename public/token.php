<?php   // token.php
//  https://dev2.m-fr.net/アカウント名/AccountBooks2021/token.php

$token = bin2hex(random_bytes(32)); // 16バイト以上、くらいで
var_dump($token);

$token = bin2hex(openssl_random_pseudo_bytes(32)); // 16バイト以上、くらいで
var_dump($token);

// ダメな子筆頭
$token = uniqid();
var_dump($token);

$token = sha1(uniqid(mt_rand(), true));
var_dump($token);

$token = uniqid(mt_rand(), true);
var_dump($token);


