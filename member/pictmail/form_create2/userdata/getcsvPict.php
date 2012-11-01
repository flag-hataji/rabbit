<?php
/*******************************
	CSVでPictデータ形式出力用ファイル
********************************/

	//ファイルの読み込み
	require_once("../SQLData.class.php");
	
	//インスタンス生成
	$sql    = new SQLData();
	
	//SESSIONからユーザーID取得
	session_start();
	$user    = $_SESSION['user'];
	$user_id = $user['user_id'];
		if(($user_id=="")||(is_null($user_id))){
		require_once("../templates/loginError.html");
		exit;
	}
	
	//日付の取得
	$today = date("YmdHis");

	//CSVファイルへの書き込み
	$filename = "pictData2_".$today.".csv";

	//ヘッダー情報
	header("Content-Type: application/octet-stream");
	header("Content-Disposition: attachment; filename=$filename");
	
	//CSVファイル出力
	$check = $sql->getcsvPictData($user_id);
	if($check==false){
		echo $sql->errorm;
		exit;
	}
	
	exit;
