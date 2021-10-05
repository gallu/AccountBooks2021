<?php  // password.php
declare(strict_types=1);

$raw_pass = 'password';

//
$pass_hash = password_hash($raw_pass, PASSWORD_DEFAULT, ['cost' => 11]);
var_dump($pass_hash);

//
$r = password_verify($raw_pass,  $pass_hash);
var_dump($r);

$r = password_verify('nopass',  $pass_hash);
var_dump($r);
