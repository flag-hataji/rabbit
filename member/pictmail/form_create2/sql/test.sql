--td_from_create�ѥƥ���SQL

/*
insert into td_form_create values('1','DB�ƥ��ȥե�����̾','DB�ƥ��ȥե�����إå���̾','DB�ƥ��ȥѥ�᡼����','1','DB�ƥ��ȥѥ�᡼����','2','DB�ƥ��ȥѥ�᡼����','2','DB�ƥ��ȥѥ�᡼����','0','DB�ƥ��ȥѥ�᡼����','0','http://www.itm-asp.test.com','0','now()','55')
insert into td_form_create (applicant_id,form_name,form_header,param1,param2,param3,param4,param5,check1,check3,thk_url,del_flag,date,user_id) values(nextval('td_form_create_applicant_id_seq'),'a','a','�ѥ�᡼����1','�ѥ�᡼����2','�ѥ�᡼����3','�ѥ�᡼����4','�ѥ�᡼����5',2,2,'http://www.yahoo.co.jp',0,'now()',3);
insert into td_form_create(applicant_id,form_name,form_header,param1,param2,param3,param4,param5,check1,check3,thk_url,del_flag,date,user_id) values(nextval('td_form_create_applicant_id_seq'),'','','�ѥ�᡼����1','�ѥ�᡼����2','�ѥ�᡼����3','�ѥ�᡼����4','�ѥ�᡼����5',2,2,'http://www.yahoo.co.jp',0,'now() ',2;
*/

/*
--td_setting_thankmail�ѥƥ���SQL

--�᡼�롢html�ƥ����ȥե饰ON�ƥ�����
insert into td_setting_thankmail values(nextval('td_setting_tha_applicant_id_seq'),1,'�ե饰ON�ƥ���������̾','�ƥ���������Madd','�ƥ��ȥ��顼��Madd','�ƥ��ȷ�̾','�ƥ��ȥƥ����ȥ�å�����','1','�ƥ��ȣ������å�����',0,'now()',1);

--�᡼�롢html�ƥ����ȥե饰OFF�ƥ�����
insert into td_setting_thankmail values(nextval('td_setting_tha_applicant_id_seq'),0,'�ե饰OFF�ƥ���������̾','�ƥ���������Madd','�ƥ��ȥ��顼��Madd','�ƥ��ȷ�̾','�ƥ��ȥƥ����ȥ�å�����','0','�ƥ��ȣ������å�����',0,'now()',2);

--insertʸ�ƥ�����
insert into td_setting_thankmail values(nextval('td_setting_tha_applicant_id_seq'),1,'�ե饰�ƥ���������̾�ѹ�', 'a@a.a','a@a.a','�ƥ��ȷ�̾','�ƥ�����',1,'�ƥ��ȣ������å�����',0,'now()',3);

--updateʸ�ƥ�����
update td_setting_thankmail set sendmail_flag=1,transmit_name='�ƥ���',transmit_mailadd='a@a.a',return_err= 'a@a.a',subject='�ƥ���',text_mess='�ƥ���\" \\',html_flag=1,html_mess='�ƥ���\'\'\"',del_flag=0,date='now()' where user_id=1;
*/

--td_userData��SQL
--�ե�����ǡ�������ʸ
insert into td_userData(applicant_id,name_family,name_first,user_mail_add,param1,param2,param3,param4,param5,param_name1,param_name2,param_name3,param_name4,param_name5,del_flag,date,user_id) values(nextval('td_userData_applicant_id_seq'),'�ƥ����Ļ�','�ƥ���̾��', 'tes@itm.a','�ƥ��ȥѥ�ࣱ','testparam2','','�Ƥ��ȤѤ�ࣴ','','�ƥ��ȥ�1\\','�ƥ��ȥѥ�ࣲ\'','','�ѥ�᡼����4\"','',0,now(),100);

--CSV DL��SQL
select name_family,name_first,user_mail_add,DATE_FORMAT( date,'%Y/%m/%d %T') from td_userdata order by date desc limit 100;