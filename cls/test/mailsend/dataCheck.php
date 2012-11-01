<?PHP
/*
	チェックプログラム
*/

	function dataCheck($aData){
	global $cCheck;
	$errorMsg = "";

	//未入力&形式チェック

		if(!$aData['subject']){
			$errorMsg[] = '件名を入力してください';
		}

		if(!$aData['message']){
			$errorMsg[] = '本文を入力してください';
		}

		
	return $errorMsg;
	}

?>