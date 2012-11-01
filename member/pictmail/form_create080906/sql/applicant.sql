/***********************************************************************

--フォーム作成用テーブル

--テーブル名
td_form_create 

--フィールド名		型名			主キー				説明

applicant_id		serial型		primary key  	--登録ＩＤ
form_name				text型										--フォーム名
form_header			text型										--フォームヘッダー
param1					text型										--パラメーター１表記名
check1					smallint型								--パラメーター１チェック値
param2					text型										--パラメーター２表記名
check2					smallint型								--パラメーター２チェック値
param3					text型										--パラメーター３表記名
check3					smallint型								--パラメーター３チェック値
param4					text型										--パラメーター４表記名
check4					smallint型								--パラメーター４チェック値
param5					text型										--パラメーター５表記名
check5					smallint型								--パラメーター５チェック値
thk_url					text型										--サンキューページ戻り先ＵＲＬ
del_flag				integer型											--Deleteフラグ
date						timestamp型								--日付
user_id					integer型		notnull			--ユーザーＩＤ

***********************************************************************/


--テーブル作成用

create table td_form_create(
applicant_id serial primary key,
form_name text,
form_header text,
param1 text,
check1 smallint,
param2 text,
check2 smallint,
param3 text,
check3 smallint,
param4 text,
check4 smallint,
param5 text,
check5 smallint,
thk_url text,
del_flag integer,
dt timestamp,
user_id integer not null
);