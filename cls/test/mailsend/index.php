<?PHP
session_start();
/*
	���䤤��碌index.php
*/

//https�˥�����쥯��
/*
if((! isset($_SERVER['HTTPS']))){
   header("location:https://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"] );
  exit ;
}
*/


	//����ե������ɤ߹���
	require_once ('../../cls/test/mailsend/setup.php');


	if( $_SERVER['REMOTE_ADDR'] == '221.246.192.14' ){
		$aData = $dData;//�ǡ��������
		//$aData = $tData;//test�ǡ���
		//echo "test<br>";
	}else{
		$aData = $dData;//�ǡ��������
	}
	define("_DEBUG_",false );//�ǥХå�

	define("_LOGIN_HTML_"       ,  "login.html" );
	define("_BASE_HTML_"        ,  "base.html" );
	define("_REGIST_HTML_"      ,  "regist.html" );
	define("_CONFILM_HTML_"     ,  "confirm.html" );
	define("_FINISH_HTML_"      ,  "finish.html" );



	if( _DEBUG_ ){ echo "_BASE_HTML_                  = "._BASE_HTML_ ."<br>\n";}
	if( _DEBUG_ ){ echo "_REGIST_HTML_                = "._REGIST_HTML_ ."<br>\n";}
	if( _DEBUG_ ){ echo "_CONFILM_HTML_               = "._CONFILM_HTML_ ."<br>\n";}
	if( _DEBUG_ ){ echo "_FINISH_HTML_                = "._FINISH_HTML_ ."<br>\n";}
	if( _DEBUG_ ){ echo "_LOGIN_HTML_                 = "._LOGIN_HTML_ ."<br>\n";}

	/*
	*�ᥤ��
	*/
	if(_DEBUG_){ $cDebug->printArrayData($_POST,$dataName='POSTDATA' ); }
		

	if(!isset($_SESSION['login']['mmail_user_id'])){
  		login();
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

	if(_DEBUG_){ $cDebug->printArrayData($_SESSION,$dataName='SESSIONDATA' ); }


	/*
	*	������
	*/
	function login(){
	   Global $cPostgres , $cDebug;
	   
	
	    if(isset($_POST['login'])){
	      
	      $query  = "SELECT mmail_user_id , pass , user_mail , name , company ";
	      $query .= "FROM td_mmail_user WHERE mmail_user_id = '{$_POST['login']['user_id']}' AND pass = '{$_POST['login']['password']}'";
	      
	      $dataS = $cPostgres->executeQuery($query);
	      $user = pg_fetch_array($dataS);
	
	      if(_DEBUG_){ $cDebug->printArrayData($user,$dataName='LOGINDATA' );}
	      
	      if($user['mmail_user_id']){
	        $_SESSION['login']['mmail_user_id'] = $user['mmail_user_id'];
	        $_SESSION['login']['pass']          = $user['pass'];
	        $_SESSION['login']['user_mail']     = $user['user_mail'];
	        $_SESSION['login']['name']          = $user['name'];

	      //$_SESSION['login']['company'] = $user['compnay'];
	      }else{
			$HTMLFILE = _LOGIN_HTML_;
			echo "NO USER!!";
			if(_DEBUG_){ echo $HTMLFILE;}
			require_once (_BASE_HTML_);
			exit;
	      }
	
	    }else{
	    	$HTMLFILE = _LOGIN_HTML_;
			if(_DEBUG_){ echo $HTMLFILE;}
			require_once (_BASE_HTML_);
			exit;
	    }
	  }

	  
	/*
	*	�ǽ��
	*/
	function getDefault($aData) {
		$HTMLFILE = _REGIST_HTML_;
		if(_DEBUG_){ echo $HTMLFILE;}
		require_once (_BASE_HTML_);
	return;
	}


	/*
	*	��ǧ
	*/
	function confirm($aData){//��ǧ
	global $cDebug,$cKen,$libConvert, $cDate;

		//��öEUC���Ѵ�
		if(is_array($aData)){
			foreach($aData as $key => $value){
				$aData[$key]  = mb_convert_encoding( $value , "EUC-JP","SJIS");
			}
		}else{
			$aData  = mb_convert_encoding( $aData , "EUC-JP","SJIS");
		}

		$errorMsg = dataCheck($aData);//���顼�����å�
		if(_DEBUG_){ $cDebug->printArrayData($aData,$dataName='aData' ); }
		
		if(!$errorMsg){
			//���顼̵�����
			foreach($aData as $key => $value){
				$aData[$key]     = $libConvert->getConvert($value,'KV3');//Ⱦ�ѥ������ʤ����Ѥ�
				$viewData[$key]  = $libConvert->getConvert($value,'168');//���򡢥���ȴ��
				$viewData[$key]  = $libConvert->getConvert($value,'KV3');
				$viewData[$key]  = str_replace("\n","<br>\n",$value);
				$viewData[$key]  = htmlspecialchars($value, ENT_QUOTES);
			}
//			$viewData['message']   = str_replace("\n","<br>\n",$viewData['message']);

			if(_DEBUG_){ $cDebug->printArrayData($viewData,$dataName='viewData' ); }
			//SJIS���᤹

			if(is_array($viewData)){
				foreach($viewData as $key => $value){
					$viewData[$key]  = mb_convert_encoding( $value , "SJIS", "EUC-JP");
					$aData[$key]  = mb_convert_encoding( $aData[$key] , "SJIS", "EUC-JP");
				}
			}else{
				$viewData  = mb_convert_encoding( $viewData ,"SJIS" , "EUC-JP");
				$aData  = mb_convert_encoding( $aData ,"SJIS" , "EUC-JP");
			}

			$HTMLFILE = _CONFILM_HTML_;
		}else{
			//���顼���ä��������
			//SJIS���᤹
			if(is_array($aData)){
				foreach($aData as $key => $value){
					$aData[$key]  = mb_convert_encoding( $value , "SJIS", "EUC-JP");
				}
			}else{
				$aData  = mb_convert_encoding( $aData ,"SJIS" , "EUC-JP");
			}

			$HTMLFILE = _REGIST_HTML_;
		}

		require_once (_BASE_HTML_);		
	return;
	}


	/*
	*	��λ
	*/
	function finish($aData){
	global $cPostgres , $cDebug;


		//EUC���Ѵ�
		if(is_array($aData)){
			foreach($aData as $key => $value){
				$aData[$key]  = mb_convert_encoding( $value , "EUC-JP","SJIS");
			}
		}else{
			$aData  = mb_convert_encoding( $aData , "EUC-JP","SJIS");
		}

		if(_DEBUG_){ $cDebug->printArrayData($_SESSION,$dataName='SESSIONDATA' ); }
		registDbMain($aData);

		$query2 = "SELECT last_value from td_mmail_message_seq ";
		$dataS = $cPostgres->executeQuery($query2);
        $td_mmail_message = pg_fetch_array($dataS);
        $message_id = $td_mmail_message['last_value'];
		passthru( "/usr/local/bin/php /www/html/cls/test/mailsend/BatchQuery.php $message_id > /dev/null &");
//		exec( "/usr/local/bin/php /www/html/cls/test/mailsend/BatchQuery.php $message_id > /dev/null &");
		
		//$query_del = "DELETE FROM td_mmail_message WHERE mmail_message_id =  {$message_id}";
		//$cPostgres->executeUpdate($query_del);

		$HTMLFILE = _FINISH_HTML_;
		require_once (_BASE_HTML_);
	return;
	}

	
	/*
	*	��ľ��
	*/
	function back($aData){
	global $cKen, $cDate, $cDebug;
		if(_DEBUG_){ $cDebug->printArrayData($aData,$dataName='BACKDATA' ); }
		foreach($aData as $key => $value ){
			$value = retrunHTML($value);
		}
		
		$HTMLFILE = _REGIST_HTML_;
	require_once(_BASE_HTML_);
	}

	/*
	*	hidden�Ǥ��Ф�
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

	/*
	*	���顼�Ǥ��Ф�
	*/
	function print_error($errorMsg){
		foreach ($errorMsg as $key => $value){
			$value = mb_convert_encoding( $value ,"SJIS" , "EUC-JP");
			print $value."<br>\n";
		}
	return;
	}
	
	/*
	*	���ˤ�äƻ��Ѥ���
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

	/*
	*	�����å������
	*/
	function bCheckd($a,$b){
		if($a == $b){
			print "checked";
		}
	}

	/*
	*	������
	*/
	function retrunHTML($cData){
		$cData = str_replace("&quot;","\"",$cData);
		$cData = str_replace("&#039;","'",$cData);
		$cData = str_replace("\'","'",$cData);
		$cData = str_replace('\"','"',$cData);
	return $cData;
	}
?>