<?PHP
/*
  設定

*/
  // - SetUp[Mode]
  if( getenv("REMOTE_ADDR")=='221.246.192.14' ){
    define('_TEST_', False );
  }else{
    define('_TEST_', False );
  }

  define('_HTTPS_COERCION_', False);
  define('_DEBUG_',  1 );
  define('_MASTER_', False );

  define('_SESSION_MODE_', 'member' );
  define('_SESSION_NAME_', 'mail' );


  // - Load & Setup[Common]
  require_once('../program/cls/define/Setup.php');

  // - SetUp[Local]

  define('_PG_ROOT_',        _DIR_CLS_."login/");
  define('_PG_ROOT_COMMON_', _DIR_CLS_."login/common/");
  define('_PG_ROOT_THIS_',   _ABSOLUTE_._DIR_USER_."member/");
  define('_PG_ROOT_HTML_',   _PG_ROOT_THIS_);
  define('_PG_ROOT_MAIL_',   _PG_ROOT_."mail/");

  define('_PG_URL_',        _URL_._DIR_USER_."member/");
  define('_PG_URL_TOP_',    _PG_URL_."index.php");


  define('_PG_FILE_MAIN_',        "Main.php");
  define('_PG_FILE_CONTOROLLER_', "Controller.php");
  define('_PG_FILE_MANAGER_',     "Manager.php");
  define('_PG_FILE_VIEWER_',      "Viewer.php");
  define('_PG_FILE_LIBRARY_',     "Library.php");
  define('_PG_FILE_QUERY_',       "Query.php");

  define('_PG_HTML_TOP_',        "index_top.html");
  define('_PG_HTML_LOGOUT_',     "index_logout.html");
  define('_PG_HTML_ERROR_',      "index_error.html");

  define('_PG_TITLE_',          "ユーザー専用ページ |");
  define('_PG_TITLE_TOP_',      _PG_TITLE_." TOP |");
  define('_PG_TITLE_ERROR_',    _PG_TITLE_." エラー |");

  require_once(_DIR_LIB_.'util/Util.php') ;
  require_once(_DIR_LIB_.'util/Html.php') ;
  require_once(_DIR_LIB_.'util/ExHtml.php') ;
/*
  if (!$_SERVER['HTTPS']) {
      $_URL_MEMBER_ = str_replace("http://","https://",_URL_MEMBER_);
      header("location:".$_URL_MEMBER_);
      exit;
  }
*/
  if(isset($_POST)){
    foreach($_POST as $key=>$val){
      $postS[$key] = htmlspecialchars($val);
    }
    if(isset($postS['id'])){
      $_SESSION['user']['id'] = $postS['id'];
    }
    if(isset($postS['password'])){
      $_SESSION['user']['password'] = $postS['password'];
    }
  }

  if(isset($_GET['get'])){
    if( $_GET['get']=='logout' ){
      unset($_SESSION['user']);
      require_once(_PG_ROOT_HTML_._PG_HTML_LOGOUT_) ;
      exit;
    }
  }

  require_once(_DIR_LIB_.'user/Attest.php') ;
  new Attest();

  header("location:pictmail/");

  require_once(_PG_ROOT_HTML_._PG_HTML_TOP_) ;


exit;
?>
