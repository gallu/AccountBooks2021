-- 
CREATE TABLE accounts (
    account_id SERIAL ,
    user_id BIGINT UNSIGNED NOT NULL COMMENT 'ユーザID',
    flag TINYINT UNSIGNED NOT NULL COMMENT '入出金フラグ: 1)入金, 2)出金',
    account_date DATE NOT NULL COMMENT '入出金の日付',
    accounting_subject VARCHAR(128) NOT NULL COMMENT '経理科目',
    amount INT UNSIGNED NOT NULL COMMENT '入出金 金額',
    -- 
    created_at DATETIME NOT NULL COMMENT '',
    -- updated_at DATETIME NOT NULL COMMENT '',
    -- 
    INDEX (user_id),
    FOREIGN KEY accounts_user_id(user_id) REFERENCES users(user_id),
    PRIMARY KEY(account_id)
)CHARACTER SET 'utf8mb4', COMMENT='1レコードが「1ユーザの１入出金」を意味するテーブル';

