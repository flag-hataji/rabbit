<?PHP
/*

  ¥æ¡¼¥¶¡¼²¾ÅÐÏ¿

*/

  // LOAD:Common Setting
  require_once '../common/define/setup.php';

  // LOAD:PG Setting
  require_once '../cls/user/Setup.php';

  if( $_SERVER['REMOTE_ADDR']=='221.246.192.14' ){
    define("_TEST_", True );
  }else{
    define("_TEST_", False );
  }
  define("_DEBUG_",False );

  // SET:PG Setting
  // name
  define('_NAME_', 'sign_up' );

  define('_LIST_MAX_', 20 );

  if( _TEST_ ){
    define('_NAME_FROM_',  '[TEST]¤ªµÒÍÍÅÐÏ¿Ã´Åö¼Ô');
    define('_NAME_TO_',    '[TEST]¤ªµÒÍÍÅÐÏ¿Ã´Åö¼Ô');
    define('_MAIL_FROM_',  'masaki@itm.ne.jp');
    define('_MAIL_TO_',    'masaki@itm.ne.jp');
    define('_MAIL_ERROR_', 'masaki@itm.ne.jp');
  }else{
    define('_NAME_FROM_',  'itm-asp.com');
    define('_NAME_TO_',    'itm-asp.com');
    define('_MAIL_FROM_',  'info@itm-asp.com');
    define('_MAIL_TO_',    'info@itm-asp.com');
    define('_MAIL_ERROR_', 'info@itm-asp.com');
  }

  // Root
  define('_ROOT_PG_',      _ROOT_CLS_USER_);
  define('_ROOT_PG_HTML_', _ROOT_._NAME_.'/');
  define('_ROOT_PG_DAT_',  _ROOT_CLS_USER_);

  // Html
  define('_HTML_PG_BASE_',    _ROOT_PG_HTML_.'base.html' );
  define('_HTML_PG_MENU_',    _ROOT_PG_HTML_.'menu.html' );
  define('_HTML_PG_WRITE_',   _ROOT_PG_HTML_.'write.html' );
  define('_HTML_PG_CONFIRM_', _ROOT_PG_HTML_.'confirm.html' );
  define('_HTML_PG_FINISH_',  _ROOT_PG_HTML_.'finish.html' );

  // Url
  define('_URL_PG_',         _URL_MEMBER_MAIL_);
  define('_URL_PG_TOP_',     _URL_MEMBER_MAIL_TOP_);
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

  // File
  define('_FILE_MAIL_TO_USER_',  'MailToUser.dat');
  define('_FILE_MAIL_TO_MASTER_','MailToMaster.dat');


  if( !isset($_SERVER['HTTPS']) ){
    header("location:https://".$_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI'] );
  }

  // Output
  switch( $expDistribution->exe ){

    // ³ÎÇ§
    case 'confirm':
      $pSession->place('confirm');
      if( $pVariable->confirm($_POST) ){
        $pSession->place('error');
      }
      break;

    // ºÆÆþÎÏ
    case 'rewrite':
      $pSession->place('write');
      $pVariable->rewrite($_POST);
      break;

    // ½ªÎ»
    case 'finish':
      if( $_SESSION[_NAME_]['place']!='finish' ){
        $pSession->place('finish');
        $pVariable->finish($_POST,$_SESSION[_NAME_ ]['mode']);
        $expPostgres->registQuery( $pQuery->sign_up() );
        $pSend->sign_up(_ROOT_PG_DAT_._FILE_MAIL_TO_USER_,_ROOT_PG_DAT_._FILE_MAIL_TO_MASTER_);
      }
      break;

    // ºÇ½é´ü(ÆþÎÏ)
    default:
      $pSession->format();
      $pSession->mode('new');
      $pSession->place('write');
      $pVariable->write();
  }

  $pOutput->html($_SESSION[_NAME_ ]['mode'], $_SESSION[_NAME_ ]['place']);

  // SHOW DEBUG
  $libDebug->arrayView($_SESSION[_NAME_],'$_SESSION[\''._NAME_.'\']',_DEBUG_);
  $libDebug->arrayView($_POST,'$_POST',_DEBUG_);
  $libDebug->arrayView($_GET, '$_GET',_DEBUG_);
  $libDebug->arrayView($pVariable->inputS, '$pVariable->inputS',_DEBUG_);
  $libDebug->arrayView($pVariable->writeS, '$pVariable->writeS',_DEBUG_);
  $libDebug->arrayView($pVariable->viewS,  '$pVariable->viewS',_DEBUG_);
  $libDebug->arrayView($pField->dbS, '$pField->dbS',_DEBUG_);
  $libDebug->defineView(_DEBUG_);

  exit;
?>
