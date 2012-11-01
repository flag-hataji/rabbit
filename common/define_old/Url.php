<?PHP
/*
   * URLÀßÄê
*/


  // URL
  define('_URL_TOP_', _URL_.'index.php');

  define('_URL_IMAGES_', _URL_.'images/'  );
  define('_URL_CSS_',    _URL_.'css/'  );

  define('_URL_COMMON_',       _URL_.'common/'  );
  define('_URL_COMMON_HTML_',  _URL_COMMON_.'html/'  );

  // Master
  define('_URL_MASTER_',     _URL_.'master/'  );
  define('_URL_MASTER_TOP_', _URL_MASTER_.'index.php');

  // Member
  define('_URL_MEMBER_',      _URL_.'member/'  );
  define('_URL_MEMBER_TOP_',  _URL_MEMBER_.'index.php');

  define('_URL_MEMBER_MAIL_',     _URL_MEMBER_.'mail/'  );
  define('_URL_MEMBER_MAIL_TOP_', _URL_MEMBER_MAIL_.'index.php');

  define('_URL_MEMBER_PLAN_',     _URL_MEMBER_.'plan/'  );
  define('_URL_MEMBER_PLAN_TOP_', _URL_MEMBER_PLAN_.'index.php');

  define('_URL_MEMBER_USER_',     _URL_MEMBER_.'user/'  );
  define('_URL_MEMBER_USER_TOP_', _URL_MEMBER_USER_.'index.php');

  define('_URL_ITM_',          _URL_.'itm/' );
  define('_URL_ITM_TOP_',      _URL_ITM_.'index.php' );
  define('_URL_ITM_USER_',     _URL_ITM_.'user/' );
  define('_URL_ITM_USER_TOP_',_URL_ITM_USER_.'index.php' );

  define('_URL_ITM_PLAN_',    _URL_ITM_.'plan/' );
  define('_URL_ITM_PLAN_TOP_',_URL_ITM_PLAN_.'index.php' );

  define('_URL_ITM_PAY_',    _URL_ITM_.'pay/' );
  define('_URL_ITM_PAY_TOP_',_URL_ITM_PAY_.'index.php' );


  define("_URL_MEMBER_STEP_PLAN_",     _URL_MEMBER_."step_plan/"  );
  define("_URL_MEMBER_STEP_PLAN_TOP_", _URL_MEMBER_STEP_PLAN_."index.php");



  $dirNum = substr_count(str_replace(_ROOT_,"",$_SERVER['SCRIPT_FILENAME']),"/");
  $i=1;
  $dirPlace = "";
  while($dirNum>=$i){
    $dirPlace .= "../";
    $i++;
  }

  define("_URL_COMMON_IMAGE_", "{$dirPlace}common/image/"  );


?>
