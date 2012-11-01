-----------------------------------
--  �桼�����ǡ��� ��ĥ1
-----------------------------------
DROP TABLE    td_user_ex1;
DROP SEQUENCE td_user_ex1_seq;

CREATE TABLE td_user_ex1 (
  user_ex1_id    int4 DEFAULT NEXTVAL('td_user_ex1_seq') PRIMARY KEY, -- ID 
  user_id       int4 NOT NULL,                                   -- �桼����ID     : ���� td_user
  root_id       int4 DEFAULT 999,                                -- ��ϩID         : ���� tm_root
  medium_id     int4 DEFAULT 999,                                -- ����ID         : ���� tm_medium
  text_root     text ,                                           -- ��ϩ
  text_medium   text ,                                           -- ����
  ip            text ,                                           -- IP
  host          text ,                                           -- �ۥ���
  referrer      text                                             -- ��ե��顼����Ͽ���κǽ�������

);

-- �������󥹤κ���
CREATE SEQUENCE td_user_ex1_seq ;
