-- 
CREATE TABLE activations (
    activation_token VARBINARY(128) NOT NULL COMMENT 'アクティベーション用の識別子',
    user_id BIGINT UNSIGNED NOT NULL COMMENT '紐づけるuser_id',
    email VARBINARY(254) NOT NULL DEFAULT '' COMMENT '確認しているemail',
    activation_ttl DATETIME NOT NULL COMMENT '有効期限',
    created_at DATETIME NOT NULL COMMENT '',
    CONSTRAINT fk_activations_user_id
       FOREIGN KEY (user_id)
       REFERENCES users (user_id),
    PRIMARY KEY(activation_token)
)CHARACTER SET 'utf8mb4', COMMENT='1レコードが「1ユーザに送る１通のアクティベーションコード」を意味するテーブル';
