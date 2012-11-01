<?PHP

/*
  list($remote_address,$remote_host,$agent,$type,$generation) = analysisAccess();

  # $remote_address = リモートアドレス  例: 123.456.789
  # $remote_host    = リモートホスト    例: *.hoge.com
  # $agent          = 端末種類          例:「PC」     「DoCoMo」
  # $type           = 携帯機種          例:「win2000」「S501i」
  # $generation     = 携帯世代          例:「MSIE6」  「FOMA」

*/
class Browse{

  var $remote_address = ""; //リモートアドレス
  var $remote_host    = ""; //リモートホスト  
  var $agent          = ""; //端末種類        
  var $type           = ""; //携帯機種        
  var $generation     = ""; //携帯世代        

  var $domain = "";   // メールの@以下の文字
  
  function Browse(){

    $this->analysis();

    return ;
  }


  function analysis(){

    $agent = "";
    $type  = "";
    $generation  = "";

    // * ユーザーエージェントの取得
    $user_agent = getenv('HTTP_USER_AGENT');

    // * リモートアドレスの取得
    $remote_address = getenv('REMOTE_ADDR');
    if($remote_address == ""){
      $remote_address = "unknown";
    }

    // * リモートホストの取得
    $remote_host  = getenv('REMOTE_HOST');
    if ( ($remote_host=="")||($remote_host==$remote_address) ){
      $remote_host = gethostbyaddr($remote_address);
    }
/*
    if( preg_match("/(.*)\.(\d+)$/",$remote_host) ) {
      $remote_host = $remote_host;
    }else if( preg_match("/(.*)\.(.*)\.(.*)\.(.*)$/",$remote_host,$M) ) {
      $remote_host = "*.$M[2].$M[3].$M[4]";
    }else if( preg_match("/(.*)\.(.*)\.(.*)$/",$remote_host,$M) ) {
      $remote_host = "*.$M[2].$M[3]";
    }
*/
    if($remote_host == ""){
      $remote_host = "unknown";

    }



    // * AU / Tu-Ka
    if ( preg_match("/UP\.Browser/i",$user_agent) ){

      if( preg_match("/ido\.ne\.jp/i",$remote_host) ){
        $agent = 'Tu-Ka';
      }else{
        $agent = 'au';
      }

      //# WAP対応
      if( preg_match("/KDDI\-([^\s]*)/i",$user_agent,$M) ){
        $type       = "WAP";
        $generation = "$M[1]";

      //# 旧端末
      }else if( preg_match("/UP\.Browser\/[^\-]*\-([^\s]*)/i",$user_agent,$M) ) {
        $type       = "OLD";
        $generation = "$M[1]";

      //# 不明
      }else{
        $type       = "unknown";
        $generation = "unknown";

      }

    
    // * DoCoMo
    }else if( preg_match("/DoCoMo/i",$user_agent) ){

      $agent = "DoCoMo";

      //# i-mode
      if( preg_match("/DoCoMo\/[^\/]*\/([^\/]*)/i",$user_agent,$M) ){
        $type       = "i-mode";
        $generation = "$M[1]";

      //# FOMA
      }else if( preg_match("/DoCoMo\/[^\s]*\s([^\s]*)/i",$user_agent,$M) ){
        
        $type       = "FOMA";
        $generation = "$M[1]";

      //# 不明
      }else{
        $type       = "unknown";
        $generation = "unknown";

      }

    
    // * vodafone(J-PHONE)
    }else if( preg_match("/J\-PHONE/i",$user_agent) || preg_match("/vodafone/i",$user_agent) ){

      $agent = 'vodafone';

      if( preg_match("/J\-PHONE\/([^\/]*)\/J\-([^\/\s]*)/i",$user_agent,$M) ){
        //# 旧端末
        if($M[1] == '2.0'){
          $type = "OLD";
        //# ステーション
        }else{
          $type = "station";
        }
        $generation = "$M[2]";

      //# 不明
      }else{
        $type       = "unknown";
        $generation = "unknown";

      }


    // * PC
    }else{


      $agent = 'PC';
      if( preg_match("/Windows 95/i",$user_agent) || 
          preg_match("/Win95/i",$user_agent) ){
        $type = "win95";

      }else if( preg_match("/Windows 9x/i",$user_agent) || 
                 preg_match("/Win 9x/i",$user_agent) ){
        $type = "winMe";

      }else if( preg_match("/Windows 98/i",$user_agent) || 
                 preg_match("/Win98/i",$user_agent) ){
        $type = "win98";

      }else if( preg_match("/Windows NT 5.1/i",$user_agent) || 
                 preg_match("/WinNT 5.1/i",$user_agent) ){
        $type = "winXP";

      }else if( preg_match("/Windows NT 5/i",$user_agent) || 
                 preg_match("/WinNT 5/i",$user_agent) ){
        $type = "win2000";

      }else if( preg_match("/Windows NT 6/i",$user_agent) || 
                 preg_match("/XP/i",$user_agent) ){
        $type = "winXP";

      }else if( preg_match("/Windows NT/i",$user_agent) || 
                 preg_match("/WinNT/i",$user_agent) ){
        $type = "winNT";

      }else if( preg_match("/Windows CE/i",$user_agent) || 
                 preg_match("/WinCE/i",$user_agent) ){
        $type = "winCE";

      }else if( preg_match("/Mac/i",$user_agent) ){
        $type = "mac";

      }else if ( preg_match("/X/i",$user_agent)      || 
                  preg_match("/Sun/i",$user_agent)    || 
                  preg_match("/Linux/i",$user_agent)  || 
                  preg_match("/HP\-UX/i",$user_agent) || 
                  preg_match("/BSD/i",$user_agent) ){
      $type = "unix";

      }else{
        $type = "unknown";

      }

      if( preg_match("/MSIE\s?([0-9])/i",$user_agent,$M) ) {
        $generation = "MSIE$M[1]";

      }else if( preg_match("/Mozilla\/([0-9])/i",$user_agent,$M) ) {
        $generation = "Netscape$M[1]";

      }else if( preg_match("/opera\/([0-9])/i",$user_agent,$M) ) {
        $generation = "opera$M[1]";

      }else{
        $generation = "unknown";

      }


    }

    $this->remote_address = $remote_address;  // リモートアドレス
    $this->remote_host    = $remote_host;     // リモートホスト  
    $this->agent          = $agent;           // 端末種類        
    $this->type           = $type;            // 携帯機種        
    $this->generation     = $generation;      // 携帯世代        

    return array($remote_address,$remote_host,$agent,$type,$generation);
  }


  /*
   * 携帯の@以下のドメイン
   * とりあえず、３機種のみ対応
   */
  function setDomain(){
    
    $this->domain['DoCoMo']   = array( 1 => "@docomo.ne.jp");
    
    $this->domain['au']       = array( 1 => "@ezweb.ne.jp");
    
    $this->domain['vodafone'] = array(
      1 => "@d.vodafone.ne.jp",
           "@h.vodafone.ne.jp",
           "@t.vodafone.ne.jp",
           "@c.vodafone.ne.jp",
           "@r.vodafone.ne.jp",
           "@k.vodafone.ne.jp",
           "@n.vodafone.ne.jp",
           "@s.vodafone.ne.jp",
           "@q.vodafone.ne.jp"
    );
    
  }

  /*
   * 指定した携帯タイプのドメインの取得
   */
  function getDomainList($agent=""){
    
    if ( $agent== "" ) { $agent=$this->agent; } 
   
    return $this->domain[$agent];
     
  }
  
}

?>
