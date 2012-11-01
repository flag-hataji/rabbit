
-- メール一括配信システム用 DB
-- フォーム(サンキューメール)


-------------------------------------------------
--  送信履歴
-------------------------------------------------
DROP TABLE    td_sform_mail;
DROP SEQUENCE td_sform_mail_seq;

-- シーケンスの作成
CREATE SEQUENCE td_sform_mail_seq ;


CREATE TABLE td_sform_mail (
  sform_mail_id   int4 DEFAULT NEXTVAL('td_sform_mail_seq') PRIMARY KEY,
  sform_ini_id    int4 NOT NULL,                                     -- 送信ユーザーID
  flag_mailsend   boolean default 't',                               -- 登録者にメールを送るかどうか
  email_from      text ,                                             -- 送信元メールアドレス
  email_from_text text ,                                             -- 送信元メール名前
  email_error     text ,                                             -- error戻り先メールアドレス
  subject         text ,                                             -- 件名
  text_msg        text ,                                             -- テキストメール本文
  html_msg        text ,                                             -- HTMLメール本文
  flag_html       boolean default 'f',                               -- HTMLメール送信フラグ（t=送る f=送らない）
  date_insert     timestamp without time zone NOT NULL Default now(), -- 登録日
  date_update     timestamp ,                                         -- 更新日
  flag_del        boolean default 'f'                                 -- 削除フラグ
);


-- 権限の設定
GRANT ALL ON td_sform_mail      TO pgsql ;
GRANT ALL ON td_sform_mail_seq  TO pgsql ;
