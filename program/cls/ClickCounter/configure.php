<?php

  switch($_SERVER['SERVER_NAME']){
   case 'www.itm-asp.com' :
   case 'itm-asp.com' :
    ini_set("display_errors","1");
    define("DEBUG","true");
    define("ROOT_PATH","/var/www/html/program");
    define("SESSION_KEY_NAME","clickcounter");
    define("DB_CONNECT","host=localhost port=5432 dbname=itm-asp user=pgsql");// ����
    break ;
   default :
    ini_set("display_errors","1");
    define("DEBUG","true");
    define("ROOT_PATH","/var/www/vhosts/test.itm-asp.com/html/program");
    define("SESSION_KEY_NAME","clickcounter");
    define("DB_CONNECT","host=localhost port=5432 dbname=itm-asp_test user=pgsql");// ����
  }

  define("PHP_PATH" ,ROOT_PATH . "/cls/ClickCounter");
  define("CLS_PATH" ,ROOT_PATH . "/cls");
  define("LIB_PATH" ,ROOT_PATH . "/lib");

  // ����
  require_once CLS_PATH . '/define/Setup.php';

  define("LOG_FLAG",false);

  if($_SESSION['user']['flag_cc'] == 't'){
    define(CLICK_COUNTER_LIMIT,"10000") ;
  }else{
    define(CLICK_COUNTER_LIMIT,"10") ;
  }

  if(!defined("FLAG_FREE")){
    define("FLAG_FREE",false);
  }

  // free�łƂ̐؂蕪�� - �L���ł͔F�� - Setup.php �̒��ł��Ă���Ă�̂ŃR�����g�A�E�g 2007.02.28
//  if(! FLAG_FREE ){
//    require_once(LIB_PATH.'/user/Attest.php') ;
//    new Attest();
//  }
  $db = pg_connect(DB_CONNECT) ;

  // �萔MY_URL�̐ݒ�
  if(! FLAG_FREE ){
    if( isset($_SESSION[SESSION_KEY_NAME]['my_url']) ){
      define(MY_URL,$_SESSION[SESSION_KEY_NAME]['my_url']);
    }else{
      $query = "SELECT change_url, setting_url FROM td_cc_user WHERE user_id = ".pg_escape_string($_SESSION['user']['user_id'])." AND delete_flag='f' AND change_flag='t'";
      $result = pg_query($db, $query);
      if(pg_num_rows($result) > 0){
        list($my_url, $setting_url) = pg_fetch_array($result,0);
        pg_free_result($result);
      }else{
        $my_url = "http://itm-asp.com/cc/";
        $setting_url = "http://itm-asp.com/";
      }
      define(MY_URL, $my_url);
      define(SETTING_URL, $setting_url);
      $_SESSION[SESSION_KEY_NAME]['my_url'] = $my_url ;
      $_SESSION[SESSION_KEY_NAME]['setting_url'] = $setting_url ;
    }
  }else{
    $my_url = "http://itm-asp.com/cc/";
    $setting_url = "http://itm-asp.com/";
    define(MY_URL, $my_url);
    define(SETTING_URL, $setting_url);
  }

?>