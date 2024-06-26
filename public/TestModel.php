<?php   // TestModel.php
//  https://dev2.m-fr.net/アカウント名/AccountBooks2021/TestModel.php
declare(strict_types=1);
//
require_once(__DIR__ . '/../libs/init.php');
require_once(BASEPATH . '/libs/ModelBase.php');

class TestModel extends ModelBase {
    protected static $table_name = 'test';
    protected static $primary_key = 'test_id';
    //
    protected static $auto_increment = true;
}

// selectのテスト
$obj = TestModel::find(1);
var_dump($obj->s);
var_dump($obj->i);
//var_dump($obj->hoge);

// insertのテスト
$obj = TestModel::create(['s' => 'ModelTest', 'i' => 1234]);
var_dump($obj);

// updateのテスト
$obj->i = 9999;
$obj->s = 'ModelTestUpdate';
$obj->update();
var_dump($obj);


