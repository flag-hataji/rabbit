-----------------------------------
--  ��ϩ�ޥ���
-----------------------------------

DROP TABLE tm_root;

CREATE TABLE tm_root (
  root_id        int4 UNIQUE NOT NULL, -- ����ID
  root           text ,                -- ����̾
  sort           int2 NOT NULL,        -- ����
  flag_show      int2 DEFAULT 1        -- �����ե饰 : 1=���� 2=�����
);

 INSERT INTO tm_root VALUES(  1,   '�֥��ξҲ�',   1 ); 
 INSERT INTO tm_root VALUES(  2,   '�����ȤξҲ�',   2 ); 
 INSERT INTO tm_root VALUES(  3,   '���ޥ��ξҲ�', 3 ); 
 INSERT INTO tm_root VALUES(  4,   '�οͤ���ξҲ�', 4 ); 
 INSERT INTO tm_root VALUES(  5,   '���饷�򸫤�',   5 ); 
 INSERT INTO tm_root VALUES(  6,   'itm.ne.jp���',  6 ); 
 INSERT INTO tm_root VALUES(  7,   'it1616.com���', 7 ); 
 INSERT INTO tm_root VALUES(  8,   'Google����',     8 ); 
 INSERT INTO tm_root VALUES(  9,   'Google����',     9 ); 
 INSERT INTO tm_root VALUES(  10,  'Yahoo����',     10 ); 
 INSERT INTO tm_root VALUES(  11,  'Yahoo����',     11 ); 
 INSERT INTO tm_root VALUES(  12,  'infoseek',      12 ); 
 INSERT INTO tm_root VALUES(  13,  'goo',           13 ); 
 INSERT INTO tm_root VALUES(  14,  'MSN',           14 ); 
 INSERT INTO tm_root VALUES( 999,  '����¾',       999 ); 

