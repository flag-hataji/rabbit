<?php
/***************************************
	登録者一覧出力用ファイル
***************************************/

	//ファイルの読み込み
//	require_once("MySmarty.class.php");
	require_once("SQLData.class.php");
	
	//インスタンス生成
//	$smarty = new MySmarty();
	$sql = new SQLData();
	
	//SESSIONよりユーザーID取得
	session_start();
	$user    = $_SESSION['user'];
	$user_id = $user['user_id'];
		if(($user_id=="")||(is_null($user_id))){
		require_once("./templates/loginError.html");
		exit;
	}
	
	//DBよりデータの取得
	$user_list = $sql->showUserData($user_id);
	if($user_list==false){
		if($sql->errorm!=""){
			echo $sql->errorm;
			exit;
		}
		//DBにデータがない場合
		$mess = "登録者データがありません";
/*
		$smarty->assign("mess",$mess);
		//HTML出力
		$smarty->display("./notFound.tpl");
*/
		require_once("./templates/notFound.html");
		exit;
	}
/*	
	//配列をHTMLへ代入
	$smarty->assign("user_list",$user_list);
	//HTML出力
	$smarty->display("./showUserData.tpl");
*/
	require_once("./templates/showUserData.html");
?>