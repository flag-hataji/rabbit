<?PHP
/**
 * �᡼�������μ¹ԥץ����
 *
 * @author fujita
 * @package defaultPackage
 */

class Mailq {

	var $error = "";

	var $margin       = "";	// �����ޤǤλ���
	var $send_count   = "";	// �����������
	var $mailq_count = "";	// �Ĥ�� td_mailq �η��

	var $send_time  = "";	// ������Ư����
	var $start_time = "";	// �᡼���������ϻ���
	var $end_time   = "";	// �᡼��������λ����

	// ������
	var $pc_flag		  = "";	// true=PC, false=����
	var $send_log_name	  = "";	// �ۿ���̾
	var $owner_mail_title = "";	// ��������ۿ����Υ����ȥ�

	/**
	* @return void
	* @param  $pc_flag	PC��,�����ѤΥե饰
	* @desc   �������
	*/
	function Mailq($pc_flag){

		if ( $pc_flag==true ) {
			// PC���ۿ�����
			$this->pc_flag 		 	= 't';
			$this->send_log_name 	= "MailLog_PC_";
			$this->owner_mail_title = "PC��";

		}else{
			// �������ۿ�����
			$this->pc_flag		 	= 'f';
			$this->send_log_name	= "MailLog_Mobile_";
			$this->owner_mail_title = "������";

		}

	}

	/**
	* @return int 0=����̵��, 1=OK, -1=Error
	* @param
	* @desc �᡼������
	*/
	function isSendMail(){

		global $Psql, $Mail, $Util;

		// �᡼���������ϻ���
		$this->start_time = date("Y-m-d H:i:s");
		$error_msg = "";	// ���顼��Message

		$where = "";
		$this->send_count = 0;

		// ��������᡼��ǡ����μ���
		$sql  = "SELECT tdq.mailq_id, tdq.email, tdq.email_name, tdq.parameter1, tdq.parameter2, tdq.parameter3, tdq.parameter4, tdq.parameter5, ";
		$sql .= " tdm.email_from, tdm.email_from_name, tdm.email_error, ";
		$sql .= " tdm.subject, tdm.message, tdm.message_html, tdm.flag_html, tdq.ins_date";
		$sql .= " FROM td_mailq as tdq left join td_message as tdm on tdq.message_id=tdm.message_id ";
		$sql .= " WHERE tdm.message_id IS NOT NULL AND tdm.send_date <= now() AND tdq.flag_pc='{$this->pc_flag}'";

//		$sql .= ( $where != "" ) ? " AND {$where} " : "";

		$sql .= " Order By tdm.count,tdq.ins_date, tdq.mailq_id ";
		$sql .= " LIMIT "._READ_COUNT_." OFFSET 0";

		if ( _DEBUG_ ) { print "SearchSQL = {$sql} <br>\n"; }

		$rst = $Psql->executeQuery($sql);

		// ��������� 0��ξ��
		if ( $Psql->getRow()==0 ) {
			$this->margin       = "00:00:00";
			$this->mailq_count	= $this->getMailqCount();
			$this->end_time 		= date("Y-m-d H:i:s");
			return 0;
		}

		// �᡼������
		$maxMargin = "00:00:00";
		while ($ary = pg_fetch_array($rst)) {

			$ary['email_from_name'] = $Util->decodeTag($ary['email_from_name']);
			$ary['email_name']      = $Util->decodeTag($ary['email_name']);

			// Qmail�� " ������򤹤�
			$ary['email_from_name'] = str_replace('"', '\"', $ary['email_from_name']);
			$ary['email_name']      = str_replace('"', '\"', $ary['email_name']);

			$mailq_id = $ary['mailq_id'];

			// ������
/*			if ( strlen($ary['email_from_name']) == mb_strlen($ary['email_from_name']) ) {
				// �ѻ��Τߤξ��
//				$from = $ary['email_from_name']." <".$ary['email_from'].">";
				$from = "\"".$ary['email_from_name']."\" <".$ary['email_from'].">";
			}else{
				// �ޥ���Х��ȴޤ�
//				$from = $this->mime_enc( $ary['email_from_name'] )." <".$ary['email_from'].">";
//				$from = $this->mime_enc("\"". $ary['email_from_name']."\"" )." <".$ary['email_from'].">";
				$from = "\"".$ary['email_from_name']."\" <".$ary['email_from'].">";
			}*/

		    $from = mb_convert_encoding($ary['email_from_name'] ,"JIS","EUC-JP");
		    $from = "=?iso-2022-jp?B?" . base64_encode($from) . "?=";
			$from = $from . " <".$ary['email_from'].">";

			// ����̾
			if ( $ary['email_name']=="��" ) {
	  			$to = $ary['email'];
			}else{

				if( strlen($ary['email_name']) == mb_strlen($ary['email_name']) ) {
					// �ѻ��Τߤξ��
				    $to      = $ary['email_name'] ." <".$ary['email'].">";

//					$to = "\"".$ary['email_name']."\" <".$ary['email'].">";
//		  			$to = $ary['email_name']." <".$ary['email'].">";
				}else {
					// �ޥ���Х��ȴޤ�
				    $to      = mb_convert_encoding($ary['email_name'] ,"JIS","EUC-JP");
				    $to      = "=?iso-2022-jp?B?" . base64_encode($to) . "?=";
				    $to      = $to ." <".$ary['email'].">";

//		  			$to = $this->mime_enc( $ary['email_name'] )." <".$ary['email'].">";
//		  			$to = $this->mime_enc( "\"".$ary['email_name']."\"" )." <".$ary['email'].">";
//		  			$to = "\"".$ary['email_name']."\" <".$ary['email'].">";
				}

			}


			$error    = $ary['email_error'];
			$subject  = $ary['subject'];

			// �ѥ�᡼��������
			//subject��Υѥ�᡼�������� 2006/03/10 hataji
			$subject = str_replace("%name%", $ary['email_name'], $subject);

			$subject = str_replace("%param1%", $ary['parameter1'], $subject);
			$subject = str_replace("%param2%", $ary['parameter2'], $subject);
			$subject = str_replace("%param3%", $ary['parameter3'], $subject);
			$subject = str_replace("%param4%", $ary['parameter4'], $subject);
			$subject = str_replace("%param5%", $ary['parameter5'], $subject);
    		$subject = str_replace("%email%",  $ary['email'],      $subject);

			$message  = str_replace("%name%", $ary['email_name'], $ary['message']);

			$message = str_replace("%param1%", $ary['parameter1'], $message);
			$message = str_replace("%param2%", $ary['parameter2'], $message);
			$message = str_replace("%param3%", $ary['parameter3'], $message);
			$message = str_replace("%param4%", $ary['parameter4'], $message);
			$message = str_replace("%param5%", $ary['parameter5'], $message);

    		$message = str_replace("%email%",  $ary['email'],      $message);

			// ���ԥ����ɤ� \n ���ѹ�
			$message = $Util->nl2LF($message);
			$message = $Util->decodeTag($message);

			// HTML�᡼������
			if ( $ary['flag_html']=="1" ) {
				$message_html  = str_replace("%name%", $ary['email_name'], $ary['message_html']);

				$message_html = str_replace("%param1%", $ary['parameter1'], $message_html);
				$message_html = str_replace("%param2%", $ary['parameter2'], $message_html);
				$message_html = str_replace("%param3%", $ary['parameter3'], $message_html);
				$message_html = str_replace("%param4%", $ary['parameter4'], $message_html);
				$message_html = str_replace("%param5%", $ary['parameter5'], $message_html);

        		$message_html = str_replace("%email%",  $ary['email'],      $message_html);

				// ���ԥ����ɤ� \n ���ѹ�
				$message_html = $Util->nl2LF($message_html);
				$message_html = $Util->decodeTag($message_html);
			}

			$subject = $Util->decodeTag($subject);

			if ( _DEBUG_ ) { print_a($ary, "_DATA"); }

			// �᡼��������¹�
			if ( $ary['flag_html']=="1" ) {
				$mail_flag = $Mail->htmlMail($from, $to, $subject, $message, $message_html,"", "", $error);

			}else{
				$mail_flag = $Mail->normalMb_send_mail($from, $to, $subject, $message, $error);
			}

			// ������λ�ξ��
			if ( $mail_flag == true ) {

				// ���ֺ��μ���
				$now = date("Y-m-d H:i:s");
				$nowMargin = $this->getTimeMargin($now, $ary['ins_date']);
				if ( $nowMargin > $maxMargin ){
					$maxMargin = $nowMargin;
				}

				// mailq������
				$sql = "DELETE FROM td_mailq WHERE mailq_id = {$mailq_id}";
				$Psql->executeUpdate($sql);
				pg_free_result($Psql->result);

				// �������
				$this->send_count += 1;

			}else{
				// �����Ǥ��ʤ��ä����
				$error_msg .=<<<END_HTML
�ʲ��� mailq_id �Υ᡼��������˼��Ԥ��ޤ�����

mailq_id����{$ary['mailq_id']}
email���� ��{$ary['email']}
email_name��{$ary['email_name']}
from        {$from}
to          {$to}

END_HTML;

			}

			// �������
			unset($mailq_id, $mailq_id, $to, $error, $subject, $message, $ary, $sql);

		}

		// ���顼��ȯ�������᡼������
		if ( $error_msg != "" ) {
			$subject = "[RABBIT MAIL]�������顼��ȯ�����ޤ�����";
			$subject = mb_encode_mimeheader($subject);
			$Mail->normalMb_send_mail("hataji@itm.ne.jp" , $subject, $error_msg, "info@rabbit-mail.jp");
		}

		// �����ޤǤ�MAX����
		$this->margin = $maxMargin;

		// �᡼��������λ����
		$this->end_time = date("Y-m-d H:i:s");

		// �������
		pg_free_result($rst);

		// td_mailq�λĤ���
		$this->mailq_count = $this->getMailqCount();

		return 1;

	}

	// EUC->JIS->MIME���󥳡���(B)����
	//----------------------------------------------------------
	function mime_enc($pString){

		$wAfterCharset  = "JIS";
		$wBeforeCharset = "EUC-JP";
		$wTempStr = "";

		// after 36 single bytes characters, if then comes MB, it is broken
		$wString = mb_convert_encoding($pString, $wAfterCharset, $wBeforeCharset);
		$pos = 0;
		$split = 36;
		while ($pos < mb_strlen($wString, $wAfterCharset))
		{
			$output = mb_strimwidth($wString, $pos, $split, "", $wAfterCharset);
			$pos += mb_strlen($output, $wAfterCharset);

			// mb_encode_mimeheader()�ϥХ�������餷��������ǲ��Ԥ��Ƥ��ޤ�����
			// base64_encode()��MIME���󥳡���ʸ�����Ĥ���

	//		$wTempStr .= (($wTempStr) ? " " : "").mb_encode_mimeheader($output, $wAfterCharset);
			$wTempStr .= (($wTempStr) ? " " : "")."=?ISO-2022-JP?B?".base64_encode($output)."?=";

		}
		return($wTempStr);

	}

	/**
	* @return bool
	* @desc ��������CSV����¸
	*/
	function isLogCsv(){

		global $Csv;

		// ���߻���
		$now = $this->send_time;

		// ��¸��ե����
		list($date, )  = explode(" ", $now);
		list($year, $month, $day) = explode("-", $date);

		// ǯ�Υե����
		$yearPath = _LOG_PATH_.$year;
		if ( file_exists($yearPath)==false ) {
			mkdir($yearPath, 0775);
		}

		// ��Υե����
		$monthPath = _LOG_PATH_.$year."/".$month;
		if ( file_exists($monthPath)==false ) {
			mkdir($monthPath, 0775);
		}

		// CSV��¸
//		$fileName = "MailLog_".date('Y-m-d').".csv";
		$fileName = $this->send_log_name.date('Y-m-d').".csv";
		$path = _LOG_PATH_.$year."/".$month."/".$fileName;

		// PG��Ư����
		$pg_time = $this->getTimeMargin($this->end_time, $this->start_time);

		// ��������, �������, ��maqil���, �����ٱ����, PG��Ư����
		$data = "{$now},{$this->send_count},{$this->mailq_count},{$this->margin},{$pg_time}\r\n";

		// SJIS�˥��󥳡���
		// isWrite�ؿ���ʸ���������Ѵ�����ˤ�äƤ����
//		$data = mb_convert_encoding($data, "SJIS", "EUC-JP");

		$Csv->isWrite($path, $data, "SJIS", "a");

	}

	/**
	* @return void
	* @desc �᡼��������λ��˴����Ԥ˥᡼������
	*/
	function isOwnerMail(){

		global $Mail;

		$subject = "[RABBIT MAIL]����������ޤ�����{$this->owner_mail_title}��";
		$from	 = "info@rabbit-mail.jp";
		$to		 = "hataji@itm-asp.com, ken@itm-asp.com";

		$now = $this->send_time;
		$pg_time = $this->getTimeMargin($this->end_time, $this->start_time);

	$message =<<<END_HTML
����������

�������֡�����{$now}
�������������{$this->send_count}
��maqil��� ��{$this->mailq_count}
�����ٱ���֡�{$this->margin}
PG��Ư���֡���{$pg_time}
END_HTML;

		return $Mail->normalMb_send_mail($from, $to, $subject, $message, $from);

	}

	/**
	* @return String
	* @desc td_mailq �Υǡ���������������
	*/
	function getMailqCount() {

		global $Psql;

		// �Ĥ����μ���
		$sql = "SELECT count(mailq_id) as cnt FROM td_mailq";
		if ( _DEBUG_ ) { print "countSQL = {$sql} <br>\n"; }
		$rst = $Psql->executeQuery($sql);
		list($cnt) = pg_fetch_array($rst);
		pg_free_result($rst);
		return $cnt;

	}

	/**
	* @return String
	* @param now ���ߤλ���
	* @param ins_sate ��Ͽ����
	* @desc ���դκ������
	*/
	function getTimeMargin($now, $ins_date){

		list($ins_date, ) = explode(".", $ins_date);

		$aryNow = $this->getExplodeDateTime($now);
		$aryIns = $this->getExplodeDateTime($ins_date);

		$mkNow = mktime($aryNow['h'], $aryNow['i'], $aryNow['s'], $aryNow['m'], $aryNow['d'], $aryNow['y'] );
		$mkIns = mktime($aryIns['h'], $aryIns['i'], $aryIns['s'], $aryIns['m'], $aryIns['d'], $aryIns['y'] );

		$margin = $mkNow - $mkIns;

		$h = 0;
		$m = 0;
		if ( $margin >= 3600 ) {
			// hh:mm:ss
			$h      = floor($margin/3600);
			$margin = $margin%3600;
		}

		if( $margin >= 60 ) {
			// mm;ss
			$m      = floor($margin/60);
			$margin = $margin%60;
		}

		$s = $margin;

		$h = sprintf("%02s", $h);
		$m = sprintf("%02s", $m);
		$s = sprintf("%02s", $s);


		return "{$h}:{$m}:{$s}";

	}


	/**
	* @return array
	* @param
	* @desc ���դ�ʬ��
	*/
	function getExplodeDateTime($timestamp){

		list($date, $time ) = explode(" ", $timestamp);

		list($y, $m, $d ) = explode("-", $date);
		list($h, $i, $s ) = explode(":", $time);

		return array('y'=>$y, 'm'=>$m, 'd'=>$d, 'h'=>$h, 'i'=>$i, 's'=>$s );

	}

	/**
	* @return bool
	* @desc ���Ӥ������Ǥ�������Ӥ��� true=OK, false=PC�Τ�
	*/
//	function isMoblieTime(){
//
//		// ���߻���μ���
//		$now = date('G');
//
//		// ���ӤؤΥ᡼��������ǽ�λ����Ӥ���
//		if ( _MOBILE_TIME_START_ <= $now AND _MOBILE_TIME_END_ >= $now ) {
//			return true;
//		}else{
//			return false;
//		}
//
//	}

}


?>