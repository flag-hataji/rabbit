-----------------------------------
--  ���Υޥ���
-----------------------------------

DROP TABLE tm_medium;

CREATE TABLE tm_medium (
  medium_id        int4 UNIQUE NOT NULL, -- ����ID
  medium           text ,                -- ����̾
  mail             text ,                -- �᡼��
  sort             int2 NOT NULL,        -- ����
  flag_show        int2 DEFAULT 1        -- �����ե饰 : 1=���� 2=�����
);

 INSERT INTO tm_medium VALUES(  1,  '�˥å���ǥ����ɥåȥ���','hataji@itm.ne.jp',  1 ); 
 INSERT INTO tm_medium VALUES(  2,  'A8','hataji@itm.ne.jp',                        2 ); 
 INSERT INTO tm_medium VALUES( 999, '����¾','hataji@itm.ne.jp', 999 ); 
