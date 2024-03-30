<?php   // withdrawal.php
declare(strict_types=1);
//
require_once(__DIR__ . '/../libs/init_auth.php');
require_once(BASEPATH . '/libs/accountsCreate.php');

// 出金する
accountsCreate('withdrawal');
