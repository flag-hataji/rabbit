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

    $subjectUser    = "[rabbit-mail]サービス仮登録のお申込ありがとうございました";
    $messageUserBase  = file_get_contents(_PG_ROOT_MAIL_._PG_FILE_MAIL_USER_NEW_);
    $messageUser = $messageUserBase;
    $messageUser = str_replace("#id#",$dataS['id'],$messageUser);
    $messageUser = str_replace("#password#",$dataS['password'],$messageUser);
    $messageUser = str_replace("#user_id#",$dataS['user_id'],$messageUser);
    $messageUser = str_replace("#name#",$dataS['name'],$messageUser);
    $messageUser = str_replace("#kana#",$dataS['kana'],$messageUser);
    $messageUser = str_replace("#flag_gender#",$dataS['flag_gender'],$messageUser);
    $messageUser = str_replace("#flag_gender#",$dataS['flag_gender'],$messageUser);
    $messageUser = str_replace("#name_company#",$dataS['name_company'],$messageUser);
    $messageUser = str_replace("#kana_company#",$dataS['kana_company'],$messageUser);
    $messageUser = str_replace("#mail#",$dataS['mail'],$messageUser);
    $messageUser = str_replace("#tel#",$dataS['tel'],$messageUser);
    $messageUser = str_replace("#mobile#",$dataS['mobile'],$messageUser);
    $messageUser = str_replace("#fax#",$dataS['fax'],$messageUser);
    $messageUser = str_replace("#zip#",$dataS['zip'],$messageUser);
    $messageUser = str_replace("#area#",$dataS['area'],$messageUser);
    $messageUser = str_replace("#address1#",$dataS['address1'],$messageUser);
    $messageUser = str_replace("#address2#",$dataS['address2'],$messageUser);
    $messageUser = str_replace("#root_id#",$dataS['root_id'],$messageUser);
    $messageUser = str_replace("#text_root#",$dataS['text_root'],$messageUser);
    $messageUser = str_replace("#n_id#",$nameS['id'],$messageUser);
    $messageUser = str_replace("#n_password#",$nameS['password'],$messageUser);
    $messageUser = str_replace("#n_user_id#",$nameS['user_id'],$messageUser);
    $messageUser = str_replace("#n_name#",$nameS['name'],$messageUser);
    $messageUser = str_replace("#n_kana#",$nameS['kana'],$messageUser);
    $messageUser = str_replace("#n_flag_gender#",$nameS['flag_gender'],$messageUser);
    $messageUser = str_replace("#n_flag_gender#",$nameS['flag_gender'],$messageUser);
    $messageUser = str_replace("#n_name_company#",$nameS['name_company'],$messageUser);
    $messageUser = str_replace("#n_kana_company#",$nameS['kana_company'],$messageUser);
    $messageUser = str_replace("#n_mail#",$nameS['mail'],$messageUser);
    $messageUser = str_replace("#n_tel#",$nameS['tel'],$messageUser);
    $messageUser = str_replace("#n_mobile#",$nameS['mobile'],$messageUser);
    $messageUser = str_replace("#n_fax#",$nameS['fax'],$messageUser);
    $messageUser = str_replace("#n_zip#",$nameS['zip'],$messageUser);
    $messageUser = str_replace("#n_area#",$nameS['area'],$messageUser);
    $messageUser = str_replace("#n_address1#",$nameS['address1'],$messageUser);
    $messageUser = str_replace("#n_address2#",$nameS['address2'],$messageUser);
    $messageUser = str_replace("#n_root_id#",$nameS['root_id'],$messageUser);
    $messageUser = str_replace("#n_text_root#",$nameS['text_root'],$messageUser);

    $plan_detail  = "";
    $query = "SELECT * FROM tm_plan WHERE flag_open=1 ORDER BY sort";

    $ExPostgres = $this->dbConnect();
    $ExPostgres->executeQuery($query);
    $count = $ExPostgres->getRow();
    if( $count!=0 ){
      $i=0;
      while($ExPostgres->getRow()-1>=$i){
        $pDataS = pg_fetch_assoc( $ExPostgres->getResult(),$i );

        $pDataS['price_first'] = floor(($pDataS['price_first']*1.05));
        $pDataS['price_month'] = floor($pDataS['price_month']*1.05);
        $pDataS['price_month6'] = floor($pDataS['price_month6']*1.05);
        $plan_detail .= "・{$pDataS['plan']}\n";
        $plan_detail .= "　メール送信可能件数　：　{$pDataS['send_max']}件（最大）\n";
        $plan_detail .= "　初期設定費　　　　　：　{$pDataS['price_first']}円\n";
        $plan_detail .= "　６ヶ月の料金　　　　：　{$pDataS['price_month6']}円 (1ヶ月 {$pDataS['price_month']}円) \n";
        if($pDataS['comment']!=""){
          $pDataS['comment'] = str_replace("\n","\n　　",$pDataS['comment']);
          $plan_detail .= "　※{$pDataS['comment']}\n";
        }

        $plan_detail .= "\n";

        $i++;
      }
    }
    pg_free_result( $ExPostgres->getResult() );
    $ExPostgres->close();
    $messageUser = str_replace("#plan_detail#",$plan_detail,$messageUser);

    $subjectMaster  = "[rabbit-mail]サービス仮登録のお申込がありました";
    $messageMasterBase  = file_get_contents(_PG_ROOT_MAIL_._PG_FILE_MAIL_MASTER_NEW_);
    $messageMaster = $messageMasterBase;
    $messageMaster = str_replace("#user_id#",$dataS['user_id'],$messageMaster);
    $messageMaster = str_replace("#name#",$dataS['name'],$messageMaster);
    $messageMaster = str_replace("#kana#",$dataS['kana'],$messageMaster);
    $messageMaster = str_replace("#mail#",$dataS['mail'],$messageMaster);
    $messageMaster = str_replace("#ip#",$dataS['ip'],$messageMaster);
    $messageMaster = str_replace("#host#",$dataS['host'],$messageMaster);
    $messageMaster = str_replace("#root_id#",$dataS['root_id'],$messageMaster);
    $messageMaster = str_replace("#medium_id#",$dataS['medium_id'],$messageMaster);
    $messageMaster = str_replace("#referrer#",$dataS['referrer'],$messageMaster);
    $messageMaster .= $messageUser;


    $subjectMedium  = "[rabbit-mail]サービス仮登録のお申込がありました：";
    $messageMediumBase  = file_get_contents(_PG_ROOT_MAIL_._PG_FILE_MAIL_MEDIUM_NEW_);
    $messageMedium = $messageMediumBase;
    $messageMedium = str_replace("#user_id#",$dataS['user_id'],$messageMedium);
    $messageMedium = str_replace("#name#",$dataS['name'],$messageMedium);
    $messageMedium = str_replace("#kana#",$dataS['kana'],$messageMedium);
    $messageMedium = str_replace("#ip#",$dataS['ip'],$messageMedium);
    $messageMedium = str_replace("#host#",$dataS['host'],$messageMedium);
    $messageMedium = str_replace("#root_id#",$dataS['root_id'],$messageMedium);
    $messageMedium = str_replace("#medium_id#",$dataS['medium_id'],$messageMedium);
    $messageMedium = str_replace("#referrer#",$dataS['referrer'],$messageMedium);

    $toUser   = mb_encode_mimeheader( $dataS['name']."様" )."<{$dataS['mail']}>";
    $fromUser = "info@rabbit-mail.jp";

    $this->sendMailMaster($toUser,$subjectMaster,$messageMaster);
    $this->sendMailUser($toUser,$fromUser,$subjectUser,$messageUser);
    $this->sendMailMedium($dataS,$subjectMedium,$messageMedium);

    return;
  }

  // メール送信：媒体者
  function sendMailMedium($dataS=False,$subject=False,$message=False){

    if(isset($dataS['medium_id']) && $dataS['medium_id']!="" ){
      $query = "SELECT * FROM tm_medium WHERE medium_id={$dataS['medium_id']} ";
      $ExPostgres = $this->dbConnect();
      $ExPostgres->executeQuery($query);
      $count = $ExPostgres->getRow();
      $mDataS = pg_fetch_assoc( $ExPostgres->getResult(),0 );
      pg_free_result( $ExPostgres->getResult() );
      $ExPostgres->close();

      $subject = $subject.$mDataS['medium'];
      $to = "{$mDataS['mail']},info@rabbit-mail.jp,masaki@itm.ne.jp";

      require_once(_DIR_LIB_."mail/Mail.php");
      $Mail = new Mail();
      $Mail->normalMb_send_mail('info@rabbit-mail.jp', $to, $subject, $message );
    }

    return;
  }


  // メール送信：管理者
  function sendMailMaster($from,$subject=False,$message=False){
    require_once(_DIR_LIB_."mail/Mail.php");
    $Mail = new Mail();
    $Mail->normalMb_send_mail($from, 'info@rabbit-mail.jp,masaki@itm.ne.jp', $subject, $message );
    return;
  }

  // メール送信：ユーザー
  function sendMailUser($to=False,$from=False,$subject=False,$message=False){
    require_once(_DIR_LIB_."mail/Mail.php");
    $Mail = new Mail();
    $Mail->normalMb_send_mail($from, $to, $subject, $message, 'info@rabbit-mail.jp,masaki@itm.ne.jp');
    return;
  }


}

?>
