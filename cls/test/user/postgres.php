<?php
/**
*ＤＢ登録用
*/

/*登録データ（POST）
[aData] => Array
-[name_kana] => ハタジ
-[name] => 幡司
-[user_mail] => hataji@itm.ne.jp
-[pass] => 123456
-[company] => 株式会社アイティエム
-[company_kana] => アイティエム
-[tel1] => 092
-[tel2] => 525
-[tel3] => 0081
-[zip] => 8100022
-[address1] => 福岡県
-[address2] => 福岡市中央区薬院３丁目13-11
-[address3] => サナガリアーノ4F
*/

/*
DBデータ

CREATE TABLE td_mmail_user (
  mmail_user_id  int4 DEFAULT NEXTVAL('td_mmail_user_seq') PRIMARY KEY,
  pass           text NOT NULL,                                      -- password
  name           text NOT NULL,                                      -- 名前
  name_kana      text NOT NULL,                                      -- カナ
  company        text ,                                              -- 会社名
  company_kana   text ,                                              -- 会社名カナ
  zip            text ,                                              -- 〒
  address1       text ,                                              -- 住所１
  address2       text ,                                              -- 住所２
  address3       text ,                                              -- 住所３
  tel            text ,                                              -- 電話番号
  user_email     text NOT NULL,                                      -- メールアドレス
  date_insert    timestamp without time zone NOT NULL Default now(), -- 登録日
  flag_delete    boolean                                             -- 削除フラグ
);
*/
	/**
	*Insert Main
	*/
	function registDbMain($aData){
	global $cDb;
	
		$query = "INSERT INTO td_mmail_user ";
		$query .= " ( pass , name , name_kana , company , company_kana , zip , address1 , address2 , address3 , tel , user_mail ) ";
		$query .= " VALUES( ";
		$query .= " '{$aData['pass']}',";
		$query .= " '{$aData['name']}',";
		$query .= " '{$aData['name_kana']}',";
		$query .= " '{$aData['company']}',";
		$query .= " '{$aData['company_kana']}', ";
		$query .= " '{$aData['zip']}',";
		$query .= " '{$aData['address1']}',";
		$query .= " '{$aData['address2']}',";
		$query .= " '{$aData['address3']}',";
		$query .= " '{$aData['tel1']}-{$aData['tel2']}-{$aData['tel3']}',";
		$query .= " '{$aData['user_mail']}'";
		$query .= " ) ";
		
		foreach($aData as $key => $value){//シングルコーテーション、ダブルコーテーションエスケープ
			$aData[$key] = htmlspecialchars($aData[$key], ENT_QUOTES);
//			$aData[$key] = str_replace("'","\'",$value);
//			$aData[$key] = str_replace('"','\"',$value);
		}
		
		if(_DEBUG_){ echo $query ; }
		$cDb->executeUpdate($query);
	return;
	}

	/**
	*Update Main
	*/
	function updateDbMain($aData){
	global $cDb;
	
		$query  = "UPDATE td_mmail_user SET  ";
		$query .= " pass = '{$aData['pass']}',";
		$query .= " name = '{$aData['name']}',";
		$query .= " name_kana = '{$aData['name_kana']}',";
		$query .= " company = '{$aData['company']}',";
		$query .= " company_kana = '{$aData['company_kana']}', ";
		$query .= " zip =  '{$aData['zip']}',";
		$query .= " address1 = '{$aData['address1']}',";
		$query .= " address2 =  '{$aData['address2']}',";
		$query .= " address3 =  '{$aData['address3']}',";
		$query .= " tel = '{$aData['tel1']}-{$aData['tel2']}-{$aData['tel3']}',";
		$query .= " user_mail = '{$aData['user_mail']}'";
		$query .= " WHERE mmail_user_id = {$aData['mmail_user_id']} ";
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