<?php

//PEARライブラリのmimeDecodeを読み込み
require_once("/usr/local/share/pear/Mail/mimeDecode.php");
require_once("/usr/local/share/pear/Mail/mime.php");
require_once("/usr/local/share/pear/Mail.php");
require_once("SqlData.php");
//SqlDataクラスのインスタンス生成
$sql = new SqlData();

//mailの文字列取得
$source = file_get_contents("php://stdin");

//$source = file_get_contents("/usr/local/vpopmail/domains/itm-asp.com/info/Maildir/new/test");
$source = file_get_contents("test2.txt");
if($source===false){
    echo "読み込みエラー";
}
//mimeDecodeのインスタンス生成

$decoder = new Mail_mimeDecode($source); // MIME分解
$parts = $decoder->getSendArray();  // それぞれのパーツを格納
list($recipients,$headers,$body) = $parts; // 各パーツを配列に格納
/*
  foreach($headers as $key=>$value){
    $text .= $key."=>".$value."\n";
  }
  mb_language("Ja") ;
  //mb_internal_encoding("EUC-JP") ;
  $mailto="niki@itm.ne.jp";
  $subject= "空メールエラー";
  $content= "ヘッダー=".$text."空メールでpictmail-xxxxxx@itm-asp.comに該当しなかった";
  $mailfrom="From:".$headers['From'];
  mb_send_mail($mailto,$subject,$content,$mailfrom);
  exit;
*/


//送信側メールアドレスの取得
$from = $headers['From'];

/*
if(isset($headers['X-Forwarded-To'])){      //Gmail転送
    $to      = $headers['X-Forwarded-To'];
}else if(isset($headers['X-Yahoo-Forwarded'])){ //Yahoomail転送
    $yahoo_to = split(' ',$headers['X-Yahoo-Forwarded']);
    $to       = $yahoo_to[3];
}else{
    $to      = $headers['To'];
}
*/
//受信者側メールアドレスを取得し、ユーザーIDを取得

//foreach($headers as $key=>$value){
  //$pat   = "/^itm\-[0-9]*@itm-asp.com$/";
  $pat = "/pictmail\-\d+@itm-asp.com/";
  if(preg_match($pat,$source,$reg)){
    $to_arr[] = $reg[0];
  }
//}

$num = count($to_arr);
foreach($to_arr as $key=>$value){
  $text .= $key."=>".$value."\n";
}
if($num==0){

  mb_language("Ja") ;
  //mb_internal_encoding("EUC-JP") ;
  $mailto="niki@itm.ne.jp";
  $subject= "空メールエラー";
  $content= "ヘッダー=".$text."空メールでpictmail-xxxxxx@itm-asp.comに該当しなかった";
  $mailfrom="From:".$headers['From'];
  mb_send_mail($mailto,$subject,$content,$mailfrom);
  exit;

}

$out_cnt = 0;
if($num>1){
  while($num>$out_cnt){
    $in_cnt = 0;
    while($num>$in_cnt){
      if($out_cnt!=in_cnt){
        if($to_arr[$out_cnt]!=$to_arr[$in_cnt]){
          mb_language("Ja") ;
          //mb_internal_encoding("EUC-JP") ;
          $mailto="niki@itm.ne.jp";
          $subject= "空メールエラー";
          $content= "ヘッダー=".$text."空メールのヘッダーでpictmail-xxxxxx@itm-asp.comのメールアドレス２つ以上あった";
          $mailfrom="From:".$headers['From'];
          mb_send_mail($mailto,$subject,$content,$mailfrom);
          exit;
        }
      }
      $in_cnt++;
    }
    $out_cnt++;
  }
}


$to = $to_arr[0];
$str     = split('-',$to);
$str2    = split("@",$str[1]);
$user_id = $str2[0];
foreach($headers as $key=>$value){
  $text .= $key."=".$value."\n";
}
/*
  mb_language("Ja") ;
  //mb_internal_encoding("EUC-JP") ;
  $mailto="niki@itm.ne.jp";
  $subject= "OK";
  $content= $to."OK";
  $mailfrom="From:".$headers['From'];
  mb_send_mail($mailto,$subject,$content,$mailfrom);
  exit;
*/
//$user_id = 3391;

if(is_numeric($user_id)===false){
	echo "不正なアドレス";
	exit;
}


//PCのアドレス＆ソフトバンク対策(受け取った時のアドレスが<xxxx@q.vodafone.ne.jp>になるため)
if(ereg("<|>",$from)){
  $sfrom = split("<",$from);
  $from = ereg_replace(">","",$sfrom[1]);
}


//DBへ値を保存
$sql->setMobailMailAdd($from,$user_id);


//受信側アドレス
$recipients = $from;

//$recipients = 'niki@itm.ne.jp';
//$recipients = 'monkichiro-1120@docomo.ne.jp';

	//DBよりサンキューメールの設定データ取得
	$sql_data = $sql->getMailData($user_id);

	if($sql_data!=""){

		//サンキューメール送信の使用確認 使用=1 不使用=0
		$sendmail_flag = $sql_data['sendmail_flag'];
		if($sendmail_flag=="1"){
	
			//DBから受けたデータをそれぞれ変数に格納
			$transmit_name    = $sql_data['transmit_name'];
			$transmit_mailadd = $sql_data['transmit_mailadd'];
			$return_err       = $sql_data['return_err'];
			$subject          = $sql_data['subject'];
			$text_mess        = $sql_data['text_mess'];
			
			//テキストメッセージのユーザータグ、改行を置換
			$text_mess        = str_replace("%name%","",$text_mess);
			$text_mess        = str_replace("%name_family%","",$text_mess);
			$text_mess        = str_replace("%name_first%","",$text_mess);
			$text_mess        = str_replace("%name_family%","",$text_mess);
			$text_mess        = str_replace("%email%",$recipients,$text_mess);
			$text_mess        = ereg_replace("\n","",$text_mess);
			
			
			while($j<=5){
				$text_mess        = str_replace("%param".$j."%","",$text_mess);
				$j++;
			}
			
		//ＰＣフラグ
		$pc_flag = 1;
		
		//携帯メッセージ、フラグの取得
		$mobail_mess = $sql_data['mobail_mess'];
    
		//携帯メッセージ、フラグの取得
		$mobail_mess        = str_replace("%name%","",$mobail_mess);
		$mobail_mess        = str_replace("%name_family%","",$mobail_mess);
		$mobail_mess        = str_replace("%name_first%","",$mobail_mess);
		$mobail_mess        = str_replace("%name_family%","",$mobail_mess);
		$mobail_mess        = str_replace("%email%",$recipients,$mobail_mess);
		//$mobail_mess        = ereg_replace("\n","",$mobail_mess);

		$k = 1;
    $paramAmount = 5;
		while($k<=$paramAmount){
			$mobail_mess        = str_replace("%param".$k."%","",$mobail_mess);
			$k++;
		}
		$text_mess   = mb_convert_kana($text_mess,"K");
		$mobail_mess = mb_convert_kana($mobail_mess,"K");
		$mobail_flag = $sql_data['mobail_flag'];

		//メルアドがdocomoかどうかチェック、携帯メッセージを使うかどうかをチェック
	    if(ereg( "^@docomo.ne.jp",substr($recipients,-13) )){
			if($mobail_flag=="2"){
				$text_mess = $mobail_mess;
			}
			$pc_flag = 0;
		}
		//メルアドがvodafoneかどうかチェックして、携帯メッセージを使うかどうかをチェック
		if(ereg( "^@[dqnchtrks]{1}.vodafone.ne.jp",substr($recipients,-17) )){
			if($mobail_flag=="2"){
				$text_mess = $mobail_mess;
			}
			$pc_flag = 0;
		}
		//メルアドがezwebかどうかチェックして、携帯メッセージを使うかどうかをチェック
		if(ereg( "^ezweb.ne.jp",substr($from,-11) )){
			if($mobail_flag=="2"){
				$text_mess = $mobail_mess;
				$pc_flag = 0;
			}
			$pc_flag = 0;
		}
		//メルアドがsoftbankかどうかチェックして、携帯メッセージを使うかどうかをチェック
		if( ereg( "^@[dqnchtrks]{1}.softbank.ne.jp",substr($from,-17) )){
			if($mobail_flag=="2"){
				$text_mess = $mobail_mess;
			}
			$pc_flag = 0;
		}
/*
		//htmlメッセージ送信の使用確認　使用=1 不使用=0;
		$html_flag        = $sql_data['html_flag'];

			if(($pc_flag=="1")&&($html_flag=="1")){
				$html_mess    = $sql_data['html_mess'];
				$html_mess = ereg_replace("\n","",$html_mess);
			
				//HTMLメール送信
				$myMail->htmlMail($from,$user_mail_add,$subject,$text_mess,$html_mess);
		
			}else{
		
		
			//通常のメール配信
			$from = "From:".$from;
			mb_send_mail($user_mail_add,$subject,$text_mess,$from);
			}
*/
		}
	}else{
    mb_language("Ja") ;
    //mb_internal_encoding("EUC-JP") ;
    $mailto="niki@itm.ne.jp";
    $subject= "ＩＤエラー";
    $content= "ヘッダー=".$text."ＩＤエラー";
    $mailfrom="From:".$headers['From'];
    mb_send_mail($mailto,$subject,$content,$mailfrom);
    exit;
  }

$body = $text_mess;
/*

//本文作成
$body = <<<EOS
$from のメールアドレスで登録致しました。

ご利用ありがとうございました。
EOS;

//文字コードをエンコーディング
$body = mb_convert_encoding($body, "ISO-2022-JP", "auto");

//インスタンス生成
$mimeObject = new Mail_Mime("\n");

//text部分をセット
$mimeObject -> setTxtBody($body);

//文字コードを設定
$bodyParam = array(
  "head_charset" => "ISO-2022-JP",
  "text_charset" => "ISO-2022-JP"
);

//エンコードされた文字列を取得
$body = $mimeObject -> get($bodyParam);

//ヘッダー生成
$addHeaders = array(
  "To" => $recipients,
  "From" => $transmit_mailadd,
  "Subject" => mb_encode_mimeheader($subject),
  "f" => $return_err
);

//ヘッダー生成
$mastar_addHeaders = array(
  "To" => $transmit_mailadd,
  "From" => $to,
  "Subject" => mb_encode_mimeheader($subject),
  "Return-Path" => $return_err
);

//ヘッダーをエンコーディング
$header = $mimeObject -> headers($addHeaders);

//SMTPサーバ設定
$mail_options = array(
	'host'      => 'www.itm-asp.com',//ホスト名
	'port'      => '25'                   //ポート番号
//	'auth'      => false,               //認証設定
//	'username'  => '',	　            //ユーザー名
//	'password'  => '',		        //パスワード
//	'localhost' => 'localhost',    //HELO
);

//Mailインスタンス生成
$mail_object =& Mail::factory("sendmail",$mail_options);

//メール送信 受信者
$res = $mail_object->send($recipients,$header,$body);

//メール送信 管理者
//$res = $mail_object->send($transmit_mailadd,$header,$body);

if(PEAR::isError($res)) {
  die("エラーメッセージ：".$res->getMessage());
  exit;
}
*/
require_once("MyMail.class.php");
$myMail = new MyMail();
$myMail->normalMb_send_mail($transmit_mailadd,$recipients,$subject,$body,$return_err);
//終了
exit;