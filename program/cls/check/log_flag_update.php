<?PHP
/**
 * �ԥ��ȥ᡼��Υե饰�����å�
 *
 * @author hataji
 * @package defaultPackage
 */
 
/**
 *
 *��������ư�����ޤ���
 * | real | test | �ѥ�᡼���ˤ�äơ����֤��ƥ��Ȥ�Ƚ�Ǥ��ޤ���
 *
 */

	/**
	* @return String
	* @desc SQL��ʸ��������
	*/
	function getSQL(){

		### �ԥ��ȥ᡼����ۿ���ˤʤäƤ���ǡ����μ��������åץǡ��� ###

		$sql = "";

        /*PC�ǡ���*/
		$sql .= "UPDATE td_log set flag_pc = 99 , date_pc = now() where log_id IN ";
		$sql .= "	(";
		$sql .= "		select t1.log_id FROM ";
		$sql .= "			(SELECT log_id , user_id ,message_id , subject ,flag_pc,flag_mobile, date_insert , send_date from td_log where  flag_pc IN (1,2) ) AS t1 ";
		$sql .= "		LEFT JOIN td_mailq AS t2 ON (t1.message_id = t2.message_id )  where t2.mailq_id IS NULL ";
		$sql .= "	) ";
		$sql .= "; ";

        /*mobile�ǡ���*/
		$sql .= "UPDATE td_log set flag_mobile = 99  , date_mobile = now()  where log_id IN ";
		$sql .= "	(";
		$sql .= "		select t1.log_id FROM ";
		$sql .= "			(SELECT log_id , user_id ,message_id , subject ,flag_pc,flag_mobile, date_insert , send_date from td_log where  flag_mobile IN (1,2) ) AS t1 ";
		$sql .= "		LEFT JOIN td_mailq AS t2 ON (t1.message_id = t2.message_id )  where t2.mailq_id IS NULL ";
		$sql .= "	)";
		$sql .= "; ";

		### �������ۿ���ˤʤäƤ���ǡ����μ��������åץǡ��� ###
        /*PC�ǡ���*/
/*
		$sql .= "UPDATE td_email_message set flag_pc = 99  where data_id IN ";
		$sql .= "	(";
		$sql .= "		SELECT t1.data_id  FROM ";
		$sql .= "			(SELECT data_id , td_user_id , flag_pc , flag_mobile, date_insert , date_send  FROM  td_email_message WHERE  flag_pc  IN (1,2) ) AS t1 ";
		$sql .= "		LEFT JOIN td_mailq_db AS t2 ON (t1.data_id = t2.td_email_message_id )  WHERE t2.mailq_db_id IS NULL ";
		$sql .= "	)";
		$sql .= ";";
*/
        /*mobile�ǡ���*/
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
	* @param  real_mode true=����, false=�ƥ���
	* @desc   �ᥤ��ץ����
	*/
	function Main($real_mode){

		if ( $real_mode == true ) {
			// ���ִĶ�������
			// ���
			define("_DEBUG_", false);	// Debug

			define("_STEP_MAIL_ERROR_", "hataji@itm.ne.jp");	// Error�������᡼��������


			$_SERVER['DOCUMENT_ROOT'] = "/var/www/vhosts/www.rabbit-mail.jp/html/";
			$_SERVER['HTTP_HOST']     = "www.rabbit-mail.jp";

		  define('_DB_NAME_','ltv-atamail');
		  define('_DB_USER_','postgres');
		  define('_DB_HOST_','localhost');
		  define('_DB_PORT_','5432');
		  define("_DB_DSN_", "pgsql://"._DB_USER_.":@"._DB_HOST_.":"._DB_PORT_."/"._DB_NAME_);	// DB��³

		  define('_DIR_LIB_', "/var/www/vhosts/www.rabbit-mail.jp/html/program/lib/");

		}

		require_once ('/var/www/vhosts/www.rabbit-mail.jp/html/program/lib/db/Postgres.php');
  		$Postgres = new Postgres();

		$sql = getSQL();
		
		$Postgres->executeUpdate($sql);
  		$Postgres->close();

	}
	


	########################   MAIN��PROGRAM   ########################


	// ��ư����Υѥ�᡼������
	$real_mode = false;
	if ( isset($_SERVER['argv']) ){

		if ( $_SERVER['argv'][1]=='real' ) {
			// ����
			$real_mode = true;
			define("_EXE_STR_",  "/var/www/vhosts/www.rabbit-mail.jp/html/program/cls/check/log_flag_update");

		}else{
			die("ERROR����ư�ѥ�᡼���������Ǥ���| real | test |");
		}

	}else{
		$real_mode = false;
	}

	// ��ŵ�ư�ɻ�
	$exe_check = _EXE_STR_;	// Check��ʸ����

	$exe_cmd = "ps auxww | grep {$exe_check} | grep -v grep | grep -v /bin/sh -c ";
	$exe_cnt = system($exe_cmd);

	if ( $exe_cnt >= 2 ) {

		// �����԰��˥᡼������
		$subject = "2�ŵ�ưȯ��";
		$body    = "\n";
		$body   .= "{$exe_cnt}�ŵ�ư��ȯ�����ޤ�����\n";
		$body   .= "{$exe_cmd}\n";
		mb_send_mail("hataji@itm.ne.jp", "info@rabbit-mail.jp", $subject, $body);

		die($exe_cnt. "�ŵ�ư \n");

	}

//	print "argv = ".$_SERVER[argv][0]."\n";
//	print "argv = ".$_SERVER[argv][1]."\n";
//	print "argc = ".$_SERVER[argc][0]."\n";
//	print ( $real_mode ) ? "real\n" : "test\n";

	// PG��ư����
	$start = date("Y-m-d H:i:s")."<br>\n";

	// �ᥤ��ץ����
	Main($real_mode);

	// PG��λ����
	$end   = date("Y-m-d H:i:s")."<br>\n";

	// ��ư���֥�
	if( _DEBUG_ ) {
		print "<br>\n";
		print "START = {$start}\n";
		print "END   = {$end}\n";
		print "��Ư���� = ".getTimeMargin($start, $end)."\n";
	}
