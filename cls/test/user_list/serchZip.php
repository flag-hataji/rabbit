<?php
/*
* 表示 - 郵便番号からの住所入力
*/
	function showInputPref($zip=False){
	global $cDb;
	    if( $zip!="" ){

	      $zip = str_replace("-","",$zip);
	      $query  = "SELECT pref FROM tm_zip WHERE zip LIKE '%{$zip}%' ORDER BY pref";

			$dataS = $cDb->executeQuery($query);
			$db_perf = pg_fetch_array($dataS);
			echo $db_perf['pref'];
		
	    }
    }

	function showInputAddress($zip=False){
	global $cDb;
    	if( $zip!="" ){

      		$zip = str_replace("-","",$zip);
      		$query  = "SELECT address FROM tm_zip WHERE zip LIKE '%{$zip}%' ORDER BY pref";

			$dataS = $cDb->executeQuery($query);
			$db_address = pg_fetch_array($dataS);
			echo $db_address['address'];

  		}
	}
	/**
	*セレクトボックスの「selected」を判定
	*/
	function getSelected($a,$b){
		if($a == $b){
			$c = 'selected';
		}else{
			$c = "";
		}
	return ($c);
	}
?>