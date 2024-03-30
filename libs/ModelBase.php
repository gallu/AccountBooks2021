<?php   // ModelBase.php
declare(strict_types=1);

Class ModelBase {
    // select * from table where id=XXX;
    // $obj = Class名::find(key);
    // // 使うとき
    // echo $obj->hoge;
    // echo $obj->foo;
    public static function find($key) : ?static {
        // DBハンドルの取得
        $dbh = static::getDbHandle();

        /* selectの発行 */
        // プリペアドステートメントの作成
        $table_name = static::$table_name;
        $primary_key = static::$primary_key;
        $sql = "SELECT * FROM {$table_name} WHERE {$primary_key} = :id ;";
        $pre = $dbh->prepare($sql);
        
        // プレースホルダにバインド
        static::bindValues($pre, [':id' => $key]);

        // SQLを実行
        $r = $pre->execute();
        $datum = $pre->fetch(PDO::FETCH_ASSOC);
        // keyに対応するデータがなければNULL return
        if (false === $datum) {
            return null;
        }

        // 取り出せたデータを「どこか」に格納
        //$obj->datum[カラム名] = データ;
        $obj = new static();
        foreach($datum as $k => $v) {
            $obj->datum[$k] = $v;
        }
        
        //
        return $obj;
    }
    //
    public function __get(string $name) {
        //
        if (false === array_key_exists($name, $this->datum)) {
            throw new \Exception("{$name}はありません");
        }
        //
        return $this->datum[$name];
    }

    // insert
    // Class名::create([...]);
    public static function create(array $datum) : ?static {
        // DBハンドルの取得
        $dbh = static::getDbHandle();

        /* insertの発行 */
        // key(カラム群)の把握
        $keys = array_keys($datum);
        // カラム名のセキュリティチェック
        // XXX ダメなのがあったら例外投げるからreturnのチェックはしない
        static::checkColumn($keys);

        //
        $keys_string = implode(', ', array_map(function($k) {
            return "`{$k}`";
        }, $keys)); // カラム名の `` でのエスケープ
        //
/*      $holder_keys = [];
        foreach($keys as $k) {
            $holder_keys[] = ":{$k}";
        }*/
        $holder_keys = array_map(function($k) {
            return ":{$k}";
        }, $keys);
        //
        $holder_keys_string = implode(', ', $holder_keys);
        
        // プリペアドステートメントの作成
        $table_name = static::$table_name;
        $sql = "INSERT INTO {$table_name}({$keys_string}) VALUES({$holder_keys_string});";
        $pre = $dbh->prepare($sql);
//var_dump($pre, $datum); exit;

        // プレースホルダにバインド
        static::bindValues($pre, $datum);

        // 実行
        $r = $pre->execute();
//var_dump($r);

        // 入れたーデータを格納
        $obj = new static();
        foreach($datum as $k => $v) {
            $obj->datum[$k] = $v;
        }
        // もし「SERIAL(auto_increment)」なら、IDを取得して格納する
        if (true === static::$auto_increment) {
            $primary_key = static::$primary_key;
            $obj->datum[$primary_key] = $dbh->lastInsertId();
        }

        //
        return $obj;
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
        // カラム名チェックをやる
        $this::checkColumn([$name]);
        // カラム名が問題なければデータを入れる
        $this->datum[$name] = $value;
    }
    public function update() : ?static {
        // DBハンドルの取得
        $dbh = static::getDbHandle();
        
        /* SQLの発行 */
        // 前提情報の作成
        $table_name = $this::$table_name;
        $primary_key = $this::$primary_key;
        // カラム名のチェック
        $this::checkColumn(array_keys($this->datum));
        // datumを「PK」と「それ以外」に分ける
        $pk = [$primary_key => $this->datum[$primary_key]];
        $cols = $this->datum;
        unset($cols[$primary_key]);
//var_dump($pk, $cols);
        //
        $awk = [];
        foreach($cols as $k => $v) {
            $awk[] = "{$k} = :{$k}";
        }
        $set_string = implode(', ', $awk);
//var_dump($set_string);exit;

        // プリペアドステートメントの作成
        $sql = "UPDATE {$table_name} SET {$set_string} WHERE {$primary_key} = :{$primary_key} ;";
        $pre = $dbh->prepare($sql);
//var_dump($this->datum, $sql); exit;

        // 値のバインド
        static::bindValues($pre, $this->datum);

        // 実行
        $r = $pre->execute();
//var_dump($r);
        
        // 自分自身をreturn
        return $this;
    }
    
    // (delete)
    // $obj = Class名::find(key);
    // $obj->delete();
    public function delete() : bool {
    }

    //
    protected static function getDbHandle() {
        return Db::getHandle();
    }

    // 
    protected static function bindValues($pre, $data) {
        foreach($data as $k => $v) {
            // プレースホルダにバインド
            if ((true === is_int($v))||(true === is_float($v))) {
                $type = \PDO::PARAM_INT;
            } else {
                $type = \PDO::PARAM_STR;
            }
            $pre->bindValue(":{$k}", $v, $type);
        }
    }

    // カラム名のチェック
    // XXX ダメなのがあったら例外投げる
    protected static function checkColumn(array $keys) {
        //
        foreach($keys as $k) {
            $len = strlen($k);
            for($i = 0; $i < $len; ++$i) {
                // 英数ならOK
                if (true === ctype_alnum($k[$i])) {
                    continue;
                }
                // アンダースコアならOK
                if ('_' === $k[$i]) {
                    continue;
                }
                // else
                throw new \Exception("カラム名 {$k} でダメくさいの({$k[$i]})があったから処理やめる！！！");
            }
        }
    }

    //
    protected static $auto_increment = false;
    protected $datum = [];
}