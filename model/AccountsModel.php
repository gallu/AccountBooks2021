<?php   // AccountsModel.php
declare(strict_types=1);
//
require_once(BASEPATH . '/libs/ModelBase.php');

class AccountsModel extends ModelBase {
    protected static $table_name = 'accounts';
    protected static $primary_key = 'account_id';
    //
    protected static $auto_increment = true;
    
    /**
     * 一覧の取得
     *
     * @param $limit_num int 1pageあたりのitem数
     * @param $p int ページ数
     * @param $sort string sort条件
     */
    public static function getList($limit_num, $p, $sort) {
        // sort条件のホワイトリスト
        $sort_list = [
            // 外部パラメタの値 => SQLのORDER BYに渡す文字列,
            'date' => 'account_date',
            'date_desc' => 'account_date DESC',
            'subject' => 'accounting_subject',
            'subject_desc' => 'accounting_subject DESC',
            'amount' => 'amount',
            'amount_desc' => 'amount DESC',
        ];
        
        /* SQLとクエリストリングを動的に作るための情報作成 */
        $where = [];
        $bind = [];
        $search = [];
        // この条件は確定
        $where[] = 'user_id = :user_id';
        $bind[':user_id'] = $_SESSION['users']['auth']['user_id'];

        /* 検索用項目の取得 */
        // 期間
        $from_date = strval($_GET['from_date'] ?? '');
        if ('' !== $from_date) {
            $where[] = 'account_date >= :from_date';
            $bind[':from_date'] = $from_date;
            $search[] = 'from_date=' . rawurlencode($from_date);
        }
        $to_date = strval($_GET['to_date'] ?? '');
        if ('' !== $to_date) {
            $where[] = 'account_date <= :to_date';
            $bind[':to_date'] = $to_date;
            $search[] = 'to_date=' . rawurlencode($to_date);
        }
        //var_dump($where, $bind, $search);

        // 科目名(部分一致)
        $accounting_subject_search = strval($_GET['accounting_subject_search'] ?? '');
        if ('' !== $accounting_subject_search) {
             // XXX
            $where[] = 'accounting_subject LIKE :accounting_subject';
            $bind[':accounting_subject'] = "%{$accounting_subject_search}%";
            $search[] = 'accounting_subject_search=' . rawurlencode($accounting_subject_search);
        }

        // 入出金
        $flag_search = (array)($_GET['flag_search'] ?? []);
        //var_dump($flag_search);
        if ([] !== $flag_search) {
            //
            $w = [];
            /*
            $flag_count = 0;
            foreach($flag_search as $f) {
                $ph = ":flag_{$flag_count}";
                $w[] = "flag = {$ph}";
                $bind[$ph] = $f;
                $search[] = rawurlencode('flag_search[]') . '=' . rawurlencode($f);
                //
                $flag_count ++;
            }
            */
            //
            if (true === in_array('1', $flag_search, true)) {
                $w[] = "flag = 1";
                //$search[] = 'flag_search%5B%5D=1';
                $search[] = rawurlencode('flag_search[]') . '=1';
            }
            if (true === in_array('2', $flag_search, true)) {
                $w[] = "flag = 2";
                //$search[] = 'flag_search%5B%5D=2';
                $search[] = rawurlencode('flag_search[]') . '=2';
            }
            //
            if ([] !== $w) {
                $where[] = '(' . implode(' OR ' , $w) . ')';
            }
        //var_dump($where, $bind);
        }

        // WEHERE句の文字列を作成
        $where_string = implode(' AND ', $where);
        //var_dump($where_string);
        // クエリストリングを作成
        $search_string_e = '';
        if ([] !== $search) {
            $search_string_e = implode('&', $search);
        }
        //var_dump($search_string_e);
        
        //
        $sort_string = $sort_list[$sort] ?? 'account_date DESC, flag, account_id';

        // 一覧の取得
        $sql = 'SELECT * FROM accounts
                 WHERE  ' . $where_string . '
                 ORDER BY ' . $sort_string . '
                 LIMIT :limit_num OFFSET :offset_num;';
//var_dump($sql);
        $pre = Db::getHandle()->prepare($sql);
        //
        foreach($bind as $k => $v) {
            if ((true === is_int($v))||(true === is_float($v))) {
                $type = \PDO::PARAM_INT;
            } else {
                $type = \PDO::PARAM_STR;
            }
            $pre->bindValue($k, $v, $type);
        }
        $pre->bindValue(':limit_num', $limit_num + 1, \PDO::PARAM_INT);
        $pre->bindValue(':offset_num', $limit_num * ($p - 1), \PDO::PARAM_INT);
        //
        $r = $pre->execute();
        //
        $list = $pre->fetchAll(\PDO::FETCH_ASSOC);
        
        //
        return [
                'list' => $list,
                'search_string_e' => $search_string_e,
                // 以下、formからの入力パラメタ
                'from_date' => $from_date,
                'to_date' => $to_date,
                'accounting_subject_search' => $accounting_subject_search,
                'flag_search' => $flag_search,
            ];
    }

}
