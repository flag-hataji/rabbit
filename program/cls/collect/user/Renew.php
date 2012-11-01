<?PHP
/*
  ����
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


  define('_SESSION_MODE_', 'user' );
  define('_SESSION_NAME_', 'user_renew' );

  // - Load & Setup[Common]
  require_once('../../program/cls/define/Setup.php');
  require_once(_DIR_LIB_.'user/Attest.php') ;
  new Attest();

  // - SetUp[Local]

  define('_PG_ROOT_',        _DIR_CLS_."user/user/");
  define('_PG_ROOT_COMMON_', _DIR_CLS_."user/common/");
  define('_PG_ROOT_HTML_',   _PG_ROOT_."html/");
  define('_PG_ROOT_MAIL_',   _PG_ROOT_."mail/");

  define('_PG_URL_',        _URL_._DIR_USER_."member/user/");
  define('_PG_URL_TOP_',    _PG_URL_."index.php");

  define('_PG_FILE_MAIN_',        "Main.php");
  define('_PG_FILE_CONTOROLLER_', "Controller.php");
  define('_PG_FILE_MANAGER_',     "Manager.php");
  define('_PG_FILE_VIEWER_',      "Viewer.php");
  define('_PG_FILE_LIBRARY_',     "Library.php");
  define('_PG_FILE_QUERY_',       "Query.php");
  define('_PG_FILE_MAILER_',      "Mailer.php");

  define('_PG_HTML_WRITE_',        "pg_renew_write.html");
  define('_PG_HTML_CONFIRM_',      "pg_renew_confirm.html");
  define('_PG_HTML_FINISH_',       "pg_renew_finish.html");
  define('_PG_HTML_DETAIL_',       "pg_renew_detail.html");

  define('_PG_TITLE_',                "itmMailService �桼������Ͽ���� |");
  define('_PG_TITLE_RENEW_',          _PG_TITLE_." �������ѹ� |");
  define('_PG_TITLE_RENEW_WRITE_',    _PG_TITLE_RENEW_." ���� |");
  define('_PG_TITLE_RENEW_CONFIRM_',  _PG_TITLE_RENEW_." ���ϳ�ǧ |");
  define('_PG_TITLE_RENEW_FINISH_',   _PG_TITLE_RENEW_." ���ϴ�λ |");

  define('_PG_FILE_MAIL_USER_RENEW_',       "userRenew.php");
  define('_PG_FILE_MAIL_MASTER_RENEW_',     "masterRenew.php");

  require_once(_DIR_LIB_.'util/Util.php') ;
  require_once(_DIR_LIB_.'util/Html.php') ;
  require_once(_DIR_LIB_.'util/ExHtml.php') ;

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
