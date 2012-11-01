-------------------------------------------------
-- ITMASPシステム DB
-- DB名：ピクトシステム
-------------------------------------------------
--  お問い合わせ情報
-------------------------------------------------

DROP TABLE    td_inquiry;
DROP SEQUENCE td_inquiry_seq;

CREATE TABLE td_inquiry (

  inquiry_id      int4 DEFAULT NEXTVAL('td_inquiry_seq') PRIMARY KEY,
  user_id         int4 ,

  name_family     text NOT NULL,  -- 名前 姓
  name_first      text NOT NULL,  -- 名前 名
  kana_family     text NOT NULL,  -- フリガナ 姓
  kana_first      text NOT NULL,  -- フリガナ 名

  name_company     text NOT NULL,  -- 名前 会社名
  kana_company      text NOT NULL,  -- フリガナ 会社名

  mail            text NOT NULL,  -- メールアドレス
  tel             text,           -- TEL
  mobile          text,           -- 携帯
  fax             text,           -- FAX

  inquiry         text,           -- お問い合わせ

  date_insert     timestamp without time zone NOT NULL Default now(), -- 登録日
  date_update     timestamp without time zone          Default now()  -- 更新日

);

-- シーケンスの作成
CREATE SEQUENCE td_inquiry_seq ;

-- 権限の設定
GRANT ALL ON td_inquiry     TO pgsql ;
GRANT ALL ON td_inquiry_seq TO pgsql ;
