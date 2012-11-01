<?php
/**
*ＤＢ登録用
*/

/*登録データ（POST）
[aData] => Array
-[flag_company] => 1
-[company] => 株式会社アイティマネジメント
-[company_kana] => カブシキガイシャアイティマネジメント
-[industry_3_id] => 7
-[activities] => システム
-[pr] => 若い安い間違いない
-[represent] => キヨスエスナオ
-[zip] => 8100021
-[pref_id] => 8
-[address1] => くまー
-[address2] => プルミエール
-[tel1] => 092
-[tel2] => 525
-[tel3] => 0081
-[fax1] => 092
-[fax2] => 525
-[fax3] => 0082
-[url] => http://www.itm.ne.jp
-[email] => hataji@itm.ne.jp
-[charge_post] => システム
-[charge] => ハタジ
-[date_organize1] => 2005
-[date_organize2] => 1
-[date_organize3] => 1
-[date_settling1] => 2002
-[date_settling2] => 3
-[date_settling3] => 30
-[capital] => 100
-[sales] => 120
-[benefit] => 130
-[employ] => 7
-[history] => 2004年　設立 2005年　第一期終了 
-[office] => 福岡
-[relation] => ニシニホンシティ
-[overseas] => 特に無し
-[main_customer] => ペンシル
-[branch_id] => 11
-[staff_id] => 14
-[mail_flag] => f
-[dm1] => DM1
-[dm2] => DM2
-[dm3] => DM3
-[dm4] => DM4
*/


	/**
	*Insert Main
	*/
	function registDbMain($aData){
	global $cPostgres;

		$aData['tel'] = $aData['tel1']."-".$aData['tel2']."-".$aData['tel3'];
		$aData['fax'] = $aData['fax1']."-".$aData['fax2']."-".$aData['fax3'];
		$aData['date_organize'] = $aData['date_organize1']."-".$aData['date_organize2']."-".$aData['date_organize3'];
		$aData['date_settling'] = $aData['date_settling1']."-".$aData['date_settling2']."-".$aData['date_settling3'];
		
		
		if(!$aData['capital']){ $aData['capital'] = 'NULL'; }
		if(!$aData['benefit']){ $aData['benefit'] = 'NULL'; }
		if(!$aData['sales']){  $aData['sales']    = 'NULL'; }
		if(!$aData['employ']){ $aData['employ']   = 'NULL'; }
		
		$i = 1;
		$DM = "";
		while( $aData['dm'.$i] ){
			$DM .= $i."_";
		$i ++;
		}

		foreach($aData as $key => $value){//シングルコーテーション、ダブルコーテーションエスケープ
			$aData[$key] = htmlspecialchars($aData[$key], ENT_QUOTES);
//			$aData[$key] = str_replace("'","\'",$value);
//			$aData[$key] = str_replace('"','\"',$value);
		}
		
		$query = "INSERT INTO td_company ";
		$query .= " VALUES( ";
		$query .= " nextval('td_company_seq'),";
		$query .= " {$aData['branch_id']},";
		$query .= " {$aData['staff_id']},";
		$query .= " {$aData['industry_3_id']},";
		$query .= " '{$aData['company']}', ";
		$query .= " '{$aData['company_kana']}',";
		$query .= " '{$aData['activities']}',";
		$query .= " '{$aData['pr']}',";
		$query .= " '{$aData['represent']}',";
		$query .= " '{$aData['zip']}',";
		$query .= " '{$aData['pref_id']}',";
		$query .= " '{$aData['address1']}',";
		$query .= " '{$aData['address2']}',";
		$query .= " '{$aData['tel']}', ";
		$query .= " '{$aData['fax']}', ";
		$query .= " '{$aData['url']}', ";
		$query .= " '{$aData['mail']}', ";
		$query .= " '{$aData['charge']}', ";
		$query .= " '{$aData['charge_post']}', ";
		$query .= " '{$aData['history']}', ";
		$query .= " '{$aData['office']}', ";
		$query .= " '{$aData['relation']}', ";
		$query .= " '{$aData['overseas']}', ";
		$query .= " '{$aData['main_customer']}', ";
		$query .= " '{$aData['bank']}', ";
		$query .= " '{$aData['date_organize']}', ";
		$query .= " '{$aData['date_settling']}', ";
		$query .= " '{$aData['capital']}', ";
		$query .= " '{$aData['benefit']}', ";
		$query .= " '{$aData['sales']}', ";
		$query .= " '{$aData['employ']}', ";
		$query .= " 1, ";
		$query .= " 'NOW', ";
		$query .= " 'NOW' ";
		$query .= " ) ";
		
		$query2  = "INSERT INTO td_company_dm ";
		$query2 .= " VALUES( ";
		$query2 .= " nextval('td_company_dm_seq'),";
		$query2 .= " currval('td_company_seq'),";
		$query2 .= " '{$DM}',";
		$query2 .= " 'NOW',";
		$query2 .= " 'NOW'";
		$query2 .= " ) ";
		
		if(_DEBUG_){ echo $query ; }
		
		pg_query($cPostgres->connection, 'BEGIN');
		$cPostgres->executeUpdate($query);
		$cPostgres->executeUpdate($query2);
		pg_query($cPostgres->connection, 'COMMIT');
	return;
	}

	/**
	*Update Main
	*/
	function updateDbMain($aData){
	global $cDb;
	
		$query = "UPDATE td_member SET  ";
		$query .= " password = '{$aData['password']}',";
		$query .= " email = '{$aData['email']}',";
		$query .= " m_email = '{$aData['m_email']}',";
		$query .= " name_family = '{$aData['name_family']}', ";
		$query .= " name_first = '{$aData['name_first']}',";
		$query .= " kana_family = '{$aData['kana_family']}',";
		$query .= " kana_first = '{$aData['kana_first']}',";
		$query .= " tel = '{$aData['tel1']}-{$aData['tel2']}-{$aData['tel3']}',";
		$query .= " sex = '{$aData['sex']}',";
		$query .= " birthday = '{$aData['year']}-{$aData['month']}-{$aData['day']}',";
		$query .= " zip = '{$aData['zip']}',";
		$query .= " address1 = '{$aData['address1']}',";
		$query .= " address2 = '{$aData['address2']}',";
		$query .= " address3 = '{$aData['address3']}',";
		$query .= " mail_flag = '{$aData['mail_flag']}', ";
		$query .= " updatedate = 'NOW' , ";
		$query .= " company = '{$aData['company']}', ";
		$query .= " company_kana = '{$aData['company_kana']}', ";
		$query .= " tel_flag = '{$aData['tel_flag']}' ";
		$query .= " WHERE member_id = {$aData['member_id']} ";
		$query .= " ;";
		
		foreach($aData as $key => $value){//シングルコーテーション、ダブルコーテーションエスケープ
			$aData[$key] = htmlspecialchars($aData[$key], ENT_QUOTES);
//			$aData[$key] = str_replace("'","\'",$value);
//			$aData[$key] = str_replace('"','\"',$value);
		}
		if(_DEBUG_){ echo $query ; }
		$cDb->executeUpdate($query);
	return;
	}



?>