<?PHP
/*
  setup.php
*/

	// LOAD:Common Setting
	//require_once ('../../../common/define/setup.php');

	// SetUp
	require_once ('../../lib/Convert.php');
	require_once ('../../lib/Mail.php');
	require_once ('../../lib/Check.php');
	require_once ('../../cls/test/mailsend/mail.php');
	require_once ('../../cls/test/mailsend/Debug.php');
	require_once ('../../cls/test/mailsend/dataCheck.php');
	require_once ('../../cls/test/mailsend/postgres.php');
	//require_once ('../cls/test_mailsend/ListKen.php');
	//require_once ('../cls/test_mailsend/ListDate.php');

	//本番
	//require_once ('../../lib/Postgres.php');
	//test
	require_once ('../../../vhosts/test.itm-asp.com/html/lib/Postgres.php');



	$cMail       = new Mail();
	$cCheck      = new Check();
	$cDebug      = new clsDebug();
	$libConvert  = new Convert();
	//$cKen        = new ListKen();
	//$cDate       = new ListDate();
	$cPostgres   = new Postgres();


	//テストデータ
	$dData['subject']   = "";
	$dData['message']   = "";
/*
	//初期化
	$dData['subject']   = "";
	$dData['message']   = "";
*/
?>