<?PHP 
//メール送信
/*
[aData] => Array
-[password] => 会員番号という名のパスワード
-[email] => 　PCメールアドレス
-[m_email] => 　携帯メールアドレス
-[name_family] => 　性
-[name_first] => 　名
-[kana_family] => 　セイ
-[kana_first] => 　メイ
-[tel_flag] => 　連絡先（1＝自宅　2＝勤務先）
-[company] => 会社名
-[company_kana] => 会社名かな
-[tel1] => 090
-[tel2] => 0000
-[tel3] => 1111
-[sex] => 0 0＝♂
-[year] => 1981
-[month] => 12
-[day] => 12
-[zip] =>　郵便番号（ハイフンあり） 
-[address1] => 県
-[address2] => 市町村
-[address3] => アパート名
-[mail_flag] => f　DM配信するか（t=YES）

*/


	function cleateMail($aData){//メール送信
	global $cMail , $cDebug;

		if($aData['sex']==0){
			$aData['sex_mb'] = "男性";
		}else{
			$aData['sex_mb'] = "女性";
		}

		if($aData['mail_flag']==t){
			$aData['mail_flag_mb'] = "受け取る";
		}else{
			$aData['mail_flag_mb'] = "受け取らない";
		}

		if($aData['tel_flag']==1){
			$aData['tel_flag_mb'] = "自宅";
		}else{
			$aData['tel_flag_mb'] = "勤務先";
		}

		//$aData['comment']  = str_replace("<改行>","\n",$aData['comment']);
		//$from 		  = "hataji@itm.ne.jp";
		$from   = "plan-promo@hnf.co.jp";
		$to     = $aData['email'];


		if(isset($aData['member_id'])){
			$res  = "会員情報変更を承りました。";
			$res2 = "会員情報変更がありました";
		}else{
			$res  = "会員登録ありがとうございます。";
			$res2 = "会員登録がありました";
		}
		$subject   = $res;
		$subject2  = $res2;
		//$error	  = $to;
		$error	  = "hataji@itm.ne.jp";

//サンキューメール本文
		$message  = $res."\n";
		$message .= "以下の情報を登録いたしました。\n";
		$message .= "\n";
		$message .= "[会員番号]　　　　　　　　{$aData['password']}\n";
		$message .= "[E-mail]　　　　　　　　　{$aData['email']}\n";
		$message .= "[携帯E-mail(モバイル用)]　{$aData['m_email']}\n";
		$message .= "[お名前]　　　　　　　　　{$aData['name_family']}　{$aData['name_first']}\n";
		$message .= "[フリガナ]　　　　　　　　{$aData['kana_family']}　{$aData['kana_first']}\n";
		$message .= "[連絡先]　　　　　　　　　{$aData['tel_flag_mb']}\n";
		$message .= "[会社名かな]　　　　　　　{$aData['company_kana']}\n";
		$message .= "[会社名]　　　　　　　　　{$aData['company']}\n";
		$message .= "[電話番号]　　　　　　　　{$aData['tel1']}-{$aData['tel2']}-{$aData['tel3']}\n";
		$message .= "[性別]　　　　　　　　　　{$aData['sex_mb']}\n";
		$message .= "[生年月日]　　　　　　　　{$aData['year']}年{$aData['month']}月{$aData['day']}日\n";
		$message .= "[郵便番号]　　　　　　　　{$aData['zip']}\n";
		$message .= "[住所(都道府県）] 　　　　{$aData['address1']}\n";
		$message .= "[住所(市町村以下)]　　　　{$aData['address2']}\n";
		$message .= "[住所(マンション名)]　　　{$aData['address3']}\n";
		$message .= "[ＤＭ・メールマガジン※]　{$aData['mail_flag_mb']}\n";
		$message .= "\n";
		$message .= "\n";


//管理者へメール本文
		$message2  = $res2."\n";
		$message2 .= "以下の情報を登録いたしました。\n";
		$message2 .= "\n";
		$message2 .= "[会員番号]　　　　　　　　{$aData['password']}\n";
		$message2 .= "[E-mail]　　　　　　　　　{$aData['email']}\n";
		$message2 .= "[携帯E-mail(モバイル用)]　{$aData['m_email']}\n";
		$message2 .= "[お名前]　　　　　　　　　{$aData['name_family']}　{$aData['name_first']}\n";
		$message2 .= "[フリガナ]　　　　　　　　{$aData['kana_family']}　{$aData['kana_first']}\n";
		$message2 .= "[連絡先]　　　　　　　　　{$aData['tel_flag_mb']}\n";
		$message2 .= "[会社名かな]　　　　　　　{$aData['company_kana']}\n";
		$message2 .= "[会社名]　　　　　　　　　{$aData['company']}\n";
		$message2 .= "[電話番号]　　　　　　　　{$aData['tel1']}-{$aData['tel2']}-{$aData['tel3']}\n";
		$message2 .= "[性別]　　　　　　　　　　{$aData['sex_mb']}\n";
		$message2 .= "[生年月日]　　　　　　　　{$aData['year']}年{$aData['month']}月{$aData['day']}日\n";
		$message2 .= "[郵便番号]　　　　　　　　{$aData['zip']}\n";
		$message2 .= "[住所(都道府県）] 　　　　{$aData['address1']}\n";
		$message2 .= "[住所(市町村以下)]　　　　{$aData['address2']}\n";
		$message2 .= "[住所(マンション名)]　　　{$aData['address3']}\n";
		$message2 .= "[ＤＭ・メールマガジン※]　{$aData['mail_flag_mb']}\n";
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