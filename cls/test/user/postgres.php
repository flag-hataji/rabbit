<?php
/**
*�ģ���Ͽ��
*/

/*��Ͽ�ǡ�����POST��
[aData] => Array
-[name_kana] => �ϥ���
-[name] => Ȩ��
-[user_mail] => hataji@itm.ne.jp
-[pass] => 123456
-[company] => ������ҥ����ƥ�����
-[company_kana] => �����ƥ�����
-[tel1] => 092
-[tel2] => 525
-[tel3] => 0081
-[zip] => 8100022
-[address1] => ʡ����
-[address2] => ʡ�������������������13-11
-[address3] => ���ʥ��ꥢ����4F
*/

/*
DB�ǡ���

CREATE TABLE td_mmail_user (
  mmail_user_id  int4 DEFAULT NEXTVAL('td_mmail_user_seq') PRIMARY KEY,
  pass           text NOT NULL,                                      -- password
  name           text NOT NULL,                                      -- ̾��
  name_kana      text NOT NULL,                                      -- ����
  company        text ,                                              -- ���̾
  company_kana   text ,                                              -- ���̾����
  zip            text ,                                              -- ��
  address1       text ,                                              -- ���꣱
  address2       text ,                                              -- ���ꣲ
  address3       text ,                                              -- ���ꣳ
  tel            text ,                                              -- �����ֹ�
  user_email     text NOT NULL,                                      -- �᡼�륢�ɥ쥹
  date_insert    timestamp without time zone NOT NULL Default now(), -- ��Ͽ��
  flag_delete    boolean                                             -- ����ե饰
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
		
		foreach($aData as $key => $value){//���󥰥륳���ơ�����󡢥��֥륳���ơ�����󥨥�������
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
		
		foreach($aData as $key => $value){//���󥰥륳���ơ�����󡢥��֥륳���ơ�����󥨥�������
			$aData[$key] = htmlspecialchars($aData[$key], ENT_QUOTES);
//			$aData[$key] = str_replace("'","\'",$value);
//			$aData[$key] = str_replace('"','\"',$value);
		}
		if(_DEBUG_){ echo $query ; }
		$cDb->executeUpdate($query);
	return;
	}



?>