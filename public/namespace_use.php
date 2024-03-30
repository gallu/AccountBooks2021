<?php  // namespace_use.php
// 
require_once('namespace.php');

use Hoge\Foo\Bar  as  HFBar;

//use Hoge\Foo\Bar  as  Bar;
use Hoge\Foo\Bar;

$obj = new \Hoge\Foo\Bar();
var_dump($obj);

$obj2 = new HFBar();
var_dump($obj2);

$obj3 = new Bar();
var_dump($obj3);

