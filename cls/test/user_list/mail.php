<?PHP 
//メール送信
/*
----aData----
[content] => その他お問合せ(ご意見・ご感想など
[name_kana_sei] => ハタジ
[name_kana_mei] => キョウヘイ
[name_sei] => 幡司
[name_mei] => 恭平
[mail] => hataji@itm.ne.jp
[mail_conf] => hataji@itm.ne.jp
[tel1] => 092
[tel2] => 525
[tel3] => 0081
[phone1] => 090
[phone2] => 0000
[phone3] => 0000
[comment] => デバッグ用テスト
[renraku] => メール
*/


	function cleateMail($aData){//メール送信
	global $cMail;

		//$aData['comment']  = str_replace("<改行>","\n",$aData['comment']);
		$to 		 = "info@itm-asp.com";
		$from     = $aData['mail'];

		$subject = "お問い合わせが来ています。";
		$subject2  = "お問い合わせを受け付けました。";
		//$error	  = $to;
		$error	  = "hataji@itm.ne.jp";

//サンキューメール本文
		$message  = "お問い合わせを受け付けました。\n";
		$message .= "\n";
		$message .= "[フリガナ　　]　　{$aData['name_kana_sei']}　{$aData['name_kana_mei']}\n";
		$message .= "[お名前　　　]　　{$aData['name_sei']}　{$aData['name_mei']}\n";
		$message .= "[会社名　　　]　　{$aData['company']}\n";
		$message .= "[メール　　　]　　{$aData['mail']}\n";
		$message .= "[電話番号　　]　　{$aData['tel1']}-{$aData['tel2']}-{$aData['tel3']}\n";
		$message .= "[質問内容　　]\n";
		$message .= "{$aData['comment']}\n";
		$message .= "\n";
		$message .= "\n";


		//管理者へメール本文
		$message2  = "お問い合わせを受け付けました。\n";
		$message2 .= "\n";
		$message2 .= "[フリガナ　　]　　{$aData['name_kana_sei']}　{$aData['name_kana_mei']}\n";
		$message2 .= "[お名前　　　]　　{$aData['name_sei']}　{$aData['name_mei']}\n";
		$message2 .= "[会社名　　　]　　{$aData['company']}\n";
		$message2 .= "[メール　　　]　　{$aData['mail']}\n";
		$message2 .= "[電話番号　　]　　{$aData['tel1']}-{$aData['tel2']}-{$aData['tel3']}\n";
		$message2 .= "[質問内容　　]\n";
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

