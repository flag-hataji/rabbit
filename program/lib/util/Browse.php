<?PHP

/*
  list($remote_address,$remote_host,$agent,$type,$generation) = analysisAccess();

  # $remote_address = ��⡼�ȥ��ɥ쥹  ��: 123.456.789
  # $remote_host    = ��⡼�ȥۥ���    ��: *.hoge.com
  # $agent          = ü������          ��:��PC��     ��DoCoMo��
  # $type           = ���ӵ���          ��:��win2000�ס�S501i��
  # $generation     = ��������          ��:��MSIE6��  ��FOMA��

*/
class Browse{

  var $remote_address = ""; //��⡼�ȥ��ɥ쥹
  var $remote_host    = ""; //��⡼�ȥۥ���  
  var $agent          = ""; //ü������        
  var $type           = ""; //���ӵ���        
  var $generation     = ""; //��������        

  var $domain = "";   // �᡼���@�ʲ���ʸ��
  
  function Browse(){

    $this->analysis();

    return ;
  }


  function analysis(){

    $agent = "";
    $type  = "";
    $generation  = "";

    // * �桼��������������Ȥμ���
    $user_agent = getenv('HTTP_USER_AGENT');

    // * ��⡼�ȥ��ɥ쥹�μ���
    $remote_address = getenv('REMOTE_ADDR');
    if($remote_address == ""){
      $remote_address = "unknown";
    }

    // * ��⡼�ȥۥ��Ȥμ���
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

      //# WAP�б�
      if( preg_match("/KDDI\-([^\s]*)/i",$user_agent,$M) ){
        $type       = "WAP";
        $generation = "$M[1]";

      //# ��ü��
      }else if( preg_match("/UP\.Browser\/[^\-]*\-([^\s]*)/i",$user_agent,$M) ) {
        $type       = "OLD";
        $generation = "$M[1]";

      //# ����
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

      //# ����
      }else{
        $type       = "unknown";
        $generation = "unknown";

      }

    
    // * vodafone(J-PHONE)
    }else if( preg_match("/J\-PHONE/i",$user_agent) || preg_match("/vodafone/i",$user_agent) ){

      $agent = 'vodafone';

      if( preg_match("/J\-PHONE\/([^\/]*)\/J\-([^\/\s]*)/i",$user_agent,$M) ){
        //# ��ü��
        if($M[1] == '2.0'){
          $type = "OLD";
        //# ���ơ������
        }else{
          $type = "station";
        }
        $generation = "$M[2]";

      //# ����
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

    $this->remote_address = $remote_address;  // ��⡼�ȥ��ɥ쥹
    $this->remote_host    = $remote_host;     // ��⡼�ȥۥ���  
    $this->agent          = $agent;           // ü������        
    $this->type           = $type;            // ���ӵ���        
    $this->generation     = $generation;      // ��������        

    return array($remote_address,$remote_host,$agent,$type,$generation);
  }


  /*
   * ���Ӥ�@�ʲ��Υɥᥤ��
   * �Ȥꤢ������������Τ��б�
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
   * ���ꤷ�����ӥ����פΥɥᥤ��μ���
   */
  function getDomainList($agent=""){
    
    if ( $agent== "" ) { $agent=$this->agent; } 
   
    return $this->domain[$agent];
     
  }
  
}

?>
