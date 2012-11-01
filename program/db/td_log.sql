
-- �᡼�����ۿ������ƥ��� DB

-------------------------------------------------
--  ��������
-------------------------------------------------
DROP TABLE    td_log;
DROP SEQUENCE td_log_seq;

CREATE TABLE td_log (
  log_id            int4 DEFAULT NEXTVAL('td_user_seq') PRIMARY KEY,
  user_id           int4 NOT NULL,                                      -- �����桼����ID
  message_id        int4 NOT NULL,                                      -- ��å�����ID
  name_from         text NOT NULL,                                      -- ������̾
  mail_from         text NOT NULL,                                      -- �����ԥ��ɥ쥹
  mail_error        text NOT NULL,                                      -- ���顼����襢�ɥ쥹
  month_count       int4 NOT NULL,                                      -- ��������������
  send_count        int4 NOT NULL,                                      -- ��������ʣУ�&���ӥȡ������
  send_count_pc     int4 NOT NULL,                                      -- ��������ʣУø�����
  send_count_mobile int4 NOT NULL,                                      -- ��������ʷ��Ӹ�����
  subject           text NOT NULL,                                      -- ��̾
  message           text NOT NULL,                                      -- ��å�����
  message_html      text NOT NULL,                                      -- ��å�����HTML
  send_date         timestamp without time zone NOT NULL,               -- ����ͽ����
  flag_pc           int2 NOT NULL,                                      -- �Уø����᡼���ۿ����֡�0=�������ʤ� 1=�����Ԥ�  2=������ 3=����󥻥� 99=��λ
  flag_mobile       int2 NOT NULL,                                      -- ���Ӹ����᡼���ۿ����֡�0=�������ʤ� 1=�����Ԥ�  2=������ 3=����󥻥� 99=��λ
  flag_type         int2 NOT NULL,                                      -- �᡼���ۿ������ס�1=PC�Τ� 2=���ӤΤ� 3=PC������
  ip                text NOT NULL,                                      -- IP
  host              text NOT NULL,                                      -- �ۥ��ȥ͡���
  date_pc           timestamp without time zone NOT NULL Default now(), -- �Уø����᡼���ۿ����� �ѹ���
  date_mobile       timestamp without time zone NOT NULL Default now(), -- ���Ӹ����᡼���ۿ����� �ѹ���
  date_insert       timestamp without time zone NOT NULL Default now()  -- ��Ͽ��
);


-- �������󥹤κ���
CREATE SEQUENCE td_log_seq ;

-- ���¤�����
GRANT ALL ON td_log     TO pgsql ;
GRANT ALL ON td_log_seq TO pgsql ;
