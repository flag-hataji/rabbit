<?PHP

/*
	�����Ͽindex.php
*/


//https�˥�����쥯��


//if((! isset($_SERVER['HTTPS']))){
//   header("location:https://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"] );
//  exit ;
//}

	//����ե������ɤ߹���
	require_once ('../../cls/test/user_list/setup.php');

/* 
	if( $_SERVER['REMOTE_ADDR'] == '221.246.192.14' ){
		$aData = $dData;//�ǡ��������
		//$aData = $tData;//test�ǡ���
		//echo "test<br>";
	}else{
		$aData = $dData;//�ǡ��������
	}
*/


	define("_DEBUG_",false );//�ǥХå�
	define('_BASE_HTML_'        ,  "base.html" );
	define("_LIST_HTML_"        ,  "list.html" );
	define("_LIST_LINE_HTML_"   ,  "list_line.html" );
	define("_CONFIRM_HTML_"     ,  "confirm.html" );
	define("_FINISH_HTML_"      ,  "finish.html" );


	
	if( _DEBUG_ ){ echo "_BASE_HTML_                  = "._BASE_HTML_ ."<br>\n";}
	if( _DEBUG_ ){ echo "_LIST_HTML_                  = "._LIST_HTML_ ."<br>\n";}
	if( _DEBUG_ ){ echo "_FINISH_HTML_                = "._FINISH_HTML_ ."<br>\n";}

	/**
	*�ᥤ��ץ����
	*/
	if(_DEBUG_){ $cDebug->printArrayData($_POST,$dataName='POSTDATA' ); }

	if(isset($_POST['del'])){
		$mmail_user_id = key($_POST['del']) ;
		delData($mmail_user_id);
	}


	//main
	search();

	/**
	*����
	*/
	function search(){
	global $cPostgres,$cDebug,$libConvert;


		$query  = "SELECT mmail_user_id , name , company , user_mail ";
 		$query .= " FROM td_mmail_user ORDER BY mmail_user_id DESC ";

		if(_DEBUG_){ echo $query."<br>\n"; }
		$data = $cPostgres->executeQuery($query);
		while ($getData = pg_fetch_array($data)){
			$searchData[] = $getData; 
			//explode("-",$newsData['day']);
		}


		if(!$searchData){
			$errorMsg = "�����ǡ���������ޤ���Ǥ���";
		}else{
			$errorMsg = "";
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
				require (_LIST_LINE_HTML_);
			}
		}else{
			$errorMsg = "�����ǡ���������ޤ���Ǥ���";
		}
	return;
	}

	/**
	*��ǧ�ڡ����ǡ������� �ȤäƤʤ�
	*/
	function GetConfirmData(){
	global $cPostgres,$cDebug;

		$query  = "SELECT * , td_company.fax AS fax0 , td_company.flag_show AS flag_show ";
 		$query .= " FROM td_company JOIN tm_pref ON td_company.pref_id = tm_pref.pref_id ";
		$query .= " JOIN tm_staff ON td_company.staff_id = tm_staff.staff_id";
 		$query .= " JOIN tm_branch ON td_company.branch_id = tm_branch.branch_id";
 		$query .= " JOIN td_company_dm ON td_company.company_id = td_company_dm.company_id";
 		$query .= " JOIN tm_industry_3 ON td_company.industry_3_id = tm_industry_3.industry_3_id";
 		$query .= " JOIN tm_industry_2 ON tm_industry_3.industry_2_id = tm_industry_2.industry_2_id";
 		$query .= " JOIN tm_industry_1 ON tm_industry_2.industry_1_id = tm_industry_1.industry_1_id";
 		$query .= " WHERE td_company.company_id = {$_GET['c_id']} ";

		if(_DEBUG_){ echo $query; }
		$data = $cPostgres->executeQuery($query);
		while ($getData = pg_fetch_array($data)){
			$searchData[] = $getData; 
			//explode("-",$newsData['day']);
		}

		if(_DEBUG_){ $cDebug->printArrayData($searchData,$dataName='searchData' ); }

		if(!$searchData){
			echo "�����ǡ���������ޤ���";
			exit;
		}else{
			return($searchData[0]);	
		}

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
	function delData($mmail_user_id){
	global $cPostgres;

		$query1  = "DELETE FROM td_mmail_user WHERE mmail_user_id = '{$mmail_user_id}'";
		$query2 = "DELETE FROM td_mmail_member WHERE user_id = '{$mmail_user_id}'";
		if(_DEBUG_){ echo "query1 = ".$query1."<br>\n"; }
		if(_DEBUG_){ echo "query2 = ".$query2."<br>\n"; }
		$cPostgres->executeUpdate($query1);
		$cPostgres->executeUpdate($query2);

	return;
	}

?>