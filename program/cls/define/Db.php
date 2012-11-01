<?PHP
/*
   * DB設定
   * 文字コード判定：EUC
*/

  define('_DB_NAME_','rabbit-mail');
  define('_DB_USER_','postgres');
  define('_DB_HOST_','localhost');
  define('_DB_PORT_','5432');

  define("_DB_DSN_", "pgsql://"._DB_USER_.":@"._DB_HOST_.":"._DB_PORT_."/"._DB_NAME_);	// DB接続

?>