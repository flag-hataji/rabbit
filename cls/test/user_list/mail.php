<?PHP 
//�᡼������
/*
----aData----
[content] => ����¾����礻(���ո��������ۤʤ�
[name_kana_sei] => �ϥ���
[name_kana_mei] => ���祦�إ�
[name_sei] => Ȩ��
[name_mei] => ��ʿ
[mail] => hataji@itm.ne.jp
[mail_conf] => hataji@itm.ne.jp
[tel1] => 092
[tel2] => 525
[tel3] => 0081
[phone1] => 090
[phone2] => 0000
[phone3] => 0000
[comment] => �ǥХå��ѥƥ���
[renraku] => �᡼��
*/


	function cleateMail($aData){//�᡼������
	global $cMail;

		//$aData['comment']  = str_replace("<����>","\n",$aData['comment']);
		$to 		 = "info@itm-asp.com";
		$from     = $aData['mail'];

		$subject = "���䤤��碌����Ƥ��ޤ���";
		$subject2  = "���䤤��碌������դ��ޤ�����";
		//$error	  = $to;
		$error	  = "hataji@itm.ne.jp";

//���󥭥塼�᡼����ʸ
		$message  = "���䤤��碌������դ��ޤ�����\n";
		$message .= "\n";
		$message .= "[�եꥬ�ʡ���]����{$aData['name_kana_sei']}��{$aData['name_kana_mei']}\n";
		$message .= "[��̾��������]����{$aData['name_sei']}��{$aData['name_mei']}\n";
		$message .= "[���̾������]����{$aData['company']}\n";
		$message .= "[�᡼�롡����]����{$aData['mail']}\n";
		$message .= "[�����ֹ桡��]����{$aData['tel1']}-{$aData['tel2']}-{$aData['tel3']}\n";
		$message .= "[�������ơ���]\n";
		$message .= "{$aData['comment']}\n";
		$message .= "\n";
		$message .= "\n";


		//�����Ԥإ᡼����ʸ
		$message2  = "���䤤��碌������դ��ޤ�����\n";
		$message2 .= "\n";
		$message2 .= "[�եꥬ�ʡ���]����{$aData['name_kana_sei']}��{$aData['name_kana_mei']}\n";
		$message2 .= "[��̾��������]����{$aData['name_sei']}��{$aData['name_mei']}\n";
		$message2 .= "[���̾������]����{$aData['company']}\n";
		$message2 .= "[�᡼�롡����]����{$aData['mail']}\n";
		$message2 .= "[�����ֹ桡��]����{$aData['tel1']}-{$aData['tel2']}-{$aData['tel3']}\n";
		$message2 .= "[�������ơ���]\n";
		$message2 .= "{$aData['comment']}\n";
		$message2 .= "\n";
		$message2 .= "\n";

		$cMail->encode( $from,$to,$subject,$message );
		//$cMail->isNormalMail($from, $to, $subject, $message, $cc="",$bcc="",$error ,$reply="");
		$cMail->normalMb_send_mail($from, $to,  $subject, $message,  $cc=False,   $bcc=False, $error ,  $reply=False);
		$cMail->normalMb_send_mail($to, $from,  $subject2, $message2,  $cc=False,   $bcc=False, $error ,  $reply=False);
	return;
	}


?>

