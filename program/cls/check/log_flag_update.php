<?PHP
/**
 * ピクトメールのフラグチェック
 *
 * @author hataji
 * @package defaultPackage
 */
 
/**
 *
 *クーロンで動かします。
 * | real | test | パラメータによって、本番かテストか判断します。
 *
 */

	/**
	* @return String
	* @desc SQLの文字列を取得
	*/
	function getSQL(){

		### ピクトメールで配信中になっているデータの取得、アップデート ###

		$sql = "";

        /*PCデータ*/
		$sql .= "UPDATE td_log set flag_pc = 99 , date_pc = now() where log_id IN ";
		$sql .= "	(";
		$sql .= "		select t1.log_id FROM ";
		$sql .= "			(SELECT log_id , user_id ,message_id , subject ,flag_pc,flag_mobile, date_insert , send_date from td_log where  flag_pc IN (1,2) ) AS t1 ";
		$sql .= "		LEFT JOIN td_mailq AS t2 ON (t1.message_id = t2.message_id )  where t2.mailq_id IS NULL ";
		$sql .= "	) ";
		$sql .= "; ";

        /*mobileデータ*/
		$sql .= "UPDATE td_log set flag_mobile = 99  , date_mobile = now()  where log_id IN ";
		$sql .= "	(";
		$sql .= "		select t1.log_id FROM ";
		$sql .= "			(SELECT log_id , user_id ,message_id , subject ,flag_pc,flag_mobile, date_insert , send_date from td_log where  flag_mobile IN (1,2) ) AS t1 ";
		$sql .= "		LEFT JOIN td_mailq AS t2 ON (t1.message_id = t2.message_id )  where t2.mailq_id IS NULL ";
		$sql .= "	)";
		$sql .= "; ";

		### めるめるで配信中になっているデータの取得、アップデート ###
        /*PCデータ*/
/*
		$sql .= "UPDATE td_email_message set flag_pc = 99  where data_id IN ";
		$sql .= "	(";
		$sql .= "		SELECT t1.data_id  FROM ";
		$sql .= "			(SELECT data_id , td_user_id , flag_pc , flag_mobile, date_insert , date_send  FROM  td_email_message WHERE  flag_pc  IN (1,2) ) AS t1 ";
		$sql .= "		LEFT JOIN td_mailq_db AS t2 ON (t1.data_id = t2.td_email_message_id )  WHERE t2.mailq_db_id IS NULL ";
		$sql .= "	)";
		$sql .= ";";
*/
        /*mobileデータ*/
/*
		$sql .= "UPDATE td_email_message set flag_mobile = 99  where data_id IN ";
		$sql .= "	(";
		$sql .= "		SELECT t1.data_id  FROM ";
		$sql .= "			(SELECT data_id , td_user_id , flag_pc , flag_mobile, date_insert , date_send  FROM  td_email_message WHERE  flag_mobile  IN (1,2) ) AS t1 ";
		$sql .= "		LEFT JOIN td_mailq_db AS t2 ON (t1.data_id = t2.td_email_message_id )  WHERE t2.mailq_db_id IS NULL ";
		$sql .= "	)";
		$sql .= ";";
*/

		return $sql;
	}

	/**
	* @return void
	* @param  real_mode true=本番, false=テスト
	* @desc   メインプログラム
	*/
	function Main($real_mode){

		if ( $real_mode == true ) {
			// 本番環境の設定
			// 定数
			define("_DEBUG_", false);	// Debug

			define("_STEP_MAIL_ERROR_", "hataji@itm.ne.jp");	// Error等の報告メール送信先


			$_SERVER['DOCUMENT_ROOT'] = "/var/www/vhosts/www.rabbit-mail.jp/html/";
			$_SERVER['HTTP_HOST']     = "www.rabbit-mail.jp";

		  define('_DB_NAME_','ltv-atamail');
		  define('_DB_USER_','postgres');
		  define('_DB_HOST_','localhost');
		  define('_DB_PORT_','5432');
		  define("_DB_DSN_", "pgsql://"._DB_USER_.":@"._DB_HOST_.":"._DB_PORT_."/"._DB_NAME_);	// DB接続

		  define('_DIR_LIB_', "/var/www/vhosts/www.rabbit-mail.jp/html/program/lib/");

		}

		require_once ('/var/www/vhosts/www.rabbit-mail.jp/html/program/lib/db/Postgres.php');
  		$Postgres = new Postgres();

		$sql = getSQL();
		
		$Postgres->executeUpdate($sql);
  		$Postgres->close();

	}
	


	########################   MAIN　PROGRAM   ########################


	// 起動設定のパラメータ取得
	$real_mode = false;
	if ( isset($_SERVER['argv']) ){

		if ( $_SERVER['argv'][1]=='real' ) {
			// 本番
			$real_mode = true;
			define("_EXE_STR_",  "/var/www/vhosts/www.rabbit-mail.jp/html/program/cls/check/log_flag_update");

		}else{
			die("ERROR：起動パラメータが不正です。| real | test |");
		}

	}else{
		$real_mode = false;
	}

	// 二重起動防止
	$exe_check = _EXE_STR_;	// Check用文字列

	$exe_cmd = "ps auxww | grep {$exe_check} | grep -v grep | grep -v /bin/sh -c ";
	$exe_cnt = system($exe_cmd);

	if ( $exe_cnt >= 2 ) {

		// 管理者宛にメール送信
		$subject = "2重起動発生";
		$body    = "\n";
		$body   .= "{$exe_cnt}重起動が発生しました。\n";
		$body   .= "{$exe_cmd}\n";
		mb_send_mail("hataji@itm.ne.jp", "info@rabbit-mail.jp", $subject, $body);

		die($exe_cnt. "重起動 \n");

	}

//	print "argv = ".$_SERVER[argv][0]."\n";
//	print "argv = ".$_SERVER[argv][1]."\n";
//	print "argc = ".$_SERVER[argc][0]."\n";
//	print ( $real_mode ) ? "real\n" : "test\n";

	// PG起動時間
	$start = date("Y-m-d H:i:s")."<br>\n";

	// メインプログラム
	Main($real_mode);

	// PG終了時間
	$end   = date("Y-m-d H:i:s")."<br>\n";

	// 起動期間ログ
	if( _DEBUG_ ) {
		print "<br>\n";
		print "START = {$start}\n";
		print "END   = {$end}\n";
		print "稼働時間 = ".getTimeMargin($start, $end)."\n";
	}
