<?php
/*******************************
	�ܺٲ��̽����ѥե�����	
********************************/

	//�ե�������ɤ߹���
//	require_once("MySmarty.class.php");
	require_once("SQLData.class.php");
	
	//���󥹥�������
//	$smarty = new MySmarty();
	$sql    = new SQLData();
	
	//SESSION����桼����ID����
	session_start();
	$user    = $_SESSION['user'];
	$user_id = $user['user_id'];
		if(($user_id=="")||(is_null($user_id))){
		require_once("./templates/loginError.html");
		exit;
	}
	
	//GET�Ǽ�������Ͽ��ID����
	$app_id = $_GET['app_id'];
	
	//DB���ǡ����μ���
	$app_list = array();
	$app_list = $sql->detailed($app_id);
	if($app_list==false){
		echo $sql->errorm;
		exit;
	}
/*	
	//HTML�����������
	$smarty->assign("app_list",$app_list);
	//HTML����
	$smarty->display("detailed.tpl");
*/
	require_once("./templates/detailed.html");
?>