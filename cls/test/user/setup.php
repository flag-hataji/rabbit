<?PHP
/*
  ユーザー情報登録setup.php
*/


	// SetUp
	require_once ('../../lib/Convert.php');
	require_once ('../../lib/Mail.php');
	require_once ('../../lib/Check.php');
	//本番
	//require_once ('../../lib/Postgres.php');
	//test
	require_once ('../../../vhosts/test.itm-asp.com/html/lib/Postgres.php');

	require_once ('../../cls/test/user/mail.php');
	require_once ('../../cls/test/user/Debug.php');
	require_once ('../../cls/test/user/dataCheck.php');
	require_once ('../../cls/test/user/ListKen.php');
	require_once ('../../cls/test/user/ListDate.php');
	require_once ('../../cls/test/user/postgres.php');
	require_once ('../../cls/test/user/serchZip.php');

	$cMail       = new Mail();
	$cCheck      = new Check();
	$cDebug      = new clsDebug();
	$libConvert  = new Convert();
	$cKen        = new ListKen();
	$cDate       = new ListDate();
	$cDb         = new Postgres();
//	$cDb         = new Postgres('pgsql://pgsql: @localhost:5432/itm-asp_test');



$dData['name_kana'] = "";
$dData['name'] = "";
$dData['user_mail'] = "";
$dData['company'] = "";
$dData['company_kana'] = "";
$dData['pass'] = "";
$dData['tel1'] = "";
$dData['tel2'] = "";
$dData['tel3'] = "";
$dData['zip'] = "";
$dData['address1'] = "";
$dData['address2'] = "";
$dData['address3'] = "";
?>