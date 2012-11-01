<?PHP
/**
*	チェックプログラム
*/

	function dataCheck($aData){
	global $cCheck  , $cDb;
	$errorMsg = "";

	//いくつかデータを結合

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

	//未入力&形式チェック 

		if(!$aData['company']){
			$errorMsg[] = '会社名を入力してください';
		}

		if($aData['company_kana']){
			if(!$cCheck->isKataKana($aData['company_kana'])){
				$errorMsg[] = '会社名フリガナは全角カタカナで入力してください';
			}
		}

		if(!$aData['industry_3_id']){
			$errorMsg[] = '業種を選択してください';
		}

		if(!$aData['zip']){
			$errorMsg[] = '本社所在地（郵便番号）を入力してください';
		}else{
			if(!$cCheck->isNumberLen($aData['zip'],7)){
				$errorMsg[] = '本社所在地（郵便番号）を正しく入力してください';
			}
		}

		if(!$aData['pref_id']){
			$errorMsg[] = '本社所在地（県）を入力してください';
		}

		if(!$aData['address1']){
			$errorMsg[] = '本社所在地（住所）を入力してください';
		}


		if(!$aData['tel']){
			$errorMsg[] = '電話番号を入力してください';
		}else{
			if(!$cCheck->isNumberLen($aData['tel'],10) && !$cCheck->isNumberLen($aData['tel'],11)){
				$errorMsg[] = '電話番号を正しく入力してください';
			}
		}

		if($aData['fax']){
			if(!$cCheck->isNumberLen($aData['fax'],10) && !$cCheck->isNumberLen($aData['fax'],11)){
				$errorMsg[] = 'ＦＡＸを正しく入力してください';
			}
		}

		if($aData['url']){
			if(!$cCheck->isUrl($aData['url'])){
				$errorMsg[] = 'ＵＲＬを正しく入力してください';
			}
		}

		if($aData['mail']){
			if(!$cCheck->isMail($aData['mail'])){
				$errorMsg[] = 'E-mailを正しく入力してください';
			}
		}

		if(!$aData['charge_post']){
			$errorMsg[] = '企業担当者部署を入力してください';
		}

		if(!$aData['charge']){
			$errorMsg[] = '企業担当者を入力してください';
		}

		if(!$aData['branch_id']){
			$errorMsg[] = '担当支店を入力してください';
		}

		if(!$aData['staff_id']){
			$errorMsg[] = '支店担当者を入力してください';
		}

	return $errorMsg;
	}

?>