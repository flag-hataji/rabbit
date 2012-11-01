
-- �᡼�����ۿ������ƥ��� DB
-- �ե�����(���󥭥塼�᡼��)


-------------------------------------------------
--  ��������
-------------------------------------------------
DROP TABLE    td_sform_mail;
DROP SEQUENCE td_sform_mail_seq;

-- �������󥹤κ���
CREATE SEQUENCE td_sform_mail_seq ;


CREATE TABLE td_sform_mail (
  sform_mail_id   int4 DEFAULT NEXTVAL('td_sform_mail_seq') PRIMARY KEY,
  sform_ini_id    int4 NOT NULL,                                     -- �����桼����ID
  flag_mailsend   boolean default 't',                               -- ��Ͽ�Ԥ˥᡼������뤫�ɤ���
  email_from      text ,                                             -- �������᡼�륢�ɥ쥹
  email_from_text text ,                                             -- �������᡼��̾��
  email_error     text ,                                             -- error�����᡼�륢�ɥ쥹
  subject         text ,                                             -- ��̾
  text_msg        text ,                                             -- �ƥ����ȥ᡼����ʸ
  html_msg        text ,                                             -- HTML�᡼����ʸ
  flag_html       boolean default 'f',                               -- HTML�᡼�������ե饰��t=���� f=����ʤ���
  date_insert     timestamp without time zone NOT NULL Default now(), -- ��Ͽ��
  date_update     timestamp ,                                         -- ������
  flag_del        boolean default 'f'                                 -- ����ե饰
);


-- ���¤�����
GRANT ALL ON td_sform_mail      TO pgsql ;
GRANT ALL ON td_sform_mail_seq  TO pgsql ;
