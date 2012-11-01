<?PHP
/*
  LIST情報setup.php
*/

	// SetUp
	require_once ('../../lib/Convert.php');
	require_once ('../../lib/Mail.php');
	require_once ('../../lib/Check.php');
	//本番
	//require_once ('../../lib/Postgres.php');
	//test
	require_once ('../../../vhosts/test.itm-asp.com/html/lib/Postgres.php');

	//require_once ('../../cls/test/user_list/mail.php');
	require_once ('../../cls/test/user_list/Debug.php');
	require_once ('../../cls/test/user_list/dataCheck.php');
	//require_once ('../../cls/test/user_list/ListKen.php');
	//require_once ('../../cls/test/user_list/ListDate.php');
	require_once ('../../cls/test/user_list/postgres.php');


	//$cMail       = new Mail();
	$cCheck      = new Check();
	$cDebug      = new clsDebug();
	//$libConvert  = new Convert();
	//$cKen        = new ListKen();
	//$cDate       = new ListDate();
	$cPostgres         = new Postgres();

?>