<?PHP
/*
	�����Ͽindex.php
*/


//https�˥�����쥯��
/*
if((! isset($_SERVER['HTTPS'])) && $_SERVER["HTTP_HOST"] == 'www.hotelnikko-fukuoka.com'){
   header("location:https://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"] );
  exit ;
}elseif((! isset($_SERVER['HTTPS'])) && $_SERVER["HTTP_HOST"] == 'hotelnikko-fukuoka.com'){
   header("location:https://www.".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"] );
  exit ;
}
*/
	//����ե������ɤ߹���
	require_once ('../../cls/test/member/setup.php');


	if(!isset($_POST['aData'])){
		$aData = $dData;
	}

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
	define("_REGIST_HTML_"      ,  "regist.html" );
	define("_CONFILM_HTML_"     ,  "confirm.html" );
	define("_FINISH_HTML_"      ,  "finish.html" );
	define("_SELECT_HTML_"      ,  "select.html" );
	define("_LOGIN_HTML_"       ,  "../rewrite/login.html" );
	
	if( _DEBUG_ ){ echo "_BASE_HTML_                  = "._BASE_HTML_ ."<br>\n";}
	if( _DEBUG_ ){ echo "_REGIST_HTML_                = "._REGIST_HTML_ ."<br>\n";}
	if( _DEBUG_ ){ echo "_CONFILM_HTML_               = "._CONFILM_HTML_ ."<br>\n";}
	if( _DEBUG_ ){ echo "_FINISH_HTML_                = "._FINISH_HTML_ ."<br>\n";}
	if( _DEBUG_ ){ echo "_LOGIN_HTML_                 = "._LOGIN_HTML_  ."<br>\n";}
	if( _DEBUG_ ){ echo "_SELECT_HTML_                = "._SELECT_HTML_  ."<br>\n";}

	/**
	*�ᥤ��ץ����
	*/
	if(_DEBUG_){ $cDebug->printArrayData($_POST,$dataName='POSTDATA' ); }

	if(isset($_GET['u_id'])){
		$_POST['aData']['user_id'] = $_GET['u_id'];
	}
	if(!isset($aData)){
		$aData = $dData;
	}

	
	if(isset($_GET['m_id'])){//�����ξ��
		$aData = getMemberData();
	}elseif(!isset($_POST['aData']['user_id'])){//������Ͽ�ǥ桼����������
		$HTMLFILE = _SELECT_HTML_;	
		if(_DEBUG_){ echo $HTMLFILE;}
		require_once (_BASE_HTML_);
	}


	if(isset($_POST['confirm'])){
		confirm($_POST['aData']);
	}elseif(isset($_POST['finish'])){
		finish($_POST['aData']);
	}elseif(isset($_POST['back'])){
		back($_POST['aData']);
	}else{
		getDefault($aData);
	}

	/**
	*�ǽ��
	*/
	function getDefault($aData) {
	global $cDate, $cDebug;
		$HTMLFILE = _REGIST_HTML_;	
		if(_DEBUG_){ echo $HTMLFILE;}
		require_once (_BASE_HTML_);
		if(_DEBUG_){ $cDebug->printArrayData($aData,$dataName='aData' ); }
	return;
	}



	/**
	*��ǧ
	*/
	function confirm($aData){
	global $cDebug,$cKen,$libConvert, $cDate;
		//ͥ�����ǥ���С���
		//if($aData['name_kana']){ $aData['name_kana'] = $libConvert->getConvert($aData['name_kana'],'KV3C'); }

		foreach($aData as $key => $value){//���󥰥륳���ơ�����󡢥��֥륳���ơ�����󥨥�������
			$aData[$key] = htmlspecialchars($aData[$key], ENT_QUOTES);
		}

		$errorMsg = dataCheck($aData);//���顼�����å�
		if(_DEBUG_){ $cDebug->printArrayData($aData,$dataName='aData' ); }
		
		if(!$errorMsg){
			//$viewData = $aData;
			foreach($aData as $key => $value){
				$viewData[$key]  = $libConvert->getConvert($value,'16');//���򡢥���ȴ��
			}
			if(_DEBUG_){ $cDebug->printArrayData($viewData,$dataName='viewData' ); }
			
			$HTMLFILE = _CONFILM_HTML_;
		}else{
			$HTMLFILE = _REGIST_HTML_;
		}
		require_once (_BASE_HTML_);		
	return;
	}

	/**
	*��λ
	*/
	function finish($aData){
		foreach($aData as $key => $value){//���󥰥륳���ơ�����󡢥��֥륳���ơ�����󥨥�������
			$aData[$key] = htmlspecialchars($aData[$key], ENT_QUOTES);
		}
		
		//DB��Ͽ
		if($aData['mmail_member_id']){
			updateDbMain($aData);
		}else{
			registDbMain($aData);
		}

    //cleateMail($aData);
		$HTMLFILE = _FINISH_HTML_;
		require_once (_BASE_HTML_);
	return;
	}

	/**
	*��ľ��
	*/
	function back($aData){//��ľ��
	global $cKen, $cDate, $cDebug;
		foreach($aData as $key => $value){//���󥰥륳���ơ�����󡢥��֥륳���ơ�����󥨥�������
			$aData[$key] = htmlspecialchars($aData[$key], ENT_QUOTES);
//			$aData[$key] = str_replace("'","\'",$value);
//			$aData[$key] = str_replace('"','\"',$value);
		}

		if(_DEBUG_){ $cDebug->printArrayData($aData,$dataName='BACKDATA' ); }
			foreach($aData as $key => $value ){
				$value = retrunHTML($value);
			}
			$HTMLFILE = _REGIST_HTML_;
		require_once(_BASE_HTML_);
	return;
	}


	/**
	* �����Ͽ�ǡ������ȡʽ�ľ����
	*/
	function getMemberData(){
	global $cDb;


		$query  = "SELECT * FROM td_mmail_member WHERE mmail_member_id = {$_GET['m_id']}";
		$dataS = $cDb->executeQuery($query);
		while ($getData = pg_fetch_array($dataS)){
			$aData = $getData; 
			//explode("-",$newsData['day']);
		}

		if($aData){
			return($aData);
		}else{
			$error = "�����Υǡ���������ޤ���Ǥ���";
		}
	}

	/**
	* ���桼������ɽ���ʥ��쥯�ȥܥå�����
	*/
	function getUsesrData(){
	global $cDb;

		$query  = "SELECT mmail_user_id , name FROM td_mmail_user ";
		$dataS = $cDb->executeQuery($query);
		while ($getData = pg_fetch_array($dataS)){
			echo "<option value='{$getData['mmail_user_id']}'>{$getData['name']}</option>";
		}

	return;
	}

	/**
	*��ǧ�ڡ�����hidden�Ǥ��Ф�
	*/
	function outPutHidden($aData){
	global $cDebug;
	if(_DEBUG_){ $cDebug->printArrayData($aData,$dataName='HIDDENDATA' ); }
		foreach($aData as $key => $value){
			$value = str_replace("\"","&quot;",$value);
			$value = str_replace("'","&#039;",$value);
			print "<input type='hidden' name='aData[$key]' value='$value'>\n";
		}
	}

	/**
	*���顼�Ǥ��Ф�
	*/
	function print_error($errorMsg){
		foreach ($errorMsg as $key => $value){
			print $value."<br>\n";
		}
	return;
	}

	/**
	*�����Ĥ��餤�Υꥹ�ȥܥå���������Ȥ���
	*/
	function ListKubun($kubun){
		$Listkubun = array('���ƣ�','���ƣ�','���ƣ�','���ƣ�','���ƣ�','���ƣ�','���ƣ�','���ƣ�','���ƣ�','���ƣ���',);

		foreach($Listkubun as $key => $value ){
			if($value == $kubun ){
				print "<option selected>$value</option>";
			}else{
				print "<option >$value</option>";
			}
		}
	return;
	}

	/**
	*�����å��ܥå����Ρ�cheked�פ�Ƚ��
	*/
	function bCheckd($a,$b){
		if($a == $b){
			print "checked";
		}
	return;
	}
	/**
	*���쥯�ȥܥå����Ρ�selected�פ�Ƚ��
	*/
	function bSelected($a,$b){
		if($a == $b){
			print "selected";
		}
	return;
	}

	/**
	*���󥰥륳���ơ�����󡢥��֥륳���ơ�������HTML�ü쥿�����Ѵ�
	*/
	function retrunHTML($cData){
		$cData = str_replace("&quot;","\"",$cData);
		$cData = str_replace("&#039;","'",$cData);
	return $cData;
	}


	/**
	*ǯ�����Υ��쥯�ȥܥå���ɽ��
	*/
	function outPutDay($year,$month,$day){
		if(!$year || !$month || !$day){
		  date("Y/m/d");
		  $year  = date("Y");
		  $month = date("m");
		  $day   = date("d");
		}

			$y = date("Y")-100;
			while( $y <= date("Y") ){
				if($y == $year ){
					$opYear .= "                      <option selected>{$y}</option>\n";
				}else{
					$opYear .= "                      <option>{$y}</option>\n";
				}
			$y++;
			}

			$m = 1;
			while( $m <= 12 ){
				if($m == $month ){
					$opMonth .= "                      <option selected>{$m}</option>\n";
				}else{
					$opMonth .= "                      <option>{$m}</option>\n";
				}
			$m++;
			}

			$d = 1;
			while( $d <= 31 ){
				if($d == $day ){
					$opDay .= "                      <option selected>{$d}</option>\n";
				}else{
					$opDay .= "                      <option>{$d}</option>\n";
				}
			$d++;
			}

		echo"
                    <select name='aData[year]'>
                      {$opYear}
                    </select>
                    ǯ 
                    <select name='aData[month]'>
                      {$opMonth}
                    </select>
                    �� 
                    <select name='aData[day]'>
                      {$opDay}
                    </select>
                    ��
        ";

	return;
	}
?>