<?php
/*******************************
	登録データ(１件)削除用ファイル
********************************/

	//ファイルの読み込み
//	require_once("MySmarty.class.php");
	require_once("SQLData.class.php");
	
	//インスタンス生成
//	$smarty = new MySmarty();
	$sql    = new SQLData();
	
	//SESSIONからユーザーID取得
	session_start();
	$user    = $_SESSION['user'];
	$user_id = $user['user_id'];
		if(($user_id=="")||(is_null($user_id))){
		require_once("./templates/loginError.html");
		exit;
	}
	
	//登録ID
	$app_id = $_GET['app_id'];	
	
	//ユーザーデータ削除
	$check = $sql->delUserData($user_id,$app_id);
	if($check==false){
		echo $sql->errorm;
		exit;
	}
	
	
	$mess = "登録ID：".$app_id."を削除しました";
	
/*	
	//HTMLへ変数代入
	$smarty->assign("mess",$mess);
	
	//HTML出力
	$smarty->display("./notFound.tpl");
*/
	require_once("./templates/delete.html");
?>