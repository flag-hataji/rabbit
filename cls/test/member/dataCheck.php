<?PHP
/**
*	�����å��ץ����
*/

	function dataCheck($aData){
	global $cCheck  , $cDb;
	$errorMsg = "";

	//�����Ĥ��ǡ�������
	//$aData['zip']      = $aData['zip1'].$aData['zip2'];
	//$aData['tel']        = $aData['tel1'].$aData['tel2'].$aData['tel3'];

	//$aData['mail_conf']  = $aData['mail_conf1']."@".$aData['mail_conf2'];
	//$aData['birthday'] = sprintf("%04d-%02d-%02d", $aData['year'], $aData['month'], $aData['day']);
	

	//̤����&���������å� 

/*
		if(!$aData['name']){
			$errorMsg[] = '̾�������Ϥ��Ƥ�������';
		}
*/
		if(!$aData['email']){
			$errorMsg[] = 'E-mail�����Ϥ��Ƥ�������';
		}elseif(!$cCheck->isMail($aData['email'])){
			$errorMsg[] = 'E-mail�����������Ϥ��Ƥ�������';
		}

	return $errorMsg;
	}

?>