
-- メール一括配信システム用 DB

-------------------------------------------------
--  送信履歴
-------------------------------------------------
DROP TABLE    td_log;
DROP SEQUENCE td_log_seq;

CREATE TABLE td_log (
  log_id            int4 DEFAULT NEXTVAL('td_user_seq') PRIMARY KEY,
  user_id           int4 NOT NULL,                                      -- 送信ユーザーID
  message_id        int4 NOT NULL,                                      -- メッセージID
  name_from         text NOT NULL,                                      -- 送信者名
  mail_from         text NOT NULL,                                      -- 送信者アドレス
  mail_error        text NOT NULL,                                      -- エラー戻り先アドレス
  month_count       int4 NOT NULL,                                      -- 送信回数（当月）
  send_count        int4 NOT NULL,                                      -- 送信件数（ＰＣ&携帯トータル）
  send_count_pc     int4 NOT NULL,                                      -- 送信件数（ＰＣ向け）
  send_count_mobile int4 NOT NULL,                                      -- 送信件数（携帯向け）
  subject           text NOT NULL,                                      -- 件名
  message           text NOT NULL,                                      -- メッセージ
  message_html      text NOT NULL,                                      -- メッセージHTML
  send_date         timestamp without time zone NOT NULL,               -- 送信予定日
  flag_pc           int2 NOT NULL,                                      -- ＰＣ向けメール配信状態：0=送信しない 1=送信待ち  2=送信中 3=キャンセル 99=完了
  flag_mobile       int2 NOT NULL,                                      -- 携帯向けメール配信状態：0=送信しない 1=送信待ち  2=送信中 3=キャンセル 99=完了
  flag_type         int2 NOT NULL,                                      -- メール配信タイプ：1=PCのみ 2=携帯のみ 3=PC＆携帯
  ip                text NOT NULL,                                      -- IP
  host              text NOT NULL,                                      -- ホストネーム
  date_pc           timestamp without time zone NOT NULL Default now(), -- ＰＣ向けメール配信状態 変更日
  date_mobile       timestamp without time zone NOT NULL Default now(), -- 携帯向けメール配信状態 変更日
  date_insert       timestamp without time zone NOT NULL Default now()  -- 登録日
);


-- シーケンスの作成
CREATE SEQUENCE td_log_seq ;

-- 権限の設定
GRANT ALL ON td_log     TO pgsql ;
GRANT ALL ON td_log_seq TO pgsql ;
