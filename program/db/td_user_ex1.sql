-----------------------------------
--  ユーザーデータ 拡張1
-----------------------------------
DROP TABLE    td_user_ex1;
DROP SEQUENCE td_user_ex1_seq;

CREATE TABLE td_user_ex1 (
  user_ex1_id    int4 DEFAULT NEXTVAL('td_user_ex1_seq') PRIMARY KEY, -- ID 
  user_id       int4 NOT NULL,                                   -- ユーザーID     : 参照 td_user
  root_id       int4 DEFAULT 999,                                -- 経路ID         : 参照 tm_root
  medium_id     int4 DEFAULT 999,                                -- 媒体ID         : 参照 tm_medium
  text_root     text ,                                           -- 経路
  text_medium   text ,                                           -- 媒体
  ip            text ,                                           -- IP
  host          text ,                                           -- ホスト
  referrer      text                                             -- リファラー（登録時の最初期を取る）

);

-- シーケンスの作成
CREATE SEQUENCE td_user_ex1_seq ;
