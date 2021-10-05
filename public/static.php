<?php  // static.php
//   https://dev2.m-fr.net/アカウント名/AccountBooks2021/static.php
declare(strict_types=1);

function hoge() {
    $i = 0;
    static $j = 0;
    //
    echo "i / j: {$i} / {$j} <br>\n";
    $i ++;
    $j ++;
    echo "i / j: {$i} / {$j} <br>\n";
    $i ++;
    $j ++;
    echo "i / j: {$i} / {$j} <br>\n";
}

hoge();
hoge();
hoge();
