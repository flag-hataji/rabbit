/**********************************************************************

--���󥭥塼�᡼���ѥơ��֥�

--�ơ��֥�̾
td_setting_thankmail

--�ե������̾			��̾			�祭��					����
applicant_id			serial��	primary key			--��ϿID
sendmail_flag			integer��									--���󥭥塼�᡼�������ե饰
transmit_name			text��										--������̾
transmit_mailadd	text��										--�������᡼�륢�ɥ쥹
return_err				text��										--���顼�����᡼�륢�ɥ쥹
subject						text��										--��̾
text_mess					text��										--�ƥ����ȥ�å�����
html_flag					integer��									--html���ѥե饰
html_mess					text��										--html��å�����
del_flag					integer��									--Delete�ե饰
date							timestamp��								--����
user_id						integer��			notnull			--�桼����ID

************************************************************************/

--�ơ��֥������SQLʸ

create table td_setting_thankmail3(
	applicant_id serial primary key,
	sendmail_flag integer,
	transmit_name text,
	transmit_mailadd text,
	return_err text,
	subject text,
	text_mess text,
	html_flag integer,
	html_mess text,
	del_flag integer,
	dt timestamp,
	user_id integer not null
);