<?PHP
/*
*	エラーデータダウンロード用
*/

ini_set('display_errors','1');

require_once '../../program/cls/define/Setup.php';
require_once (_DIR_LIB_.'db/Postgres.php');
$cPostgres         = new Postgres();

//require_once _DIR_CLS_.'pictmail/error/setup.php';
//require_once _DIR_COMMON_.'pictmail/define/setup.php';

  main();

	function main(){
	global $cPostgres;

	$query  = "SELECT tmain.name_family, tmain.name_first, tmain.mail, tmain.name_company , tpict.flag_del";
	$query .= "FROM td_user AS tmain ";
	$query .= "JOIN td_pictmail AS tpict ON tmain.user_id = tpict.user_id ";
	$query .= "WHERE tpict.flag_del = 0 ";
	$query .= "ORDER BY tmain.user_id ";

//		$query  = "SELECT * FROM td_error_log WHERE user_id = {$_SESSION['user']['user_id']} ";
//		$query .= " ORDER BY error_count DESC , date_insert ";

		$data = $cPostgres->executeQuery($query);
/*
		$CsvData  = "メールアドレス,";
		$CsvData .= "エラー回数,";
		$CsvData .= "初回エラー日,";
		$CsvData .= "最終エラー取得日";
		$CsvData .= "\r\n";
*/
		while ( $DownData = pg_fetch_array($data) ) {

			foreach($DownData as $key => $valus){
				$valus = str_replace("\r","\n",$valus);
				$valus = str_replace("\rn","\n",$valus);
				$valus = str_replace("\n","<BR>",$valus);
				$valus = str_replace(",","，",$valus);
/*
				if($key != "0" || $key != "1"){
					$CsvData .= $valus.",";
				}
*/
			}

/*
			$insstr = explode(".",$DownData['date_insert'],2); 
			$upstr  = explode(".",$DownData['date_update'],2); 
			$DownData['date_insert'] = $insstr[0];
			$DownData['date_update'] = $upstr[0];

*/
			$CsvData .= "{$DownData['name_family']}{$DownData['name_first']},{$DownData['mail']},{$DownData['name_company']}\r\n";
			//print_r ($ary);
		}

    $CsvData = mb_convert_encoding($CsvData,"SJIS" ,"EUC-JP");

		$filename = "itm-asp_dm.csv";
		header ("Content-Disposition: attachment; filename=$filename");
		header ("Content-type: application/x-csv");
		echo $CsvData;

	return;
	}

?>