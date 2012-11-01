
-- メール一括配信システム用 DB


-------------------------------------------------
--  エラー履歴
-------------------------------------------------
DROP TABLE    td_error_log;
DROP SEQUENCE td_error_log_seq;

CREATE TABLE td_error_log (
  error_log_id   int4 DEFAULT NEXTVAL('td_error_log_seq') PRIMARY KEY,
  user_id        int4 NOT NULL,                                      -- 送信ユーザーID
  mail           text NOT NULL,                                      -- エラーメールアドレス
  error_count    int4 NOT NULL,                                      -- 送信件数
  date_insert    timestamp without time zone NOT NULL Default now(), -- 登録日
  date_update    timestamp without time zone                         -- 更新日
);

-- シーケンスの作成
CREATE SEQUENCE td_error_log_seq ;

-- 権限の設定
GRANT ALL ON td_error_log     TO pgsql ;
GRANT ALL ON td_error_log_seq TO pgsql ;
