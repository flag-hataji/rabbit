<?php

//�ģ¥��饹�ե������ɤ߹���
require_once("base_DB.class.php");

/**
SQL��Ϣ���饹
*/
class SqlData extends base_DB{
	
	//����¦�᡼�륢�ɥ쥹
	var $from_mail_add;
	
	//����¦�᡼�륢�ɥ쥹
	var $to_mail_add;
	
	//����
	var $dt;
	
	//�桼����ID
	var $user_id;
	
	/**
	���᡼�뤫��������᡼�륢�ɥ쥹��DB����¸
	*/
	function setMobailMailAdd($from,$user_id)
	{
		//����������
		$from      =  pg_escape_string($from);
		$user_id   =  pg_escape_string($user_id);
		
		//SQLʸȯ��
		$sql = "insert into td_userdata(".
		"applicant_id,user_mail_add,".
		"del_flag,dt,user_id) ".
		"values(nextval('td_userData_applicant_id_seq'),".
		"'$from','0','now()','$user_id')";
		
		//������¹�
		$res = pg_query($sql);
		if($res===false){
			echo "�ǡ�������¸�˼��Ԥ��ޤ���";
			exit;
		}
		return true;
	}
	
	function getMailData($user_id){
		
		//������ȯ��
		$sql = "select * from td_setting_thankmail3 where user_id = ".$user_id;
		
		//������¹�
		$res = pg_query($sql);
		
		$arr = pg_fetch_assoc($res);
		return $arr;
	}
}

?>