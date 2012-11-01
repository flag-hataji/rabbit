<?PHP
/*
  �桼��������������

*/
  // - SetUp[Mode]
  if( getenv("REMOTE_ADDR")=='221.246.192.14' ){
    define('_HTTPS_COERCION_', False);
    define('_DEBUG_',  False );
    define('_TEST_',   False );
    define('_MASTER_', False );
    define('_ITM_',      True );
  }else{
    define('_HTTPS_COERCION_', False);
    define('_DEBUG_',  False );
    define('_TEST_',   False );
    define('_MASTER_', False );
    define('_ITM_',      False );
  }

  define('_SESSION_MODE_', 'member' );
  define('_SESSION_NAME_', 'mail' );


  // - Load & Setup[Common]
  require_once('../../../program/cls/define/Setup.php');
  require_once(_DIR_LIB_.'user/Attest.php') ;
  new Attest();

  // - SetUp[Local]
  define('_PG_ROOT_',        _DIR_CLS_."mail/user/");
  define('_PG_ROOT_COMMON_', _DIR_CLS_."mail/common/");
  define('_PG_ROOT_THIS_',   _ABSOLUTE_."member/pictmail/mail/");
  define('_PG_ROOT_HTML_',   _PG_ROOT_THIS_);
  define('_PG_ROOT_CSV_',    _PG_ROOT_."csv/");
  define('_PG_ROOT_DAT_',    _PG_ROOT_."dat/");
  define('_PG_ROOT_MAIL_',   _PG_ROOT_."mail/");

  define('_PG_URL_',        _URL_._DIR_ADMIN_."user/");
  define('_PG_URL_TOP_',    _PG_URL_."index.php");


  define('_PG_FILE_MAIN_',        "Main.php");
  define('_PG_FILE_CONTOROLLER_', "Controller.php");
  define('_PG_FILE_MANAGER_',     "Manager.php");
  define('_PG_FILE_VIEWER_',      "Viewer.php");
  define('_PG_FILE_LIBRARY_',     "Library.php");
  define('_PG_FILE_QUERY_',       "Query.php");
  define('_PG_FILE_FILEUP_',      "Fileup.php");
  define('_PG_FILE_SENDER_',      "Sender.php");
  define('_PG_FILE_TESTER_',      "Tester.php");

  define('_PG_HTML_LIST_PAGE_',    "pg_list_page.html");
  define('_PG_HTML_STOP_',         "pg_stop.html");
  define('_PG_HTML_WRITE_',        "pg_write.html");
  define('_PG_HTML_CONFIRM_',      "pg_confirm.html");
  define('_PG_HTML_FINISH_',       "pg_finish.html");
  define('_PG_HTML_DETAIL_',       "pg_detail.html");


  define('_PG_TITLE_',                "�᡼���ۿ��¹� ��");
  define('_PG_TITLE_STOP_',       _PG_TITLE_." �������");
  define('_PG_TITLE_WRITE_',      _PG_TITLE_." ����");
  define('_PG_TITLE_CONFIRM_',    _PG_TITLE_." ���ϳ�ǧ");
  define('_PG_TITLE_FINISH_',     _PG_TITLE_." ���ϴ�λ");

  define('_PG_MAIL_ERROR_',      "error-#user_id#@rabbit-mail.jp");

  define('_PG_MAIL_START_PC_',   "flag-pc_start-#log_id#@rabbit-mail.jp");
  define('_PG_MAIL_START_MO_',   "flag-mo_start-#log_id#@rabbit-mail.jp");

  define('_PG_MAIL_FINISH_PC_',  "flag-pc_finish-#log_id#@rabbit-mail.jp");
  define('_PG_MAIL_FINISH_MO_',  "flag-mo_finish-#log_id#@rabbit-mail.jp");

  define('_PG_DAT_MESSAGE_',     "message_#user_id#_#date#.dat");
  define('_PG_DAT_MESSAGE_HTML_',"html_message_#user_id#_#date#.dat");

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
