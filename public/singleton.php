<?php   // singleton.php
declare(strict_types=1);

class Hoge {
}
//
$obj = new Hoge();
$obj2 = new Hoge();
var_dump($obj, $obj2);

//
class Foo {
    //
    private function __construct() {
    }
    //
    public static function getInstance() {
        static $obj = null;
        if (null === $obj) {
            $obj = new static();
        }
        return $obj;
    }
}
//
$obj3 = Foo::getInstance();
$obj4 = Foo::getInstance();
var_dump($obj3, $obj4);









