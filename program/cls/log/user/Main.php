<?PHP
/*
  ユーザー管理：設定

*/
  // - SetUp[Mode]
  if( getenv("REMOTE_ADDR")=='221.246.192.14' ){
    define('_HTTPS_COERCION_', False);
    define('_DEBUG_',  False );
    define('_TEST_',   False );
    define('_MASTER_', False );
  }else{
    define('_HTTPS_COERCION_', False);
    define('_DEBUG_',  False );
    define('_TEST_',   False );
    define('_MASTER_', False );
  }


  define('_SESSION_MODE_', 'user' );
  define('_SESSION_NAME_', 'log' );
  define('_LIST_NUM_ID_',   10 );

  define('_LIST_NUM1_',     15 );
  define('_LIST_NUM2_',     15 );

  // - Load & Setup[Common]
  require_once('../../../program/cls/define/Setup.php');
  require_once(_DIR_LIB_.'user/Attest.php') ;
  new Attest();

  // - SetUp[Local]
  define('_PG_ROOT_',            _DIR_CLS_."log/user/");
  define('_PG_ROOT_COMMON_',     _DIR_CLS_."log/common/");
  define('_PG_ROOT_THIS_',   _ABSOLUTE_."member/pictmail/log/");
  define('_PG_ROOT_HTML_RENEW_', _PG_ROOT_THIS_);
  define('_PG_ROOT_HTML_NEW_',   _PG_ROOT_THIS_);

  define('_PG_URL_',        _URL_._DIR_MEMBER_PICTMAIL_."log/");
  define('_PG_URL_TOP_',    _PG_URL_."index.php");

  define('_PG_URL_RENEW_SEEK_',   _PG_URL_."index.php?get=seek&mode=renew");
  define('_PG_URL_RENEW_LIST_',   _PG_URL_."index.php?get=list&mode=renew");
  define('_PG_URL_DETAIL_',       _PG_URL_."index.php?get=detail&mode=renew&log_id=#log_id#");
  define('_PG_URL_DELETE_',       _PG_URL_."index.php?get=delete&mode=renew&log_id=#log_id#");
  define('_PG_URL_CANCEL_PC_',    _PG_URL_."index.php?get=cancel_pc&mode=renew&message_id=#message_id#&log_id=#log_id#&send_count_pc=#send_count_pc#");
  define('_PG_URL_CANCEL_MOBILE_',_PG_URL_."index.php?get=cancel_mobile&mode=renew&message_id=#message_id#&log_id=#log_id#&send_count_mobile=#send_count_mobile#");

  define('_PG_FILE_MAIN_',        "Main.php");
  define('_PG_FILE_CONTOROLLER_', "Controller.php");
  define('_PG_FILE_MANAGER_',     "Manager.php");
  define('_PG_FILE_VIEWER_',      "Viewer.php");
  define('_PG_FILE_LIBRARY_',     "Library.php");
  define('_PG_FILE_QUERY_',       "Query.php");
  define('_PG_FILE_MAKER_',       "Maker.php");

  define('_PG_HTML_SEEK_' ,     "pg_seek.html");
  define('_PG_HTML_LIST_',      "pg_list.html");
  define('_PG_HTML_LIST_PAGE_', "pg_list_page.html");
  define('_PG_HTML_LIST_IN_',   "pg_list_in.html");
  define('_PG_HTML_DETAIL_',    "pg_detail.html");

  define('_PG_TITLE_',        " メール配信ログ");
  define('_PG_TITLE_NEW_',    _PG_TITLE_."登録 ：");
  define('_PG_TITLE_RENEW_',  _PG_TITLE_."閲覧 ：");
  define('_PG_TITLE_SEEK_',   " 検索");
  define('_PG_TITLE_LIST_',   " 一覧");
  define('_PG_TITLE_DETAIL_', " 詳細");

  require_once(_DIR_LIB_.'util/Util.php') ;
  require_once(_DIR_LIB_.'util/Html.php') ;
  require_once(_DIR_LIB_.'util/ExHtml.php') ;

  if( file_exists(_PG_ROOT_._PG_FILE_CONTOROLLER_) ){
    require_once(_PG_ROOT_._PG_FILE_CONTOROLLER_);
    $Controller = new Controller();
  }else{
   die("Error : "._PG_ROOT_._PG_FILE_MAIN_." on line ".__LINE__." "._PG_ROOT_._PG_FILE_CONTOROLLER_." Require Error");
  }
  $Controller->setControl();

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
