<?PHP
/*
* ステップメール表示クラス
*/

class View
{

	
	function View() {
		
	}



	/**
	*セレクトボックスの表示
	*/
	function printSelectBox(){

		$sBoxData[0]['value'] = "all";   $sBoxData[0]['str']   = "すべてのユーザー";
		$sBoxData[1]['value'] = "start"; $sBoxData[1]['str']   = "配信中ユーザー";
		$sBoxData[2]['value'] = "stop";  $sBoxData[2]['str']   = "配信停止中ユーザー";
		$sBoxData[3]['value'] = "none";  $sBoxData[3]['str']   = "シナリオ無しユーザー";
		$sBoxData[4]['value'] = "error"; $sBoxData[4]['str']   = "エラー停止中ユーザー";

		$query   = "SELECT scenario_id , scenario_name FROM td_scenario WHERE flag_del = 'f' AND user_id = {$_SESSION['user']['user_id']} ORDER BY scenario_id";
		$scenario = GetDbData($query);

		//シナリオ入れる
		$i=4;
		foreach($scenario as $key => $value){
			$sBoxData[$i]['value'] = "{$value['scenario_id']}";
			$sBoxData[$i]['str']   = "{$value['scenario_name']}";
			$i++;

		}
		
		//表示
		echo "<select name='where_select' >\n";
		foreach($sBoxData as $key => $value){
			if(!isset($_POST['where_select'])){
				echo "<option value='{$value['value']}' >{$value['str']}</option>\n";
			}elseif($_POST['where_select'] == $value['value']){
				echo "<option value='{$value['value']}' selected >{$value['str']}</option>\n";
			}else{
				echo "<option value='{$value['value']}' >{$value['str']}</option>\n";
			}
			
			/*
		  	if($_POST['where'] == $value['value']){
				echo "<option value='{$value['value']}' selected >{$value['str']}</option>\n";
		  	}else{
				echo "<option value='{$value['value']}' >{$value['str']}</option>\n";
			}
			*/
		  }	
		echo "</select>\n";

	return ;
	}

	/**
	*ユーザーリスト表示
	*/
/*
	function printListData($searchData){

		$errorMsg = "";
		if($searchData){
			foreach($searchData as $key => $value){
				require (_LIST_LINE_HTML_);
			}
		}
	return;
	}
*/

	/*
	*	配信状況の表示
	*/
	function flag_send_name($num){
		switch($num){
			case '0';
				echo "配信中";
				break;
			case '1';
				echo "ストップ";
				break;
			case '2';
				echo "削除";
				break;
			case '3';
				echo "エラー停止中";
				break;
		}

	return;
	}


	/*
	*	リスト表示条件の保持
	*/
	function listbox_select($data){
		if($_POST['where'] == $data){
			echo "selected";
		}
		
	return;
	}


	/*
	*	リスト表示条件の保持
	*/
	function bCheckd($a,$b){
		if($a == $b){
			print "checked";
		}
	}

}
?>