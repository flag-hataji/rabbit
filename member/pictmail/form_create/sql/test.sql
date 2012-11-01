--td_from_create用テストSQL

/*
insert into td_form_create values('1','DBテストフォーム名','DBテストフォームヘッダー名','DBテストパラメータ１','1','DBテストパラメータ２','2','DBテストパラメータ３','2','DBテストパラメータ４','0','DBテストパラメータ５','0','http://www.itm-asp.test.com','0','now()','55')
insert into td_form_create (applicant_id,form_name,form_header,param1,param2,param3,param4,param5,check1,check3,thk_url,del_flag,date,user_id) values(nextval('td_form_create_applicant_id_seq'),'a','a','パラメーター1','パラメーター2','パラメーター3','パラメーター4','パラメーター5',2,2,'http://www.yahoo.co.jp',0,'now()',3);
insert into td_form_create(applicant_id,form_name,form_header,param1,param2,param3,param4,param5,check1,check3,thk_url,del_flag,date,user_id) values(nextval('td_form_create_applicant_id_seq'),'','','パラメーター1','パラメーター2','パラメーター3','パラメーター4','パラメーター5',2,2,'http://www.yahoo.co.jp',0,'now() ',2;
*/

/*
--td_setting_thankmail用テストSQL

--メール、htmlテキストフラグONテスト用
insert into td_setting_thankmail values(nextval('td_setting_tha_applicant_id_seq'),1,'フラグONテスト送信者名','テスト送信元Madd','テストエラー先Madd','テスト件名','テストテキストメッセージ','1','テストｈｔｍｌメッセージ',0,'now()',1);

--メール、htmlテキストフラグOFFテスト用
insert into td_setting_thankmail values(nextval('td_setting_tha_applicant_id_seq'),0,'フラグOFFテスト送信者名','テスト送信元Madd','テストエラー先Madd','テスト件名','テストテキストメッセージ','0','テストｈｔｍｌメッセージ',0,'now()',2);

--insert文テスト用
insert into td_setting_thankmail values(nextval('td_setting_tha_applicant_id_seq'),1,'フラグテスト送信者名変更', 'a@a.a','a@a.a','テスト件名','テスト中',1,'テストｈｔｍｌメッセージ',0,'now()',3);

--update文テスト用
update td_setting_thankmail set sendmail_flag=1,transmit_name='テスト',transmit_mailadd='a@a.a',return_err= 'a@a.a',subject='テスト',text_mess='テスト\" \\',html_flag=1,html_mess='テスト\'\'\"',del_flag=0,date='now()' where user_id=1;
*/

--td_userData用SQL
--フォームデータ挿入文
insert into td_userData(applicant_id,name_family,name_first,user_mail_add,param1,param2,param3,param4,param5,param_name1,param_name2,param_name3,param_name4,param_name5,del_flag,date,user_id) values(nextval('td_userData_applicant_id_seq'),'テスト苗字','テスト名前', 'tes@itm.a','テストパラム１','testparam2','','てすとぱらむ４','','テストパ1\\','テストパラム２\'','','パラメーター4\"','',0,now(),100);

--CSV DL用SQL
select name_family,name_first,user_mail_add,DATE_FORMAT( date,'%Y/%m/%d %T') from td_userdata order by date desc limit 100;