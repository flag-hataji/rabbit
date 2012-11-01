#!/usr/local/bin/php -q
<?PHP
/*
  pictmail送信回数自動更新
*/

  define("_TEST_", False );
  define("_DEBUG_",False );

  define("_ROOT_", "/var/www/vhosts/rabbit-mail.jp/html/");
//  define("_ROOT_", "/usr/local/apache/htdocs/");
//  define("_ROOT_", "/usr/local/apache/htdocs/mail_send/");


  define('_ROOT_COMMON_',       _ROOT_.'common/' );
  define('_ROOT_COMMON_EXP_',   _ROOT_COMMON_.'exp/' );

  define('_ROOT_LIB_',           _ROOT_.'lib/' );
  define('_ROOT_LIB_EXCEPTION_', _ROOT_LIB_.'exception/' );

  define('_ROOT_CLS_',          _ROOT_.'cls/' );
  define('_ROOT_CLS_MAIL_',     _ROOT_CLS_.'mail/' );

  require_once _ROOT_LIB_."Postgres.php";
  require_once _ROOT_LIB_."Mail.php";
  $utilPostgres = new Postgres();
  $utilMail     = new Mail();

  require_once _ROOT_COMMON_EXP_."ExpPostgres.php";
  $expPostgres = new ExpPostgres();



  $query  = "UPDATE td_pictmail SET ";
  $query .= " month_now=month_max,send_now=send_max WHERE plan_pictmail_id!=1 AND plan_pictmail_id!=7 ";

  $expPostgres->registQuery( $query );

  exit;
?>
