<?PHP
/**
*	�����å��ץ����
*/

	function dataCheck($aData){
	global $cCheck  , $cDb;
	$errorMsg = "";

	//�����Ĥ��ǡ�������

	echo $aData['zip'] = str_replace("-","",$aData['zip']);
	
	//$aData['zip']      = $aData['zip1'].$aData['zip2'];
	$aData['tel']        = $aData['tel1'].$aData['tel2'].$aData['tel3'];
	//$aData['phone']      = $aData['phone1'].$aData['phone2'].$aData['phone3'];
	//$aData['mail_conf']  = $aData['mail_conf1']."@".$aData['mail_conf2'];
	//$aData['birthday'] = sprintf("%04d-%02d-%02d", $aData['year'], $aData['month'], $aData['day']);
/*
    $query  = "SELECT count(*) FROM td_member WHERE email = '{$aData['email']}' AND password != '{$aData['password']}' AND delete_flag = 'f' ";
    $dataS = $cDb->executeQuery($query);
	$db_email = pg_fetch_array($dataS);

    $query2  = "SELECT count(*) FROM td_member WHERE email = '{$aData['email']}' AND password != '{$aData['password']}' AND delete_flag = 'f' ";
    $dataM = $cDb->executeQuery($query2);
	$db_m_email = pg_fetch_array($dataM);
*/

	//̤����&���������å� 

		if(!$aData['company']){
			$errorMsg[] = '���̾�����Ϥ��Ƥ�������';
		}

		if($aData['company_kana']){
			if(!$cCheck->isKataKana($aData['company_kana'])){
				$errorMsg[] = '���̾�եꥬ�ʤ����ѥ������ʤ����Ϥ��Ƥ�������';
			}
		}

		if(!$aData['industry_3_id']){
			$errorMsg[] = '�ȼ�����򤷤Ƥ�������';
		}

		if(!$aData['zip']){
			$errorMsg[] = '�ܼҽ���ϡ�͹���ֹ�ˤ����Ϥ��Ƥ�������';
		}else{
			if(!$cCheck->isNumberLen($aData['zip'],7)){
				$errorMsg[] = '�ܼҽ���ϡ�͹���ֹ�ˤ����������Ϥ��Ƥ�������';
			}
		}

		if(!$aData['pref_id']){
			$errorMsg[] = '�ܼҽ���ϡʸ��ˤ����Ϥ��Ƥ�������';
		}

		if(!$aData['address1']){
			$errorMsg[] = '�ܼҽ���ϡʽ���ˤ����Ϥ��Ƥ�������';
		}


		if(!$aData['tel']){
			$errorMsg[] = '�����ֹ�����Ϥ��Ƥ�������';
		}else{
			if(!$cCheck->isNumberLen($aData['tel'],10) && !$cCheck->isNumberLen($aData['tel'],11)){
				$errorMsg[] = '�����ֹ�����������Ϥ��Ƥ�������';
			}
		}

		if($aData['fax']){
			if(!$cCheck->isNumberLen($aData['fax'],10) && !$cCheck->isNumberLen($aData['fax'],11)){
				$errorMsg[] = '�ƣ��ؤ����������Ϥ��Ƥ�������';
			}
		}

		if($aData['url']){
			if(!$cCheck->isUrl($aData['url'])){
				$errorMsg[] = '�գң̤����������Ϥ��Ƥ�������';
			}
		}

		if($aData['mail']){
			if(!$cCheck->isMail($aData['mail'])){
				$errorMsg[] = 'E-mail�����������Ϥ��Ƥ�������';
			}
		}

		if(!$aData['charge_post']){
			$errorMsg[] = '���ô������������Ϥ��Ƥ�������';
		}

		if(!$aData['charge']){
			$errorMsg[] = '���ô���Ԥ����Ϥ��Ƥ�������';
		}

		if(!$aData['branch_id']){
			$errorMsg[] = 'ô����Ź�����Ϥ��Ƥ�������';
		}

		if(!$aData['staff_id']){
			$errorMsg[] = '��Źô���Ԥ����Ϥ��Ƥ�������';
		}

	return $errorMsg;
	}

?>