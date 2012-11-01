<?PHP

/*
	���顼ɽ���ץ����
*/


	//����ե������ɤ߹���
	require_once (_DIR_CLS_.'pictmail/error/setup.php');
	//require_once("../../common/define/setup.php");



	define("_DEBUG_",false );//�ǥХå�
	define('_BASE_HTML_'        ,  "base.html" );
	define("_LIST_HTML_"        ,  "list.html" );
	define("_LIST_LINE_HTML_"   ,  "list_line.html" );
	define("_CONFIRM_HTML_"     ,  "confirm.html" );
	define("_FINISH_HTML_"      ,  "finish.html" );


	
	if( _DEBUG_ ){ echo "_BASE_HTML_                  = "._BASE_HTML_ ."<br>\n";}
	if( _DEBUG_ ){ echo "_LIST_HTML_                  = "._LIST_HTML_ ."<br>\n";}
	if( _DEBUG_ ){ echo "_FINISH_HTML_                = "._FINISH_HTML_ ."<br>\n";}

	if( _DEBUG_ ){ $cDebug->printArrayData($_SESSION['user'],$dataName='sessionData' ); }
	
	/**
	*�ᥤ��ץ����
	*/
	if(_DEBUG_){ $cDebug->printArrayData($_POST,$dataName='POSTDATA' ); }

	if(isset($_GET['id'])){
		$error_log_id = $_GET['id'] ;
		delData($error_log_id);
	}


	//main
	search();

	/**
	*����
	*/
	function search(){
	global $cPostgres,$cDebug,$libConvert;
		
		if(!$_SESSION['user']['user_id']){
			echo "NO SESSION";
			exit;
		}
		
	
		$query  = "SELECT * ";
 		$query .= " FROM td_error_log WHERE user_id = {$_SESSION['user']['user_id']} ";
 		$query .= " ORDER BY error_count DESC , date_insert LIMIT 500 ";

		//count��
		$query2  = "SELECT count(*) ";
 		$query2 .= " FROM td_error_log WHERE user_id = {$_SESSION['user']['user_id']} ";


		if(_DEBUG_){ echo "query = ".$query."<br>\n"; echo "query2 = ".$query2."<br>\n"; }
		$data      = $cPostgres->executeQuery($query);
		
		$dataCount = $cPostgres->executeQuery($query2);
		$getCount  = pg_fetch_array($dataCount);
		$getCount  = $getCount[0];
		while ($getData = pg_fetch_array($data)){
			$searchData[] = $getData; 
			//explode("-",$newsData['day']);
		}


		require_once (_BASE_HTML_);

		if(_DEBUG_){ $cDebug->printArrayData($searchData,$dataName='searchData' ); }
	return;
	}

	/**
	*�ꥹ��ɽ��
	*/
	function printListData($searchData){

		if($searchData){
			foreach($searchData as $key => $value){
				$insstr = explode(".",$value['date_insert'],2); 
				$upstr  = explode(".",$value['date_update'],2); 
				$value['date_insert'] = $insstr[0];
				$value['date_update'] = $upstr[0];

				$delStr = printDel($value['error_log_id'],$value['mail']);
				require (_LIST_LINE_HTML_);
			}
		}
	return;
	}


	/**
	*��ǧ����ɽ��
	*/
	function Confirm($viewData) {
	global $cDebug;
		if(_DEBUG_){ $cDebug->printArrayData($viewData,$dataName='viewData' ); }

		foreach($viewData as $key => $value){
			$viewData[$key] = str_replace("\r\n","<br>",$value);
			$viewData[$key] = str_replace("\n","<br>",$value);
			$viewData[$key] = str_replace("\r","<br>",$value);
		}

		require_once (_CONFIRM_HTML_);
	return;
	}

	/**
	*�ǡ������
	*/
	function delData($error_log_id){
	global $cPostgres;

		$query  = "DELETE FROM td_error_log WHERE user_id = {$_SESSION['user']['user_id']} ";

		if($error_log_id != 'all'){
			$query .= " AND error_log_id = '{$error_log_id}' ";
		}
		if(_DEBUG_){ echo "query = ".$query."<br>\n"; }

		$cPostgres->executeUpdate($query);

	return;
	}

	/**
	*�����󥯺���
	*/
	function printDel($error_log_id , $mail){

		$confirm_str  = "�ʲ��Υ᡼�륢�ɥ쥹�������ޤ���\\n";
		$confirm_str .= "�ǡ���������Ͻ���ޤ��󤬤�����Ǥ��礦����\\n";
		$confirm_str .= "\\n";
		$confirm_str .= "�᡼�륢�ɥ쥹 {$mail}\\n";

		$del_str    =  "<A HREF=\"index.php?id={$error_log_id}\" ";
		$del_str   .=  "onclick=\"return confirm('{$confirm_str}');\" >���</A>";
		//echo $del_str;
	  return($del_str);

	}

?>