
-- �᡼�����ۿ������ƥ��� DB


-------------------------------------------------
--  ���顼����
-------------------------------------------------
DROP TABLE    td_error_log;
DROP SEQUENCE td_error_log_seq;

CREATE TABLE td_error_log (
  error_log_id   int4 DEFAULT NEXTVAL('td_error_log_seq') PRIMARY KEY,
  user_id        int4 NOT NULL,                                      -- �����桼����ID
  mail           text NOT NULL,                                      -- ���顼�᡼�륢�ɥ쥹
  error_count    int4 NOT NULL,                                      -- �������
  date_insert    timestamp without time zone NOT NULL Default now(), -- ��Ͽ��
  date_update    timestamp without time zone                         -- ������
);

-- �������󥹤κ���
CREATE SEQUENCE td_error_log_seq ;

-- ���¤�����
GRANT ALL ON td_error_log     TO pgsql ;
GRANT ALL ON td_error_log_seq TO pgsql ;
