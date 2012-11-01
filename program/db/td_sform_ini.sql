
-- �᡼�����ۿ������ƥ��� DB


-------------------------------------------------
--  ��������
-------------------------------------------------
DROP TABLE    td_sform_ini;
DROP SEQUENCE td_sform_ini_seq;

-- �������󥹤κ���
CREATE SEQUENCE td_sform_ini_seq ;


CREATE TABLE td_sform_ini (
  sform_ini_id   int4 DEFAULT NEXTVAL('td_sform_ini_seq') PRIMARY KEY,
  user_id        int4 NOT NULL,                                     -- �����桼����ID
  scenario_id    int4 ,                                             -- ���ʥꥪID
  sform_name     text ,                                             -- �ե�����̾
  company_name_ini     text ,                                       -- ���̾����ʣ���ɽ��������ɽ��������ɽ����ɬ�ܡ�
  post_ini       text ,                                             -- �򿦼�̾����ʣ���ɽ��������ɽ��������ɽ����ɬ�ܡ�
  param1_name    text ,                                             -- �ѥ�᡼�����͡���
  param1_ini     text ,                                             -- �ѥ�᡼��������ʣ���ɽ��������ɽ��������ɽ����ɬ�ܡ�
  param2_name    text ,                                             -- �ѥ�᡼�����͡���
  param2_ini     text ,                                             -- �ѥ�᡼��������ʣ���ɽ��������ɽ��������ɽ����ɬ�ܡ�
  param3_name    text ,                                             -- �ѥ�᡼�����͡���
  param3_ini     text ,                                             -- �ѥ�᡼��������ʣ���ɽ��������ɽ��������ɽ����ɬ�ܡ�
  param4_name    text ,                                             -- �ѥ�᡼�����͡���
  param4_ini     text ,                                             -- �ѥ�᡼��������ʣ���ɽ��������ɽ��������ɽ����ɬ�ܡ�
  param5_name    text ,                                             -- �ѥ�᡼�����͡���
  param5_ini     text ,                                             -- �ѥ�᡼��������ʣ���ɽ��������ɽ��������ɽ����ɬ�ܡ�
  param6_name    text ,                                             -- �ѥ�᡼�����͡���
  param6_ini     text ,                                             -- �ѥ�᡼��������ʣ���ɽ��������ɽ��������ɽ����ɬ�ܡ�
  param7_name    text ,                                             -- �ѥ�᡼�����͡���
  param7_ini     text ,                                             -- �ѥ�᡼��������ʣ���ɽ��������ɽ��������ɽ����ɬ�ܡ�
  param8_name    text ,                                             -- �ѥ�᡼�����͡���
  param8_ini     text ,                                             -- �ѥ�᡼��������ʣ���ɽ��������ɽ��������ɽ����ɬ�ܡ�
  param9_name    text ,                                             -- �ѥ�᡼�����͡���
  param9_ini     text ,                                             -- �ѥ�᡼��������ʣ���ɽ��������ɽ��������ɽ����ɬ�ܡ�
  param10_name   text ,                                             -- �ѥ�᡼�������͡���
  param10_ini    text ,                                             -- �ѥ�᡼����������ʣ���ɽ��������ɽ��������ɽ����ɬ�ܡ�
  heder          text ,                                             -- �ե�����Υإå���
  bg_color       text ,                                             -- �Хå����顼
  line_color     text ,                                             -- �饤�󥫥顼
  font_color     text ,                                             -- �ե���ȥ��顼
  chara_code     text ,                                             -- ʸ��������
  mail           text ,                                             -- ���󥭥塼�᡼��������
  mail_text      text ,                                             -- ���󥭥塼�᡼����ʸ
  flag_mailsend  boolean default 't',                               -- ��Ͽ�Ԥ˥᡼������뤫�ɤ���
  back_url       text ,                                             -- �ɤδ�λ��URL����뤫
  date_insert    timestamp without time zone NOT NULL Default now(), -- ��Ͽ��
  date_update    timestamp ,                                         -- ������
  flag_del       boolean default 'f'                                 -- ����ե饰
);


-- ���¤�����
GRANT ALL ON td_sform_ini      TO pgsql ;
GRANT ALL ON td_sform_ini_seq  TO pgsql ;
