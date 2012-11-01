<?php
/*******************************
	CSV�����ǡ��������ѥե�����
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
//	$day = $today[year].$today[mon].$today[mday];

	//CSV�ե�����ؤν񤭹���
	$filename = "allData".$today.".csv";

	//�إå�������
	header("Content-Type: application/octet-stream");
	header("Content-Disposition: attachment; filename=$filename");
	
	//CSV�ե��������
	$check = $sql->getcsvData($user_id);
	if($check==false){
		echo mb_convert_encoding($sql->errorm,"SJIS","EUC-JP");
		//echo $sql->errorm;
		exit;
	}
	
	exit;