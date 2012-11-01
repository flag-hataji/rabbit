<?php

//ＤＢクラスファイル読み込み
require_once("base_DB.class.php");

/**
SQL関連クラス
*/
class SqlData extends base_DB{
	
	//送信側メールアドレス
	var $from_mail_add;
	
	//受信側メールアドレス
	var $to_mail_add;
	
	//日付
	var $dt;
	
	//ユーザーID
	var $user_id;
	
	/**
	空メールから受けたメールアドレスをDBへ保存
	*/
	function setMobailMailAdd($from,$user_id)
	{
		//エスケープ
		$from      =  pg_escape_string($from);
		$user_id   =  pg_escape_string($user_id);
		
		//SQL文発行
		$sql = "insert into td_userdata(".
		"applicant_id,user_mail_add,".
		"del_flag,dt,user_id) ".
		"values(nextval('td_userData_applicant_id_seq'),".
		"'$from','0','now()','$user_id')";
		
		//クエリ実行
		$res = pg_query($sql);
		if($res===false){
			echo "データの保存に失敗しました";
			exit;
		}
		return true;
	}
	
	function getMailData($user_id){
		
		//クエリ発行
		$sql = "select * from td_setting_thankmail3 where user_id = ".$user_id;
		
		//クエリ実行
		$res = pg_query($sql);
		
		$arr = pg_fetch_assoc($res);
		return $arr;
	}
}

?>