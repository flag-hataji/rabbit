<?PHP
/*
*	����ǡ��������������
*/
//require_once ("cls/define/Setup.php") ;
require_once ("/var/www/rabbit-mail.jp/html/program/lib/db/Postgres.php");
$cDb = new Postgres;
//define('DB_CONNECT','pgsql://pgsql: @localhost:5432/nikko');
define("_DEBUG_" , false);
//$cDb = new Db(DB_CONNECT);


  main();

	function main(){
	global $cDb;

		$query = "SELECT t1.user_id , t1.name_family , t1.name_first , t1.mail ,t1.name_company , t2.flag_dm ,t2.plan_pictmail_id ";
		$query .= "FROM td_user AS t1 JOIN td_pictmail AS t2 ON t1.user_id = t2.user_id WHERE t2.flag_del = '0' AND t2.flag_dm='1'";

		$data = $cDb->executeQuery($query);
		$CsvData = "";
		while ( $DownData = pg_fetch_array($data) ) {
		switch ($DownData['plan_pictmail_id']){
			case 1:
				$planName = "̵�����";
				break;
			case 2:
				$planName = "�饤��";
				break;
			case 3:
				$planName = "�����������";
				break;
			case 4:
				$planName = "�������ѡ���";
				break;
			case 5:
				$planName = "��������";
				break;
			case 6:
				$planName = "�����ӥ�";
				break;
			case 7:
				$planName = "3000��";
				break;
			case 8:
				$planName = "���ڥ���룱��";
				break;
			case 9:
				$planName = "���ڥ���룲��";
				break;
			case 10:
				$planName = "5000��";
				break;
			case 11:
				$planName = "7000��";
				break;
			case 12:
				$planName = "10000��";
				break;
			case 13:
				$planName = "����������ɥץ饹";
				break;
		}
		
			$CsvData .= $DownData['name_family']."��".$DownData['name_first'].",".$DownData['mail'].",".$DownData['name_company'].",".$DownData['name_family'].",".$planName ;
			$CsvData .= ",".error_url($DownData);//���顼�գң�
			$CsvData .= "\n";
			//print_r ($ary);
		}

    $CsvData = mb_convert_encoding($CsvData,"SJIS" ,"EUC-JP");

		$filename = "asp_dm_member.csv";
		header ("Content-Disposition: attachment; filename=$filename");
		header ("Content-type: application/x-csv");
		echo $CsvData;

	return;
	}


  function error_url($member){
		//�ۿ���ߣգң̺���
		$user['m']   = crypt($member['mail'],"hoge");
		$user['id']  = $member['user_id'];
		//$getData = serialize($user);
		
		$error = "http://www.itm-asp.com/mail_stop/stop.php?m={$user['m']}&num={$user['id']}";
	return($error);
  }
/*
$file     = $_GET['file'] ;//�ե�����գң�
$filename = mb_convert_encoding($_GET['name'],"SJIS", "EUC-JP") ;//�ե�����̾

$extension = strrchr( $file, ".");//��ĥ��ȴ�����

//echo $extension;

if($file && $filename){
	header ("Content-Disposition: attachment; filename=$filename$extension");
	header ("Content-type: application/x-csv");
	readfile ($file);
}
*/
?>
