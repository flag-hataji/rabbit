<?php
/*******************************
	��Ͽ�ǡ���(����)����ѥե�����
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
	
	//��ϿID
	$app_id = $_GET['app_id'];	
	
	//�桼�����ǡ������
	$check = $sql->delUserData($user_id,$app_id);
	if($check==false){
		echo $sql->errorm;
		exit;
	}
	
	
	$mess = "��ϿID��".$app_id."�������ޤ���";
	
/*	
	//HTML���ѿ�����
	$smarty->assign("mess",$mess);
	
	//HTML����
	$smarty->display("./notFound.tpl");
*/
	require_once("./templates/delete.html");
?>