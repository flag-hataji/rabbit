<?php
/*******************************
	index.html�����ѥե�����
********************************/

	//�ե�������ɤ߹���
	//require_once("MySmarty.class.php");
	require_once("./SQLData.class.php");
	
	//���󥹥�������
	$sql = new SQLData();
//	$smarty = new MySmarty();
	
	//SESSION����桼����ID����
	session_start();

	$user    = $_SESSION['user'];
	$user_id = $user['user_id'];
		if(($user_id=="")||(is_null($user_id))){
		require_once("./templates/loginError.html");
		exit;
	}

	//�ե�����ID����
	$f_id = $sql->getFormId($user_id);
	if($f_id=="f"){
		echo $sql->errorm;
		exit;
	}
	//����
	require_once("./templates/top.html");

?>