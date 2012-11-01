<?PHP
/*

  メール送信関連

*/

  class Send{

    var $debug = '';

    Function Send($debug=False){

      if( $debug ) $this->debug = True;

      $this->format();

      return ;
    }


    /*
     * 初期化
     */
    Function format(){

      if( $this->debug ) echo" - "._ROOT_PG_."Send.php | format() <br>\n";

      return ;
    }


    /*
     * テスト送信
     */
    Function test(){
      Global $libMail,$pVariable;

      if( $this->debug ) echo" - "._ROOT_PG_."Send.php | test() <br>\n";

     $libMail->normalMb_send_mail( $pVariable->inputS['mail_from'],
                                   $pVariable->inputS['mail_test'],
                                   $pVariable->inputS['subject'],
                                   $pVariable->inputS['message'],
                                   False,False,
                                   $pVariable->inputS['mail_error']);
      return ;
    }


    /*
     * テスト送信HTML
     */
    Function test_html(){
      Global $libMail,$pVariable;

      if( $this->debug ) echo" - "._ROOT_PG_."Send.php | test() <br>\n";

     $libMail->htmlMail( $pVariable->inputS['mail_from'],
                                   $pVariable->inputS['mail_test'],
                                   $pVariable->inputS['subject'],
                                   $pVariable->inputS['message'],
                                   $pVariable->inputS['message_html'],
                                   False,False,
                                   $pVariable->inputS['mail_error']);
      return ;
    }



    /*
     * 一括送信実行()
     */
    Function runBatch(){
      Global $pVariable,$pQuery;

      if( $this->debug ) echo" - "._ROOT_PG_."Send.php | runBatch()  is Run "._ROOT_PG_."BatchQuery.php<br>\n ";


      $query['td_log'] = $pQuery->insert_td_log();
      $query['td_message'] = $pQuery->insert_td_message();
      $query['td_mailq'] = $pQuery->insert_td_mailq();
      $query['td_pictmail'] = $pQuery->update_td_pictmail();

      $argv1 = urlencode( serialize( $pVariable->inputS['file_mail'] ) );
      $argv2 = urlencode( serialize( $pVariable->inputS['name_from'] ) );
      $argv3 = urlencode( serialize( $pVariable->inputS['mail_from'] ) );
      $argv4 = urlencode( serialize( $pVariable->inputS['mail_error'] ) );
      $argv5 = urlencode( serialize( $pVariable->inputS['subject'] ) );
      $argv6 = urlencode( serialize( $pVariable->inputS['message'] ) );

      $argv7 = urlencode( serialize( $query['td_log'] ) );
      $argv8 = urlencode( serialize( $query['td_message'] ) );
      $argv9 = urlencode( serialize( $query['td_mailq'] ) );
      $argv10= urlencode( serialize( $query['td_pictmail'] ) );

      exec( _ROOT_PG_."BatchQuery.php $argv1 $argv2 $argv3 $argv4 $argv5 $argv6 $argv7 $argv8 $argv9 $argv10 > /dev/null &");
      if( $this->debug ) echo" - END <br>\n ";

      return ;
    }




    /*
     * 一括送信実行(未使用)
     */
    Function runBatchOLD(){
      Global $pVariable;

      if( $this->debug ) echo" - "._ROOT_PG_."Send.php | runBatch()  "._ROOT_PG_."BatchMail.php<br>\n ";


      echo "<br>\n";
      echo $pVariable->inputS['file_mail']."<br>\n";
      echo $pVariable->inputS['name_from']."<br>\n";
      echo $pVariable->inputS['mail_from']."<br>\n";
      echo $pVariable->inputS['mail_error']."<br>\n";
      echo $pVariable->inputS['subject']."<br>\n";
      echo $pVariable->inputS['message']."<br>\n";
      echo $pVariable->inputS['query']."<br>\n<br>\n";



      $argv1 = urlencode( serialize( $pVariable->inputS['file_mail'] ) );
      $argv2 = urlencode( serialize( $pVariable->inputS['name_from'] ) );
      $argv3 = urlencode( serialize( $pVariable->inputS['mail_from'] ) );
      $argv4 = urlencode( serialize( $pVariable->inputS['mail_error'] ) );
      $argv5 = urlencode( serialize( $pVariable->inputS['subject'] ) );
      $argv6 = urlencode( serialize( $pVariable->inputS['message'] ) );
      $argv7 = urlencode( serialize( $pVariable->inputS['query'] ) );

      exec( _ROOT_PG_."BatchMail.php $argv1 $argv2 $argv3 $argv4 $argv5 $argv6 $argv7 > /dev/null &");
      if( $this->debug ) echo" - END <br>\n ";
      return ;
    }

  }

?>
