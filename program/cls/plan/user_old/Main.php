<?PHP
/*
  設定
*/
  // - SetUp[Mode]
  if( getenv("REMOTE_ADDR")=='221.246.192.14' ){
    define('_HTTPS_COERCION_', False);
    define('_DEBUG_',  False );
    define('_TEST_', False );
    define('_MASTER_', True );
  }else{
    define('_HTTPS_COERCION_', False);
    define('_DEBUG_',  False );
    define('_TEST_', False );
    define('_MASTER_', True );
  }


  define('_SESSION_MODE_', 'user' );
  define('_SESSION_NAME_', 'plan' );

  // - Load & Setup[Common]
  require_once('../../../program/cls/define/Setup.php');

  // - SetUp[Local]

  define('_PG_ROOT_',        _DIR_CLS_."plan/user/");
  define('_PG_ROOT_COMMON_', _DIR_CLS_."plan/common/");
  define('_PG_ROOT_THIS_',   _ABSOLUTE_."member/pictmail/plan/");
  define('_PG_ROOT_HTML_',   _PG_ROOT_THIS_);
  define('_PG_ROOT_MAIL_',   _PG_ROOT_."mail/");
  define('_PG_URL_',        _URL_._DIR_ADMIN_."plan/");
  define('_PG_URL_TOP_',    _PG_URL_."index.php");

  define('_PG_URL_RENEW_SEEK_',       _PG_URL_."index.php?get=seek&mode=renew");
  define('_PG_URL_RENEW_LIST_',       _PG_URL_."index.php?get=list&mode=renew");
  define('_PG_URL_RENEW_USER_WRITE_', _PG_URL_."index.php?get=write&mode=renew&user_id=#user_id#");
  define('_PG_URL_DELETE_USER_',      _PG_URL_."index.php?get=delete&mode=renew&user_id=#user_id#");
  define('_PG_URL_RENEW_PLAN_WRITE_', _URL_ADMIN_."pictmail/index.php?get=write&mode=renew&user_id=#user_id#");
  define('_PG_URL_PERMISSION_USER_',  _PG_URL_."index.php?get=permission&mode=renew&user_id=#user_id#");


  define('_PG_FILE_MAIN_',        "Main.php");
  define('_PG_FILE_CONTOROLLER_', "Controller.php");
  define('_PG_FILE_MANAGER_',     "Manager.php");
  define('_PG_FILE_VIEWER_',      "Viewer.php");
  define('_PG_FILE_LIBRARY_',     "Library.php");
  define('_PG_FILE_QUERY_',       "Query.php");
  define('_PG_FILE_MAILER_',      "Mailer.php");

 
  define('_PG_HTML_WRITE_',    "pg_write.html");
  define('_PG_HTML_LIST_IN_',  "pg_list_in.html");
  define('_PG_HTML_CONFIRM_',  "pg_confirm.html");
  define('_PG_HTML_FINISH_',   "pg_finish.html");
  define('_PG_HTML_DETAIL_',   "pg_detail.html");


  define('_PG_TITLE_',                "プラン設定・変更申請 ");
  define('_PG_TITLE_WRITE_',    _PG_TITLE_."： 入力");
  define('_PG_TITLE_CONFIRM_',  _PG_TITLE_."： 入力確認");
  define('_PG_TITLE_FINISH_',   _PG_TITLE_."： 入力完了");

  define('_PG_FILE_MAIL_USER_NEW1_',   "userNew1.txt");
  define('_PG_FILE_MAIL_USER_NEW2_',   "userNew2.txt");
  define('_PG_FILE_MAIL_USER_NEW3_',   "userNew3.txt");
  define('_PG_FILE_MAIL_USER_RENEW_',  "userRenew.txt");
  define('_PG_FILE_MAIL_MASTER_NEW_',  "masterNew.txt");

  require_once(_DIR_LIB_.'util/Util.php') ;
  require_once(_DIR_LIB_.'util/Html.php') ;
  require_once(_DIR_LIB_.'util/ExHtml.php') ;

  $_SESSION['plan_end']=False;

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
