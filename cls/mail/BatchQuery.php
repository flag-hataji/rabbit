#!/usr/local/bin/php -q
<?PHP
/*
  mailq登録
*/

  define("_TEST_", False );
  define("_DEBUG_",False );

  define("_ROOT_", "/var/www/vhosts/rabbit-mail.jp/html/");
//  define("_ROOT_", "/var/www/vhosts/test.itm-asp.com/html/");
//  define("_ROOT_", "/usr/local/apache/htdocs/");
//  define("_ROOT_", "/usr/local/apache/htdocs/mail_send/");


  define('_ROOT_COMMON_',       _ROOT_.'common/' );
  define('_ROOT_COMMON_EXP_',   _ROOT_COMMON_.'exp/' );

  define('_ROOT_LIB_',           _ROOT_.'lib/' );
  define('_ROOT_LIB_EXCEPTION_', _ROOT_LIB_.'exception/' );

  define('_ROOT_CLS_',          _ROOT_.'cls/' );
  define('_ROOT_CLS_MAIL_',     _ROOT_CLS_.'mail/' );


  define('_ROOT_PG_',     _ROOT_CLS_MAIL_);
  define('_ROOT_PG_DAT_', _ROOT_."dat/mail/");

  define("_MAIL_MASTER_", "info@itm-asp.com");
  //define("_MAIL_MASTER_", "masaki@itm.ne.jp");

  require_once _ROOT_LIB_."Postgres.php";
  require_once _ROOT_LIB_."Mail.php";
  $utilPostgres = new Postgres();
  $utilMail     = new Mail();

/*TEST*/  //$utilMail->normalMb_send_mail( _MAIL_MASTER_, _MAIL_MASTER_,  "001", "clear", False,   False, _MAIL_MASTER_);


  require_once _ROOT_COMMON_EXP_."ExpPostgres.php";
  $expPostgres = new ExpPostgres();

  require_once _ROOT_PG_."FileUp.php";
  $pFileUp   = new FileUp('','',_DEBUG_);

/*TEST*/ // $utilMail->normalMb_send_mail( _MAIL_MASTER_, _MAIL_MASTER_,  "002", "clear", False,   False, _MAIL_MASTER_);


  if(
    !isset($_SERVER['argv'][1]) || 
    !isset($_SERVER['argv'][2]) || 
    !isset($_SERVER['argv'][3]) || 
    !isset($_SERVER['argv'][4]) || 
    !isset($_SERVER['argv'][5]) || 
    !isset($_SERVER['argv'][6]) || 
    !isset($_SERVER['argv'][7]) || 
    !isset($_SERVER['argv'][8]) || 
    !isset($_SERVER['argv'][9]) 
  ){
    echo "Not argv \n\n";
    $utilMail->normalMb_send_mail( _MAIL_MASTER_, _MAIL_MASTER_,  "Not argv", "Error", False,   False, _MAIL_MASTER_);
    exit;
  }

/*TEST*/ // $utilMail->normalMb_send_mail( _MAIL_MASTER_, _MAIL_MASTER_,  "003", "clear", False,   False, _MAIL_MASTER_);


  /*
    $_SERVER['argv']

    1 = 送信リストファイル
    2 = 送信者名
    3 = 送信者アドレス
    4 = エラーメール送信先アドレス
    5 = 件名
    6 = 本文
    7 = クエリー
  */
  $file_mail = urldecode($_SERVER['argv'][1]);
  $file_mail = unserialize($file_mail) ;

  $name_from = urldecode($_SERVER['argv'][2]);
  $name_from = unserialize($name_from) ;

  $mail_from = urldecode($_SERVER['argv'][3]);
  $mail_from = unserialize($mail_from) ;

  $mail_error = urldecode($_SERVER['argv'][4]);
  $mail_error = unserialize($mail_error) ;

  $subject = urldecode($_SERVER['argv'][5]);
  $subject = unserialize($subject) ;

  $message = urldecode($_SERVER['argv'][6]);
  $message = unserialize($message) ;

  $query['td_log'] = urldecode($_SERVER['argv'][7]);
  $query['td_log'] = unserialize($query['td_log']) ;

  $query['td_message'] = urldecode($_SERVER['argv'][8]);
  $query['td_message'] = unserialize($query['td_message']) ;

  $query['td_mailq'] = urldecode($_SERVER['argv'][9]);
  $query['td_mailq'] = unserialize($query['td_mailq']) ;

  $query['td_pictmail'] = urldecode($_SERVER['argv'][10]);
  $query['td_pictmail'] = unserialize($query['td_pictmail']) ;


$hogehoge .= $query['td_log']."\n\n";
$hogehoge .= $query['td_message']."\n\n";
$hogehoge .= $query['td_mailq']."\n\n";
/*TEST*/ // $utilMail->normalMb_send_mail( _MAIL_MASTER_, _MAIL_MASTER_,  "004", $hogehoge, False,   False, _MAIL_MASTER_);

  $filePath = _ROOT_PG_DAT_.$file_mail;

  if( !file_exists($filePath) ){
    echo "Not filePath \n\n";
    $utilMail->normalMb_send_mail( _MAIL_MASTER_, _MAIL_MASTER_,  "Not filePath", "Error\n{$filePath}\n{$query}", False,   False, _MAIL_MASTER_);
    exit;
  }

  mb_language("Japanese") ;
  mb_internal_encoding("EUC-JP") ;

  $mail_from = mb_encode_mimeheader( "{$name_from}" )."<".$mail_from.">";

  $td_mailq = "START\n\n";
  $fp = fopen($filePath,'r') ;

/*TEST*/ // $utilMail->normalMb_send_mail( _MAIL_MASTER_, _MAIL_MASTER_,  "005", $filePath, False,   False, _MAIL_MASTER_);
  $flagMobile=False;
  $mC=0;
  while( !feof($fp) ){

    $mailq_query = "";

    $oneData = fgets($fp);
    $oneData = str_replace("\r", "", $oneData);
    $oneData = str_replace("\n", "", $oneData);
//    $oneData = htmlspecialchars($oneData);

    $explodeS = explode(",",$oneData);

    $name = $explodeS[0];
    $mail = $explodeS[1];
    $parameter1 = $explodeS[2];
    $parameter2 = $explodeS[3];
    $parameter3 = $explodeS[4];
    $parameter4 = $explodeS[5];
    $parameter5 = $explodeS[6];

    if( $mail!="" ){

      if($name==""){
        $name="　";
      }

      $mailq_query = $query['td_mailq'];

      $mailq_query = str_replace("EMAIL_NAME",$name,$mailq_query);
      $mailq_query = str_replace("EMAIL",$mail,$mailq_query);
      $mailq_query = str_replace("PARAMETER1",$parameter1,$mailq_query);
      $mailq_query = str_replace("PARAMETER2",$parameter2,$mailq_query);
      $mailq_query = str_replace("PARAMETER3",$parameter3,$mailq_query);
      $mailq_query = str_replace("PARAMETER4",$parameter4,$mailq_query);
      $mailq_query = str_replace("PARAMETER5",$parameter5,$mailq_query);
      if( ereg( "^docomo.ne.jp",substr($mail,-12) ) || 
          ereg( "^vodafone.ne.jp",substr($mail,-14) ) || 
          ereg( "^ezweb.ne.jp",substr($mail,-11) ) ){
        $mailq_query = str_replace("FLAG_PC",'f',$mailq_query);
        $flagMobile=True;
      }else{
        if($flagMobile && strstr( $mailq_query, "_#MASTER#_")){
          $mailq_query = str_replace("FLAG_PC",'f',$mailq_query);
        }else{
          $mailq_query = str_replace("FLAG_PC",'t',$mailq_query);
        }
        $mailq_query = str_replace("_#MASTER#_","",$mailq_query);
      }
      $registCheck0 = $expPostgres->registQuery( $mailq_query );
      if(!$registCheck0){
        $utilMail->normalMb_send_mail( "masaki@itm.ne.jp", "masaki@itm.ne.jp",  "ERROR td_mailq", "td_mailq_Error-{$mailq_query}", False,   False, _MAIL_MASTER_);
        $utilMail->normalMb_send_mail( "hataji@itm.ne.jp", "hataji@itm.ne.jp",  "ERROR td_mailq", "td_mailq_Error-{$mailq_query}", False,   False, _MAIL_MASTER_);
      }
      unset($mailq_query);
      //usleep(1);
      $mC++;
    }
  }
  unset($mailq_query);
  $mC=($mC-1);

  $query['td_pictmail'] = str_replace("SEND_NUM",$mC,$query['td_pictmail']);

  $registCheck1 = $expPostgres->registQuery( $query['td_log'] );
  $registCheck2 = $expPostgres->registQuery( $query['td_message'] );
  $registCheck3 = $expPostgres->registQuery( $query['td_pictmail'] );

/*TEST*/  
//$utilMail->normalMb_send_mail( _MAIL_MASTER_, _MAIL_MASTER_,  "006", $hogehoge, False,   False, _MAIL_MASTER_);

/*TEST*/  
if(!$registCheck1){
  $utilMail->normalMb_send_mail( "masaki@itm.ne.jp", "masaki@itm.ne.jp",  "ERROR td_log", "td_log -{$query['td_log']}", False,   False, _MAIL_MASTER_);
  $utilMail->normalMb_send_mail( "hataji@itm.ne.jp", "hataji@itm.ne.jp",  "ERROR td_log", "td_log -{$query['td_log']}", False,   False, _MAIL_MASTER_);
}

/*TEST*/
if(!$registCheck2){
  $utilMail->normalMb_send_mail( "masaki@itm.ne.jp", "masaki@itm.ne.jp",  "ERROR td_message", "td_message -{$query['td_message']}", False,   False, _MAIL_MASTER_);
  $utilMail->normalMb_send_mail( "hataji@itm.ne.jp", "hataji@itm.ne.jp",  "ERROR td_message", "td_message -{$query['td_message']}", False,   False, _MAIL_MASTER_);
}

/*TEST*/
if(!$registCheck3){
  $utilMail->normalMb_send_mail( "masaki@itm.ne.jp", "masaki@itm.ne.jp",  "ERROR td_pictmail", "td_pictmail -{$query['td_pictmail']}", False,   False, _MAIL_MASTER_);
  $utilMail->normalMb_send_mail( "hataji@itm.ne.jp", "hataji@itm.ne.jp",  "ERROR td_pictmail", "td_pictmail -{$query['td_pictmail']}", False,   False, _MAIL_MASTER_);
}
/*TEST*/
$utilMail->normalMb_send_mail( "masaki@itm.ne.jp", "masaki@itm.ne.jp",  "ASP", "送信したメールの数：{$mC}\n送信リストファイル{$filePath}\n送信したメッセージ{$query['td_message']}", False,   False, _MAIL_MASTER_);
$utilMail->normalMb_send_mail( "hataji@itm.ne.jp", "hataji@itm.ne.jp",  "ASP", "送信したメールの数：{$mC}\n送信リストファイル{$filePath}\n送信したメッセージ{$query['td_message']}", False,   False, _MAIL_MASTER_);

  if( $mail_from ){

    $suject = "[itm-asp]メール配信のご予約を承りました";

    $thanks = "itmメールサービスご利用ありがとうございます。\n";
    $thanks .= "\n";
    $thanks .= "送信の予約を承りました。  \n";
    $thanks .= "メールはご予約のお時間に送信し始めますが、\n";
    $thanks .= "サーバーの状況によっては多少メール配信が送れる場合がございます。\n";
    $thanks .= "何卒ご了承いただくようお願い申し上げます。\n";
    $thanks .= "\n";
    $thanks .= "なお、ご不明な点、ご質問等ございましたら\n";
    $thanks .= "092-525-0081までご連絡くださいませ。\n";
    $thanks .= "\n";
    $thanks .= "携帯メールアドレスの配信は9：00〜20:55になります。\n";
    $thanks .= "全てのメール配信終了後、ご登録いただいておりますメールアドレス宛まで\n";
    $thanks .= "配信したメールと同内容のメールをお送りいたします。\n";

    $utilMail->normalMb_send_mail( _MAIL_MASTER_, $mail_from, $suject, $thanks, False,   False, _MAIL_MASTER_);
  }

  //$expPostgres->registQuery( $query );

  flock($fp, LOCK_UN);
  fclose($fp);

  chmod ($filePath, 0777); 
  if( !unlink($filePath) ){
    $utilMail->normalMb_send_mail( "masaki@itm.ne.jp", "masaki@itm.ne.jp",  "ERROR UNLINK", "UNLINK -{$filePath}", False,   False, _MAIL_MASTER_);
  }else{
    $utilMail->normalMb_send_mail( "masaki@itm.ne.jp", "masaki@itm.ne.jp",  "UNLINK OK", "UNLINK -{$filePath}", False,   False, _MAIL_MASTER_);
  }

  exit;
?>
