<?PHP
/*

  �᡼��������Ϣ

*/

  class Send{

    var $debug = '';

    Function Send($debug=False){

      if( $debug ) $this->debug = True;

      $this->format();

      return ;
    }


    /*
     * �����
     */
    Function format(){

      if( $this->debug ) echo" - "._ROOT_PG_."Send.php | format() <br>\n";

      return ;
    }


    /*
     * sign_up ���󥭥塼�᡼������
     */
    Function sign_up($mailUser=False,$mailMaster=False){
      Global $libMail,$pField,$pVariable;

      if( $this->debug ) echo" - "._ROOT_PG_."Send.php | sign_up() <br>\n";

      $master = mb_encode_mimeheader( _NAME_FROM_ )."<"._MAIL_FROM_.">";
      $user   = mb_encode_mimeheader( "{$pVariable->inputS['name']} ��" )."<{$pVariable->inputS['mail']}>";

      $message  = "";
      $message .= "����������\n";
      $message .= "��".date('Y/m/d H:i')."\n";
      $message .= "\n";
      $message .= "��{$pField->nameS['name']}\n";
      $message .= "��{$pVariable->inputS['name']}\n";
      $message .= "\n";
      $message .= "��{$pField->nameS['kana']}\n";
      $message .= "��{$pVariable->inputS['kana']}\n";
      $message .= "\n";
      $message .= "��{$pField->nameS['mail']}\n";
      $message .= "��{$pVariable->inputS['mail']}\n";
      $message .= "\n";
      $message .= "������\n";
      $message .= "����{$pVariable->inputS['zip']}\n";
      $message .= "��{$pVariable->inputS['address1']} {$pVariable->inputS['address2']}\n";
      $message .= "\n";
      $message .= "��{$pField->nameS['tel']}\n";
      $message .= "��{$pVariable->inputS['tel']}\n";
      $message .= "\n";
      $message .= "��{$pField->nameS['fax']}\n";
      $message .= "��{$pVariable->inputS['fax']}\n";
      $message .= "\n";


      $userMessage   = "";
      if( file_exists($mailUser) ){
        $load =  file($mailUser);
        foreach($load as $key=>$value){
          $value = str_replace("#InputName#",$pVariable->inputS['name'],$value);
          $value = str_replace("#InputDataS#",$message,$value);
          $userMessage .= $value;
        }
      }

      $masterMessage   = "";
      if( file_exists($mailMaster) ){
        $load =  file($mailMaster);
        foreach($load as $key=>$value){
          $value = str_replace("#InputName#",$pVariable->inputS['name'],$value);
          $value = str_replace("#InputDataS#",$message,$value);
          $masterMessage .= $value;
        }
      }


      $userSubject  = "�����ӥ��������꤬�Ȥ��������ޤ���";
      $libMail->normalMb_send_mail( $master, $user,  $userSubject, $userMessage, False, False, _MAIL_ERROR_);

      $masterSubject  = "�����ӥ���������ޤ���";
      $libMail->normalMb_send_mail( $user,  $master, $masterSubject, $masterMessage, False, False, _MAIL_ERROR_);
      $libMail->normalMb_send_mail( $user,  "masaki@itm.ne.jp", $masterSubject, $masterMessage, False, False, _MAIL_ERROR_);


      return ;
    }


    /*
     * �ץ���ѹ� ���󥭥塼�᡼������
     */
    Function plan($plan_id=False){
      Global $libMail,$expPostgres;

      if( $this->debug ) echo" - "._ROOT_PG_."Send.php | sign_up({$plan_id}) <br>\n";

      $query  = "SELECT * FROM tm_plan WHERE flag_open=1 AND plan_id={$plan_id}";
      if( $this->debug ) echo"<font size='1'> -  query =  {$query}</font> <br>\n";
      $pDataS = $expPostgres->getOne( $query,PGSQL_ASSOC );

      $master = mb_encode_mimeheader( _NAME_FROM_ )."<"._MAIL_FROM_.">";
      $user   = mb_encode_mimeheader( "{$_SESSION['user']['name_family']} {$_SESSION['user']['name_first']} ��" )."<{$_SESSION['user']['mail']}>";

      $message .= "��{$_SESSION['user']['user_id']}\n";
      $message .= "��{$_SESSION['user']['name_family']} {$_SESSION['user']['name_first']}\n";
      $message .= "��{$_SESSION['user']['mail']}\n";
      $message .= "{$pDataS['plan']}\n";
      $message .= "\n";


      $user_subject  = "[itm-asp]�ץ���ѹ���˾����ޤ���";
      $user_message  = "";
      $user_message .= "�ѹ���˾����ޤ���\n";
      $user_message .= $message;;
      $libMail->normalMb_send_mail( $master, $user,  $user_subject, $user_message, False, False, _MAIL_ERROR_);

      $master_subject  = "�ץ���ѹ���˾������ޤ���";
      $master_message  = "";
      $master_message .= "�ѹ���˾������ޤ���";
      $master_message .= $message;;
      $libMail->normalMb_send_mail( $user, $master, $master_subject, $master_message, False, False, _MAIL_ERROR_);
      $libMail->normalMb_send_mail( $user, "masaki@itm.ne.jp", $master_subject, $master_message, False, False, _MAIL_ERROR_);


      return ;
    }


  }

?>
