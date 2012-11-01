#!/usr/local/bin/php -q
<?PHP
/*
  pictmail送信回数自動更新
*/

  define("_TEST_", False );
  define("_DEBUG_",False );

  define("_ROOT_", "/var/www/vhosts/www.rabbit-mail.jp/html/");
//  define("_ROOT_", "/usr/local/apache/htdocs/");
//  define("_ROOT_", "/usr/local/apache/htdocs/mail_send/");


  define('_ROOT_PROGRAM_',    _ROOT_.'program/' );
  define('_ROOT_LIB_',        _ROOT_PROGRAM_.'lib/' );
  define('_ROOT_CLS_',        _ROOT_PROGRAM_.'cls/' );
  define('_ROOT_DEFINE_',     _ROOT_CLS_.'define/' );



  require_once(_ROOT_DEFINE_."Db.php");
  require_once( _ROOT_LIB_."db/Postgres.php");
  require_once( _ROOT_LIB_."db/ExPostgres.php");


//exit;
  $ExPostgres = new ExPostgres(_DB_NAME_,_DB_USER_,_DB_HOST_,_DB_PORT_);

  $query  = "UPDATE td_pictmail SET ";
  $query .= " month_now=month_max,send_now=send_max ";
  $query .= " WHERE plan_pictmail_id!=1 ";
  $query .= " AND plan_pictmail_id!=7 "; // 3000円プラン
  $query .= " AND plan_pictmail_id!=10 "; // 3000円プラン
  $query .= " AND plan_pictmail_id!=11 "; // 3000円プラン

  $ExPostgres->registQuery($query);
  $ExPostgres->close();

exit;
?>
