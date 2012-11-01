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
  function sendMail($dataS=False,$viewS=False,$nameS=False){

    $url = _URL_.$viewS['url']."?collect_id={$dataS['collect_id']}";

    $subjectUser    = "[itm-asp]ダウンロードお申込ありがとうございます";
    $messageUserBase  = file_get_contents(_PG_ROOT_MAIL_._PG_FILE_MAIL_USER_NEW_);
    $messageUser = $messageUserBase;
    $messageUser = str_replace("#collect_id#",$dataS['collect_id'],$messageUser);
    $messageUser = str_replace("#mail#",$dataS['mail'],$messageUser);
    $messageUser = str_replace("#tool_id#",$viewS['tool_id'],$messageUser);
    $messageUser = str_replace("#url#",$url,$messageUser);

    $messageUser = str_replace("#n_collect_id#",$nameS['collect_id'],$messageUser);
    $messageUser = str_replace("#n_mail#",$nameS['mail'],$messageUser);
    $messageUser = str_replace("#n_tool_id#",$dataS['tool_id'],$messageUser);


    $toUser   = $dataS['mail'];
    $fromUser = "info@itm-asp.com";

    $this->sendMailUser($toUser,$fromUser,$subjectUser,$messageUser);

    return;
  }

  // メール送信：管理者
  function sendMailMaster($from=False,$subject=False,$message=False){
    require_once(_DIR_LIB_."mail/Mail.php");
    $Mail = new Mail();
    $Mail->normalMb_send_mail($from, 'info@itm-asp.com,masaki@itm.ne.jp', $subject, $message );
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
