<?PHP
/*
	���䤤��碌index.php
*/

//https�˥�����쥯��

if((! isset($_SERVER['HTTPS']))){
   header("location:https://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"] );
  exit ;
}


	//����ե������ɤ߹���
	require_once ('../cls/inquiry/setup.php');

	 
	if( $_SERVER['REMOTE_ADDR'] == '221.246.192.14' ){
		$aData = $dData;//�ǡ��������
		//$aData = $tData;//test�ǡ���
		//echo "test<br>";
	}else{
		$aData = $dData;//�ǡ��������
	}
	define("_DEBUG_",false );//�ǥХå�

//	define("_STERT_HTML_"       ,  "start.html" );
	define("_BASE_HTML_"        ,  "base.html" );
	define("_REGIST_HTML_"      ,  "regist.html" );
	define("_CONFILM_HTML_"     ,  "confirm.html" );
	define("_FINISH_HTML_"      ,  "finish.html" );


	
	if( _DEBUG_ ){ echo "_BASE_HTML_                  = "._BASE_HTML_ ."<br>\n";}
	if( _DEBUG_ ){ echo "_REGIST_HTML_                = "._REGIST_HTML_ ."<br>\n";}
	if( _DEBUG_ ){ echo "_CONFILM_HTML_               = "._CONFILM_HTML_ ."<br>\n";}
	if( _DEBUG_ ){ echo "_FINISH_HTML_                = "._FINISH_HTML_ ."<br>\n";}
	/*
	*�ᥤ��
	*/
	if(_DEBUG_){ $cDebug->printArrayData($_POST,$dataName='POSTDATA' ); }

	if(isset($_GET['content'])  == 'mailsend'){ 
		$aData['content']  = "�᡼���������˴ؤ��뤪��礻" ;
		$aData['content2'] = "�ʥ᡼�������������ƥ�˴ؤ�����䡢�����ۤʤɤ򤴵���������������";
	}else{
		$aData['content']  = "ASP�����ƥ�˴ؤ��뤪��礻" ;
		$aData['content2'] = "�ʤ���¾���ո��������ۤʤɤ򤴵�������������";
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
	
	function getDefault($aData) {//�ǽ��
	global $cKen , $cDate;
			$HTMLFILE = _REGIST_HTML_;
		if(_DEBUG_){ echo $HTMLFILE;}
		require_once (_BASE_HTML_);
	return;
	}

	function confirm($aData){//��ǧ
	global $cDebug,$cKen,$libConvert, $cDate;
		//ͥ�����ǥ���С���
		$aData['name_kana_sei'] = $libConvert->getConvert($aData['name_kana_sei'],'KV3C');
		$aData['name_kana_mei'] = $libConvert->getConvert($aData['name_kana_mei'],'KV3C');
/*
		$aData['zip1']      = $libConvert->getConvert($aData['zip1'],'n');
		$aData['zip2']      = $libConvert->getConvert($aData['zip2'],'n');
		$aData['tel1']      = $libConvert->getConvert($aData['tel1'],'n');
		$aData['tel2']      = $libConvert->getConvert($aData['tel2'],'n');
		$aData['tel3']      = $libConvert->getConvert($aData['tel3'],'n');
*/
		$errorMsg = dataCheck($aData);//���顼�����å�
		if(_DEBUG_){ $cDebug->printArrayData($aData,$dataName='aData' ); }
		
		if(!$errorMsg){
			//$viewData = $aData;
			foreach($aData as $key => $value){
				$viewData[$key]  = $libConvert->getConvert($value,'168');//���򡢥���ȴ��
			}
			$viewData['comment']   = str_replace("\n","<br>\n",$viewData['comment']);
			if(_DEBUG_){ $cDebug->printArrayData($viewData,$dataName='viewData' ); }
			
			$HTMLFILE = _CONFILM_HTML_;
		}else{
			$HTMLFILE = _REGIST_HTML_;
		}
		require_once (_BASE_HTML_);		
	return;
	}

	function finish($aData){//��λ
//	require_once (CLS.'mail/registDb.php');
//		registDb($_POST);
		cleateMail($aData);
		$HTMLFILE = _FINISH_HTML_;
		require_once (_BASE_HTML_);
	return;
	}

	function back($aData){
	global $cKen, $cDate, $cDebug;
	if(_DEBUG_){ $cDebug->printArrayData($aData,$dataName='BACKDATA' ); }
		foreach($aData as $key => $value ){
			$value = retrunHTML($value);
		}
		$HTMLFILE = _REGIST_HTML_;
	require_once(_BASE_HTML_);
	}

	function outPutHidden($aData){
	global $cDebug;
	if(_DEBUG_){ $cDebug->printArrayData($aData,$dataName='HIDDENDATA' ); }
		foreach($aData as $key => $value){
			$value = str_replace("\"","&quot;",$value);
			$value = str_replace("'","&#039;",$value);
			print "<input type='hidden' name='aData[$key]' value='$value'>\n";
		}
	}

	function print_error($errorMsg){
		foreach ($errorMsg as $key => $value){
			print $value."<br>\n";
		}
	return;
	}

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

	function bCheckd($a,$b){
		if($a == $b){
			print "checked";
		}
	}

	function retrunHTML($cData){
		$cData = str_replace("&quot;","\"",$cData);
		$cData = str_replace("&#039;","'",$cData);
	return $cData;
	}
?>