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
  define('_DEBUG_',  False );
  define('_MASTER_', True );

  define('_SESSION_MODE_', 'master' );
  define('_SESSION_NAME_', 'pictmail' );
  define('_LIST_NUM_ID_',   10 );

  define('_LIST_NUM1_',     20 );
  define('_LIST_NUM2_',     15 );

  // - Load & Setup[Common]
  require_once('../../program/cls/define/Setup.php');

  // - SetUp[Local]

  define('_PG_ROOT_',        _DIR_CLS_."pictmail/master/");
  define('_PG_ROOT_COMMON_', _DIR_CLS_."pictmail/common/");
  define('_PG_ROOT_HTML_',   _PG_ROOT_."html/");

  define('_PG_URL_',        _URL_._DIR_ADMIN_."user2/");
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
  define('_PG_FILE_MAKER_',       "Maker.php");


  define('_PG_HTML_LIST_PAGE_',    "pg_list_page.html");
  define('_PG_HTML_WRITE_',        "pg_write.html");
  define('_PG_HTML_CONFIRM_',      "pg_confirm.html");
  define('_PG_HTML_FINISH_',       "pg_finish.html");
  define('_PG_HTML_DETAIL_',       "pg_detail.html");

  define('_PG_HTML_SELECT_WRITE_',    "pg_select_write.html");
  define('_PG_HTML_SELECT_CONFIRM_',  "pg_select_confirm.html");
  define('_PG_HTML_SELECT_FINISH_',   "pg_select_finish.html");
  define('_PG_HTML_SELECT_DETAIL_',   "pg_select_detail.html");


  define('_PG_TITLE_',                "| ユーザー管理：プランカスタム |");
  define('_PG_TITLE_RENEW_',          _PG_TITLE_." 修正 |");
  define('_PG_TITLE_RENEW_WRITE_',    _PG_TITLE_RENEW_." 入力 |");
  define('_PG_TITLE_RENEW_CONFIRM_',  _PG_TITLE_RENEW_." 入力確認 |");
  define('_PG_TITLE_RENEW_FINISH_',   _PG_TITLE_RENEW_." 入力完了 |");

  define('_PG_TITLE_SELECT_',          _PG_TITLE_." 修正 |");
  define('_PG_TITLE_SELECT_WRITE_',    _PG_TITLE_SELECT_." 選択 |");
  define('_PG_TITLE_SELECT_CONFIRM_',  _PG_TITLE_SELECT_." 選択確認 |");
  define('_PG_TITLE_SELECT_FINISH_',   _PG_TITLE_SELECT_." 選択完了 |");


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
