<?php

/**********************************************
		�쐬�����t�H�[������̓��̓f�[�^��
		DB�֕ۑ����邽�߂̃t�@�C��
*********************************************/


	//�t�@�C����ǂݍ���
//	require_once("MySmarty.class.php");
	require_once("SQLData.class.php");
	require_once("MyMail.class.php");
		
	//�C���X�^���X����
//	$smarty = new MySmarty();
	$sql    = new SQLData();
	$myMail   = new MyMail;

	//GET�Ń��[�U�[ID�擾
	$user_id = $_GET['u_id'];
	$f_id = $_GET['f_id'];
	
	//ID�̈�v�m�F
	$id_flag = $sql->isValidUser($user_id,$f_id);
	if(($user_id=="")||(!is_numeric($user_id))||(!$id_flag)){
		require_once("./templates/error.html");
		exit;
	}
	
	$submit = $_POST['submit'];
	if($submit!=""){
		$sub_key = key($submit);
		if($sub_key==="back"){
			require_once("./m-confirmForm.php");
		}
	}

	//POST�̃f�[�^���擾
	$data = $_POST['data'];

	//�t�H�[������󂯂��f�[�^��ϐ��Ɋi�[
	$name_family 	  = mb_convert_encoding($data['name_family'],"EUC-JP","SJIS");
	$name_first		  = mb_convert_encoding($data['name_first'],"EUC-JP","SJIS");
	$user_mail_add    = mb_convert_encoding($data['user_mail_add'],"EUC-JP","SJIS");
	$paramAmount      = mb_convert_encoding($data['paramAmount'],"EUC-JP","SJIS");
	$del_flag		  = mb_convert_encoding($data['del_flag'],"EUC-JP","SJIS");
	$thk_url          = mb_convert_encoding($data['thk_url'],"EUC-JP","SJIS");;
	$i="1";
	while($i<=$paramAmount){
		$param[$i]  = mb_convert_encoding($data['param'.$i],"EUC-JP","SJIS");
		$p_name[$i] = mb_convert_encoding($data['param_name'.$i],"EUC-JP","SJIS");
		$i++;
	}
	
	//DB�N���X�֒l���i�[
	$sql->setNameFamily($name_family);
	$sql->setNameFirst($name_first);
	$sql->setUserMailAdd($user_mail_add);
	$sql->setParam($param);
	$sql->setPName($p_name);
	$sql->setDeleteFlag($del_flag);
	$sql->setUserID($user_id);
		
	//DB�փt�H�[���f�[�^��ۑ�
	$res = $sql->saveUserData();
	if(!$res){
		echo mb_convert_encoding($sql->errorm,"SJIS","EUC-JP");
		exit;
	}
	
	//DB���T���L���[���[���̐ݒ�f�[�^�擾
	$tableName="td_setting_thankmail";
	$sql_data = $sql->getTableData($tableName,$user_id);
	
	//�T���L���[���[�����M�̎g�p�m�F �g�p=1 �s�g�p=0
	$sendmail_flag = $sql_data['sendmail_flag'];
	if($sendmail_flag=="1"){

		//DB����󂯂��f�[�^�����ꂼ��ϐ��Ɋi�[
		$transmit_name    = $sql_data['transmit_name'];
		$transmit_mailadd = $sql_data['transmit_mailadd'];
		$return_err       = $sql_data['return_err'];
		$subject          = $sql_data['subject'];
		$text_mess        = $sql_data['text_mess'];
		
		//�e�L�X�g���b�Z�[�W�̃��[�U�[�^�O�A���s��u��
		$text_mess        = str_replace("%name%",$name_family."  ".$name_first,$text_mess);
		$text_mess        = str_replace("%name_family%",$name_family,$text_mess);
		$text_mess        = str_replace("%name_first%",$name_first,$text_mess);
		$text_mess        = str_replace("%name_family%",$name_family,$text_mess);
		$text_mess        = str_replace("%email%",$user_mail_add,$text_mess);
		$text_mess        = ereg_replace("\n","",$text_mess);
		
		$j="1";		
		while($j<=$paramAmount){
			$text_mess        = str_replace("%param".$j."%",$param[$j],$text_mess);
			$j++;
		}
		
		//���[���w�b�_�[
		$from = mb_encode_mimeheader($transmit_name)."<".$transmit_mailadd.">";
		
		//�o�b�t���O
		$pc_flag = 1;
		
		//�g�у��b�Z�[�W�A�t���O�̎擾
		$mobail_mess = $sql_data['mobail_mess'];
		
		//�g�у��b�Z�[�W�̃��[�U�[�^�O�A���s��u��
		$mobail_mess        = str_replace("%name%",$name_family."  ".$name_first,$mobail_mess);
		$mobail_mess        = str_replace("%name_family%",$name_family,$mobail_mess);
		$mobail_mess        = str_replace("%name_first%",$name_first,$mobail_mess);
		$mobail_mess        = str_replace("%name_family%",$name_family,$mobail_mess);
		$mobail_mess        = str_replace("%email%",$user_mail_add,$mobail_mess);
		$mobail_mess        = ereg_replace("\n","",$mobail_mess);
		
		$k="1";		
		while($k<=$paramAmount){
			$mobail_mess        = str_replace("%param".$k."%",$param[$k],$mobail_mess);
			$k++;
		}

		$text_mess   = mb_convert_kana($text_mess,"K");
		$mobail_mess = mb_convert_kana($mobail_mess,"K");
		$mobail_flag = $sql_data['mobail_flag'];

		//�����A�h��docomo���ǂ����`�F�b�N�A�g�у��b�Z�[�W���g�����ǂ������`�F�b�N
	    if(ereg( "^@docomo.ne.jp",substr($user_mail_add,-13) )){
			if($mobail_flag=="2"){
				$text_mess = $mobail_mess;
			}
			$pc_flag = 0;
		}
		//�����A�h��vodafone���ǂ����`�F�b�N���āA�g�у��b�Z�[�W���g�����ǂ������`�F�b�N
		if(ereg( "^@[dqnchtrks]{1}.vodafone.ne.jp",substr($user_mail_add,-17) )){
			if($mobail_flag=="2"){
				$text_mess = $mobail_mess;
			}
			$pc_flag = 0;
		}
		//�����A�h��ezweb���ǂ����`�F�b�N���āA�g�у��b�Z�[�W���g�����ǂ������`�F�b�N
		if(ereg( "^ezweb.ne.jp",substr($user_mail_add,-11) )){
			if($mobail_flag=="2"){
				$text_mess = $mobail_mess;
			}
			$pc_flag = 0;
		}
		//�����A�h��softbank���ǂ����`�F�b�N���āA�g�у��b�Z�[�W���g�����ǂ������`�F�b�N
		if(ereg( "^@[dqnchtrks]{1}.softbank.ne.jp",substr($str,-17) )){
			if($mobail_flag=="2"){
				$text_mess = $mobail_mess;
			}
			$pc_flag = 0;
		}

		//html���b�Z�[�W���M�̎g�p�m�F�@�g�p=1 �s�g�p=0;
		$html_flag        = $sql_data['html_flag'];

		if(($pc_flag=="1")&&($html_flag=="1")){
			$html_mess    = $sql_data['html_mess'];
			$html_mess = ereg_replace("\n","",$html_mess);

			//HTML���[�����M
			$myMail->htmlMail($from,$user_mail_add,$subject,$text_mess,$html_mess);
			
			//�Ǘ���(itm_niki�Ƀ��[��)
			$myMail->htmlMail($from,"niki@itm.ne.jp",$subject,$text_mess,$html_mess);
		
		}else{
			//�ʏ�̃��[���z�M
			$from = "From:".$from;
			mb_send_mail($user_mail_add,$subject,$text_mess,$from);
			mb_send_mail("niki@itm.ne.jp",$subject,$text_mess,$from);
		}
	}
	
	$url = $thk_url;
	//html�o��
	//$smarty->assign("url",$thk_url);
	//$smarty->display("./completion.tpl");
	require_once("./templates/m-cf_completion.html");
	exit;

?>