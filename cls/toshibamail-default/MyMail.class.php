<?PHP
/********************************************
	メールを送信するためのクラスファイル
********************************************/

class MyMail
{

  function Mail(){
    if( !extension_loaded('mbstring') ){
      die("mbstring not loaded . you add extension mbstring module");
    }

    mb_language("Japanese") ;
    mb_internal_encoding("EUC-JP") ;

  }


  /**
  * エンコード
  */
  function encode( $from,$to,$subject,$message ){

    $message = mb_convert_encoding( $message,"JIS" ) ;

    // mb_encode_mimeheader がバグ持ちのため
    
    $from    = mb_convert_encoding($from ,"ISO-2022-JP","EUC-JP");
    $from    = "=?iso-2022-jp?B?" . base64_encode($from) . "?=";
    
    $to      = mb_convert_encoding($to ,"ISO-2022-JP","EUC-JP");
    $to      = "=?iso-2022-jp?B?" . base64_encode($to) . "?=";

    $subject = mb_convert_encoding($subject ,"ISO-2022-JP","EUC-JP");
    $subject = "=?iso-2022-jp?B?" . base64_encode($subject) . "?=";

    return array($from,$to,$subject,$message) ;
  }


  /*
   * メール送信
   */
  function normalMail($from=False,  $to=False, $subject=False, $message=False, 
                      $error=False ,$cc=False, $bcc=False,     $reply=False){

    // エンコード
    list($from,$to,$subject,$message) = $this->encode( $from,$to,$subject,$message );

    // メールヘッダ
    $header  = "MIME-Version: 1.0\n";
    $header .= "Content-Type: text/plain; charset=iso-2022-jp\n";
    $header .= "Content-Transfer-Encoding: 7bit\n";
    $header .= "From: {$from}\n";
    if( $reply != "" ) $header .= "Reply-To: {$reply}\n";
    if( $cc    != "" ) $header .= "Cc: {$cc}\n";
    if( $bcc   != "" ) $header .= "Bcc: {$bcc}\n";
    if( $error != "" ) $header .= "Error-To: {$error}\n";

    mail( $to, $subject, $message, $header ) ;

    return ;
  }


  /*
   * メール送信(mb_send_mail)
   */
  function normalMb_send_mail($from=False,  $to=False, $subject=False, $message=False, 
                              $error=False, $cc=False, $bcc=False,     $reply=False){

    $header = "From: {$from}\n";
    if( $reply!="" ){
      $header .= "Reply-To: {$reply}\n";
    } else {
      $header .= "Reply-To: {$from}\n";
    }
    if( $cc!="" ){
     $header .= "Cc: {$cc}\n";
    }
    if( $bcc!="" ){
      $header .= "Bcc: {$bcc}\n";
    }
	
    $error_to="";
    if( $error!="" ){
//      $header .= "Error-To: {$error}\n";
      $error_to = "-f {$error}";
    }

//    mb_send_mail( $to, $subject, $message, $header ) ;
    return mb_send_mail( $to, $subject, $message, $header, $error_to ) ;

  }


  /**
  * @return bool
  * @param
  * @desc HTMLメールの送信
  */
  function htmlMail($from=False, $to=False,  $subject=False, $message=False, $htmlMessage=False,
					$error=False,$cc=False,  $bcc=False,  $reply=False){

    // 区切り文字
    $boundary = uniqid("b");

    // メールヘッダ
    $header  = "MIME-Version: 1.0\n";
    $header .= "Content-Type: multipart/alternative; boundary=\"{$boundary}\"\n";
    $header .= "From: {$from}\n";
    
    if( $reply!="" ){
      $header .= "Reply-To: {$reply}\n";
    } else {
      $header .= "Reply-To: {$from}\n";
    }
    if( $cc!="" ){
     $header .= "Cc: {$cc}\n";
    }
    if( $bcc!="" ){
      $header .= "Bcc: {$bcc}\n";
    }
    
    $error_to="";
    if( $error!="" ){
      $error_to = "-f {$error}";
    }

    // 本文の作成
    $subject = "=?iso-2022-jp?B?" . base64_encode( mb_convert_encoding($subject, "JIS") ) . "?=";
    
    // TEXT本文
    $textBody  = "--{$boundary}\n";
    $textBody .= "Content-Type: text/plain; charset=\"ISO-2022-JP\"\n";
    $textBody .= "Content-Transfer-Encoding: 7bit\n";
    $textBody .= "\n";
    $textBody .= mb_convert_encoding($message, "JIS","EUC-JP")."\n";

    // HTML本文
    $htmlBody  = "\n\n--{$boundary}\n";
    $htmlBody .= "Content-Type: text/html; charset=\"ISO-2022-JP\"\n";
    $htmlBody .= "Content-Transfer-Encoding: 7bit\n";
    $htmlBody .= "\n";
    $htmlBody .= mb_convert_encoding($htmlMessage, "JIS","EUC-JP")."\n";
    $htmlBody .= "--{$boundary}--\n";
    
    $body = $textBody.$htmlBody;
    
    return mail($to, $subject, $body, $header, $error_to);

  }

}

?>
