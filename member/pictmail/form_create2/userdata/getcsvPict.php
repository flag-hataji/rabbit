<?php
/*******************************
	CSV��Pict�ǡ������������ѥե�����
********************************/

	//�ե�������ɤ߹���
	require_once("../SQLData.class.php");
	
	//���󥹥�������
	$sql    = new SQLData();
	
	//SESSION����桼����ID����
	session_start();
	$user    = $_SESSION['user'];
	$user_id = $user['user_id'];
		if(($user_id=="")||(is_null($user_id))){
		require_once("../templates/loginError.html");
		exit;
	}
	
	//���դμ���
	$today = date("YmdHis");

	//CSV�ե�����ؤν񤭹���
	$filename = "pictData2_".$today.".csv";

	//�إå�������
	header("Content-Type: application/octet-stream");
	header("Content-Disposition: attachment; filename=$filename");
	
	//CSV�ե��������
	$check = $sql->getcsvPictData($user_id);
	if($check==false){
		echo $sql->errorm;
		exit;
	}
	
	exit;
