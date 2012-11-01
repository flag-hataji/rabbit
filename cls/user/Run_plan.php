<?PHP
/*

  ユーザー仮登録

*/


  // LOAD:Common Setting
  require_once '../../common/define/setup.php';

  // LOAD:PG Setting
  require_once '../../cls/user/Setup.php';

  define("_TEST_", False );
  define("_DEBUG_",False );

  // SET:PG Setting
  // name
  define('_NAME_', 'plan' );

  define('_LIST_MAX_', 20 );

  if( _TEST_ ){
    define('_NAME_FROM_',  '[TEST]itm-asp');
    define('_NAME_TO_',    '[TEST]itm-asp');
    define('_MAIL_FROM_',  'masaki@pictnotes.jp');
    define('_MAIL_TO_',    'masaki@pictnotes.jp');
    define('_MAIL_ERROR_', 'masaki@pictnotes.jp');
  }else{
    define('_NAME_FROM_',  'itm-asp');
    define('_NAME_TO_',    'itm-asp');
    define('_MAIL_FROM_',  'info@itm-asp.com');
    define('_MAIL_TO_',    'info@itm-asp.com');
    define('_MAIL_ERROR_', 'info@itm-asp.com');
  }

  // Root
  define('_ROOT_PG_',      _ROOT_CLS_USER_);
  define('_ROOT_PG_HTML_', _ROOT_MEMBER_.'plan/');
//  define('_ROOT_PG_HTML_',  _ROOT_PG_);
  define('_ROOT_PG_DAT_',  _ROOT_CLS_USER_);

  // Html
  define('_HTML_PG_BASE_',    _ROOT_PG_HTML_.'base.html' );
  define('_HTML_PG_MENU_',    _ROOT_PG_HTML_.'menu.html' );
  define('_HTML_PG_WRITE_',   _ROOT_PG_HTML_.'write.html' );
  define('_HTML_PG_CONFIRM_', _ROOT_PG_HTML_.'confirm.html' );
  define('_HTML_PG_FINISH_',  _ROOT_PG_HTML_.'finish.html' );

  // Url
  define('_URL_PG_',         _URL_MEMBER_PLAN_);
  define('_URL_PG_TOP_',     _URL_MEMBER_PLAN_TOP_);
  define('_URL_PG_NEW_',     _URL_PG_TOP_.'?get=new');
  define('_URL_PG_RENEW_',   _URL_PG_TOP_.'?get=renew');
  define('_URL_PG_REWRITE_', _URL_PG_TOP_.'?get=rewrite');
  define('_URL_PG_DELETE_',  _URL_PG_TOP_.'?get=delete');

  // Image
  define('_IMAGE_PG_', _URL_PG_.'image/');

  // File
  define('_FILE_MAIL_TO_USER_A_', 'MailToUserPlanA.dat');
  define('_FILE_MAIL_TO_USER_B_', 'MailToUserPlanB.dat');
  define('_FILE_MAIL_TO_MASTER_', 'MailToMasterPlan.dat');


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

  if( isset($_POST['next']) && $_POST['next']!="" ){
    $mode = key($_POST['next']);
  }else{
    $mode = "write";
  }


  $error = "";
  $plan_id = "";
  $auto_money = "f";
  switch( $mode ){

    // 確認
    case 'confirm':
      $pSession->place('confirm');

      $html = _HTML_PG_CONFIRM_;
      if( isset($_POST['inputS']['plan_id']) ){
        $plan_id = $_POST['inputS']['plan_id'];

        $query  = "SELECT * FROM td_pictmail WHERE plan_pictmail_id={$plan_id} AND user_id={$_SESSION['user']['user_id']}";
        $uDataS = $expPostgres->getOne( $query,PGSQL_ASSOC );
        if($uDataS){
          $error = "既にそのプランでご利用いただいております。";
          $html = _HTML_PG_WRITE_;
        }
      }else{
        $error = "プランを選択してください。";
        $html = _HTML_PG_WRITE_;
      }
      if( isset($_POST['inputS']['auto_money']) ){
        $auto_money=$_POST['inputS']['auto_money'];
      }
      break;

    // 再入力
    case 'rewrite':
      $plan_id = $_POST['inputS']['plan_id'];
      if( isset($_POST['inputS']['auto_money']) ){
        $auto_money=$_POST['inputS']['auto_money'];
      }
      $html = _HTML_PG_WRITE_;
      break;

    // 終了
    case 'finish':
      //if( $_SESSION[_NAME_]['place']!='finish' ){
        $pSession->place('finish');
        $pVariable->finish($_POST,'replan');

        // 新規->プランアップ
        if( $_SESSION['user']['plan_pictmail_id']==1 ){
          $fileMailToUser = _FILE_MAIL_TO_USER_A_;
        }else{
          $fileMailToUser = _FILE_MAIL_TO_USER_B_;
        }

        $pSend->plan( $_POST['inputS']['plan_id'],_ROOT_PG_DAT_.$fileMailToUser,_ROOT_PG_DAT_._FILE_MAIL_TO_MASTER_ );
      //}
      $html = _HTML_PG_FINISH_;
      break;

    // 最初期(入力)
    default:
      $html = _HTML_PG_WRITE_;
  }

  require_once(_HTML_PG_BASE_);



  // SHOW DEBUG
  //$libDebug->arrayView($_SESSION[_NAME_],'$_SESSION[\''._NAME_.'\']',_DEBUG_);
  $libDebug->arrayView($_POST,'$_POST',_DEBUG_);
  $libDebug->arrayView($_GET, '$_GET',_DEBUG_);
  $libDebug->arrayView($pField->dbS, '$pField->dbS',_DEBUG_);
  $libDebug->defineView(_DEBUG_);

  exit;
?>
