/**********************************************************************
--作成したフォームの入力内容保存用テーブル

--テーブル名
td_userdata2

--フィールド名				型名					主キー					説明
applicant_id				serial型			primary key				--登録ID
name_family					text型													--名前(姓)
name_first					text型													--名前(名)
user_mail_add						text型													--メールアドレス
param_name1					text型													--パラメーター1名
param1							text型													--パラメーター１入力内容
param_name2					text型													--パラメーター2名
param2							text型													--パラメーター2入力内容
param_name3					text型													--パラメーター3名
param3							text型													--パラメーター3入力内容
param_name4					text型													--パラメーター4名
param4							text型													--パラメーター4入力内容
param_name5					text型													--パラメーター5名
param5							text型													--パラメーター5入力内容
del_flag						integer型												--deleteフラグ
date								timestamp型											--登録日
user_id							integer型												--ユーザーID
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
