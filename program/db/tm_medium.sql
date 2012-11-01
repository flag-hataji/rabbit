-----------------------------------
--  媒体マスタ
-----------------------------------

DROP TABLE tm_medium;

CREATE TABLE tm_medium (
  medium_id        int4 UNIQUE NOT NULL, -- 媒体ID
  medium           text ,                -- 媒体名
  mail             text ,                -- メール
  sort             int2 NOT NULL,        -- 順番
  flag_show        int2 DEFAULT 1        -- 公開フラグ : 1=公開 2=非公開
);

 INSERT INTO tm_medium VALUES(  1,  'ニッチメディアドットコム','hataji@itm.ne.jp',  1 ); 
 INSERT INTO tm_medium VALUES(  2,  'A8','hataji@itm.ne.jp',                        2 ); 
 INSERT INTO tm_medium VALUES( 999, 'その他','hataji@itm.ne.jp', 999 ); 
