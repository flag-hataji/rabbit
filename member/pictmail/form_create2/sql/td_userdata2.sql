/**********************************************************************
--���������ե����������������¸�ѥơ��֥�

--�ơ��֥�̾
td_userdata2

--�ե������̾				��̾					�祭��					����
applicant_id				serial��			primary key				--��ϿID
name_family					text��													--̾��(��)
name_first					text��													--̾��(̾)
user_mail_add						text��													--�᡼�륢�ɥ쥹
param_name1					text��													--�ѥ�᡼����1̾
param1							text��													--�ѥ�᡼��������������
param_name2					text��													--�ѥ�᡼����2̾
param2							text��													--�ѥ�᡼����2��������
param_name3					text��													--�ѥ�᡼����3̾
param3							text��													--�ѥ�᡼����3��������
param_name4					text��													--�ѥ�᡼����4̾
param4							text��													--�ѥ�᡼����4��������
param_name5					text��													--�ѥ�᡼����5̾
param5							text��													--�ѥ�᡼����5��������
del_flag						integer��												--delete�ե饰
date								timestamp��											--��Ͽ��
user_id							integer��												--�桼����ID
**********************************************************************/

create table td_userdata2(
applicant_id serial primary key,
name_family text,
name_first text,
user_mail_add text,
param_name1 text,
param1 text,
param_name2 text,
param2 text,
param_name3 text,
param3 text,
param_name4 text,
param4 text,
param_name5 text,
param5 text,
del_flag integer,
dt timestamp,
user_id integer
);
