<?PHP
class Mailer{

  function Mailer(){

  }

  // メール送信：完了
  function sendMailFinish($isMainS=""){

    require_once(_DIR_LIB_."util/Browse.php");
    $Browse = new Browse();

    if( date('d')<=10 ){
      $year  = date('Y');
      $month = date('m');
    }else{
      if( date('m')==12 ){
        $year  = date('Y')+1;
        $month = 1;
      }else{
        $year  = date('Y');
        $month = sprintf("%02d",date('m')+1);
      }
    }
    $time = strtotime( "{$year}-{$month}-01" );
    $day_service_end = date( "Y年m月", mktime(0,0,0,date("m",$time)+5,date("d",$time),date("Y",$time)) );
    $day_limit = date("Y/m/d", strtotime("15 day"));
    $day_now = date("Y/m/d");


    $dataS['price_month6'] = sprintf('%18s',floor($isMainS->planS['price_month6']*1.05));
    $dataS['price_first']  = sprintf('%18s',floor($isMainS->planS['price_first']*1.05));
    $dataS['price_total']  = sprintf('%18s',$isMainS->planS['price_total']);

    $dataS['price_month6'] = number_format($dataS['price_month6']);
    $dataS['price_first']  = number_format($dataS['price_first']);
    $dataS['price_total_base']  = str_replace(" ","",$dataS['price_total']);
    $dataS['price_total']  = number_format($dataS['price_total']);


    $toUser   = mb_encode_mimeheader( $_SESSION['user']['name_family'].$_SESSION['user']['name_first']."様" )."<{$_SESSION['user']['mail']}>";
    $fromUser = "info@itm-asp.com";

    $subjectUser    = "[itm-asp]プラン変更の申請を承りました";
    if($_SESSION['user']['plan_pictmail_id']==1 || $_SESSION['user']['plan_pictmail_id']==7){
      $messageUserBase  = file_get_contents(_PG_ROOT_MAIL_._PG_FILE_MAIL_USER_NEW1_);
    }else{
      $messageUserBase  = file_get_contents(_PG_ROOT_MAIL_._PG_FILE_MAIL_USER_RENEW_);
    }

    $messageUser = $messageUserBase;
    $messageUser = str_replace("#name#",$_SESSION['user']['name_family'].$_SESSION['user']['name_first'],$messageUser);
    if($_SESSION['user']['name_company']!=""){
      $messageUser = str_replace("#name_company#",$_SESSION['user']['name_company'],$messageUser);
    }else{
      $messageUser = str_replace("#name_company#",$_SESSION['user']['name_family'].$_SESSION['user']['name_first'],$messageUser);
    }
    $messageUser = str_replace("#plan#",           $isMainS->planS['plan'],$messageUser);
    $messageUser = str_replace("#auto_money#",     $isMainS->viewS['flag_automoney'],$messageUser);
    $messageUser = str_replace("#pay#",            $isMainS->viewS['flag_pay'],$messageUser);
    $messageUser = str_replace("#price_month#",    $dataS['price_month'],$messageUser);
    $messageUser = str_replace("#price_month6#",   $dataS['price_month6'],$messageUser);
    $messageUser = str_replace("#price_first#",    $dataS['price_first'],$messageUser);
    $messageUser = str_replace("#price_total_base#",$dataS['price_total_base'],$messageUser);
    $messageUser = str_replace("#price_total#",    $dataS['price_total'],$messageUser);
    $messageUser = str_replace("#day_service_end#",$day_service_end,$messageUser);
    $messageUser = str_replace("#day_limit#",      $day_limit,$messageUser);
    $messageUser = str_replace("#day_now#",        $day_now,$messageUser);
    $messageUser = str_replace("#user_id#",        $_SESSION['user']['user_id'],$messageUser);

    $this->sendMailUser($toUser,$fromUser,$subjectUser,$messageUser);



    $subjectMaster  = "[itm-asp]プラン変更の申請がありました";
    $messageMasterBase  = file_get_contents(_PG_ROOT_MAIL_._PG_FILE_MAIL_MASTER_NEW_);
    $messageMaster  = $messageMasterBase;
    $messageMaster = str_replace("#name#",$_SESSION['user']['name_family'].$_SESSION['user']['name_first'],$messageMaster);
    $messageMaster = str_replace("#mail#",$_SESSION['user']['mail'],$messageMaster);
    if($_SESSION['user']['name_company']!=""){
      $messageMaster = str_replace("#name_company#",$_SESSION['user']['name_company'],$messageMaster);
    }else{
      $messageMaster = str_replace("#name_company#",$_SESSION['user']['name_family'].$_SESSION['user']['name_first'],$messageMaster);
    }
    $messageMaster = str_replace("#plan#",           $isMainS->planS['plan'],$messageMaster);
    $messageMaster = str_replace("#auto_money#",     $isMainS->viewS['flag_automoney'],$messageMaster);
    $messageMaster = str_replace("#pay#",            $isMainS->viewS['flag_pay'],$messageMaster);
    $messageMaster = str_replace("#price_month#",    $dataS['price_month'],$messageMaster);
    $messageMaster = str_replace("#price_month6#",   $dataS['price_month6'],$messageMaster);
    $messageMaster = str_replace("#price_first#",    $dataS['price_first'],$messageMaster);
    $messageMaster = str_replace("#price_total#",    $dataS['price_total'],$messageMaster);
    $messageMaster = str_replace("#day_service_end#",$day_service_end,$messageMaster);
    $messageMaster = str_replace("#day_limit#",      $day_limit,$messageMaster);
    $messageMaster = str_replace("#day_now#",        $day_now,$messageMaster);
    $messageMaster = str_replace("#user_id#",        $_SESSION['user']['user_id'],$messageMaster);
    $messageMaster  = str_replace("#ip#",$Browse->remote_address,$messageMaster);
    $messageMaster  = str_replace("#host#",$Browse->remote_host,$messageMaster);
    $messageMaster .= $messageUser;

    $this->sendMailMaster($_SESSION['user']['mail'],$subjectMaster,$messageMaster);

    return;
  }

  // メール送信：管理者
  function sendMailMaster($from=False,$subject=False,$message=False){
    require_once(_DIR_LIB_."mail/Mail.php");
    $from = 'info@itm-asp.com';
    $to   = 'info@itm-asp.com,masaki@itm.ne.jp';
    //$to   = 'masaki@itm.ne.jp';
    $Mail = new Mail();
    $Mail->normalMb_send_mail($from, $to, $subject, $message );
    return;
  }

  // メール送信：ユーザー
  function sendMailUser($to=False,$from=False,$subject=False,$message=False){
    require_once(_DIR_LIB_."mail/Mail.php");
    $Mail = new Mail();
    $Mail->normalMb_send_mail($from, $to, $subject, $message, 'info@itm-asp.com,hataji@itm.ne.jp,masaki@itm.ne.jp');
    return;
  }


}

?>
