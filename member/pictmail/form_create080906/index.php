<?php
/*******************************
	index.html出力用ファイル
********************************/

	//ファイルを読み込み
	//require_once("MySmarty.class.php");
	require_once("./SQLData.class.php");
	
	//インスタンス生成
	$sql = new SQLData();
//	$smarty = new MySmarty();
	
	//SESSIONからユーザーID取得
	session_start();

	$user    = $_SESSION['user'];
	$user_id = $user['user_id'];
		if(($user_id=="")||(is_null($user_id))){
		require_once("./templates/loginError.html");
		exit;
	}

	//フォームID取得
	$f_id = $sql->getFormId($user_id);
	if($f_id=="f"){
		echo $sql->errorm;
		exit;
	}
	//出力
	require_once("./templates/top.html");

?>