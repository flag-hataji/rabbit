-----------------------------------
--  経路マスタ
-----------------------------------

DROP TABLE tm_root;

CREATE TABLE tm_root (
  root_id        int4 UNIQUE NOT NULL, -- 媒体ID
  root           text ,                -- 媒体名
  sort           int2 NOT NULL,        -- 順番
  flag_show      int2 DEFAULT 1        -- 公開フラグ : 1=公開 2=非公開
);

 INSERT INTO tm_root VALUES(  1,   'ブログの紹介',   1 ); 
 INSERT INTO tm_root VALUES(  2,   'サイトの紹介',   2 ); 
 INSERT INTO tm_root VALUES(  3,   'メルマガの紹介', 3 ); 
 INSERT INTO tm_root VALUES(  4,   '知人からの紹介', 4 ); 
 INSERT INTO tm_root VALUES(  5,   'チラシを見て',   5 ); 
 INSERT INTO tm_root VALUES(  6,   'itm.ne.jpより',  6 ); 
 INSERT INTO tm_root VALUES(  7,   'it1616.comより', 7 ); 
 INSERT INTO tm_root VALUES(  8,   'Google広告',     8 ); 
 INSERT INTO tm_root VALUES(  9,   'Google検索',     9 ); 
 INSERT INTO tm_root VALUES(  10,  'Yahoo広告',     10 ); 
 INSERT INTO tm_root VALUES(  11,  'Yahoo検索',     11 ); 
 INSERT INTO tm_root VALUES(  12,  'infoseek',      12 ); 
 INSERT INTO tm_root VALUES(  13,  'goo',           13 ); 
 INSERT INTO tm_root VALUES(  14,  'MSN',           14 ); 
 INSERT INTO tm_root VALUES( 999,  'その他',       999 ); 

