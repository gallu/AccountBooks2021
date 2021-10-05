-- 
CREATE TABLE users (
    user_id SERIAL ,
    user_name VARCHAR(64) NOT NULL DEFAULT '' COMMENT 'ユーザ名',
    email VARBINARY(254) DEFAULT NULL COMMENT 'email',
    password VARBINARY(256) NOT NULL COMMENT 'パスワード',
    created_at DATETIME NOT NULL COMMENT '',
    updated_at DATETIME NOT NULL COMMENT '',
    UNIQUE KEY (email),
    PRIMARY KEY(user_id)
)CHARACTER SET 'utf8mb4', COMMENT='1レコードが「1ユーザ」を意味するテーブル';