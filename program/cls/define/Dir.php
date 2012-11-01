<?PHP

/*
   * ディレクトリ設定
   * 文字コード判定：EUC
*/


  define('_DIR_IMAGES_', 'images/'  );
  define('_DIR_CSS_',    'css/'  );

  // * Data
  define('_DIR_DAT_', ' dat/' );
  define('_DIR_HTML_', 'html/' );
  define('_DIR_CSV_', ' csv/' );

  define('_DIR_ADMIN_',      'itm/' );
  define('_DIR_ADMIN_HTML_', _DIR_PROGRAM_.'html/' );
  define('_DIR_ADMIN_USER_', _DIR_ADMIN_.'user/' );
  define('_DIR_ADMIN_PLAN_', _DIR_ADMIN_.'plan/' );
  define('_DIR_ADMIN_NEWS_', _DIR_ADMIN_.'news/' );

  define('_DIR_USER_',  '');
  define('_DIR_USER_HTML_',    _DIR_PROGRAM_.'html/' );
  define('_DIR_USER_SIGNUP_',  _DIR_USER_.'sign_up/' );
  define('_DIR_USER_NEWS_',    _DIR_USER_.'news/' );
  define('_DIR_USER_INQUIRY_', _DIR_USER_.'inquiry/' );

  define('_DIR_MEMBER_',         'member/' );
  define('_DIR_MEMBER_HTML_',    _DIR_PROGRAM_.'html/member/' );


  define('_DIR_MEMBER_USER_',       _DIR_MEMBER_.'user/' );
  define('_DIR_MEMBER_USER_RENEW_', _DIR_MEMBER_USER_.'renew/' );

  define('_DIR_MEMBER_PICTMAIL_',             _DIR_MEMBER_.'pictmail/' );
  define('_DIR_MEMBER_PICTMAIL_PLAN_',        _DIR_MEMBER_PICTMAIL_.'plan/' );
  define('_DIR_MEMBER_PICTMAIL_PLAN_RENEW_',  _DIR_MEMBER_PICTMAIL_PLAN_.'renew/' );


/*
  $isPositionSelf = $_SERVER['PHP_SELF'];
  $isPositionNum1 = (strpos($isPositionSelf,"/",2)-1);
  $isPosition1    = substr($isPositionSelf,1,$isPositionNum1);
  define("_DIR_IS_POSITION1_", $isPosition1 );
*/

  $isPositionSelf = $_SERVER['PHP_SELF'];
  $isSelfS = explode("/",substr($isPositionSelf,1,strrpos($isPositionSelf,"/")));
  foreach($isSelfS as $key=>$val ){
    $key = $key+1;
    $name = "_DIR_IS_POSITION{$key}_";
    define($name, $val );
  }

?>
