<?php
/**
*ＤＢ登録用
*/

/*登録データ（POST）
[aData] => Array
-[email] => hataji@itm.ne.jp
-[name] => 幡司恭平
-[user_id] => 1
*/

/*
DBデータ
CREATE TABLE td_mmail_member (
  mmail_member_id int4 DEFAULT NEXTVAL('td_mmail_member_seq') PRIMARY KEY,
  user_id         int4 NOT NULL,                                     -- 送信ユーザーID
  email           text NOT NULL,                                     -- メールアドレス
  name            text ,
  date_insert     timestamp without time zone NOT NULL Default now() -- 登録日
);
*/

	/**
	*Insert Main
	*/
	function registDbMain($aData){
	global $cDb;
	
		$query = "INSERT INTO td_mmail_member ";
		$query .= " ( user_id , email , name) ";
		$query .= " VALUES( ";
		$query .= " {$aData['user_id']},";
		$query .= " '{$aData['email']}',";
		$query .= " '{$aData['name']}'";
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

		$query  = "UPDATE td_mmail_member SET  ";
		$query .= " name  = '{$aData['name']}',";
		$query .= " email = '{$aData['email']}'";
		$query .= " WHERE mmail_member_id = {$aData['mmail_member_id']} ";
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