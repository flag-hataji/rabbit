<?PHP
/*
   * 基本設定

*/
  session_start();

  // Domain
  define('_DOMAIN_',     $_SERVER['HTTP_HOST'] );
  define('_DOMAIN_SSL_', False );


  // SSL Check
  define('_HTTP_','https://');

//  define('_POSITION_', '/mail_send/');
  define('_POSITION_', '/');

  // ROOT
  define('_ROOT_',     $_SERVER['DOCUMENT_ROOT']._POSITION_ );
  define('_ROOT_COMMON_',        _ROOT_.'common/' );
  define('_ROOT_COMMON_DEFINE_', _ROOT_COMMON_.'define/' );
  define('_ROOT_COMMON_EXP_',    _ROOT_COMMON_.'exp/' );
  define('_ROOT_COMMON_MASTER_', _ROOT_COMMON_.'master/' );
  define('_ROOT_COMMON_HTML_',   _ROOT_COMMON_.'html/' );
  define('_ROOT_LIB_',           _ROOT_.'lib/' );
  define('_ROOT_LIB_EXCEPTION_', _ROOT_LIB_.'exception/' );
  define('_ROOT_ITM_', _ROOT_.'itm/' );
  define('_ROOT_DAT_', _ROOT_.'dat/' );
  define('_ROOT_CLS_', _ROOT_.'cls/' );
  require_once _ROOT_COMMON_DEFINE_."/Root.php";

  // HTML
  require_once _ROOT_COMMON_DEFINE_."Html.php";

  // URL
  define('_P_URL_', "http://"._DOMAIN_._POSITION_  );
  define('_S_URL_', "https://"._DOMAIN_._POSITION_  );
  define('_URL_', _HTTP_._DOMAIN_._POSITION_  );
  require_once _ROOT_COMMON_DEFINE_."Url.php";

  // MAIL
  require_once _ROOT_COMMON_DEFINE_."Mail.php";


?>
