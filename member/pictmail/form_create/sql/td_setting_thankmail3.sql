/**********************************************************************

--サンキューメール用テーブル

--テーブル名
td_setting_thankmail

--フィールド名			型名			主キー					説明
applicant_id			serial型	primary key			--登録ID
sendmail_flag			integer型									--サンキューメール送信フラグ
transmit_name			text型										--送信者名
transmit_mailadd	text型										--送信元メールアドレス
return_err				text型										--エラー戻り先メールアドレス
subject						text型										--件名
text_mess					text型										--テキストメッセージ
html_flag					integer型									--html使用フラグ
html_mess					text型										--htmlメッセージ
del_flag					integer型									--Deleteフラグ
date							timestamp型								--日付
user_id						integer型			notnull			--ユーザーID

************************************************************************/

--テーブル作成用SQL文

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