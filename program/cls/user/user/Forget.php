<?PHP
/*
  ユーザー管理：設定

*/
  // - SetUp[Mode]
  if( getenv("REMOTE_ADDR")=='221.246.192.14' ){
    define('_TEST_', False );
  }else{
    define('_TEST_', False );
  }
  define('_HTTPS_COERCION_', False);
  define('_DEBUG_',  0 );
  define('_MASTER_', False );

  define('_SESSION_MODE_', 'user' );
  define('_SESSION_NAME_', 'sign_up' );
  define('_LIST_NUM_ID_',   10 );

  define('_LIST_NUM1_',     20 );
  define('_LIST_NUM2_',     15 );

  // - Load & Setup[Common]
  require_once('../program/cls/define/Setup.php');

  // - SetUp[Local]

  define('_PG_ROOT_',        _DIR_CLS_."user/user/");
  define('_PG_ROOT_COMMON_', _DIR_CLS_."user/common/");
  define('_PG_ROOT_THIS_',   _ABSOLUTE_."forget/");
  define('_PG_ROOT_HTML_',   _PG_ROOT_THIS_);
  define('_PG_ROOT_MAIL_',   _PG_ROOT_."mail/");

  define('_PG_URL_',        _URL_._DIR_ADMIN_."forget/");
  define('_PG_URL_TOP_',    _PG_URL_."index.php");

  define('_PG_FILE_MAIN_',        "Main.php");
  define('_PG_FILE_CONTOROLLER_', "Controller.php");
  define('_PG_FILE_MANAGER_',     "Manager.php");
  define('_PG_FILE_VIEWER_',      "Viewer.php");
  define('_PG_FILE_LIBRARY_',     "Library.php");
  define('_PG_FILE_QUERY_',       "Query.php");
  define('_PG_FILE_MAILER_',      "Mailer.php");

  define('_PG_HTML_WRITE_',        "pg_forget_write.html");
  define('_PG_HTML_FINISH_',       "pg_forget_finish.html");

  define('_PG_TITLE_',          "IDとパスワードの確認  |");
  define('_PG_TITLE_WRITE_',    _PG_TITLE_." 入力 |");
  define('_PG_TITLE_FINISH_',   _PG_TITLE_." 入力完了 |");

  define('_PG_FILE_MAIL_USER_FORGET_', "userForget.txt");

  require_once(_DIR_LIB_.'util/Util.php') ;
  require_once(_DIR_LIB_.'util/Html.php') ;
  require_once(_DIR_LIB_.'util/ExHtml.php') ;


  $title = _PG_TITLE_WRITE_;
  $error = "";
  $mail = "";
  $html = _PG_ROOT_HTML_._PG_HTML_WRITE_;

  if( isset($_POST['finish']) ){

    require_once(_DIR_LIB_."db/Postgres.php");
    require_once(_DIR_LIB_."db/ExPostgres.php");
    require_once(_DIR_LIB_.'check/Check.php');
    $ExPostgres = new ExPostgres(_DB_NAME_,_DB_USER_,_DB_HOST_,_DB_PORT_);
    $Check = new Check() ;

    $mail = $_POST['mail'];
    $mail = htmlspecialchars($mail);

	$error = "";

    if($mail==""){
      $error = "メールアドレスが入力されていません";
    }elseif( !$Check->isMail($mail) ){
	  $error = "メールアドレスが正しくありません";
	}else{

	    $query = "SELECT * FROM td_user JOIN td_pictmail ON td_user.user_id = td_pictmail.user_id WHERE mail='{$mail}' AND td_pictmail.flag_del = 0";
	    $ExPostgres->executeQuery($query);
	    $count = $ExPostgres->getRow();

	    if( $count==0 ){
	      $error = "メールアドレスは登録されていません";
	    }else{	      
	      $user_data ="";
		  $user_data .= "※入力ミス防止のため、コピー＆貼りつけでログインしてください。\n";
		  $user_data .= "※コピーの際に最後に空白が入ることがあります。ご注意ください。\n";
		  $user_data .= "\n";

	      while ($dataS = pg_fetch_assoc($ExPostgres->getResult())) {
		  	$user_data .= "ご登録名　：　". $dataS['name_family']." ".$dataS['name_first']." \n";
		  	$user_data .= "ＩＤ　　　：　". $dataS['id']."　 \n";
		  	$user_data .= "パスワード：　". $dataS['password']."　 \n";
		  	$user_data .=  "\n";
		  }
		  	$user_data .= "\n";

		  
	      require_once(_DIR_LIB_."mail/Mail.php");
	      $Mail = new Mail();

	      $subject = "[rabbit-mail]ID&passwordのご確認";
	      $messageBase  = file_get_contents(_PG_ROOT_MAIL_._PG_FILE_MAIL_USER_FORGET_);
	      $message = $messageBase;
	      $message = str_replace("#user_data#",$user_data,$message);

	      $Mail->normalMb_send_mail("info@rabbit-mail.jp", $mail, $subject, $message );
	    }

	pg_free_result( $ExPostgres->getResult() );
	$ExPostgres->close();
	}

    $errorWord = $error;

    if($error!=""){
      $html = _PG_ROOT_HTML_._PG_HTML_WRITE_;
    }else{
      $title = _PG_TITLE_FINISH_;
      $html = _PG_ROOT_HTML_._PG_HTML_FINISH_;
    }


  }

  require_once($html) ;

  if( _DEBUG_ ){
    require_once(_DIR_LIB_.'debug/Debug.php');
    $libDebug = new Debug();
    $libDebug->arrayView($_SESSION[_SESSION_MODE_][_SESSION_NAME_],'$_SESSION[\''._SESSION_MODE_.'\'][\''._SESSION_NAME_.'\']',_DEBUG_);
    $libDebug->arrayView($_POST,'$_POST',_DEBUG_);
    $libDebug->arrayView($_GET, '$_GET',_DEBUG_);
    $libDebug->defineView(_DEBUG_);
  }

  exit;

?>
