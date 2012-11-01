<?php
// clickcounter/[user_id]/[url_cd]
// cls/clickcounter/index.php?a=user_id&b=url_cd

class ClickCounter
{

  var $default_url  = "http://www.itm-asp.com/cc_ng.html";
  var $conf_flag    = "2";// file=1 db=2
  var $save_flag    = "1";// file=1 db=2 db&file3
  var $connection   = "host=localhost port=5432 dbname=itm-asp user=pgsql";
  var $db           = null ;
  var $inputs       = null;

  // __construct
  function ClickCounter()
  {

    if( $this->conf_flag ==2 OR $this->save_flag != 1){
      $this->setConnect() ;
    }

    $this->inputs['redirect_url'] = $this->default_url ;

    $this->setInputsData();

    if(! $this->isCheckVar( $this->inputs['user_id'] ) ){
      $this->setRedirect($this->inputs['redirect_url']);
    }
    if(! $this->isCheckVar( $this->inputs['url_cd'] ) ){
      $this->setRedirect($this->inputs['redirect_url']);
    }
    // 設定の呼び出し
    $this->Controller();
    $this->setRedirect($this->inputs['redirect_url']);
  }


  /**
   * URLから変数を抜き出す。
   * 
   */
  function setInputsData()
  {
    $datas = explode("/", $_SERVER["REQUEST_URI"]);
    array_shift($datas);// 2階層ずらす
    array_shift($datas);
    $this->inputs['user_id']  = array_shift($datas);
    $this->inputs['url_cd']   = array_shift($datas);
    $this->inputs['user_var'] = array_shift($datas);
  }



  /**
   * Controller　保存形式(file or DB)による振り分け。
   * 
   */
  function Controller()
  {
    $flag = false ;
    switch( $this->conf_flag ){
      case 1 :
        $flag = $this->setRedirectUrlFile();
        break ;
      case 2 :
        $flag = $this->setRedirectUrlDb();
        break ;
      default :
    }

    if(! $flag ){
      return ;
    }

    switch( $this->save_flag ){
      case 1 :
        $this->setClickSaveFile();
        break ;
      case 2 :
        $this->setClickSaveDb();
        break ;
      case 3 :
        $this->setClickSaveDb();
        $this->setClickSaveFile();
        break ;
      default :
        $this->setError("mode flag Error");
    }
    // コンバージョン率用Cookie
    $this->setConversionCookie();
  }


  /**
   * リダイレクト設定の呼び出しdb版
   * 
   */
  function setRedirectUrlDb()
  {
    $user_id = pg_escape_string($this->inputs['user_id']) ;
    $url_cd  = pg_escape_string($this->inputs['url_cd'])  ;

    $query = "SELECT clickcounter_id,user_counter_id, url, conversion_id FROM td_clickcounter WHERE user_id= $user_id AND url_cd = '$url_cd' ";

    $result = pg_query($this->db, $query);
    if(pg_num_rows($result) == 1){
      list($this->inputs['clickcounter_id'], $this->inputs['user_counter_id'], $this->inputs['redirect_url'], $this->inputs['conversion_id']) = pg_fetch_array($result, 0);
      return ture ;
    }else{
      return false ;
    }
  }
  /**
   * リダイレクト設定の呼び出しfile版
   * 
   */
  function setRedirectUrlFile()
  {
    $this->inputs['clickcounter_id']   = 0 ;
    $this->inputs['user_counter_id']     = 0 ;
    $this->inputs['redirect_url'] = "" ;

    return false ;
  }


  /**
   * アクセスデータを登録 db版
   * 
   */
  function setClickSaveDb()
  {
    $user_id = pg_escape_string($this->inputs['user_id']) ;
    $url_cd  = pg_escape_string($this->inputs['url_cd'])  ;
    $user_var= pg_escape_string($this->inputs['user_var'])  ;


    if(isset($_SERVER['REMOTE_ADDR'])){
      $remote_addr = pg_escape_string($_SERVER['REMOTE_ADDR'])  ;
    }else{
      $remote_addr = "";
    }
    if(isset($_SERVER['HTTP_USER_AGENT'])){
      $http_user_agent = pg_escape_string($_SERVER['HTTP_USER_AGENT'])  ;
    }else{
      $http_user_agent = "";
    }
    if(isset($_SERVER['HTTP_REFERER'])){
      $http_referer = pg_escape_string($_SERVER['HTTP_REFERER'])  ;
    }else{
      $http_referer = "";
    }

    $query = " INSERT INTO td_click_access ";
    $query .= " VALUES(nextval('td_click_access_seq'), {$this->inputs['user_counter_id']}, $user_id, '$url_cd', '$user_var','{$remote_addr}', '{$http_user_agent}', '{$http_referer}','now','now','now')";

    $result = pg_query($this->db,$query);
    if(! $result){
      $this->setError("insert error $query");
    }
  }

  /**
   * アクセスデータを登録 file版
   * 
   */
  function setClickSaveFile()
  {

    $month    = date("Ym") ;
    $today    = date("Ymd") ;
    $datetime = date("Y-m-d H:i:s");
    $date     = date("Y-m-d");
    $hour     = date("H");
    $path     = "/var/www/clickcounter_log/{$this->inputs['user_id']}/log/{$this->inputs['clickcounter_id']}" ;

    // ＩＤ別に保存
    $logFile  = $path."/click_log_{$today}.txt" ;

//20080410 hataji グーグルボット対策
    $googlebot_count = substr_count($_SERVER['HTTP_USER_AGENT'],"google");
    $yahoobot_count  = substr_count($_SERVER['HTTP_USER_AGENT'],"yahoo");
	$msn_count       = substr_count($_SERVER['HTTP_USER_AGENT'],"msn");
	$picserch_count  = substr_count($_SERVER['HTTP_USER_AGENT'],"picsearch");
	$help_naver_count= substr_count($_SERVER['HTTP_USER_AGENT'],"naver");
	$reap_cs_count   = substr_count($_SERVER['HTTP_USER_AGENT'],"reap");
	
	
	if($googlebot_count==0 && $yahoobot_count == 0 && $msnbot_count==0 && $picserch_count==0 && $help_naver_count==0 && $reap_cs_count==0){
    	$access   = "{$datetime}\t{$this->inputs['clickcounter_id']}\t{$this->inputs['user_counter_id']}\t{$this->inputs['user_id']}\t{$this->inputs['url_cd']}\t{$this->inputs['user_var']}\t{$_SERVER[REMOTE_ADDR]}\t{$_SERVER['HTTP_USER_AGENT']}\t{$_SERVER['HTTP_REFERER']}\t{$date}\t{$hour}" ;
	}else{
		return;
	}
    // dir check
    if(! file_exists($path)){
      mkdir($path) OR die("NOT CREATED MONTH DIR");
    }

    // write
    $fp=fopen($logFile,"a") or die("NOT CREATED ACCESS FILE");
    flock($fp,LOCK_EX);
    fputs($fp,"$access\n");
    flock($fp,LOCK_UN);
    fclose($fp);
  }


  /**
   * コンバーション率用cookieの発行
   * <img src="http://www.itm-asp.com/conv/{user_id}/{conversion_id}">
   * <img src="http://www.itm-asp.com/conv/589/1">
   */
  function setConversionCookie()
  {
    if( $this->inputs['conversion_id'] == ""){// コンバージョンをとる場合だけcookieの発行
      return false ;
    }

    $user_id = $this->inputs['user_id'];

//    if( isset($_COOKIE[$user_id]) ){
//      // 古いデータだけ削除？
//    }

    $name  = $this->inputs['clickcounter_id'] ;
    // {conversion_id}_{user_id}_{url_cd}_{time}
    $value = $this->inputs['conversion_id'] . '_' . $this->inputs['user_id'] . '_' . $this->inputs['url_cd'] . '_' . time();

      // ip - access_date
    header("P3P: CP=\"NOI NOR UNI COM NAV INT DEVo PSDo OUR\", policyref=\"http://www.itm-asp.com/w3c/p3p.xml\"");
    setcookie ("ITM_{$name}", "{$value}", time()+2592000, "/conv/{$user_id}", ".itm-asp.com");// 一ヶ月

    return true ;
  }


//------------------------------------------------------------------------------------------//

  /**
   * DBとのコネクションをはる
   * @return boolean コネクションがはれない場合に false を返す。
   */
  function setConnect()
  {
    $this->db = pg_connect($this->connection);
    if(! $this->db ){
      $this->setError("DB Connect Error");
      return false ;
    }
  }

  /**
   * errorが起きたときにメールを飛ばす
   * @param string $message メール本文
   */
  function setError($message)
  {
    $message = "ClickCounter ERROR \n\n".$message;
    mb_send_mail("system@itm.ne.jp","itm-asp error",$message);// error
  }

  /**
   * $this->inputs の値の検証
   * 
   */
  function isCheckVar($var)
  {
    if(! ereg("^[0-9A-Za-z(]+$",$var) ){
      return false ;
    }
    return true ;
  }

  /**
   * リダイレクト
   * 
   */
  function setRedirect($url)
  {
    header("Location: {$url}");
    exit ;
  }


}

?>