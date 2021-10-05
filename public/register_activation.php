<?php   // register_activation.php
declare(strict_types=1);

//
require_once(__DIR__ . '/../libs/init.php');

// tokenを把握
$token = strval($_POST['token'] ?? '');
if ('' === $token) {
    // XXX
    echo 'tokenが指定されていません';
    exit;
}

// DB上での存在確認
$dbh = Db::getHandle();

/* はじめにお掃除 */
// XXX 本当はバッチ組んでcronで動かすほうがよい。以下は暫定処理
$sql = 'delete from activations where activation_ttl < now();';
$pre = $dbh->prepare($sql);
//var_dump($pre);

// バインド
// XXX 今回はなし

// SQLを実行
$r = $pre->execute();
//var_dump($r);

// トラン開始
$r = $dbh->beginTransaction(); // XXX

// tokenを検索
// XXX 上でお掃除しているのでactivation_ttlは聞かない。バッチに移動させたらactivation_ttlを追加すること
$sql = 'select * from activations where activation_token = :activation_token  FOR UPDATE';
$pre = $dbh->prepare($sql);
//var_dump($pre);

// バインド
$pre->bindValue(':activation_token', $token);

// SQLを実行
$r = $pre->execute();
//var_dump($r);

$datum = $pre->fetch(\PDO::FETCH_ASSOC);
var_dump($datum);
if (false === $datum) {
    // XXX 本来はエラー画面に遷移させる
    echo "tokenが見つからなかったよ？";
    exit;
}

// emailを認証する(＝usersにemailを入れる)
$sql = 'update users set email = :email where user_id = :user_id;';
$pre = $dbh->prepare($sql);
// バインド
$pre->bindValue(':email', $datum['email']);
$pre->bindValue(':user_id',  $datum['user_id']);
// SQLを実行
$r = $pre->execute();
var_dump($r);

// tokenを消す
$sql = 'delete from activations where activation_token = :activation_token';
$pre = $dbh->prepare($sql);
//var_dump($pre);
// バインド
$pre->bindValue(':activation_token', $token);
// SQLを実行
$r = $pre->execute();
var_dump($r);

// トラン終了
$r = $dbh->commit(); // XXX

// 完了画面
echo 'fin';
// XXX 後でlocationに書き換える











