<?php   // ModelBase.php

Class ModelBase {
    // select * from table where id=XXX;
    // $obj = Class名::find(key);
    public static function find($key) {
    }
    public function __get(string $name) {
    }

    // insert
    // Class名::create([...]);
    public static function create(array $datum) {
    }

    /*
    // (update)
    // $obj = Class名::find(key);
    $obj->hoge = 10;
    $obj->foo = 10;
    $obj->update();
    */
    //
    public function __set(string $name, $value) {
    }
    public function update() {
    }
    
    // (delete)
    // $obj = Class名::find(key);
    // $obj->delete();
    public function delete() {
    }

}