<?PHP
/**
 * CRON�ˤ��td_mailq�ˤ��ޤä��᡼�����������
 *
 * @author fujita
 * @package defaultPackage
 */

define("_DEBUG_", false);

// �������
include_once "setup.php";

//$argv = $_SERVER['argv'];

// �ۿ�����μ���
//if ( isset($argv[1]) ) {

    define("_READ_COUNT_", 300);
    
//}else{
//    die("READ COUNT NOT...");
//}

// ��������
//if ( isset($argv[2]) ){
//	// TEST
//	define("_EXE_STR_",  "/var/www/vhosts/test.itm-asp.com/html/pictmail/mailq/mobile_mailq"); // ��ŵ�ư�ɻ�
//}else{

	// ����
	define("_EXE_STR_",  "/var/www/vhosts/www.rabbit-mail.jp/html/program/cls/pictmail/mailq/mobile_mailq"); // ��ŵ�ư�ɻ�
	
//}

// ���饹
if ( _DEBUG_ ) { include _ROOT_LIB_."debug/Debuglib.php"; }

include _ROOT_LIB_."mail/Mail.php"; // ����ؿ�
include _ROOT_LIB_."db/Postgres.php";
include _ROOT_LIB_."file/Csv.php";
include _ROOT_LIB_."util/Util.php";

include _ROOT_CLS_."pictmail/mailq/mailq.php";

$Psql = new Postgres();
$Mail = new Mail();
$Csv  = new Csv();
$Util = new Util();

$Mailq = new Mailq(false);	// false=�����Ѥǵ�ư

// ��ŵ�ư�ɻ�
$exe_check = _EXE_STR_;	// Check��ʸ����

$exe_cmd = "ps auxww | grep {$exe_check} | grep -v grep | grep -v /bin/sh -c ";
$exe_cnt = system($exe_cmd);

if ( $exe_cnt >= 2 ) {

	// �����԰��˥᡼������
	$subject = "[rabbit-mail.jp MAIL]mobile 2�ŵ�ưȯ��";
	$body    = "\n";
	$body   .= "{$exe_cnt}�ŵ�ư��ȯ�����ޤ�����\n";
	$body   .= "{$exe_cmd}\n";
	$Mail->normalMb_send_mail("info@rabbit-mail.jp", "hataji@itm-asp.com", $subject, $body);

	die($exe_cnt. "�ŵ�ư \n");

}

// PG��ư����
$Mailq->send_time = date("Y-m-d H:i:s");

// �᡼������
$flag = $Mailq->isSendMail();

// �������κ���
$Mailq->isLogCsv();

// ������λ��˥ϥ����˥᡼������
if ( $Mailq->send_count > 0 ) {
	$Mailq->isOwnerMail();
}

//print "START = {$mailq->start_time}\n";
//print "END   = {$mailq->end_time}\n";
//print "��Ư���� = ".$mailq->getTimeMargin($mailq->end_time, $mailq->start_time)."\n";

?>
