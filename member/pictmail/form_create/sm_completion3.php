<?php
/********************************************
	���󥭥塼�᡼���������Ƴ�ǧ���ϥե�����
********************************************/

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
	
	//POST�Ǽ������ͤ����
	$data = $_POST['data'];
	
	//���줾����ͤ��ѿ��˳�Ǽ
	$sendMail         = $data['sendMail'];
	$transmit_name    = $data['transmit_name'];
	$transmit_mailadd = $data['transmit_mailadd'];
	$return_err       = $data['return_err'];
	$subject          = $data['subject'];
	$text_mess        = $data['text_mess'];
	$use_html         = $data['use_html'];
	$html_mess        = $data['html_mess'];
	$use_mobail       = $data['use_mobail'];
	$mobail_mess      = $data['mobail_mess'];
	$del_flag         = $data['del_flag'];
	$flag             = $data['flag'];
		
	//DB���饹���ͤ��Ǽ
	$sql->setSendMail($sendMail);
	$sql->setTransmitName($transmit_name);
	$sql->setTransmitMailAdd($transmit_mailadd);
	$sql->setReturnErr($return_err);
	$sql->setSubject($subject);
	$sql->setTextMess($text_mess);
	$sql->setUseHtml($use_html);
	$sql->setHtmlMess($html_mess);
	$sql->setUseMobail($use_mobail);
	$sql->setMobailMess($mobail_mess);
	$sql->setDeleteFlag($del_flag);
	$sql->setUserId($user_id);
	
	//�ǡ�����DB����¸
	if($flag=="in"){		//�����ν���
		$ans = $sql->insertSettingMail3Data();
		if(!$ans){
		echo $sql->errorm;
			exit;
		}
	}else if($flag=="up"){					//�����ν���
		$ans = $sql->updateSettingMail3Data();
		if(!$ans){
			echo $sql->errorm;
			exit;
		}
	}
	
	//html����
	$url = "./index.php";
/*
	$smarty->assign("url",$url);
	$smarty->display("./completion.tpl");
*/
	require_once("./templates/completion.html");
?>