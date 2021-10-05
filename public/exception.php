<?php  // exception.php
declare(strict_types=1);
//
try {
    throw new \ErrorException('hoge error');
} catch (\Throwable $e) {
    echo $e->getMessage() , "<br>\n";
}

//
try {
    throw new \ErrorException('hoge error');
} catch (\ErrorException $e) {
    echo 'ErrorException: ' , $e->getMessage() , "<br>\n";
} catch (\Throwable $e) {
    echo 'Throwable: ' , $e->getMessage() , "<br>\n";
}


