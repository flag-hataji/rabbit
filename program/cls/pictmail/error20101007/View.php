<?PHP
/*
* ���ƥåץ᡼��ɽ�����饹
*/

class View
{

	
	function View() {
		
	}



	/**
	*���쥯�ȥܥå�����ɽ��
	*/
	function printSelectBox(){

		$sBoxData[0]['value'] = "all";   $sBoxData[0]['str']   = "���٤ƤΥ桼����";
		$sBoxData[1]['value'] = "start"; $sBoxData[1]['str']   = "�ۿ���桼����";
		$sBoxData[2]['value'] = "stop";  $sBoxData[2]['str']   = "�ۿ������桼����";
		$sBoxData[3]['value'] = "none";  $sBoxData[3]['str']   = "���ʥꥪ̵���桼����";
		$sBoxData[4]['value'] = "error"; $sBoxData[4]['str']   = "���顼�����桼����";

		$query   = "SELECT scenario_id , scenario_name FROM td_scenario WHERE flag_del = 'f' AND user_id = {$_SESSION['user']['user_id']} ORDER BY scenario_id";
		$scenario = GetDbData($query);

		//���ʥꥪ�����
		$i=4;
		foreach($scenario as $key => $value){
			$sBoxData[$i]['value'] = "{$value['scenario_id']}";
			$sBoxData[$i]['str']   = "{$value['scenario_name']}";
			$i++;

		}
		
		//ɽ��
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
	*�桼�����ꥹ��ɽ��
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
	*	�ۿ�������ɽ��
	*/
	function flag_send_name($num){
		switch($num){
			case '0';
				echo "�ۿ���";
				break;
			case '1';
				echo "���ȥå�";
				break;
			case '2';
				echo "���";
				break;
			case '3';
				echo "���顼�����";
				break;
		}

	return;
	}


	/*
	*	�ꥹ��ɽ�������ݻ�
	*/
	function listbox_select($data){
		if($_POST['where'] == $data){
			echo "selected";
		}
		
	return;
	}


	/*
	*	�ꥹ��ɽ�������ݻ�
	*/
	function bCheckd($a,$b){
		if($a == $b){
			print "checked";
		}
	}

}
?>