<?PHP
class Mailer{

  function Mailer(){

  }

  // DB接続
  function dbConnect(){
    require_once(_DIR_LIB_."db/Postgres.php");
    require_once(_DIR_LIB_."db/ExPostgres.php");
    $ExPostgres = new ExPostgres(_DB_NAME_,_DB_USER_,_DB_HOST_,_DB_PORT_);
    return $ExPostgres;
  }


  // メール送信：完了
  function sendMailFinish($dataS=False,$nameS=False){

    $dataS['inquiry'] = str_replace("<br />\n","\n",$dataS['inquiry']);

    $subjectUser    = "[rabbit-mail]お問い合わせいただきありがとうございました";
    $messageUserBase  = file_get_contents(_PG_ROOT_MAIL_._PG_FILE_MAIL_USER_NEW_);
    $messageUser = $messageUserBase;
    $messageUser = str_replace("#inquiry_id#",$dataS['inquiry_id'],$messageUser);
    $messageUser = str_replace("#name#",$dataS['name'],$messageUser);
    $messageUser = str_replace("#kana#",$dataS['kana'],$messageUser);
    $messageUser = str_replace("#name_company#",$dataS['name_company'],$messageUser);
    $messageUser = str_replace("#kana_company#",$dataS['kana_company'],$messageUser);
    $messageUser = str_replace("#mail#",$dataS['mail'],$messageUser);
    $messageUser = str_replace("#tel#",$dataS['tel'],$messageUser);
    $messageUser = str_replace("#mobile#",$dataS['mobile'],$messageUser);
    $messageUser = str_replace("#fax#",$dataS['fax'],$messageUser);
    $messageUser = str_replace("#inquiry#",$dataS['inquiry'],$messageUser);

    $messageUser = str_replace("#n_inquiry_id#",$nameS['inquiry_id'],$messageUser);
    $messageUser = str_replace("#n_name#",$nameS['name'],$messageUser);
    $messageUser = str_replace("#n_kana#",$nameS['kana'],$messageUser);
    $messageUser = str_replace("#n_name_company#",$nameS['name_company'],$messageUser);
    $messageUser = str_replace("#n_kana_company#",$nameS['kana_company'],$messageUser);
    $messageUser = str_replace("#n_mail#",$nameS['mail'],$messageUser);
    $messageUser = str_replace("#n_tel#",$nameS['tel'],$messageUser);
    $messageUser = str_replace("#n_mobile#",$nameS['mobile'],$messageUser);
    $messageUser = str_replace("#n_fax#",$nameS['fax'],$messageUser);
    $messageUser = str_replace("#n_inquiry#",$nameS['inquiry'],$messageUser);

    $subjectMaster  = "[rabbit-mail]お問い合わせがありました";
    if(isset($_SESSION['user']['user_id'])){
      $subjectMaster .= " ユーザーID：{$_SESSION['user']['user_id']}";
    }
    $messageMasterBase  = file_get_contents(_PG_ROOT_MAIL_._PG_FILE_MAIL_MASTER_NEW_);
    $messageMaster = $messageMasterBase;
    $messageMaster = str_replace("#inquiry_id#",$dataS['inquiry_id'],$messageMaster);
    $messageMaster = str_replace("#user_id#",$dataS['user_id'],$messageMaster);
    $messageMaster = str_replace("#name#",$dataS['name'],$messageMaster);
    $messageMaster = str_replace("#kana#",$dataS['kana'],$messageMaster);
    $messageMaster = str_replace("#mail#",$dataS['mail'],$messageMaster);
    $messageMaster = str_replace("#ip#",$dataS['ip'],$messageMaster);
    $messageMaster = str_replace("#host#",$dataS['host'],$messageMaster);
    $messageMaster .= $messageUser;

    $toUser   = mb_encode_mimeheader( $dataS['name']."様" )."<{$dataS['mail']}>";
    $fromUser = "contact@rabbit-mail.jp";

    //hataji追加 2006/11/2
    $subjectMaster = html_entity_decode($subjectMaster,ENT_QUOTES);
    $messageMaster = html_entity_decode($messageMaster,ENT_QUOTES);
    $subjectUser   = html_entity_decode($subjectUser,ENT_QUOTES);
    $messageUser   = html_entity_decode($messageUser,ENT_QUOTES);
    //

    $this->sendMailMaster($toUser,$subjectMaster,$messageMaster);
    $this->sendMailUser($toUser,$fromUser,$subjectUser,$messageUser);

    return;
  }

  // メール送信：管理者
  function sendMailMaster($from=False,$subject=False,$message=False){
    require_once(_DIR_LIB_."mail/Mail.php");
    $Mail = new Mail();

    //hataji変更 2006/11/2
    //$Mail->normalMb_send_mail($from, 'info@ltv-atamail.com,masaki@itm.ne.jp', $subject, $message );
    $Mail->normalMb_send_mail($from, 'contact@rabbit-mail.jp', $subject, $message ,'contact@rabbit-mail.jp' );

    return;
  }

  // メール送信：ユーザー
  function sendMailUser($to=False,$from=False,$subject=False,$message=False){
    require_once(_DIR_LIB_."mail/Mail.php");
    $Mail = new Mail();
    $Mail->normalMb_send_mail($from, $to, $subject, $message, $from);
    return;
  }


}

?>
