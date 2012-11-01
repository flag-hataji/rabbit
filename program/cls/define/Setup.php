<?PHP
/*
   * 基本設定
   * 文字コード判定：EUC
*/

new Setup();

class Setup {

  function Setup(){

    //IEにてCSVダウンロードの際にエラーが出るので追加 2007/3/8 hataji

    session_start();
    ini_set("display_errors",1);

    // SSL
    define('_HTTP_','http://');

/*
    if( isset($_SERVER['HTTPS']) || (defined("_HTTPS_COERCION_") && _HTTPS_COERCION_) ){
      define('_HTTP_','https://');
    }else{
      define('_HTTP_','http://');
    }
*/
    // Domain
    define('_DOMAIN_',     $_SERVER['HTTP_HOST'] );

    // ドキュメントルート・プログラムルート
    // - 絶対パス _ABSOLUTE_
    // - 相対パス _RELATIVE_
  /*
    if(_DOMAIN_=='test.itm-asp.com' ){
      define('_POSITION_', '');
    }else{
      define('_POSITION_', '/');
    }
  */
    define('_POSITION_', '/');

    define('_ABSOLUTE_',  $_SERVER['DOCUMENT_ROOT']._POSITION_ );

    $i=1; 
    $dirPlace = "";
    while( substr_count(str_replace(_ABSOLUTE_, "", $_SERVER['SCRIPT_FILENAME']), "/")>=$i ){
      $dirPlace .= "../";
      $i++;
    }
    define('_RELATIVE_',  $dirPlace );

    // ディレクトリ
    define('_DIR_PROGRAM_',    _ABSOLUTE_.'program/' );
    define('_DIR_LIB_',        _DIR_PROGRAM_.'lib/' );
    define('_DIR_COMMON_',     _DIR_PROGRAM_.'common/' );
    define('_DIR_CLS_',        _DIR_PROGRAM_.'cls/' );
    define('_DIR_CLS_DEFINE_', _DIR_CLS_.'define/' );
    define('_DIR_TEMPLATE_',   _DIR_PROGRAM_.'template/' );
    require_once _DIR_CLS_DEFINE_."Dir.php";

    //Root
    require_once _DIR_CLS_DEFINE_."Root.php";

    // DB
    require_once _DIR_CLS_DEFINE_."Db.php";

    // HTML
    require_once _DIR_CLS_DEFINE_."Html.php";

    // File
    require_once _DIR_CLS_DEFINE_."File.php";

    // URL
    define('_URL_', _HTTP_._DOMAIN_._POSITION_  );
    if(_DOMAIN_=='test.itm-asp.com' ){
      define('_SURL_',"http://"._DOMAIN_._POSITION_  );
    }else{
      define('_SURL_',"https://"._DOMAIN_._POSITION_  );
    }
    require_once _DIR_CLS_DEFINE_."Url.php";

    // MAIL
    define('_MAIL_SU_',  'masaki@itm.ne.jp' );
    require_once _DIR_CLS_DEFINE_."Mail.php";

    // Cookie発行
    require_once(_DIR_LIB_."cookie/Cookie.php");
    $Cookie = new Cookie();

    if( isset($_GET['medium_id']) && is_numeric($_GET['medium_id']) ){
      $cookieS['referer']   = "";
      $cookieS['medium_id'] = "";
      $Cookie->dropCookie("sign_up",$cookieS);
    }
    if( !isset($_COOKIE['sign_up']) || (isset($_GET['medium_id']) && is_numeric($_GET['medium_id'])) ){
      if(isset($_SERVER['HTTP_REFERER'])){
        $cookieS['referer']   = $_SERVER['HTTP_REFERER'];
      }else{
        $cookieS['referer']   = "";
      }
      $cookieS['medium_id'] = "";
      if( isset($_GET['medium_id']) && is_numeric($_GET['medium_id']) ){
        $cookieS['medium_id'] = $_GET['medium_id'];
      }
      $Cookie->setCookie("sign_up",$cookieS);
    }

    define("_ACCESS_COUNT_NAME_", str_replace("/","__",$_SERVER['PHP_SELF']));

    if( _DIR_IS_POSITION1_=="member"){
      require_once(_DIR_LIB_.'user/Attest.php') ;
      new Attest();
    }

  }
}
?>
