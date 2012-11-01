<?PHP
/**
*	チェックプログラム
*/

	function dataCheck($aData){
	global $cCheck  , $cDb;
	$errorMsg = "";

	//いくつかデータを結合
	//$aData['zip']      = $aData['zip1'].$aData['zip2'];
	$aData['tel']        = $aData['tel1'].$aData['tel2'].$aData['tel3'];

	//$aData['mail_conf']  = $aData['mail_conf1']."@".$aData['mail_conf2'];
	//$aData['birthday'] = sprintf("%04d-%02d-%02d", $aData['year'], $aData['month'], $aData['day']);
	

	//未入力&形式チェック 


		if(!$aData['name_kana']){
			$errorMsg[] = 'フリガナを入力してください';
		}else{
			if( !mb_ereg_match("^[ァ-ヶー0-9０-９　]+$",$aData['name_kana']) ){
				$errorMsg[] = 'フリガナは全角カタカナで入力してください';
			}
		}

		if(!$aData['name']){
			$errorMsg[] = '名前を入力してください';
		}

		if(!$aData['user_mail']){
			$errorMsg[] = 'E-mailを入力してください';
		}elseif(!$cCheck->isMail($aData['user_mail'])){
			$errorMsg[] = 'E-mailを正しく入力してください';
		}

		if(!$aData['pass']){
			$errorMsg[] = 'passwordを入力してください';
		}elseif(!$cCheck->isEisu($aData['pass'])){
			$errorMsg[] = 'passwordは半角英数で入力してください';
		}

		if($aData['tel']){
			echo "TEL == ".$aData['tel'];
			if(!$cCheck->isTel($aData['tel'])){
				$errorMsg[] = '電話番号を正しく入力してください';
			}
		}
		
		if($aData['zip']){
			if(!$cCheck->isZip($aData['zip']))
			$errorMsg[] = '郵便番号を正しく入力してください';
		}
		
/*
		if(!$aData['address1']){
			$errorMsg[] = '住所(都道府県)を入力してください';
		}	
		
		if(!$aData['address2']){
			$errorMsg[] = '住所(市町村以下)を入力してください';
		}
*/

	return $errorMsg;
	}

?>