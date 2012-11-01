<?PHP
/**
 * CRONによりtd_mailqにたまったメールを送信する
 *
 * @author fujita
 * @package defaultPackage
 */

define("_DEBUG_", false);

// 初期設定
include_once "setup.php";

//$argv = $_SERVER['argv'];

// 配信件数の取得
//if ( isset($argv[1]) ) {

    define("_READ_COUNT_", 300);
    
//}else{
//    die("READ COUNT NOT...");
//}

// 個別設定
//if ( isset($argv[2]) ){
//	// TEST
//	define("_EXE_STR_",  "/var/www/vhosts/test.itm-asp.com/html/pictmail/mailq/mobile_mailq"); // 二重起動防止
//}else{

	// 本番
	define("_EXE_STR_",  "/var/www/vhosts/www.rabbit-mail.jp/html/program/cls/pictmail/mailq/mobile_mailq"); // 二重起動防止
	
//}

// クラス
if ( _DEBUG_ ) { include _ROOT_LIB_."debug/Debuglib.php"; }

include _ROOT_LIB_."mail/Mail.php"; // 自作関数
include _ROOT_LIB_."db/Postgres.php";
include _ROOT_LIB_."file/Csv.php";
include _ROOT_LIB_."util/Util.php";

include _ROOT_CLS_."pictmail/mailq/mailq.php";

$Psql = new Postgres();
$Mail = new Mail();
$Csv  = new Csv();
$Util = new Util();

$Mailq = new Mailq(false);	// false=携帯用で起動

// 二重起動防止
$exe_check = _EXE_STR_;	// Check用文字列

$exe_cmd = "ps auxww | grep {$exe_check} | grep -v grep | grep -v /bin/sh -c ";
$exe_cnt = system($exe_cmd);

if ( $exe_cnt >= 2 ) {

	// 管理者宛にメール送信
	$subject = "[rabbit-mail.jp MAIL]mobile 2重起動発生";
	$body    = "\n";
	$body   .= "{$exe_cnt}重起動が発生しました。\n";
	$body   .= "{$exe_cmd}\n";
	$Mail->normalMb_send_mail("info@rabbit-mail.jp", "hataji@itm-asp.com", $subject, $body);

	die($exe_cnt. "重起動 \n");

}

// PG起動時間
$Mailq->send_time = date("Y-m-d H:i:s");

// メール送信
$flag = $Mailq->isSendMail();

// 送信ログの作成
$Mailq->isLogCsv();

// 送信完了後にハタジにメール送信
if ( $Mailq->send_count > 0 ) {
	$Mailq->isOwnerMail();
}

//print "START = {$mailq->start_time}\n";
//print "END   = {$mailq->end_time}\n";
//print "稼働時間 = ".$mailq->getTimeMargin($mailq->end_time, $mailq->start_time)."\n";

?>
