<?PHP
/*
*	エラーデータダウンロード用
*/


ini_set('display_errors','1');
echo "require setup.php 1";

require_once '../../../program/cls/define/Setup.php';
echo "require setup.php";
exit;

require_once _DIR_CLS_.'pictmail/error/setup.php';
//require_once _DIR_COMMON_.'pictmail/define/setup.php';

	if(isset($_SESSION['user'])){
	  main();
	}else{
		echo "SESSION ERROR";
		exit;
	}

	function main(){
	global $cPostgres;

		$query  = "SELECT * FROM td_error_log_itm WHERE user_id = {$_SESSION['user']['user_id']} ";
		$query .= " ORDER BY error_count DESC , date_insert ";

		$data = $cPostgres->executeQuery($query);

		$CsvData  = "メールアドレス,";
		$CsvData .= "エラー回数,";
		$CsvData .= "初回エラー日,";
		$CsvData .= "最終エラー取得日";
		$CsvData .= "\r\n";

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

			$insstr = explode(".",$DownData['date_insert'],2); 
			$upstr  = explode(".",$DownData['date_update'],2); 
			$DownData['date_insert'] = $insstr[0];
			$DownData['date_update'] = $upstr[0];
			$CsvData .= $DownData['mail'].",".$DownData['error_count'].",".$DownData['date_insert'].",".$DownData['date_update']."\r\n";
			//print_r ($ary);
		}

    $CsvData = mb_convert_encoding($CsvData,"SJIS" ,"EUC-JP");
    $today = date('YmdHis');
		$filename = "error_log{$today}.csv";
		header ("Content-Disposition: attachment; filename=$filename");
		header ("Content-type: application/x-csv");
		echo $CsvData;

	return;
	}

?>