<?PHP
/*
* �����С��ץ�����ư�����å��ץ���� var1.0 2006/11/15
* hataji
*
*/

// Apache��ư�����å�
	$exe_ap['name']   = "Apache";
	$exe_ap['check']  = "ps auxww | grep httpd | grep -v grep -c";
	$exe_ap['run']    = "apachectl start";

// Posgre��ư�����å�
	$exe_db['name']   = "Postgres";
	$exe_db['check']  = "ps auxww | grep pgsql | grep -v grep | grep -v integration -c";
	$exe_db['run']    = "/usr/local/etc/rc.d/postgresql.sh start";

// Qmail��ư�����å�
	$exe_qm['name']   = "Qmail";
	$exe_qm['check']  = "ps auxww | grep qmails | grep -v grep -c";
	$exe_qm['run']    = "
/var/qmail/rc start
/usr/local/bin/tcpserver -H -R -v -x /usr/local/vpopmail/etc/tcp.smtp.cdb -c 100 -u qmaild -g qmaild 0 25 \
/var/qmail/bin/qmail-smtpd 2>&1 \
| /var/qmail/bin/splogger smtpd &
/usr/local/bin/tcpserver -R -H 0 110 /var/qmail/bin/qmail-popup www.itm-asp.com \
/usr/local/vpopmail/bin/vchkpw /var/qmail/bin/qmail-pop3d Maildir 2>&1 \ | /var/qmail/bin/splogger pop3d &
";

	define(EMAIL , 'kyo_fd3s@q.vodafone.ne.jp,hell_and_heaven@q.vodafone.ne.jp,s-_-ki@docomo.ne.jp,l-o-lzzz.zz.z@ezweb.ne.jp');
//define(EMAIL , 'kyo_fd3s@q.vodafone.ne.jp');

function process_check($exe_cmd){
	$exe_cnt = system($exe_cmd['check']);

	if ( $exe_cnt == 0 ) {
		$error = system( $exe_cmd['run'] );
    if($error != 0){
			// �����԰��˥᡼������
			$subject = "�ڶ۵ޡ�itm-asp�����С����";
			$body   .= "{$exe_cmd['name']}�ε�ư�˼��Ԥ��ޤ�����\n��޳�ǧ���Ƶ�ư���Ƥ�������\n";
			mb_send_mail(EMAIL, $subject, $body);
			echo "error = {$exe_cnt}";
		}else{
			// �����԰��˥᡼������
			$subject = "������itm-asp";
			$body   .= "{$exe_cmd['name']}�ߤޤäƤ����ɺƵ�ư���ޤ�����\n�Ȥꤢ�����ͻҸ��Ǥ�\n";
			mb_send_mail(EMAIL, $subject, $body);
			echo "start ok = {$exe_cnt}";
		}
  }
}

process_check($exe_ap);
process_check($exe_db);
//process_check($exe_qm);
?>
