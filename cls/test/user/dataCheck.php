<?PHP
/**
*	�����å��ץ����
*/

	function dataCheck($aData){
	global $cCheck  , $cDb;
	$errorMsg = "";

	//�����Ĥ��ǡ�������
	//$aData['zip']      = $aData['zip1'].$aData['zip2'];
	$aData['tel']        = $aData['tel1'].$aData['tel2'].$aData['tel3'];

	//$aData['mail_conf']  = $aData['mail_conf1']."@".$aData['mail_conf2'];
	//$aData['birthday'] = sprintf("%04d-%02d-%02d", $aData['year'], $aData['month'], $aData['day']);
	

	//̤����&���������å� 


		if(!$aData['name_kana']){
			$errorMsg[] = '�եꥬ�ʤ����Ϥ��Ƥ�������';
		}else{
			if( !mb_ereg_match("^[��-����0-9��-����]+$",$aData['name_kana']) ){
				$errorMsg[] = '�եꥬ�ʤ����ѥ������ʤ����Ϥ��Ƥ�������';
			}
		}

		if(!$aData['name']){
			$errorMsg[] = '̾�������Ϥ��Ƥ�������';
		}

		if(!$aData['user_mail']){
			$errorMsg[] = 'E-mail�����Ϥ��Ƥ�������';
		}elseif(!$cCheck->isMail($aData['user_mail'])){
			$errorMsg[] = 'E-mail�����������Ϥ��Ƥ�������';
		}

		if(!$aData['pass']){
			$errorMsg[] = 'password�����Ϥ��Ƥ�������';
		}elseif(!$cCheck->isEisu($aData['pass'])){
			$errorMsg[] = 'password��Ⱦ�ѱѿ������Ϥ��Ƥ�������';
		}

		if($aData['tel']){
			echo "TEL == ".$aData['tel'];
			if(!$cCheck->isTel($aData['tel'])){
				$errorMsg[] = '�����ֹ�����������Ϥ��Ƥ�������';
			}
		}
		
		if($aData['zip']){
			if(!$cCheck->isZip($aData['zip']))
			$errorMsg[] = '͹���ֹ�����������Ϥ��Ƥ�������';
		}
		
/*
		if(!$aData['address1']){
			$errorMsg[] = '����(��ƻ�ܸ�)�����Ϥ��Ƥ�������';
		}	
		
		if(!$aData['address2']){
			$errorMsg[] = '����(��Į¼�ʲ�)�����Ϥ��Ƥ�������';
		}
*/

	return $errorMsg;
	}

?>