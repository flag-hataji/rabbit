<?PHP
/**
 * メール送信の実行プログラム
 *
 * @author fujita
 * @package defaultPackage
 */

class Mailq {

	var $error = "";

	var $margin       = "";	// 送信までの時間
	var $send_count   = "";	// 送信した件数
	var $mailq_count = "";	// 残りに td_mailq の件数

	var $send_time  = "";	// 送信稼働時間
	var $start_time = "";	// メール送信開始時間
	var $end_time   = "";	// メール送信終了時間

	// 送信先
	var $pc_flag		  = "";	// true=PC, false=携帯
	var $send_log_name	  = "";	// 配信ログ名
	var $owner_mail_title = "";	// 送信結果配信時のタイトル

	/**
	* @return void
	* @param  $pc_flag	PC用,携帯用のフラグ
	* @desc   初期設定
	*/
	function Mailq($pc_flag){

		if ( $pc_flag==true ) {
			// PC用配信設定
			$this->pc_flag 		 	= 't';
			$this->send_log_name 	= "MailLog_PC_";
			$this->owner_mail_title = "PC用";

		}else{
			// 携帯用配信設定
			$this->pc_flag		 	= 'f';
			$this->send_log_name	= "MailLog_Mobile_";
			$this->owner_mail_title = "携帯用";

		}

	}

	/**
	* @return int 0=送信無し, 1=OK, -1=Error
	* @param
	* @desc メール送信
	*/
	function isSendMail(){

		global $Psql, $Mail, $Util;

		// メール送信開始時間
		$this->start_time = date("Y-m-d H:i:s");
		$error_msg = "";	// エラー用Message

		$where = "";
		$this->send_count = 0;

		// 送信するメールデータの取得
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

		// 該当件数が 0件の場合
		if ( $Psql->getRow()==0 ) {
			$this->margin       = "00:00:00";
			$this->mailq_count	= $this->getMailqCount();
			$this->end_time 		= date("Y-m-d H:i:s");
			return 0;
		}

		// メール送信
		$maxMargin = "00:00:00";
		while ($ary = pg_fetch_array($rst)) {

			$ary['email_from_name'] = $Util->decodeTag($ary['email_from_name']);
			$ary['email_name']      = $Util->decodeTag($ary['email_name']);

			// Qmailで " が邪魔をする
			$ary['email_from_name'] = str_replace('"', '\"', $ary['email_from_name']);
			$ary['email_name']      = str_replace('"', '\"', $ary['email_name']);

			$mailq_id = $ary['mailq_id'];

			// 送信元
/*			if ( strlen($ary['email_from_name']) == mb_strlen($ary['email_from_name']) ) {
				// 英字のみの場合
//				$from = $ary['email_from_name']." <".$ary['email_from'].">";
				$from = "\"".$ary['email_from_name']."\" <".$ary['email_from'].">";
			}else{
				// マルチバイト含む
//				$from = $this->mime_enc( $ary['email_from_name'] )." <".$ary['email_from'].">";
//				$from = $this->mime_enc("\"". $ary['email_from_name']."\"" )." <".$ary['email_from'].">";
				$from = "\"".$ary['email_from_name']."\" <".$ary['email_from'].">";
			}*/

		    $from = mb_convert_encoding($ary['email_from_name'] ,"JIS","EUC-JP");
		    $from = "=?iso-2022-jp?B?" . base64_encode($from) . "?=";
			$from = $from . " <".$ary['email_from'].">";

			// 宛先名
			if ( $ary['email_name']=="　" ) {
	  			$to = $ary['email'];
			}else{

				if( strlen($ary['email_name']) == mb_strlen($ary['email_name']) ) {
					// 英字のみの場合
				    $to      = $ary['email_name'] ." <".$ary['email'].">";

//					$to = "\"".$ary['email_name']."\" <".$ary['email'].">";
//		  			$to = $ary['email_name']." <".$ary['email'].">";
				}else {
					// マルチバイト含む
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

			// パラメータの設定
			//subject内のパラメータも設定 2006/03/10 hataji
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

			// 改行コードを \n に変更
			$message = $Util->nl2LF($message);
			$message = $Util->decodeTag($message);

			// HTMLメール送信
			if ( $ary['flag_html']=="1" ) {
				$message_html  = str_replace("%name%", $ary['email_name'], $ary['message_html']);

				$message_html = str_replace("%param1%", $ary['parameter1'], $message_html);
				$message_html = str_replace("%param2%", $ary['parameter2'], $message_html);
				$message_html = str_replace("%param3%", $ary['parameter3'], $message_html);
				$message_html = str_replace("%param4%", $ary['parameter4'], $message_html);
				$message_html = str_replace("%param5%", $ary['parameter5'], $message_html);

        		$message_html = str_replace("%email%",  $ary['email'],      $message_html);

				// 改行コードを \n に変更
				$message_html = $Util->nl2LF($message_html);
				$message_html = $Util->decodeTag($message_html);
			}

			$subject = $Util->decodeTag($subject);

			if ( _DEBUG_ ) { print_a($ary, "_DATA"); }

			// メールの送信実行
			if ( $ary['flag_html']=="1" ) {
				$mail_flag = $Mail->htmlMail($from, $to, $subject, $message, $message_html,"", "", $error);

			}else{
				$mail_flag = $Mail->normalMb_send_mail($from, $to, $subject, $message, $error);
			}

			// 送信完了の場合
			if ( $mail_flag == true ) {

				// 時間差の取得
				$now = date("Y-m-d H:i:s");
				$nowMargin = $this->getTimeMargin($now, $ary['ins_date']);
				if ( $nowMargin > $maxMargin ){
					$maxMargin = $nowMargin;
				}

				// mailqから削除
				$sql = "DELETE FROM td_mailq WHERE mailq_id = {$mailq_id}";
				$Psql->executeUpdate($sql);
				pg_free_result($Psql->result);

				// 送信件数
				$this->send_count += 1;

			}else{
				// 送信できなかった場合
				$error_msg .=<<<END_HTML
以下の mailq_id のメールの送信に失敗しました。

mailq_id　　{$ary['mailq_id']}
email　　 　{$ary['email']}
email_name　{$ary['email_name']}
from        {$from}
to          {$to}

END_HTML;

			}

			// メモリ解放
			unset($mailq_id, $mailq_id, $to, $error, $subject, $message, $ary, $sql);

		}

		// エラーが発生したメール送信
		if ( $error_msg != "" ) {
			$subject = "[RABBIT MAIL]送信エラーが発生しました。";
			$subject = mb_encode_mimeheader($subject);
			$Mail->normalMb_send_mail("hataji@itm.ne.jp" , $subject, $error_msg, "info@rabbit-mail.jp");
		}

		// 送信までのMAX時間
		$this->margin = $maxMargin;

		// メール送信終了時間
		$this->end_time = date("Y-m-d H:i:s");

		// メモリ解放
		pg_free_result($rst);

		// td_mailqの残り件数
		$this->mailq_count = $this->getMailqCount();

		return 1;

	}

	// EUC->JIS->MIMEエンコード(B)する
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

			// mb_encode_mimeheader()はバグがあるらしく、途中で改行してしまうため
			// base64_encode()でMIMEエンコード文字列をつくる

	//		$wTempStr .= (($wTempStr) ? " " : "").mb_encode_mimeheader($output, $wAfterCharset);
			$wTempStr .= (($wTempStr) ? " " : "")."=?ISO-2022-JP?B?".base64_encode($output)."?=";

		}
		return($wTempStr);

	}

	/**
	* @return bool
	* @desc 送信ログをCSVに保存
	*/
	function isLogCsv(){

		global $Csv;

		// 現在時刻
		$now = $this->send_time;

		// 保存先フォルダ
		list($date, )  = explode(" ", $now);
		list($year, $month, $day) = explode("-", $date);

		// 年のフォルダ
		$yearPath = _LOG_PATH_.$year;
		if ( file_exists($yearPath)==false ) {
			mkdir($yearPath, 0775);
		}

		// 月のフォルダ
		$monthPath = _LOG_PATH_.$year."/".$month;
		if ( file_exists($monthPath)==false ) {
			mkdir($monthPath, 0775);
		}

		// CSV保存
//		$fileName = "MailLog_".date('Y-m-d').".csv";
		$fileName = $this->send_log_name.date('Y-m-d').".csv";
		$path = _LOG_PATH_.$year."/".$month."/".$fileName;

		// PG稼働時間
		$pg_time = $this->getTimeMargin($this->end_time, $this->start_time);

		// 送信時間, 送信件数, 残maqil件数, 最大遅延時間, PG稼働時間
		$data = "{$now},{$this->send_count},{$this->mailq_count},{$this->margin},{$pg_time}\r\n";

		// SJISにエンコード
		// isWrite関数で文字コード変換を一緒にやってくれる
//		$data = mb_convert_encoding($data, "SJIS", "EUC-JP");

		$Csv->isWrite($path, $data, "SJIS", "a");

	}

	/**
	* @return void
	* @desc メール送信完了後に管理者にメール送信
	*/
	function isOwnerMail(){

		global $Mail;

		$subject = "[RABBIT MAIL]送信がありました（{$this->owner_mail_title}）";
		$from	 = "info@rabbit-mail.jp";
		$to		 = "hataji@itm-asp.com, ken@itm-asp.com";

		$now = $this->send_time;
		$pg_time = $this->getTimeMargin($this->end_time, $this->start_time);

	$message =<<<END_HTML
■送信状況

送信時間　　　{$now}
送信件数　　　{$this->send_count}
残maqil件数 　{$this->mailq_count}
最大遅延時間　{$this->margin}
PG稼働時間　　{$pg_time}
END_HTML;

		return $Mail->normalMb_send_mail($from, $to, $subject, $message, $from);

	}

	/**
	* @return String
	* @desc td_mailq のデータ件数を取得する
	*/
	function getMailqCount() {

		global $Psql;

		// 残り件数の取得
		$sql = "SELECT count(mailq_id) as cnt FROM td_mailq";
		if ( _DEBUG_ ) { print "countSQL = {$sql} <br>\n"; }
		$rst = $Psql->executeQuery($sql);
		list($cnt) = pg_fetch_array($rst);
		pg_free_result($rst);
		return $cnt;

	}

	/**
	* @return String
	* @param now 現在の時間
	* @param ins_sate 登録時間
	* @desc 日付の差を取得
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
	* @desc 日付の分解
	*/
	function getExplodeDateTime($timestamp){

		list($date, $time ) = explode(" ", $timestamp);

		list($y, $m, $d ) = explode("-", $date);
		list($h, $i, $s ) = explode(":", $time);

		return array('y'=>$y, 'm'=>$m, 'd'=>$d, 'h'=>$h, 'i'=>$i, 's'=>$s );

	}

	/**
	* @return bool
	* @desc 携帯に送信できる時間帯か？ true=OK, false=PCのみ
	*/
//	function isMoblieTime(){
//
//		// 現在時刻の取得
//		$now = date('G');
//
//		// 携帯へのメール送信可能の時間帯か？
//		if ( _MOBILE_TIME_START_ <= $now AND _MOBILE_TIME_END_ >= $now ) {
//			return true;
//		}else{
//			return false;
//		}
//
//	}

}


?>