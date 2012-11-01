<?PHP
/*

  ID/Password忘れたページ

*/


  // LOAD:Common Setting
  require_once '../common/define/setup.php';

  // LOAD:PG Setting
  require_once '../cls/user/Setup.php';

  if( _DOMAIN_=='192.168.1.210' ){
    define("_TEST_", True );
  }else{
    define("_TEST_", False );
  }
  define("_DEBUG_",False );

  define('_NAME_FROM_',  'itm-asp.com');
  define('_NAME_TO_',    'itm-asp.com');
  define('_MAIL_FROM_',  'info@itm-asp.com');
  define('_MAIL_TO_',    'info@itm-asp.com');
  define('_MAIL_ERROR_', 'info@itm-asp.com');

  // SET:PG Setting
  // name
  define('_NAME_', 'user' );

  define('_LIST_MAX_', 20 );

  // Root
  define('_ROOT_PG_',      _ROOT_CLS_USER_);
  define('_ROOT_PG_HTML_', _ROOT_MEMBER_);
  define('_ROOT_PG_DAT_',  _ROOT_CLS_USER_);

  // Html
  define('_HTML_PG_BASE_',   _ROOT_PG_HTML_.'base.html' );
  define('_HTML_PG_WRITE_',  _ROOT_PG_HTML_.'forget_write.html' );
  define('_HTML_PG_FINISH_', _ROOT_PG_HTML_.'forget_finish.html' );

  // Url
  define('_URL_PG_',         _URL_MEMBER_);
  define('_URL_PG_TOP_',     _URL_MEMBER_TOP_);
  define('_URL_PG_WRITE_', _URL_PG_TOP_.'?get=finish');

  // Image
  define('_IMAGE_PG_', _URL_PG_.'image/');

  // LOAD:PARTS
  require_once _ROOT_PG_.'Session.php';
  require_once _ROOT_PG_.'Field.php';
  require_once _ROOT_PG_.'Variable.php';
  require_once _ROOT_PG_.'OutputUser.php';
  require_once _ROOT_PG_.'Query.php';
  require_once _ROOT_PG_.'CheckSp.php';
  require_once _ROOT_PG_.'Send.php';


  // SET:PARTS
  $pSession  = new Session(_NAME_,_DEBUG_);
  $pField    = new Field(_DEBUG_,_TEST_);
  $pVariable = new Variable(_DEBUG_);
  $pOutput   = new OutputUser(_HTML_PG_BASE_,'EUC-JP',_LIST_MAX_,_DEBUG_);
  $pQuery    = new Query(_DEBUG_);
  $pCheckSp  = new CheckSp(_DEBUG_);
  $pSend     = new Send(_DEBUG_);


  // Output
  $html=_HTML_PG_WRITE_;
  $errorWord = "";
  $errorNum = 0;
  switch( $expDistribution->exe ){

    // 送信
    case 'finish':
      $pSession->format('forget');
      $pSession->mode('forget');
      $pSession->place('error');
      if(isset($_POST['mail']) && $_POST['mail']!="" ){
        $mail = htmlspecialchars($_POST['mail']);
        if( $libCheck->isMail($mail) ){
          $query  = "SELECT * FROM td_user ";
          $query .= " JOIN td_pictmail ON td_pictmail.user_id=td_user.user_id ";
          $query .= " WHERE td_user.mail='{$mail}' AND td_user.flag_pictmail='t' ";
          $query .= " AND td_pictmail.flag_del!=1";

          $pDataS = $expPostgres->getOne( $query,PGSQL_ASSOC );
          if($pDataS!=""){
            $master = mb_encode_mimeheader( _NAME_FROM_ )."<"._MAIL_FROM_.">";
            //$user   = mb_encode_mimeheader( "{$pVariable->inputS['name']} 様" )."<{$pVariable->inputS['mail']}>";
            $user   = $mail;




            $subject  = "[itm-asp]ご確認情報のお知らせ";
            $message  = "";
            $message .= "\n";
            $message .= "IDとPasswordをお知らせいたします\n";
            $message .= "\n";
            $message .= "ID　　　：{$pDataS['id']} \n";
            $message .= "Password：{$pDataS['password']} \n";
            $message .= "\n";
            $libMail->normalMb_send_mail( $master, $user,  $subject, $message, False, False, _MAIL_ERROR_);
            $pSession->place('finish');
          }else{
            $errorNum = 3;
          }


        }else{
          $errorNum = 2;
        }
      }else{
        $errorNum = 1;
      }
      if( $errorNum!=0 ){
        switch($errorNum){
          case 1: $errorWord="メールアドレスが未入力です";
            break;
          case 2: $errorWord="ご入力されたメールアドレスが正しくありません";
            break;
          case 3: $errorWord="ご入力されたメールアドレスは登録されておりません";
            break;

        }
      }else{
        $html=_HTML_PG_FINISH_;
      }
      break;

    // 最初期
    default:
      $pSession->format('forget');
      $pSession->mode('forget');
      $pSession->place('write');
  }
  require_once(_HTML_PG_BASE_);

  // SHOW DEBUG
  $libDebug->arrayView($_SESSION[_NAME_],'$_SESSION[\''._NAME_.'\']',_DEBUG_);
  $libDebug->arrayView($_POST,'$_POST',_DEBUG_);
  $libDebug->arrayView($_GET, '$_GET',_DEBUG_);
  $libDebug->arrayView($pField->dbS, '$pField->dbS',_DEBUG_);
  $libDebug->defineView(_DEBUG_);

  exit;
?>
