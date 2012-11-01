<?PHP
/*
  設定
*/
  // - SetUp[Mode]
  if( getenv("REMOTE_ADDR")=='221.246.192.14' ){
    define('_HTTPS_COERCION_', False);
    define('_DEBUG_',  False );
    define('_MASTER_', False );
    define('_TEST_', False );
  }else{
    define('_HTTPS_COERCION_', True);
    define('_DEBUG_',  False );
    define('_MASTER_', False );
    define('_TEST_', False );
  }


  define('_SESSION_MODE_', 'admin' );
  define('_SESSION_NAME_', 'admin_new' );

  // - Load & Setup[Common]
  require_once('../../program/cls/define/Setup.php');



  // - SetUp[Local]

  define('_PG_ROOT_',        _DIR_CLS_."user/master/");
  define('_PG_ROOT_COMMON_', _DIR_CLS_."user/common/");
  define('_PG_ROOT_THIS_',   _ABSOLUTE_."sign_up/");
  define('_PG_ROOT_HTML_',   _DIR_CLS_."user/master/html/");
  define('_PG_ROOT_MAIL_',   _PG_ROOT_."mail/");


  define('_PG_URL_',        _URL_._DIR_USER_."member/user/");
  define('_PG_URL_TOP_',    _PG_URL_."index.php");
  define('_PG_URL_FINISH_',    "finish.php");

  define('_PG_FILE_MAIN_',        "Main.php");
  define('_PG_FILE_CONTOROLLER_', "Controller.php");
  define('_PG_FILE_MANAGER_',     "Manager.php");
  define('_PG_FILE_VIEWER_',      "Viewer.php");
  define('_PG_FILE_LIBRARY_',     "Library.php");
  define('_PG_FILE_QUERY_',       "Query.php");
  define('_PG_FILE_MAILER_',      "Mailer.php");

  define('_PG_HTML_WRITE_',        "pg_write.html");
  define('_PG_HTML_CONFIRM_',      "pg_confirm.html");
  define('_PG_HTML_FINISH_',       "pg_finish.html");
  define('_PG_HTML_DETAIL_',       "pg_detail.html");

  define('_PG_TITLE_',             "メール配信システム ピクトメール無料仮登録 ：");
  define('_PG_TITLE_NEW_WRITE_',   _PG_TITLE_." 入力");
  define('_PG_TITLE_NEW_CONFIRM_', _PG_TITLE_." 入力確認");
  define('_PG_TITLE_NEW_FINISH_',  _PG_TITLE_." 入力完了");

  define('_PG_FILE_MAIL_USER_NEW_',       "userNew.txt");
  define('_PG_FILE_MAIL_MASTER_NEW_',     "masterNew.txt");
  define('_PG_FILE_MAIL_MEDIUM_NEW_',     "mediumNew.txt");

  require_once(_DIR_LIB_.'util/Util.php') ;
  require_once(_DIR_LIB_.'util/Html.php') ;
  require_once(_DIR_LIB_.'util/ExHtml.php') ;
/*
  if (!$_SERVER['HTTPS']) {
      $_PG_URL_ = "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
      header("location:".$_PG_URL_);
      exit;
  }
*/
  if( file_exists(_PG_ROOT_._PG_FILE_CONTOROLLER_) ){
    require_once(_PG_ROOT_._PG_FILE_CONTOROLLER_);
    new Controller();
  }else{
   die("Error : "._PG_ROOT_._PG_FILE_MAIN_." on line ".__LINE__." "._PG_ROOT_._PG_FILE_CONTOROLLER_." Require Error");
  }

  // - SHOW DEBUG
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
