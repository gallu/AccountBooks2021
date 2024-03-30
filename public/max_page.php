<?php   // max_page.php

/*
 $total_num: 全体の個数
 $par_num: 1ページあたりの個数
 */
function cal($total_num, $par_num) {
    //
    $count = ceil($total_num / $par_num);
    echo "{$total_num}/{$par_num} は、最大で {$count}ページです<br>\n";
}
//
cal(100, 10);
cal(99, 10);
cal(91, 10);
cal(90, 10);
