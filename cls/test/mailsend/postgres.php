<?php
/**
*ＤＢ登録用
*/

/*登録データ（POST）
[aData] => Array
-[title] => hataji@itm.ne.jp
-[message] => 幡司恭平
-[user_id] => 1
*/

/*
DBデータ
CREATE TABLE td_mmail_message (
  mmail_message_id  int4 DEFAULT NEXTVAL('td_mmail_message_seq') PRIMARY KEY,
  user_id           text NOT NULL,                                      -- ユーザーＩＤ
  name              text NOT NULL,                                      -- 送信者
  from_mail         text NOT NULL,                                      -- 送信元メアド
  error_mail        text NOT NULL,                                      -- エラー戻り先メアド
  title             text NOT NULL,                                      -- タイトル
  message           text NOT NULL,                                      -- メッセージ本文
  date_insert       timestamp without time zone NOT NULL Default now()  -- 登録日
);

*/

	/**
	*Insert Main
	*/
	function registDbMain($aData){
	global $cPostgres  ;

		foreach($aData as $key => $value){//シングルコーテーション、ダブルコーテーションエスケープ
			//$aData[$key] = htmlspecialchars($aData[$key], ENT_QUOTES);
			$aData[$key] = str_replace("'","\'",$aData[$key]);
			$aData[$key] = str_replace('"','\"',$aData[$key]);
		}
	
		$query  = "INSERT INTO td_mmail_message ";
		$query .= " ( user_id , name , from_mail , error_mail , subject , message) ";
		$query .= " VALUES( ";
		$query .= " {$_SESSION['login']['mmail_user_id']},";
		$query .= " '{$_SESSION['login']['name']}',";
		$query .= " '{$_SESSION['login']['user_mail']}',";
		$query .= " 'hataji@itm.ne.jp',";
		$query .= " '{$aData['subject']}',";
		$query .= " '{$aData['message']}'";
		$query .= " ) ";

		if(_DEBUG_){ echo $query ; }
		$cPostgres->executeUpdate($query);
	return;
	}
?>