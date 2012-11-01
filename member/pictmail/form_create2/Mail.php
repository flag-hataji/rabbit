<?PHP
/**
*  メールクラス
*
*  文字コード：EUC-JP
*
* @package /lib/org/
* @author  Kiyosue
* @since   PHP5
* @version 2006.12.01
*/
class Mail
{

  public function __construct(){
  
    if(! extension_loaded('mbstring')){
      throw new MyException("mbstring not loaded . you add extension mbstring module");
    }
  }

  public function setSendMail($from, $to, $subject, $message, $cc="",$bcc="",$error="" ,$reply="")
  {
    $header = "";

//    $header  = "MIME-Version: 1.0\r\n";
//    $header .= "Content-Type: text/plain; charset=iso-2022-jp\r\n";
//    $header .= "Content-Transfer-Encoding: 7bit\r\n";
    $header .= "From: {$from}\r\n";
    if( $reply!="" ){
      $header .= "Reply-To: {$reply}\r\n";
    } else {
      $header .= "Reply-To: {$from}\r\n";
    }
    if( $cc!="" ){
     $header .= "Cc: {$cc}\r\n";
    }
    if( $bcc!="" ){
      $header .= "Bcc: {$bcc}\r\n";
    }
    if( $error!="" ){
//      $header .= "Error-To: {$error}\r\n";
      $error_to = "-f {$error}";
    }

    mb_send_mail( $to, $subject, $message, $header, $error_to ) ;
  }

}

?>