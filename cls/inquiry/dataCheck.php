<?PHP
/*
	チェックプログラム
*/

	function dataCheck($aData){
	global $cCheck;
	$errorMsg = "";

	//いくつかデータを結合
	//$aData['zip']      = $aData['zip1'].$aData['zip2'];
	$aData['tel']        = $aData['tel1'].$aData['tel2'].$aData['tel3'];
	//$aData['phone']      = $aData['phone1'].$aData['phone2'].$aData['phone3'];
	$aData['mail_conf']  = $aData['mail_conf1']."@".$aData['mail_conf2'];
	//$aData['birthday'] = sprintf("%04d-%02d-%02d", $aData['year'], $aData['month'], $aData['day']);


	//未入力&形式チェック
		if(!$aData['name_kana_sei']){
			$errorMsg[] = 'フリガナ(姓)を入力してください';
		}else{
			if(!$cCheck->isKataKana($aData['name_kana_sei'])){
				$errorMsg[] = 'フリガナ（姓）は全角カタカナで入力してください';
			}
		}
		if(!$aData['name_kana_mei']){
			$errorMsg[] = 'フリガナ（名）を入力してください';
		}else{
			if(!$cCheck->isKataKana($aData['name_kana_mei'])){
				$errorMsg[] = 'フリガナ（名）は全角カタカナで入力してください';
			}
		}

		if(!$aData['name_sei']){
			$errorMsg[] = '名前(姓)を入力してください';
		}
		if(!$aData['name_mei']){
			$errorMsg[] = '名前（名）を入力してください';
		}

		if(!$aData['mail']){
			$errorMsg[] = 'メールアドレスを入力してください';
		}elseif(!$cCheck->isMail($aData['mail'])){
			$errorMsg[] = 'メールアドレスを正しく入力してください';
		}
		if(!$aData['mail_conf']){
			$errorMsg[] = 'メールアドレス（確認用）を入力してください';
		}elseif(!$cCheck->isMail($aData['mail_conf'])){
			$errorMsg[] = 'メールアドレス（確認用）を正しく入力してください';
		}

		if( $aData['mail'] && $aData['mail_conf']){
			if($aData['mail'] != $aData['mail_conf']){
				$errorMsg[] = '確認用メールアドレスと一致しません';
			}
		}

		if($aData['tel']){
			if(!$cCheck->isNumber($aData['tel'])){
			 $errorMsg[] = '電話番号を正しく入力してください';
			}
		}
/*
		if( !$aData['renraku']){
				$errorMsg[] = 'ご連絡方法を選択してください。';
		}
*/
		if(!$aData['comment']){
			$errorMsg[] = 'お問い合わせ内容を入力してください';
		}

/*
		if($aData['renraku']!="メールでのご連絡"){
			if(!$aData['tel']){
				$errorMsg[] = 'ご連絡方法が電話の場合は電話番号を入力してください';
			}
		}
*/
		
	return $errorMsg;
	}

?>