<?PHP
/*
	�����å��ץ����
*/

	function dataCheck($aData){
	global $cCheck;
	$errorMsg = "";

	//�����Ĥ��ǡ�������
	//$aData['zip']      = $aData['zip1'].$aData['zip2'];
	$aData['tel']        = $aData['tel1'].$aData['tel2'].$aData['tel3'];
	//$aData['phone']      = $aData['phone1'].$aData['phone2'].$aData['phone3'];
	$aData['mail_conf']  = $aData['mail_conf1']."@".$aData['mail_conf2'];
	//$aData['birthday'] = sprintf("%04d-%02d-%02d", $aData['year'], $aData['month'], $aData['day']);


	//̤����&���������å�
		if(!$aData['name_kana_sei']){
			$errorMsg[] = '�եꥬ��(��)�����Ϥ��Ƥ�������';
		}else{
			if(!$cCheck->isKataKana($aData['name_kana_sei'])){
				$errorMsg[] = '�եꥬ�ʡ����ˤ����ѥ������ʤ����Ϥ��Ƥ�������';
			}
		}
		if(!$aData['name_kana_mei']){
			$errorMsg[] = '�եꥬ�ʡ�̾�ˤ����Ϥ��Ƥ�������';
		}else{
			if(!$cCheck->isKataKana($aData['name_kana_mei'])){
				$errorMsg[] = '�եꥬ�ʡ�̾�ˤ����ѥ������ʤ����Ϥ��Ƥ�������';
			}
		}

		if(!$aData['name_sei']){
			$errorMsg[] = '̾��(��)�����Ϥ��Ƥ�������';
		}
		if(!$aData['name_mei']){
			$errorMsg[] = '̾����̾�ˤ����Ϥ��Ƥ�������';
		}

		if(!$aData['mail']){
			$errorMsg[] = '�᡼�륢�ɥ쥹�����Ϥ��Ƥ�������';
		}elseif(!$cCheck->isMail($aData['mail'])){
			$errorMsg[] = '�᡼�륢�ɥ쥹�����������Ϥ��Ƥ�������';
		}
		if(!$aData['mail_conf']){
			$errorMsg[] = '�᡼�륢�ɥ쥹�ʳ�ǧ�ѡˤ����Ϥ��Ƥ�������';
		}elseif(!$cCheck->isMail($aData['mail_conf'])){
			$errorMsg[] = '�᡼�륢�ɥ쥹�ʳ�ǧ�ѡˤ����������Ϥ��Ƥ�������';
		}

		if( $aData['mail'] && $aData['mail_conf']){
			if($aData['mail'] != $aData['mail_conf']){
				$errorMsg[] = '��ǧ�ѥ᡼�륢�ɥ쥹�Ȱ��פ��ޤ���';
			}
		}

		if($aData['tel']){
			if(!$cCheck->isNumber($aData['tel'])){
			 $errorMsg[] = '�����ֹ�����������Ϥ��Ƥ�������';
			}
		}
/*
		if( !$aData['renraku']){
				$errorMsg[] = '��Ϣ����ˡ�����򤷤Ƥ���������';
		}
*/
		if(!$aData['comment']){
			$errorMsg[] = '���䤤��碌���Ƥ����Ϥ��Ƥ�������';
		}

/*
		if($aData['renraku']!="�᡼��ǤΤ�Ϣ��"){
			if(!$aData['tel']){
				$errorMsg[] = '��Ϣ����ˡ�����äξ��������ֹ�����Ϥ��Ƥ�������';
			}
		}
*/
		
	return $errorMsg;
	}

?>