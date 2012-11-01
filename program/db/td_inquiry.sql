-------------------------------------------------
-- ITMASP�����ƥ� DB
-- DB̾���ԥ��ȥ����ƥ�
-------------------------------------------------
--  ���䤤��碌����
-------------------------------------------------

DROP TABLE    td_inquiry;
DROP SEQUENCE td_inquiry_seq;

CREATE TABLE td_inquiry (

  inquiry_id      int4 DEFAULT NEXTVAL('td_inquiry_seq') PRIMARY KEY,
  user_id         int4 ,

  name_family     text NOT NULL,  -- ̾�� ��
  name_first      text NOT NULL,  -- ̾�� ̾
  kana_family     text NOT NULL,  -- �եꥬ�� ��
  kana_first      text NOT NULL,  -- �եꥬ�� ̾

  name_company     text NOT NULL,  -- ̾�� ���̾
  kana_company      text NOT NULL,  -- �եꥬ�� ���̾

  mail            text NOT NULL,  -- �᡼�륢�ɥ쥹
  tel             text,           -- TEL
  mobile          text,           -- ����
  fax             text,           -- FAX

  inquiry         text,           -- ���䤤��碌

  date_insert     timestamp without time zone NOT NULL Default now(), -- ��Ͽ��
  date_update     timestamp without time zone          Default now()  -- ������

);

-- �������󥹤κ���
CREATE SEQUENCE td_inquiry_seq ;

-- ���¤�����
GRANT ALL ON td_inquiry     TO pgsql ;
GRANT ALL ON td_inquiry_seq TO pgsql ;
