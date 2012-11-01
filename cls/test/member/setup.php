<?PHP
/*
  メンバー情報登録setup.php
*/


	// SetUp
	require_once ('../../lib/Convert.php');
	require_once ('../../lib/Mail.php');
	require_once ('../../lib/Check.php');
	//本番
	//require_once ('../../lib/Postgres.php');
	//test
	require_once ('../../../vhosts/test.itm-asp.com/html/lib/Postgres.php');

	require_once ('../../cls/test/member/mail.php');
	require_once ('../../cls/test/member/Debug.php');
	require_once ('../../cls/test/member/dataCheck.php');
	require_once ('../../cls/test/member/postgres.php');
	require_once ('../../cls/test/member/serchZip.php');

	$cMail       = new Mail();
	$cCheck      = new Check();
	$cDebug      = new clsDebug();
	$libConvert  = new Convert();
	$cDb         = new Postgres();
//	$cDb         = new Postgres('pgsql://pgsql: @localhost:5432/itm-asp_test');



$dData['name'] = "";
$dData['email'] = "hataji@itm.ne.jp";


?>