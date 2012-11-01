<?php
/*******************************
	詳細画面出力用ファイル	
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
	
	//GETで受けた登録者ID取得
	$app_id = $_GET['app_id'];
	
	//DBよりデータの取得
	$app_list = array();
	$app_list = $sql->detailed($app_id);
	if($app_list==false){
		echo $sql->errorm;
		exit;
	}
/*	
	//HTMLへ配列を代入
	$smarty->assign("app_list",$app_list);
	//HTML出力
	$smarty->display("detailed.tpl");
*/
	require_once("./templates/detailed.html");
?>