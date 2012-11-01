<?PHP
/**
*	チェックプログラム
*/

	function dataCheck($aData){
	global $cCheck  , $cDb;
	$errorMsg = "";

	//いくつかデータを結合
	//$aData['zip']      = $aData['zip1'].$aData['zip2'];
	//$aData['tel']        = $aData['tel1'].$aData['tel2'].$aData['tel3'];

	//$aData['mail_conf']  = $aData['mail_conf1']."@".$aData['mail_conf2'];
	//$aData['birthday'] = sprintf("%04d-%02d-%02d", $aData['year'], $aData['month'], $aData['day']);
	

	//未入力&形式チェック 

/*
		if(!$aData['name']){
			$errorMsg[] = '名前を入力してください';
		}
*/
		if(!$aData['email']){
			$errorMsg[] = 'E-mailを入力してください';
		}elseif(!$cCheck->isMail($aData['email'])){
			$errorMsg[] = 'E-mailを正しく入力してください';
		}

	return $errorMsg;
	}

?>