<?PHP
/*
  お問い合わせsetup.php
*/

	// LOAD:Common Setting
	//require_once ('../../../common/define/setup.php');

	// SetUp
	require_once ('../lib/Convert.php');
	require_once ('../lib/Mail.php');
	require_once ('../lib/Check.php');
	require_once ('../cls/inquiry/mail.php');
	require_once ('../cls/inquiry/Debug.php');
	require_once ('../cls/inquiry/dataCheck.php');
	require_once ('../cls/inquiry/ListKen.php');
	require_once ('../cls/inquiry/ListDate.php');


	$cMail       = new Mail();
	$cCheck      = new Check();
	$cDebug      = new clsDebug();
	$libConvert  = new Convert();
	$cKen        = new ListKen();
	$cDate       = new ListDate();


	//テストデータ
	$tData['name_kana_sei'] = "ハタジ";
	$tData['name_kana_mei'] = "キョウヘイ";
	$tData['name_sei']      = "幡司";
	$tData['name_mei']      = "恭平";
	$tData['mail']          = "hataji@itm.ne.jp";
	$tData['company']       = "株式会社アイティマネジメント";
	$tData['mail_conf1']    = "hataji";
	$tData['mail_conf2']    = "itm.ne.jp";
	$tData['tel1']          = "092";
	$tData['tel2']          = "525";
	$tData['tel3']          = "0081";
	$tData['phone1']        = "090";
	$tData['phone2']        = "0000";
	$tData['phone3']        = "0000";
	$tData['comment']   = "デバッグ用テスト";

	//初期化
	$dData['name_kana_sei'] = "";
	$dData['name_kana_mei'] = "";
	$dData['name_sei']      = "";
	$dData['name_mei']      = "";
	$dData['mail']          = "";
	$dData['company']       = "";
	$dData['mail_conf1']    = "";
	$dData['mail_conf2']    = "";
	$dData['tel1']          = "";
	$dData['tel2']          = "";
	$dData['tel3']          = "";
	$dData['phone1']        = "";
	$dData['phone2']        = "";
	$dData['phone3']        = "";
	$dData['comment']   = "";

?>