<?PHP
/*
	�����å��ץ����
*/

	function dataCheck($aData){
	global $cCheck;
	$errorMsg = "";

	//̤����&���������å�

		if(!$aData['subject']){
			$errorMsg[] = '��̾�����Ϥ��Ƥ�������';
		}

		if(!$aData['message']){
			$errorMsg[] = '��ʸ�����Ϥ��Ƥ�������';
		}

		
	return $errorMsg;
	}

?>