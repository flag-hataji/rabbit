<?php
/***************************************
	��Ͽ�԰��������ѥե�����
***************************************/

	//�ե�������ɤ߹���
//	require_once("MySmarty.class.php");
	require_once("SQLData.class.php");
	
	//���󥹥�������
//	$smarty = new MySmarty();
	$sql = new SQLData();
	
	//SESSION���桼����ID����
	session_start();
	$user    = $_SESSION['user'];
	$user_id = $user['user_id'];
		if(($user_id=="")||(is_null($user_id))){
		require_once("./templates/loginError.html");
		exit;
	}
	
	//DB���ǡ����μ���
	$user_list = $sql->showUserData($user_id);
	if($user_list==false){
		if($sql->errorm!=""){
			echo $sql->errorm;
			exit;
		}
		//DB�˥ǡ������ʤ����
		$mess = "��Ͽ�ԥǡ���������ޤ���";
/*
		$smarty->assign("mess",$mess);
		//HTML����
		$smarty->display("./notFound.tpl");
*/
		require_once("./templates/notFound.html");
		exit;
	}
/*	
	//�����HTML������
	$smarty->assign("user_list",$user_list);
	//HTML����
	$smarty->display("./showUserData.tpl");
*/
	require_once("./templates/showUserData.html");
?>