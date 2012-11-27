<?php
/**
 * maillogのエラーから、メールアドレスをブラックリストに登録
 * 
 * /usr/local/bin/php /var/www/vhosts/www.rabbit-mail.jp/html/program/cls/batch/black_list.php
 * 
 */

// 初期設定
require_once "/var/www/vhosts/www.rabbit-mail.jp/html/program/cls/define/Db.php";      // 本番
//require_once "/var/www/vhosts/test.itm-asp.com/html/program/cls/define/Db.php";   // テスト

require_once '/usr/share/pear/DB.php';

// エラー時の送信先
$subject  = 'rabbit-mail BlackList登録エラー';
$body     = '';
$owner_to = 'hataji@itm.ne.jp';

// 読み込むログファイル
$mail_log_file = '/var/log/maillog';
//$mail_log_file = '/var/log/maillog';

// ブラックリストの一時ファイル
$black_list_file = '/tmp/black_list.temp';

// 抜き出すエラーメッセージ
$mail_err_msg1 = 'said: 550'; 
//$mail_err_msg2 = 'Remote_host_said:_550';
$error_type   = '@yahoo\.co\.jp|@gmail\.com|@google\.co\.jp|@livedoor\.com';

// MailLogからエラーの文字列を抜き出したブラックリストファイルを作成
// /bin/grep 'does_not_like_recipient' /var/log/maillog | /bin/grep  'Remote_host_said:_550' | /bin/egrep '@docomo\.ne\.jp|@softbank\.ne\.jp|@ezweb\.ne\.jp|@.\.vodafone\.ne\.jp' | less
//exec("/bin/grep '{$mail_err_msg1}' {$mail_log_file} | /bin/grep  '{$mail_err_msg2}' | /bin/egrep '{$error_type}' > {$black_list_file}");
exec("/bin/grep '{$mail_err_msg1}' {$mail_log_file} > {$black_list_file}");

// ブラックリストファイルの読み込み
$handle = fopen($black_list_file, 'r');

if ( $handle == false ) {
    die('ブラックリストファイルの読み込みに失敗');
}

// DB接続
$db_con = '';
$db_con = DB::connect( _DB_DSN_ );

if (PEAR::isError($db_con)) {
    mb_send_mail($owner_to, $subject, "DBの接続に失敗しました");
    exit;
}

// １行づつ解析
while( ( $err_msg = fgets($handle) ) !== false ) {

    // メールアドレスの取得
    $email = getErrMsgMail($err_msg);

    if ( $email === -1 ) {
        $body = "キャリアの解析不能\n" . $err_msg;
        mb_send_mail($owner_to, $subject, $body);
        die($body);
        exit;
    }
    
    // ErrorMail
    if ( $email === '' ) {
        $body = "Mailの解析不能\n" . $err_msg;
        mb_send_mail($owner_to, $subject, $body);
        die($body);
        exit;
    }

    // Mailアドレスを td_black_listに登録
    isInsertBlackList($email);
    
}

// ファイルを閉じる
fclose($handle);

// ブラックリストファイルの削除
unlink($black_list_file);

print "完了\n";

/**
 * td_email_black_listに登録
 * @param type $email 
 */
function isInsertBlackList($email){

    global $db_con, $subject, $owner_to;
    
    print ">>{$email}\n";
    
    // 重複データ有りの場合は無視
    if ( isMailUnique($email)==false ) {
        print "  重複有り\n";
        return ;
    }
    print "  重複無し\n";

    $email = pg_escape_string($email);
  
    $sql = "INSERT INTO td_mail_blacklist VALUES( '{$email}')";
    print "  ".$sql . "\n";
    
    $db_con->query($sql);    
    
    // 登録エラー
    if (PEAR::isError($db_con)) {
        mb_send_mail($owner_to, $subject, "(rabbit-mail)BlackListの登録に失敗しました\n{$sql}");
        exit;
    }
    
    print "  登録完了\n";
    
    
}

/**
 * メールアドレスが登録されているかチェック
 * @param type $email 
 */
function isMailUnique($email){

    global $db_con;

    $email = pg_escape_string($email);
    $sql = "SELECT mail FROM td_mail_blacklist WHERE mail='{$email}'";
    
    $result = $db_con->query($sql);    

    // 件数の取得
    $count = $result->numRows();

    $result->free();
    
    // 該当のデータ無し
    if ( $count == 0 ) {
        return true;
    }

    // 該当のデータ有り
    return false;
    
}

/**
 * メールアドレスを抜き出す
 * @param type $match_list
 * @param type $start_match
 * @param type $end_match 
 */
function getErrMail($match_list, $start_match, $end_match){
 
    // マッチしなければ終わり
    if ( isset($match_list[0])==false ){
        return '';
    }

    // マッチ部分のメールアドレス取得
    $start_match = str_replace( "\\", "", $start_match);  // 正規表現で使っていた「\」が邪魔をするので
    $end_match   = str_replace( "\\", "", $end_match);    // 正規表現で使っていた「\」が邪魔をするので
    
    $email = substr($match_list[0], strlen($start_match), strlen($end_match)*-1);
    
    $email = str_replace('"', '', $email); // DoCoMoで @の前や . が連続して使われると " で囲まれるので

//    print $match_list[0]. "\n";
//    print $email . "\n";
//    print "\n";
    
    return $email;
    
}

/**
 * メールアドレスからキャリアの判定
 * @param type $msg 
 */
function getErrMsgMail($msg){
    
    // メールの正規表現
    $base_match = '[\|\+\?\/\"0-9,a-z,A-Z,_,\.,-=:#\']+';

    $match_list = '';

    // すべてのメール
    $match = $base_match . '@[\w\d_-]+\.[\w\d._-]+';
    if( preg_match('/'.$match.'/', $msg) ){
        
        // メール部分の抜き出し
        
        $start_match = '<';
        $end_match   = '\>';
        $error_match = "{$start_match}{$match}{$end_match}";
        
        preg_match("/{$error_match}/", $msg, $match_list);
        
        return getErrMail($match_list, $start_match, $end_match);
        
    }
    
    
    // DoCoMo
    $match = $base_match . '@docomo\.ne\.jp';
    if( preg_match('/'.$match.'/', $msg) ){
        
        // DoCoMoのメール部分の抜き出し
        
        $start_match = '_550_Unknown_user_';
        $end_match   = '\/Giving_up';
        $docomo_match = "{$start_match}{$match}{$end_match}";
        
        preg_match("/{$docomo_match}/", $msg, $match_list);
        
        return getErrMail($match_list, $start_match, $end_match);
        
    }   
    
    // EzWeb
    $match = $base_match . '@ezweb\.ne\.jp';
    if( preg_match("/$match/", $msg) ){
        
        // EzWebのメール部分の抜き出し
        $start_match = 'Remote_host_said:_550_<';
        $end_match   = '>:_User_unknown';
        $ezweb_match = "{$start_match}{$match}{$end_match}";

        preg_match("/$ezweb_match/", $msg, $match_list);

        return getErrMail($match_list, $start_match, $end_match);
        
    }   
    
    // SoftBank, vodafone
    $match = $base_match . '(@softbank\.ne\.jp|@.\.vodafone\.ne\.jp)';
    if( preg_match("/$match/", $msg) ){
        
        // SoftBank, vodafoneのメール部分の抜き出し
        $start_match = '_550_Invalid_recipient:_<';
        $end_match   = '>\/Giving_up';
        $softbank_match = "{$start_match}{$match}{$end_match}";
        
        preg_match("/$softbank_match/", $msg, $match_list);
        
        
        return getErrMail($match_list, $start_match, $end_match);

    }   

    return -1;
    
}
