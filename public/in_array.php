<?php   // in_array.php
declare(strict_types=1);

// 第三引数を省略すると結果が変わる
$awk = [0, 'aa', 'bb', 'cc', 'dd', 'ee', '1', '2', 3];
var_dump( in_array('aa', $awk, true) );
var_dump( in_array('zz', $awk, true) );
var_dump( in_array(1, $awk, true) );
var_dump( in_array('3', $awk, true) );

//
$awk2 = array_flip($awk);
var_dump($awk2);
$awk2['bb'] = null; // 小細工

// issetの注意点
var_dump( isset($awk2['aa']) );
var_dump( isset($awk2['zz']) );
var_dump( isset($awk2['1']) );
var_dump( isset($awk2['bb']) );

// 
var_dump( array_key_exists('aa', $awk2) );
var_dump( array_key_exists('zz', $awk2) );
var_dump( array_key_exists('bb', $awk2) );




