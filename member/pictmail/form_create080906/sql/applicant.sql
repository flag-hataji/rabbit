/***********************************************************************

--�ե���������ѥơ��֥�

--�ơ��֥�̾
td_form_create 

--�ե������̾		��̾			�祭��				����

applicant_id		serial��		primary key  	--��Ͽ�ɣ�
form_name				text��										--�ե�����̾
form_header			text��										--�ե�����إå���
param1					text��										--�ѥ�᡼������ɽ��̾
check1					smallint��								--�ѥ�᡼�����������å���
param2					text��										--�ѥ�᡼������ɽ��̾
check2					smallint��								--�ѥ�᡼�����������å���
param3					text��										--�ѥ�᡼������ɽ��̾
check3					smallint��								--�ѥ�᡼�����������å���
param4					text��										--�ѥ�᡼������ɽ��̾
check4					smallint��								--�ѥ�᡼�����������å���
param5					text��										--�ѥ�᡼������ɽ��̾
check5					smallint��								--�ѥ�᡼�����������å���
thk_url					text��										--���󥭥塼�ڡ��������գң�
del_flag				integer��											--Delete�ե饰
date						timestamp��								--����
user_id					integer��		notnull			--�桼�����ɣ�

***********************************************************************/


--�ơ��֥������

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