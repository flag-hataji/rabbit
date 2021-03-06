<?php
/*******************************************
	フォームを作成、変更するためのファイル
	作成されたデータはDBへ保存
*********************************************/

	//ファイルを読み込み
//	require_once("MySmarty.class.php");
	require_once("CheckValue.class.php");
	require_once("SQLData.class.php");
	
	//SESSIONからユーザーID取得
	session_start();
	$user    = $_SESSION['user'];
	$user_id = $user['user_id'];
		if(($user_id=="")||(is_null($user_id))){
		require_once("./templates/loginError.html");
		exit;
	}
	
	//インスタンス生成
//	$smarty = new MySmarty();
	$chk = new CheckValue();
	$sql = new SQLData();
	
	//POSTのデータを取得
	$data = $_POST['data'];
	
	//パラメーター数の指定
	$paramAmount = "5";

	//Deleteフラグの設定
	$del_flag = 0;
	
	//パラメーターの値、チェック値の初期化
	for($i=1;$i<=$paramAmount;$i++){
		$param_name[$i] = "パラメーター".$i;
		$check[$i] = "0";
	}
	
	//サンキューページ戻り先URL初期値設定
	$thk_url = "http://www.yahoo.co.jp";
	
	//DBよりフォームデータの取得
	//テーブル名
	$tableName = "td_form_create";
	$sql_data = $sql->getTableData($tableName,$user_id);
	if($sql_data=="f"){
		echo $sql->errorm;
		exit;
	}

	//フォームデータ修正の場合の対処
	if(!$sql_data==""){

		//フォームネームの取得
		$form_name = $sql_data['form_name'];
		//フォームヘッダーの取得
		$form_header = $sql_data['form_header'];
		
		//名前のチェック値取得
		$name_check = $sql_data['name_check'];

		if($name_check=="1"){
		    $name_cnt0 = "on";
		    
		}else if($name_check=="2"){
		    $name_cnt0 = "on";
		    $name_cnt1 = "on";
		}
		//パラメーター、チェック値の取得
		for($l=1;$l<=$paramAmount;$l++){
		
			$param_name[$l] = $sql_data['param'.$l];
			$check[$l] = $sql_data['check'.$l];
			if($check[$l]=="1"){
				$cnt0[$l] = "on";
			}else if($check[$l]=="2"){
				$cnt0[$l] = "on";
				$cnt1[$l] = "on";
			}
			
		}	
		
		//サンキューページ戻り先URLの取得
		$thk_url = $sql_data['thk_url'];
	
	}else{				//フォームデータ新規作成の場合の対処
		if(is_null($data)){
		/*	//htmlへ変数代入
			$smarty->assign("param_name",$param_name);
			$smarty->assign("thk_url",$thk_url);
			//html出力
			$smarty->display("./correction.tpl");
			exit;
		*/
			require_once("./templates/correction.html");
			exit;
		}
	}

	//POSTフラグ
	$postFlag = "0";

	//POSTが来た場合の処理
	if(!is_null($data)){

		//POSTから受けたデータ　　　フォームの名前
		if((!$data['form_name']=="")||(!is_null($data['form_name']))){
			$form_name = $data['form_name'];
			
		}
		
		//POSTから受けたデータ　　　フォームヘッダー
		if((!$data['form_header']=="")||(!is_null($data['form_header']))){
			$form_header = $data['form_header'];
		}

		//POSTから受けたデータ　　お名前
		$name_check0 = $data['name_check'][0];
		$name_check1 = $data['name_check'][1];
        
		//使用チェック時
		if($name_check0=="t"){
		    $name_cnt0  = "on";
		    $name_check = "1";
		}else{
		    $name_cnt0 = "off";
		}
		//必須チェック時
		if($name_check1=="t"){
		    $name_cnt0  ="on";
		    $name_cnt1  ="on";
		    $name_check = "2";
		}else{
		    $name_cnt1 = "off";
		}
		//どちらもチェックがない場合
		if(($name_check0!="t")&&($name_check1!="t")){
		    $name_cnt0  = "off";
		    $name_cnt1  = "off";
		    $name_check = "0";
		}
		
		//POSTから受けたデータ　　パラメーター
		for($j=1;$j<=$paramAmount;$j++){
			
			//checkboxの値を取得	
			$param_ini0 = $data['param_ini'.$j][0];
			$param_ini1 = $data['param_ini'.$j][1];
			
			if($param_ini0=="t"){				//checkbox使用の入力チェック
				$param_name[$j] = $data['param_name'.$j];			
				$chk->requireCheck($param_name[$j],"パラメーター$j");
				$cnt0[$j]="on";
				$check[$j]="1";	
			}else{
				$cnt0[$j]="off";
			}
			
			if($param_ini1=="t"){			//checkbox必須の入力チェック
			
				$param_name[$j] = $data['param_name'.$j];			
				$chk->requireCheck($param_name[$j],"パラメーター$j");
				$cnt0[$j]="on";
				$cnt1[$j]="on";
				$check[$j]="2";
			}else{
				$cnt1[$j]="off";
			}
			
			if((!$param_ini0=="t")&&(!$param_ini1=="t")){ //どちらも入力されていない場合
				$cnt0[$j]="off";
				$cnt1[$j]="off";
				$check[$j]="0";
			}
			$postFlag="1";
		}
		
		//サンキューページ戻り先URL取得
		$thk_url = $data['thk_url'];
		
		//入力チェック
		//$chk->requireCheck($thk_url,"サンキューページ戻り先URL");
		$chk->urlCheck($thk_url);
	}

	//thk_urlが空のときの対処
	if($thk_url==""){
		$thk_url = "";
	}
	
	//DBクラスへ値を格納
	$sql->setFormName($form_name);
	$sql->setFormHeader($form_header);
	$sql->setParamName($param_name);
	$sql->setParamVal($param_val);
	$sql->setNameCheck($name_check);
	$sql->setCheck($check);
	$sql->setCheckVal($check_val);
	$sql->setThkUrl($thk_url);
	$sql->setDeleteFlag($del_flag);
	$sql->setUserId($user_id);
		
	//文字列の置換
	$form_name   = htmlspecialchars($form_name);
	$form_header = htmlspecialchars($form_header);
	foreach($param_name as $key=>$value){
		$param_name[$key] = htmlspecialchars($value);
	}

	$thk_url = htmlspecialchars($thk_url);
				
/*	//htmlへ変数代入
	$smarty->assign("postFlag",$postFlag);
	$smarty->assign("cnt0",$cnt0);
	$smarty->assign("cnt1",$cnt1);
	$smarty->assign("form_name",$form_name);
	$smarty->assign("form_header",$form_header);
	$smarty->assign("param_name",$param_name);
	$smarty->assign("thk_url",$thk_url);
*/
	//エラーメッセージ取得
	$errorm = $chk->getError();
	$cnt = count($errorm);
	if($cnt>0){
		/*
		$smarty->assign("errorm",$errorm);
		$smarty->display("./correction.tpl");
		*/
		
		require_once("./templates/correction.html");
		exit;
	}else{
	
		//DBへ値を格納
		if($sql_data==""){		//新規の場合
			$res = $sql->insertFormData();
			if(!$res){
				echo $sql->errorm;
				exit;
			}
		}else{					//修正の場合
			$res = $sql->updateFormData();
			if(!$res){
				echo $sql->errorm;
				exit;
			}
		}
	}
	

	if(is_null($data)){

		//修正時出力先
		require_once("./templates/correction.html");
	}else{	//登録完了時出力先
		$url = "./index.php";
		/*$smarty->assign("url","./index.php");
		$smarty->display("./completion.tpl");
		*/
		
		//フォームID取得
		$f_id = $sql->getFormId($user_id);
		if($f_id=="f"){
			echo $sql->errorm;
			exit;
		}

		$url_mess = "http://www.rabbit-mail.jp/member/pictmail/form_create/confirmForm.php?u_id=$user_id&f_id=$f_id";
		$url_mess2 ="http://www.rabbit-mail.jp/member/pictmail/form_create/m-confirmForm.php?u_id=$user_id&f_id=$f_id";
    $mess_flag = 1;
		require_once("./templates/completion.html");
	}


?>