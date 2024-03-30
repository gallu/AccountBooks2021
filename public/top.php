<?php   // top.php
declare(strict_types=1);

//
require_once(__DIR__ . '/../libs/init_auth.php');

/* 設定 */
//$limit_num = 100; // 1ページあたりの表示数
$limit_num = 5; // 1ページあたりの表示数

// 情報があったら受け取る
$session = $_SESSION['flash'] ?? [];
unset($_SESSION['flash']); // flashデータなんで速やかに削除
//var_dump($session);

// ページ数の取得とざっくりしたfilter
$p = intval($_GET['p'] ?? 1);
if (1 > $p) {
    $p = 1;
}
//var_dump($p);

// sort条件を取得〔validate相当の処理は使うときに)
$sort = strval($_GET['sort'] ?? '');

// 一覧データを取得
$data = AccountsModel::getList($limit_num, $p, $sort);

// データをそれぞれ変数に展開(下のコードをあまり修正したくないので)
$list = $data['list'];
$search_string_e = $data['search_string_e'];
//
$from_date = $data['from_date'];
$to_date = $data['to_date'];
$accounting_subject_search = $data['accounting_subject_search'];
$flag_search = $data['flag_search'];

//var_dump($list);

// 「前」「次」の有無を確認
$before_page = $p - 1; // 「前がない」なら０になるから後はテンプレート側で判定
if (count($list) === ($limit_num + 1)) {
    $next_page = $p + 1;
    array_pop($list); // 末尾の要素を１つ削る
} else {
    $next_page = 0;
}

// 入金と出金の各合計額
$deposit_total = $withdrawal_total = 0;
//
foreach($list as $datum) {
    /*
    if (1 == $datum['flag']) {
        $deposit_total += $datum['amount'];
    } else {
        $withdrawal_total += $datum['amount'];
    }
    */
    if (1 == $datum['flag']) {
        $v = 'deposit_total';
    } else {
        $v = 'withdrawal_total';
    }
    $$v += $datum['amount'];
}
//var_dump($deposit_total, $withdrawal_total);

// CSRF用のtokenを作成してセッションに仕込む
$csrf_token = Csrf::createToken();

//
$template_filename = 'top.twig';
$context = [
    'deposit' => $session['deposit'] ?? [],
    'withdrawal' => $session['withdrawal'] ?? [],
    'list' => $list,
    'deposit_total' => $deposit_total,
    'withdrawal_total' => $withdrawal_total,
    // ページング用の情報
    'now_page' => $p,
    'next_page' => $next_page,
    'before_page' => $before_page,
    'search_string_e' => $search_string_e,
    // 検索用情報
    'from_date' => $from_date,
    'to_date' => $to_date,
    'accounting_subject_search' => $accounting_subject_search,
    'flag_search' => $flag_search,
    // sort用情報
    'sort' => $sort,
    // CSRF用
    'csrf_token' => $csrf_token,
];
//var_dump($context);

// 出力
require_once(BASEPATH . '/libs/fin.php');
