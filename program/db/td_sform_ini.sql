
-- メール一括配信システム用 DB


-------------------------------------------------
--  送信履歴
-------------------------------------------------
DROP TABLE    td_sform_ini;
DROP SEQUENCE td_sform_ini_seq;

-- シーケンスの作成
CREATE SEQUENCE td_sform_ini_seq ;


CREATE TABLE td_sform_ini (
  sform_ini_id   int4 DEFAULT NEXTVAL('td_sform_ini_seq') PRIMARY KEY,
  user_id        int4 NOT NULL,                                     -- 送信ユーザーID
  scenario_id    int4 ,                                             -- シナリオID
  sform_name     text ,                                             -- フォーム名
  company_name_ini     text ,                                       -- 会社名設定（０：表示　１：表示　２：表示＆必須）
  post_ini       text ,                                             -- 役職社名設定（０：表示　１：表示　２：表示＆必須）
  param1_name    text ,                                             -- パラメータ１ネーム
  param1_ini     text ,                                             -- パラメータ１設定（０：表示　１：表示　２：表示＆必須）
  param2_name    text ,                                             -- パラメータ２ネーム
  param2_ini     text ,                                             -- パラメータ２設定（０：表示　１：表示　２：表示＆必須）
  param3_name    text ,                                             -- パラメータ３ネーム
  param3_ini     text ,                                             -- パラメータ３設定（０：表示　１：表示　２：表示＆必須）
  param4_name    text ,                                             -- パラメータ４ネーム
  param4_ini     text ,                                             -- パラメータ４設定（０：表示　１：表示　２：表示＆必須）
  param5_name    text ,                                             -- パラメータ５ネーム
  param5_ini     text ,                                             -- パラメータ５設定（０：表示　１：表示　２：表示＆必須）
  param6_name    text ,                                             -- パラメータ６ネーム
  param6_ini     text ,                                             -- パラメータ６設定（０：表示　１：表示　２：表示＆必須）
  param7_name    text ,                                             -- パラメータ７ネーム
  param7_ini     text ,                                             -- パラメータ７設定（０：表示　１：表示　２：表示＆必須）
  param8_name    text ,                                             -- パラメータ８ネーム
  param8_ini     text ,                                             -- パラメータ８設定（０：表示　１：表示　２：表示＆必須）
  param9_name    text ,                                             -- パラメータ９ネーム
  param9_ini     text ,                                             -- パラメータ９設定（０：表示　１：表示　２：表示＆必須）
  param10_name   text ,                                             -- パラメータ１０ネーム
  param10_ini    text ,                                             -- パラメータ１０設定（０：表示　１：表示　２：表示＆必須）
  heder          text ,                                             -- フォームのヘッダー
  bg_color       text ,                                             -- バックカラー
  line_color     text ,                                             -- ラインカラー
  font_color     text ,                                             -- フォントカラー
  chara_code     text ,                                             -- 文字コード
  mail           text ,                                             -- サンキューメール送信先
  mail_text      text ,                                             -- サンキューメール本文
  flag_mailsend  boolean default 't',                               -- 登録者にメールを送るかどうか
  back_url       text ,                                             -- どの完了後URLに戻るか
  date_insert    timestamp without time zone NOT NULL Default now(), -- 登録日
  date_update    timestamp ,                                         -- 更新日
  flag_del       boolean default 'f'                                 -- 削除フラグ
);


-- 権限の設定
GRANT ALL ON td_sform_ini      TO pgsql ;
GRANT ALL ON td_sform_ini_seq  TO pgsql ;
