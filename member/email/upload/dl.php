<?PHP
/**
* メールアドレスアップロード
*
*  文字コード：EUC-JP
*
* @package email_group
* @author  itm
* @since   PHP5
* @version 2008.04.12
*/
  session_cache_limiter("public");
  header("Cache-Control: public");
  header("Pragma: public");

  require_once("../../../../itm/program/member/email/upload/Main.php");

  $__Main = new Main();

  $__Main->setMain();

  exit;
?>
