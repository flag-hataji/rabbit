<?php
/**
 * maillog�Υ��顼���顢�᡼�륢�ɥ쥹��֥�å��ꥹ�Ȥ���Ͽ
 * 
 * /usr/local/bin/php /var/www/vhosts/www.rabbit-mail.jp/html/program/cls/batch/black_list.php
 * 
 */

// �������
require_once "/var/www/vhosts/www.rabbit-mail.jp/html/program/cls/define/Db.php";      // ����
//require_once "/var/www/vhosts/test.itm-asp.com/html/program/cls/define/Db.php";   // �ƥ���

require_once '/usr/share/pear/DB.php';

// ���顼����������
$subject  = 'rabbit-mail BlackList��Ͽ���顼';
$body     = '';
$owner_to = 'hataji@itm.ne.jp';

// �ɤ߹�����ե�����
$mail_log_file = '/var/log/maillog';
//$mail_log_file = '/var/log/maillog';

// �֥�å��ꥹ�Ȥΰ���ե�����
$black_list_file = '/tmp/black_list.temp';

// ȴ���Ф����顼��å�����
$mail_err_msg1 = 'said: 550'; 
//$mail_err_msg2 = 'Remote_host_said:_550';
$error_type   = '@yahoo\.co\.jp|@gmail\.com|@google\.co\.jp|@livedoor\.com';

// MailLog���饨�顼��ʸ�����ȴ���Ф����֥�å��ꥹ�ȥե���������
// /bin/grep 'does_not_like_recipient' /var/log/maillog | /bin/grep  'Remote_host_said:_550' | /bin/egrep '@docomo\.ne\.jp|@softbank\.ne\.jp|@ezweb\.ne\.jp|@.\.vodafone\.ne\.jp' | less
//exec("/bin/grep '{$mail_err_msg1}' {$mail_log_file} | /bin/grep  '{$mail_err_msg2}' | /bin/egrep '{$error_type}' > {$black_list_file}");
exec("/bin/grep '{$mail_err_msg1}' {$mail_log_file} > {$black_list_file}");

// �֥�å��ꥹ�ȥե�������ɤ߹���
$handle = fopen($black_list_file, 'r');

if ( $handle == false ) {
    die('�֥�å��ꥹ�ȥե�������ɤ߹��ߤ˼���');
}

// DB��³
$db_con = '';
$db_con = DB::connect( _DB_DSN_ );

if (PEAR::isError($db_con)) {
    mb_send_mail($owner_to, $subject, "DB����³�˼��Ԥ��ޤ���");
    exit;
}

// ���ԤŤĲ���
while( ( $err_msg = fgets($handle) ) !== false ) {

    // �᡼�륢�ɥ쥹�μ���
    $email = getErrMsgMail($err_msg);

    if ( $email === -1 ) {
        $body = "����ꥢ�β�����ǽ\n" . $err_msg;
        mb_send_mail($owner_to, $subject, $body);
        die($body);
        exit;
    }
    
    // ErrorMail
    if ( $email === '' ) {
        $body = "Mail�β�����ǽ\n" . $err_msg;
        mb_send_mail($owner_to, $subject, $body);
        die($body);
        exit;
    }

    // Mail���ɥ쥹�� td_black_list����Ͽ
    isInsertBlackList($email);
    
}

// �ե�������Ĥ���
fclose($handle);

// �֥�å��ꥹ�ȥե�����κ��
unlink($black_list_file);

print "��λ\n";

/**
 * td_email_black_list����Ͽ
 * @param type $email 
 */
function isInsertBlackList($email){

    global $db_con, $subject, $owner_to;
    
    print ">>{$email}\n";
    
    // ��ʣ�ǡ���ͭ��ξ���̵��
    if ( isMailUnique($email)==false ) {
        print "  ��ʣͭ��\n";
        return ;
    }
    print "  ��ʣ̵��\n";

    $email = pg_escape_string($email);
  
    $sql = "INSERT INTO td_mail_blacklist VALUES( '{$email}')";
    print "  ".$sql . "\n";
    
    $db_con->query($sql);    
    
    // ��Ͽ���顼
    if (PEAR::isError($db_con)) {
        mb_send_mail($owner_to, $subject, "(rabbit-mail)BlackList����Ͽ�˼��Ԥ��ޤ���\n{$sql}");
        exit;
    }
    
    print "  ��Ͽ��λ\n";
    
    
}

/**
 * �᡼�륢�ɥ쥹����Ͽ����Ƥ��뤫�����å�
 * @param type $email 
 */
function isMailUnique($email){

    global $db_con;

    $email = pg_escape_string($email);
    $sql = "SELECT mail FROM td_mail_blacklist WHERE mail='{$email}'";
    
    $result = $db_con->query($sql);    

    // ����μ���
    $count = $result->numRows();

    $result->free();
    
    // �����Υǡ���̵��
    if ( $count == 0 ) {
        return true;
    }

    // �����Υǡ���ͭ��
    return false;
    
}

/**
 * �᡼�륢�ɥ쥹��ȴ���Ф�
 * @param type $match_list
 * @param type $start_match
 * @param type $end_match 
 */
function getErrMail($match_list, $start_match, $end_match){
 
    // �ޥå����ʤ���н����
    if ( isset($match_list[0])==false ){
        return '';
    }

    // �ޥå���ʬ�Υ᡼�륢�ɥ쥹����
    $start_match = str_replace( "\\", "", $start_match);  // ����ɽ���ǻȤäƤ�����\�פ�����򤹤�Τ�
    $end_match   = str_replace( "\\", "", $end_match);    // ����ɽ���ǻȤäƤ�����\�פ�����򤹤�Τ�
    
    $email = substr($match_list[0], strlen($start_match), strlen($end_match)*-1);
    
    $email = str_replace('"', '', $email); // DoCoMo�� @������ . ��Ϣ³���ƻȤ���� " �ǰϤޤ��Τ�

//    print $match_list[0]. "\n";
//    print $email . "\n";
//    print "\n";
    
    return $email;
    
}

/**
 * �᡼�륢�ɥ쥹���饭��ꥢ��Ƚ��
 * @param type $msg 
 */
function getErrMsgMail($msg){
    
    // �᡼�������ɽ��
    $base_match = '[\|\+\?\/\"0-9,a-z,A-Z,_,\.,-=:#\']+';

    $match_list = '';

    // ���٤ƤΥ᡼��
    $match = $base_match . '@[\w\d_-]+\.[\w\d._-]+';
    if( preg_match('/'.$match.'/', $msg) ){
        
        // �᡼����ʬ��ȴ���Ф�
        
        $start_match = '<';
        $end_match   = '\>';
        $error_match = "{$start_match}{$match}{$end_match}";
        
        preg_match("/{$error_match}/", $msg, $match_list);
        
        return getErrMail($match_list, $start_match, $end_match);
        
    }
    
    
    // DoCoMo
    $match = $base_match . '@docomo\.ne\.jp';
    if( preg_match('/'.$match.'/', $msg) ){
        
        // DoCoMo�Υ᡼����ʬ��ȴ���Ф�
        
        $start_match = '_550_Unknown_user_';
        $end_match   = '\/Giving_up';
        $docomo_match = "{$start_match}{$match}{$end_match}";
        
        preg_match("/{$docomo_match}/", $msg, $match_list);
        
        return getErrMail($match_list, $start_match, $end_match);
        
    }   
    
    // EzWeb
    $match = $base_match . '@ezweb\.ne\.jp';
    if( preg_match("/$match/", $msg) ){
        
        // EzWeb�Υ᡼����ʬ��ȴ���Ф�
        $start_match = 'Remote_host_said:_550_<';
        $end_match   = '>:_User_unknown';
        $ezweb_match = "{$start_match}{$match}{$end_match}";

        preg_match("/$ezweb_match/", $msg, $match_list);

        return getErrMail($match_list, $start_match, $end_match);
        
    }   
    
    // SoftBank, vodafone
    $match = $base_match . '(@softbank\.ne\.jp|@.\.vodafone\.ne\.jp)';
    if( preg_match("/$match/", $msg) ){
        
        // SoftBank, vodafone�Υ᡼����ʬ��ȴ���Ф�
        $start_match = '_550_Invalid_recipient:_<';
        $end_match   = '>\/Giving_up';
        $softbank_match = "{$start_match}{$match}{$end_match}";
        
        preg_match("/$softbank_match/", $msg, $match_list);
        
        
        return getErrMail($match_list, $start_match, $end_match);

    }   

    return -1;
    
}
