<?php   // accountsCreate.php
declare(strict_types=1);

require_once(BASEPATH . '/model/AccountsModel.php');

/*
 * 入出金の処理がだいたい一緒なので共通化
 *
 * @param string $type 'deposit' または 'withdrawal'
 */
function accountsCreate($type) {
    // データの取得
    $account_date = strval($_POST['account_date'] ?? '');
    $accounting_subject = strval($_POST['accounting_subject'] ?? '');
    $amount = intval($_POST['amount'] ?? 0);
    //var_dump($account_date, $accounting_subject, $amount);

    // validate
    $error = [];
    // CSRF tokenのチェック
    if (false === Csrf::isValid()) {
        $error['csrf'] = true;
    }
    // 日付
    $t = strtotime($account_date);
    if (false === $t) {
        $error['account_date'] = true;
    } else {
        $account_date = date('Y-m-d', $t);
    }
    // 科目
    if (0 === strlen($accounting_subject)) {
        $error['accounting_subject'] = true;
    }
    // 金額
    if (0 >= $amount) {
        $error['amount'] = true;
    }
    //
    if ([] !== $error) {
        //
        $_SESSION['flash'][$type]['error'] = true;
        $_SESSION['flash'][$type]['account_date'] = $account_date;
        $_SESSION['flash'][$type]['accounting_subject'] = $accounting_subject;
        $_SESSION['flash'][$type]['amount'] = $amount;
        //
        header('Location: ./top.php');
        exit;
    }

    // XXX ここまできたらvalidate OK

    // typeの選定
    if ('deposit' === $type) {
        $flg = 1;
    } else if ('withdrawal' === $type) {
        $flg = 2;
    } else {
        // XXX
        echo "typeがおかしい（プログラミングのミス)\n";
        exit;
    }

    // データのINSERT
    $data = [
        'user_id' => $_SESSION['users']['auth']['user_id'],
        'flag' => $flg,
        'account_date' => $account_date,
        'accounting_subject' => $accounting_subject,
        'amount' => $amount,
        'created_at' => date('Y-m-d H:i:s'),
    ];
    //var_dump($data); exit;
    $r = AccountsModel::create($data);
    //var_dump($r); exit;

    // top pageに遷移
    $_SESSION['flash'][$type]['success'] = true;
    header('Location: ./top.php');
    exit;
}
