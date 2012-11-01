<?php
/*****************************************
	���󥭥塼�᡼�������ѥե�����
****************************************/

	//�ե�������ɤ߹���
//	require_once("MySmarty.class.php");
	require_once("CheckValue.class.php");
	require_once("SQLData.class.php");
	
	//���󥹥�������
//	$smarty = new MySmarty();
	$chk = new CheckValue();
	$sql = new SQLData();
	
	//SESSION���桼����ID����
	session_start();
	$user    = $_SESSION['user'];
	$user_id = $user['user_id'];
		if(($user_id=="")||(is_null($user_id))){
		require_once("./templates/loginError.html");
		exit;
	}
	
	//delete�ե饰
	$del_flag="0";
	
	//�ե���������ϥǡ��������
	$data = $_POST['data'];
	
	//TEXT��å������ν��������
	$text_mess = "��å����������Ϥ��Ʋ�����";
	
	//hrml��å������ν��������
	$html_mess = "";
	
	//DB����ǡ��������
	$sql_data = $sql->getSettingMail3Data($user_id);
	if(!$sql_data==""){
	
		//���󥭥塼�᡼��Υե饰����	
		$sendMail         = $sql_data['sendmail_flag'];
		if($sendMail=="1"){
			$sendMail="t";
		}else if($sendMail=="0"){
			$sendMail="f";
		}
		//������̾����
		$transmit_name    = $sql_data['transmit_name'];
		//�������᡼�륢�ɥ쥹����
		$transmit_mailadd = $sql_data['transmit_mailadd'];
		//���顼�����᡼�륢�ɥ쥹�μ���
		$return_err       = $sql_data['return_err'];
		//��̾�μ���
		$subject          = $sql_data['subject'];
		//TEXT��å������μ���
		$text_mess        = $sql_data['text_mess'];
		//HTML��å��������ѤΥե饰����
		$use_html         = $sql_data['html_flag'];
		//���ӥ�å����������
		$mobail_mess      = $sql_data['mobail_mess'];
		$use_mobail       = $sql_data['mobail_flag'];
		//html�Ѥ��ѿ��ִ�
		if($use_html=="1"){
			$use_html="t";
		}
		
		//HTML��å������μ���
		$html_mess        = $sql_data['html_mess'];
		//�����ѤΥե饰
		$flag = "up";
	}else{								//���������ξ��ν���
		if(is_null($data)){
			$flag="in";
			
			//���Ӥؤ��н�����
			$use_mobail = 2;
		/*
			//html���ѿ�����
			$smarty->assign("flag",$flag);
			$smarty->assign("text_mess",$text_mess);
			$smarty->assign("postFlag",$postFlag);
			//html����
			$smarty->display("./settingMail.tpl");
		*/
			require_once("./templates/settingMail3.html");
			exit;
		}
	}
	
	//POST���褿�����н�
	if(!is_null($data)){
	
		//���󥭥塼�᡼��Υե饰����	
		$sendMail         = $data['sendMail'];
		//������̾����						��ɬ�ܹ���
		$transmit_name    = $data['transmit_name'];
		//�������᡼�륢�ɥ쥹����			��ɬ�ܹ���
		$transmit_mailadd = $data['transmit_mailadd'];
		//���顼�����᡼�륢�ɥ쥹�μ���	��ɬ�ܹ���
		$return_err       = $data['return_err'];
		//��̾�μ���						��ɬ�ܹ���
		$subject          = $data['subject'];
		//TEXT��å������μ���				��ɬ�ܹ���
		$text_mess        = $data['text_mess'];
		//HTML��å��������ѤΥե饰����
		$use_html         = $data['use_html'];
		//HTML��å������μ���
		$html_mess        = $data['html_mess'];
		//�����ѥ�å���������
		$mobail_mess      = $data['mobail_mess'];
		//�����ѥե饰����
		$use_mobail       = $data['use_mobail'];

		//�⡼�ɤμ���
		$mode             = $data['mode'];
		//�ե饰�μ���
		$flag             = $data['flag'];
		/*�������ƤΥ��顼�����å�
			requireCheck��ɬ�ܹ��ܳ�ǧ�᥽�å�
			zenCheck�ϣ��Х���ʸ����ǧ�᥽�å�
			mailCheck�ϥ᡼�륢�ɥ쥹�����å��᥽�å�*/
		$chk->requireCheck($transmit_name,"������̾");
//		$chk->zenCheck($transmit_name,"������̾");
		$chk->requireCheck($transmit_mailadd,"�������᡼�륢�ɥ쥹");
		$chk->mailCheck($transmit_mailadd,"�������᡼�륢�ɥ쥹");
		$chk->requireCheck($return_err,"���顼�����᡼�륢�ɥ쥹");
		$chk->mailCheck($return_err,"���顼�����᡼�륢�ɥ쥹");
		$chk->requireCheck($subject,"��̾");
		$chk->requireCheck($text_mess,"TEXT��å�����");
		
		
		if($mode=="check"){
			//HTML��ǧ�����Ѥ��Ѵ�
			$transmit_name    = htmlspecialchars($transmit_name);
			$transmit_mailadd = htmlspecialchars($transmit_mailadd);
			$return_err       = htmlspecialchars($return_err);
			$subject          = htmlspecialchars($subject);
			$s_text_mess      = htmlspecialchars($text_mess);
			$s_text_mess      = nl2br($s_text_mess);
			$s_html_mess      = htmlspecialchars($html_mess);
			$s_html_mess      = nl2br($s_html_mess);
			$html_mess        = ereg_replace('"',"'",$html_mess);
			$s_mobail_mess    = nl2br(htmlspecialchars($mobail_mess));
		}
	}
/*
	//HTML���ѿ�����
	$smarty->assign("sendMail",$sendMail);
	$smarty->assign("transmit_name",$transmit_name);
	$smarty->assign("transmit_mailadd",$transmit_mailadd);
	$smarty->assign("return_err",$return_err);
	$smarty->assign("subject",$subject);
	$smarty->assign("text_mess",$text_mess);
	$smarty->assign("s_text_mess",$s_text_mess);
	$smarty->assign("use_html",$use_html);
	$smarty->assign("html_mess",$html_mess);
	$smarty->assign("s_html_mess",$s_html_mess);
	$smarty->assign("del_flag",$del_flag);
	$smarty->assign("flag",$flag);
*/
	//���顼�ο�������������顼������Х��顼ɽ��
	$errorm = array();
	$errorm = $chk->getError();
	$cnt = count($errorm);
	if($cnt>0){
	/*
		//HTML���ѿ�����
		$smarty->assign("errorm",$errorm);
		//HTML����
		$smarty->display("./settingMail.tpl");
	*/
		require_once("./templates/settingMail3.html");
	}else{
	
		if(is_null($data)){				//��������
			//HTML����
			//$smarty->display("./settingMail.tpl");
			require_once("./templates/settingMail3.html");
		}else{
			if($mode=="input"){			//��Ͽ�����ѹ���
				//$smarty->display("./settingMail.tpl");
				require_once("./templates/settingMail3.html");
			}else if($mode=="check"){
				//HTML����					//��Ͽ��
				//$smarty->display("./sm_check.tpl");
				require_once("./templates/sm_check3.html");
			}
		}
		
	}

?>