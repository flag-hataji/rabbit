<?PHP
/*

  ユーザー専用ページ

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
  define("_DEBUG_",False);

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
  define('_HTML_PG_MENU_',   _ROOT_PG_HTML_.'menu.html' );
  define('_HTML_PG_LOGIN_',  _ROOT_PG_HTML_.'login.html' );
  define('_HTML_PG_ERROR_',  _ROOT_PG_HTML_.'error.html' );

  // Url
  define('_URL_PG_',         _URL_MEMBER_);
  define('_URL_PG_TOP_',     _URL_MEMBER_TOP_);
  define('_URL_PG_MENU_',    _URL_PG_TOP_.'?get=menu');
  define('_URL_PG_LOGIN_',   _URL_PG_TOP_.'?get=login');
  define('_URL_PG_LOGOUT_',  _URL_PG_TOP_.'?get=logout');
  define('_URL_PG_LIST_',    _URL_PG_TOP_.'?get=list');
  define('_URL_PG_NEW_',     _URL_PG_TOP_.'?get=new');
  define('_URL_PG_RENEW_',   _URL_PG_TOP_.'?get=renew');
  define('_URL_PG_REWRITE_', _URL_PG_TOP_.'?get=rewrite');
  define('_URL_PG_DELETE_',  _URL_PG_TOP_.'?get=delete');

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
  switch( $expDistribution->exe ){

    // ログイン
    case 'login':
      $pSession->login($_POST);
      $pSession->mode('top');
      $pSession->place('error');
      if( $pCheckSp->login() ){
        $pSession->place('menu');
      }else{
        $pSession->logout();
      }
      break;

    // ログアウト
    case 'logout':
      $pSession->format('top');
      $pSession->logout();
      $pSession->mode('top');
      $pSession->place('login');
      break;

    // 最初期
    default:
      if( $pCheckSp->login() ){
        $pSession->mode('top');
        $pSession->place('login');
        $pSession->place('menu');
      }else{
        $pSession->format('top');
        $pSession->mode('top');
        $pSession->place('login');
      }
  }
  $pOutput->html($_SESSION[_NAME_ ]['mode'], $_SESSION[_NAME_ ]['place']);

  // SHOW DEBUG
  $libDebug->arrayView($_SESSION[_NAME_],'$_SESSION[\''._NAME_.'\']',_DEBUG_);
  $libDebug->arrayView($_POST,'$_POST',_DEBUG_);
  $libDebug->arrayView($_GET, '$_GET',_DEBUG_);
  $libDebug->arrayView($pField->dbS, '$pField->dbS',_DEBUG_);
  $libDebug->defineView(_DEBUG_);

  exit;
?>
