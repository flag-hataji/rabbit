<?PHP

class Tester extends Html {

  var $modeS       = "";
  var $defaultS    = "";
  var $inputS      = "";
  var $writeS      = "";
  var $errorS      = "";

  function Tester($Manager=False){
    $this->Manager = $Manager;
    require_once( _DIR_LIB_."ex/ViewerLib.php" );
    require_once( _DIR_LIB_."ex/Library.php" );
    $this->ViewerLib = new ViewerLib();
    $this->Library   = new Library();

    require_once(_DIR_LIB_."mail/Mail.php");
    $Mail = new Mail();

    $mail_from = mb_encode_mimeheader( "{$Manager->inputS['name_from']}" )."<{$Manager->inputS['mail_from']}>";



    if( isset($_POST['post']['test1']) ){
      $Mail->normalMb_send_mail($mail_from, $Manager->inputS['mail_test'], $Manager->inputS['subject'], $Manager->inputS['message'],$Manager->inputS['mail_error'] );
    }else if( isset($_POST['post']['test2']) ){
      $Mail->htmlMail($mail_from, $Manager->inputS['mail_test'], $Manager->inputS['subject'], $Manager->inputS['message'], $Manager->inputS['message_html'],"","",$Manager->inputS['mail_error'] );
    }

  }


  // メール送信：ユーザー
  function sendMail($subject=False,$message=False){

    require_once(_DIR_LIB_."mail/Mail.php");
    $Mail = new Mail();

//    $Mail->normalMb_send_mail('info@itm-asp.com', $this->valS['mail_confirm'], $subject, $message );

    return;
  }


}
?>
