#!/usr/local/bin/php -q
<?php

	require_once ('/www/vhosts/test.itm-asp.com/html/lib/Postgres.php');
	$cPostgres   = new Postgres();

	
	define("_DEBUG_",false );//デバッグ
	
	
	if(!isset($_SERVER['argc'])){
		mb_send_mail ( "hataji@itm.ne.jp", "mobail_mail_error" , "BatchQuery ERROR!" , "hataji@itm.ne.jp" , "-fhataji@itm.ne.jp" );
		exit;
	}else{
		main ();
	}
	
	/**
	*Insert Main
	*/
	function main(){
	global $cPostgres  ;
	
		pg_query($cPostgres->connection, "BEGIN");
		
		$query_message  = "SELECT * FROM td_mmail_message WHERE mmail_message_id = {$_SERVER['argv'][1]} ";
		if(_DEBUG_){ echo $query_message."\n";}
		$dataM          = $cPostgres->executeQuery($query_message);
 		$mmailData      = pg_fetch_array($dataM);
		print_r($mmailData);
		
 		$mmailData['user_id_10000'] = $mmailData['user_id']+10000;//メール配信とかぶらないように＋100000
 		
		$mmailData['subject'] = str_replace("'","\'",$mmailData['subject']);
		$mmailData['subject'] = str_replace('"','\"',$mmailData['subject']);
		
		$mmailData['message'] = str_replace("'","\'",$mmailData['message']);
		$mmailData['message'] = str_replace('"','\"',$mmailData['message']);
 		
 		$query_insert  = "INSERT INTO td_message ";
		$query_insert .= " ( user_id, count, email_from, email_from_name, email_error, subject, message, send_date, flag_html ) ";
		$query_insert .= " VALUES( ";
		$query_insert .= " {$mmailData['user_id_10000']},";
		$query_insert .= " 1,";
		$query_insert .= " '{$mmailData['from_mail']}',";
		$query_insert .= " '{$mmailData['name']}',";
		$query_insert .= " '{$mmailData['error_mail']}',";
		$query_insert .= " '{$mmailData['subject']}',";
		$query_insert .= " '{$mmailData['message']}',";
		$query_insert .= " NOW(),";
		$query_insert .= " 0";
		$query_insert .= " ) ";

		//if(_DEBUG_){ echo $query_insert."\n";}
		$cPostgres->executeUpdate($query_insert);
		
		$query_member = "SELECT * FROM td_mmail_member WHERE user_id = {$mmailData['user_id']} ";
		if(_DEBUG_){ echo $query_member."\n";}
			
		$dataMember  = $cPostgres->executeQuery($query_member);
		while ($getData = pg_fetch_array($dataMember)){
			
	 		$query_insert2  = "INSERT INTO td_mailq ";
			$query_insert2 .= " ( email, email_name, message_id, flag_pc ) ";
			$query_insert2 .= " VALUES( ";
			$query_insert2 .= " '{$getData['email']}',";
			$query_insert2 .= " '{$getData['name']}',";
			$query_insert2 .= " currval('td_message_message_id_seq'),";
			$query_insert2 .= " 'T'";
			$query_insert2 .= " ) ";

			
			$cPostgres->executeUpdate($query_insert2);
			//explode("-",$newsData['day']);
			if(_DEBUG_){ echo $query_insert2."\n";}
		}
	
	$query_del = "DELETE FROM td_mmail_message WHERE mmail_message_id = {$_SERVER['argv'][1]}";
	$cPostgres->executeUpdate($query_del);
	pg_query($cPostgres->connection, "COMMIT");
	
	return;
	}

	
?>