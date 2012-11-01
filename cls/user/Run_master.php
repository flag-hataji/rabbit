<?PHP
/*

  ユーザーマスター管理

*/


  // LOAD:Common Setting
  require_once '../../common/define/setup.php';

  // SetUp
  require_once '../../cls/user/Setup.php';

  if( _DOMAIN_=='192.168.1.210' ){
    define("_TEST_", True );
  }else{
    define("_TEST_", False );
  }
  define("_DEBUG_",False );

  // SET:PG Setting
  // name
  define('_NAME_', 'master' );

  define('_LIST_MAX_', 20 );

  if( _TEST_ ){
    define('_NAME_FROM_',  '[TEST]ITM担当者');
    define('_NAME_TO_',    '[TEST]ITM担当者');
    define('_MAIL_FROM_',  'masaki@itm.ne.jp');
    define('_MAIL_TO_',    'masaki@itm.ne.jp');
    define('_MAIL_ERROR_', 'masaki@itm.ne.jp');
  }else{
    define('_NAME_FROM_',  'ITM担当者');
    define('_NAME_TO_',    'ITM担当者');
    define('_MAIL_FROM_',  'masaki@pictsys.com');
    define('_MAIL_TO_',    'masaki@pictsys.com');
    define('_MAIL_ERROR_', 'masaki@pictsys.com');
  }

  // Root
  define('_ROOT_PG_',      _ROOT_CLS_USER_);
  define('_ROOT_PG_HTML_', _ROOT_ITM_USER_);
  define('_ROOT_PG_DAT_',  _ROOT_CLS_USER_);

  // Html
  define('_HTML_PG_BASE_',    _ROOT_PG_HTML_.'base.html' );
  define('_HTML_PG_MENU_',    _ROOT_PG_HTML_.'menu.html' );
  define('_HTML_PG_LIST_',    _ROOT_PG_HTML_.'list.html' );
  define('_HTML_PG_LIST_MAIL_',    _ROOT_PG_HTML_.'list_mail.html' );
  define('_HTML_PG_LIST_MAIL_TEMP_',    _ROOT_PG_HTML_.'list_mail_temp.html' );
  define('_HTML_PG_WRITE_',   _ROOT_PG_HTML_.'write.html' );
  define('_HTML_PG_CONFIRM_', _ROOT_PG_HTML_.'confirm.html' );
  define('_HTML_PG_FINISH_',  _ROOT_PG_HTML_.'finish.html' );

  // Url
  define('_URL_PG_',         _URL_ITM_USER_);
  define('_URL_PG_TOP_',     _URL_ITM_USER_TOP_ );
  define('_URL_PG_LIST_',    _URL_PG_TOP_.'?get=list');
  define('_URL_PG_NEW_',     _URL_PG_TOP_.'?get=new');
  define('_URL_PG_RENEW_',   _URL_PG_TOP_.'?get=renew');
  define('_URL_PG_REWRITE_', _URL_PG_TOP_.'?get=rewrite');
  define('_URL_PG_DELETE_',  _URL_PG_TOP_.'?get=delete');
  define('_URL_PG_PLAN_',    _URL_ITM_PLAN_TOP_);
  define('_URL_PG_PAY_',     _URL_ITM_PAY_TOP_);

  define('_URL_PG_PERMISSION1_',  _URL_PG_TOP_.'?get=permission&flag_permission=1');
  define('_URL_PG_PERMISSION2_',  _URL_PG_TOP_.'?get=permission&flag_permission=2');

  // Image
  define('_IMAGE_PG_', _URL_PG_.'image/');


  // LOAD:PARTS
  require_once _ROOT_PG_.'Session.php';
  require_once _ROOT_PG_.'Field.php';
  require_once _ROOT_PG_.'Variable.php';
  require_once _ROOT_PG_.'OutputMaster.php';
  require_once _ROOT_PG_.'Query.php';
  require_once _ROOT_PG_.'CheckSp.php';
  require_once _ROOT_PG_.'Send.php';


  // SET:PARTS
  $pSession  = new Session(_NAME_,_DEBUG_);
  $pField    = new Field(_DEBUG_,_TEST_);
  $pVariable = new Variable(_DEBUG_);
  $pOutput   = new OutputMaster(_HTML_PG_BASE_,'EUC-JP',_LIST_MAX_,_DEBUG_);
  $pQuery    = new Query(_DEBUG_);
  $pCheckSp  = new CheckSp(_DEBUG_);
  $pSend     = new Send(_DEBUG_);


  // Output
  switch( $expDistribution->exe ){


    // 削除
    case 'delete':
      $expPostgres->registQuery( $pQuery->delete_td_pictmail($_GET['user_id']) );
      $pSession->mode('list');
      $pSession->place('list');
      $pSession->lists();
      $pVariable->listS();
      break;

    // 許可/不可
    case 'permission':
      $query = "UPDATE td_pictmail SET flag_permission={$_GET['flag_permission']} ";

      if($_GET['flag_permission']==1){
        $query .= ", send_now=send_max ";
      }else if($_GET['flag_permission']==2){
        $query .= ", send_now=0 ";
      }

      $query .= "WHERE user_id={$_GET['user_id']} ";

      $expPostgres->registQuery( $query );
      $pSession->mode('list');
      $pSession->place('list');
      $pSession->lists();
      $pVariable->listS();
      break;

    // 新規登録
    case 'new':
      $pSession->mode('new');
      $pSession->place('write');
      $pVariable->write();
      break;

    // 修正登録
    case 'renew':
      $pSession->mode('renew');
      $pSession->place('write');
      $pVariable->renew($_GET['user_id']);
      break;

    // 確認
    case 'confirm':
      $pSession->place('confirm');
      if( $pVariable->confirm($_POST) ){
        $pSession->place('error');
      }
      break;

    // 再入力
    case 'rewrite':
      $pSession->place('write');
      $pVariable->rewrite($_POST);
      break;

    // 終了
    case 'finish':
      if( $_SESSION[_NAME_]['place']!='finish' ){
        $pSession->place('finish');
        $pVariable->finish($_POST,$_SESSION[_NAME_ ]['mode']);
        switch($_SESSION[_NAME_ ]['mode']){
          case   'new': $expPostgres->registQuery( $pQuery->insert_td_user() ); break;
          case 'renew': $expPostgres->registQuery( $pQuery->update_td_user() ); break;
        }
      }
      break;

    // リスト
    case 'list':
      $pSession->format();
      $pSession->mode('list');
      $pSession->place('list');
      $pSession->lists();
      $pVariable->listS();
      break;

    // リスト
    case 'list_mail':
      $pSession->format();
      $pSession->mode('list');
      $pSession->place('list_mail');
      $pSession->lists();
      $pVariable->listS();
      break;

    // リスト
    case 'list_mail_temp':
      $pSession->format();
      $pSession->mode('list');
      $pSession->place('list_mail_temp');
      $pSession->lists();
      $pVariable->listS();
      break;

    // 最初期(リスト)
    default:
      $pSession->format();
      $pSession->mode('list');
      $pSession->place('list');
      $pSession->lists();
      $pVariable->listS();
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
