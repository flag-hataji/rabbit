<?PHP 
//�᡼������
/*
[aData] => Array
-[password] => ����ֹ�Ȥ���̾�Υѥ����
-[email] => ��PC�᡼�륢�ɥ쥹
-[m_email] => �����ӥ᡼�륢�ɥ쥹
-[name_family] => ����
-[name_first] => ��̾
-[kana_family] => ������
-[kana_first] => ���ᥤ
-[tel_flag] => ��Ϣ�����1�Ἣ��2���̳���
-[company] => ���̾
-[company_kana] => ���̾����
-[tel1] => 090
-[tel2] => 0000
-[tel3] => 1111
-[sex] => 0 0���
-[year] => 1981
-[month] => 12
-[day] => 12
-[zip] =>��͹���ֹ�ʥϥ��ե󤢤�� 
-[address1] => ��
-[address2] => ��Į¼
-[address3] => ���ѡ���̾
-[mail_flag] => f��DM�ۿ����뤫��t=YES��

*/


	function cleateMail($aData){//�᡼������
	global $cMail , $cDebug;

		if($aData['sex']==0){
			$aData['sex_mb'] = "����";
		}else{
			$aData['sex_mb'] = "����";
		}

		if($aData['mail_flag']==t){
			$aData['mail_flag_mb'] = "�������";
		}else{
			$aData['mail_flag_mb'] = "�������ʤ�";
		}

		if($aData['tel_flag']==1){
			$aData['tel_flag_mb'] = "����";
		}else{
			$aData['tel_flag_mb'] = "��̳��";
		}

		//$aData['comment']  = str_replace("<����>","\n",$aData['comment']);
		//$from 		  = "hataji@itm.ne.jp";
		$from   = "plan-promo@hnf.co.jp";
		$to     = $aData['email'];


		if(isset($aData['member_id'])){
			$res  = "��������ѹ��򾵤�ޤ�����";
			$res2 = "��������ѹ�������ޤ���";
		}else{
			$res  = "�����Ͽ���꤬�Ȥ��������ޤ���";
			$res2 = "�����Ͽ������ޤ���";
		}
		$subject   = $res;
		$subject2  = $res2;
		//$error	  = $to;
		$error	  = "hataji@itm.ne.jp";

//���󥭥塼�᡼����ʸ
		$message  = $res."\n";
		$message .= "�ʲ��ξ������Ͽ�������ޤ�����\n";
		$message .= "\n";
		$message .= "[����ֹ�]����������������{$aData['password']}\n";
		$message .= "[E-mail]������������������{$aData['email']}\n";
		$message .= "[����E-mail(��Х�����)]��{$aData['m_email']}\n";
		$message .= "[��̾��]������������������{$aData['name_family']}��{$aData['name_first']}\n";
		$message .= "[�եꥬ��]����������������{$aData['kana_family']}��{$aData['kana_first']}\n";
		$message .= "[Ϣ����]������������������{$aData['tel_flag_mb']}\n";
		$message .= "[���̾����]��������������{$aData['company_kana']}\n";
		$message .= "[���̾]������������������{$aData['company']}\n";
		$message .= "[�����ֹ�]����������������{$aData['tel1']}-{$aData['tel2']}-{$aData['tel3']}\n";
		$message .= "[����]��������������������{$aData['sex_mb']}\n";
		$message .= "[��ǯ����]����������������{$aData['year']}ǯ{$aData['month']}��{$aData['day']}��\n";
		$message .= "[͹���ֹ�]����������������{$aData['zip']}\n";
		$message .= "[����(��ƻ�ܸ���] ��������{$aData['address1']}\n";
		$message .= "[����(��Į¼�ʲ�)]��������{$aData['address2']}\n";
		$message .= "[����(�ޥ󥷥��̾)]������{$aData['address3']}\n";
		$message .= "[�ģ͡��᡼��ޥ�����]��{$aData['mail_flag_mb']}\n";
		$message .= "\n";
		$message .= "\n";


//�����Ԥإ᡼����ʸ
		$message2  = $res2."\n";
		$message2 .= "�ʲ��ξ������Ͽ�������ޤ�����\n";
		$message2 .= "\n";
		$message2 .= "[����ֹ�]����������������{$aData['password']}\n";
		$message2 .= "[E-mail]������������������{$aData['email']}\n";
		$message2 .= "[����E-mail(��Х�����)]��{$aData['m_email']}\n";
		$message2 .= "[��̾��]������������������{$aData['name_family']}��{$aData['name_first']}\n";
		$message2 .= "[�եꥬ��]����������������{$aData['kana_family']}��{$aData['kana_first']}\n";
		$message2 .= "[Ϣ����]������������������{$aData['tel_flag_mb']}\n";
		$message2 .= "[���̾����]��������������{$aData['company_kana']}\n";
		$message2 .= "[���̾]������������������{$aData['company']}\n";
		$message2 .= "[�����ֹ�]����������������{$aData['tel1']}-{$aData['tel2']}-{$aData['tel3']}\n";
		$message2 .= "[����]��������������������{$aData['sex_mb']}\n";
		$message2 .= "[��ǯ����]����������������{$aData['year']}ǯ{$aData['month']}��{$aData['day']}��\n";
		$message2 .= "[͹���ֹ�]����������������{$aData['zip']}\n";
		$message2 .= "[����(��ƻ�ܸ���] ��������{$aData['address1']}\n";
		$message2 .= "[����(��Į¼�ʲ�)]��������{$aData['address2']}\n";
		$message2 .= "[����(�ޥ󥷥��̾)]������{$aData['address3']}\n";
		$message2 .= "[�ģ͡��᡼��ޥ�����]��{$aData['mail_flag_mb']}\n";
		$message2 .= "\n";

		if(_DEBUG_){ $cDebug->printArrayData($aData,$dataName='MailData' ); }
		
		//$cMail->encode( $from,$to,$subject,$message );
		//$cMail->isNormalMail($from, $to, $subject, $message, $cc="",$bcc="",$error ,$reply="");
		$error1 = $cMail->normalMb_send_mail($from, $to,  $subject, $message,  $cc=False,   $bcc=False, $error ,  $reply=False);
		$error2 = $cMail->normalMb_send_mail($to, $from,  $subject2, $message2,  $cc=False,   $bcc=False, $error ,  $reply=False);

		if(_DEBUG_){
			echo $error2 ."<br>". $error2."<br>";
		}
	return;
	}



?>