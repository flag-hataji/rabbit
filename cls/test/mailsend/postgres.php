<?php
/**
*�ģ���Ͽ��
*/

/*��Ͽ�ǡ�����POST��
[aData] => Array
-[title] => hataji@itm.ne.jp
-[message] => Ȩ�ʶ�ʿ
-[user_id] => 1
*/

/*
DB�ǡ���
CREATE TABLE td_mmail_message (
  mmail_message_id  int4 DEFAULT NEXTVAL('td_mmail_message_seq') PRIMARY KEY,
  user_id           text NOT NULL,                                      -- �桼�����ɣ�
  name              text NOT NULL,                                      -- ������
  from_mail         text NOT NULL,                                      -- �������ᥢ��
  error_mail        text NOT NULL,                                      -- ���顼�����ᥢ��
  title             text NOT NULL,                                      -- �����ȥ�
  message           text NOT NULL,                                      -- ��å�������ʸ
  date_insert       timestamp without time zone NOT NULL Default now()  -- ��Ͽ��
);

*/

	/**
	*Insert Main
	*/
	function registDbMain($aData){
	global $cPostgres  ;

		foreach($aData as $key => $value){//���󥰥륳���ơ�����󡢥��֥륳���ơ�����󥨥�������
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