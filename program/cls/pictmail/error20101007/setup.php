<?PHP
/*
  エラー情報表示
*/

	// SetUp
	require_once (_DIR_LIB_.'convert/Convert.php');
	require_once (_DIR_LIB_.'mail/Mail.php');
	require_once (_DIR_LIB_.'check/Check.php');
	//本番
	//require_once ('../../lib/Postgres.php');
	//test
	require_once (_DIR_LIB_.'db/Postgres.php');

	//require_once ('../../cls/test/user_list/mail.php');
	require_once (_DIR_CLS_.'pictmail/error/Debug.php');
	//require_once ('../../program/cls/error/dataCheck.php');
	//require_once ('../../cls/test/user_list/ListKen.php');
	//require_once ('../../cls/test/user_list/ListDate.php');
	//require_once ('../../program/cls/error/postgres.php');


	//$cMail       = new Mail();
	//$cCheck      = new Check();
	$cDebug      = new clsDebug();
	//$libConvert  = new Convert();
	//$cKen        = new ListKen();
	//$cDate       = new ListDate();
	$cPostgres         = new Postgres();

?>