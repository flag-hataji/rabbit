<?php

//PEAR�饤�֥���mimeDecode���ɤ߹���
require_once("/usr/local/share/pear/Mail/mimeDecode.php");
require_once("/usr/local/share/pear/Mail/mime.php");
require_once("/usr/local/share/pear/Mail.php");
require_once("SqlData.php");
//SqlData���饹�Υ��󥹥�������
$sql = new SqlData();

//mail��ʸ�������
$source = file_get_contents("php://stdin");

//$source = file_get_contents("/usr/local/vpopmail/domains/itm-asp.com/info/Maildir/new/test");
$source = file_get_contents("test2.txt");
if($source===false){
    echo "�ɤ߹��ߥ��顼";
}
//mimeDecode�Υ��󥹥�������

$decoder = new Mail_mimeDecode($source); // MIMEʬ��
$parts = $decoder->getSendArray();  // ���줾��Υѡ��Ĥ��Ǽ
list($recipients,$headers,$body) = $parts; // �ƥѡ��Ĥ�����˳�Ǽ
/*
  foreach($headers as $key=>$value){
    $text .= $key."=>".$value."\n";
  }
  mb_language("Ja") ;
  //mb_internal_encoding("EUC-JP") ;
  $mailto="niki@itm.ne.jp";
  $subject= "���᡼�륨�顼";
  $content= "�إå���=".$text."���᡼���pictmail-xxxxxx@itm-asp.com�˳������ʤ��ä�";
  $mailfrom="From:".$headers['From'];
  mb_send_mail($mailto,$subject,$content,$mailfrom);
  exit;
*/


//����¦�᡼�륢�ɥ쥹�μ���
$from = $headers['From'];

/*
if(isset($headers['X-Forwarded-To'])){      //Gmailž��
    $to      = $headers['X-Forwarded-To'];
}else if(isset($headers['X-Yahoo-Forwarded'])){ //Yahoomailž��
    $yahoo_to = split(' ',$headers['X-Yahoo-Forwarded']);
    $to       = $yahoo_to[3];
}else{
    $to      = $headers['To'];
}
*/
//������¦�᡼�륢�ɥ쥹����������桼����ID�����

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
  $subject= "���᡼�륨�顼";
  $content= "�إå���=".$text."���᡼���pictmail-xxxxxx@itm-asp.com�˳������ʤ��ä�";
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
          $subject= "���᡼�륨�顼";
          $content= "�إå���=".$text."���᡼��Υإå�����pictmail-xxxxxx@itm-asp.com�Υ᡼�륢�ɥ쥹���İʾ夢�ä�";
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
	echo "�����ʥ��ɥ쥹";
	exit;
}


//PC�Υ��ɥ쥹�����եȥХ��к�(������ä����Υ��ɥ쥹��<xxxx@q.vodafone.ne.jp>�ˤʤ뤿��)
if(ereg("<|>",$from)){
  $sfrom = split("<",$from);
  $from = ereg_replace(">","",$sfrom[1]);
}


//DB���ͤ���¸
$sql->setMobailMailAdd($from,$user_id);


//����¦���ɥ쥹
$recipients = $from;

//$recipients = 'niki@itm.ne.jp';
//$recipients = 'monkichiro-1120@docomo.ne.jp';

	//DB��ꥵ�󥭥塼�᡼�������ǡ�������
	$sql_data = $sql->getMailData($user_id);

	if($sql_data!=""){

		//���󥭥塼�᡼�������λ��ѳ�ǧ ����=1 �Ի���=0
		$sendmail_flag = $sql_data['sendmail_flag'];
		if($sendmail_flag=="1"){
	
			//DB����������ǡ����򤽤줾���ѿ��˳�Ǽ
			$transmit_name    = $sql_data['transmit_name'];
			$transmit_mailadd = $sql_data['transmit_mailadd'];
			$return_err       = $sql_data['return_err'];
			$subject          = $sql_data['subject'];
			$text_mess        = $sql_data['text_mess'];
			
			//�ƥ����ȥ�å������Υ桼�������������Ԥ��ִ�
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
			
		//�Уåե饰
		$pc_flag = 1;
		
		//���ӥ�å��������ե饰�μ���
		$mobail_mess = $sql_data['mobail_mess'];
    
		//���ӥ�å��������ե饰�μ���
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

		//��륢�ɤ�docomo���ɤ��������å������ӥ�å�������Ȥ����ɤ���������å�
	    if(ereg( "^@docomo.ne.jp",substr($recipients,-13) )){
			if($mobail_flag=="2"){
				$text_mess = $mobail_mess;
			}
			$pc_flag = 0;
		}
		//��륢�ɤ�vodafone���ɤ��������å����ơ����ӥ�å�������Ȥ����ɤ���������å�
		if(ereg( "^@[dqnchtrks]{1}.vodafone.ne.jp",substr($recipients,-17) )){
			if($mobail_flag=="2"){
				$text_mess = $mobail_mess;
			}
			$pc_flag = 0;
		}
		//��륢�ɤ�ezweb���ɤ��������å����ơ����ӥ�å�������Ȥ����ɤ���������å�
		if(ereg( "^ezweb.ne.jp",substr($from,-11) )){
			if($mobail_flag=="2"){
				$text_mess = $mobail_mess;
				$pc_flag = 0;
			}
			$pc_flag = 0;
		}
		//��륢�ɤ�softbank���ɤ��������å����ơ����ӥ�å�������Ȥ����ɤ���������å�
		if( ereg( "^@[dqnchtrks]{1}.softbank.ne.jp",substr($from,-17) )){
			if($mobail_flag=="2"){
				$text_mess = $mobail_mess;
			}
			$pc_flag = 0;
		}
/*
		//html��å����������λ��ѳ�ǧ������=1 �Ի���=0;
		$html_flag        = $sql_data['html_flag'];

			if(($pc_flag=="1")&&($html_flag=="1")){
				$html_mess    = $sql_data['html_mess'];
				$html_mess = ereg_replace("\n","",$html_mess);
			
				//HTML�᡼������
				$myMail->htmlMail($from,$user_mail_add,$subject,$text_mess,$html_mess);
		
			}else{
		
		
			//�̾�Υ᡼���ۿ�
			$from = "From:".$from;
			mb_send_mail($user_mail_add,$subject,$text_mess,$from);
			}
*/
		}
	}else{
    mb_language("Ja") ;
    //mb_internal_encoding("EUC-JP") ;
    $mailto="niki@itm.ne.jp";
    $subject= "�ɣĥ��顼";
    $content= "�إå���=".$text."�ɣĥ��顼";
    $mailfrom="From:".$headers['From'];
    mb_send_mail($mailto,$subject,$content,$mailfrom);
    exit;
  }

$body = $text_mess;
/*

//��ʸ����
$body = <<<EOS
$from �Υ᡼�륢�ɥ쥹����Ͽ�פ��ޤ�����

�����Ѥ��꤬�Ȥ��������ޤ�����
EOS;

//ʸ�������ɤ򥨥󥳡��ǥ���
$body = mb_convert_encoding($body, "ISO-2022-JP", "auto");

//���󥹥�������
$mimeObject = new Mail_Mime("\n");

//text��ʬ�򥻥å�
$mimeObject -> setTxtBody($body);

//ʸ�������ɤ�����
$bodyParam = array(
  "head_charset" => "ISO-2022-JP",
  "text_charset" => "ISO-2022-JP"
);

//���󥳡��ɤ��줿ʸ��������
$body = $mimeObject -> get($bodyParam);

//�إå�������
$addHeaders = array(
  "To" => $recipients,
  "From" => $transmit_mailadd,
  "Subject" => mb_encode_mimeheader($subject),
  "f" => $return_err
);

//�إå�������
$mastar_addHeaders = array(
  "To" => $transmit_mailadd,
  "From" => $to,
  "Subject" => mb_encode_mimeheader($subject),
  "Return-Path" => $return_err
);

//�إå����򥨥󥳡��ǥ���
$header = $mimeObject -> headers($addHeaders);

//SMTP����������
$mail_options = array(
	'host'      => 'www.itm-asp.com',//�ۥ���̾
	'port'      => '25'                   //�ݡ����ֹ�
//	'auth'      => false,               //ǧ������
//	'username'  => '',	��            //�桼����̾
//	'password'  => '',		        //�ѥ����
//	'localhost' => 'localhost',    //HELO
);

//Mail���󥹥�������
$mail_object =& Mail::factory("sendmail",$mail_options);

//�᡼������ ������
$res = $mail_object->send($recipients,$header,$body);

//�᡼������ ������
//$res = $mail_object->send($transmit_mailadd,$header,$body);

if(PEAR::isError($res)) {
  die("���顼��å�������".$res->getMessage());
  exit;
}
*/
require_once("MyMail.class.php");
$myMail = new MyMail();
$myMail->normalMb_send_mail($transmit_mailadd,$recipients,$subject,$body,$return_err);
//��λ
exit;