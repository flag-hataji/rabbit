<?PHP

class Fileup extends Html {

  var $wordcode   = "";
  var $errorNum   = "";
  var $sendMax    = 60;
  var $numS       = "";
  var $flagS      = "";
  var $tempS      = "";
  var $errorS     = "";
  var $dataErrorS = "";

  function Fileup(){
    if( _DEBUG_ ){
      require_once(_DIR_LIB_.'debug/Debug.php');
      $this->Debug = new Debug();
    }
  }


  // DB��³
  function dbConnect(){
    require_once(_DIR_LIB_."db/Postgres.php");
    require_once(_DIR_LIB_."db/ExPostgres.php");
    $ExPostgres = new ExPostgres(_DB_NAME_,_DB_USER_,_DB_HOST_,_DB_PORT_);
    return $ExPostgres;
  }


  // *����* �ǥХå�
  function showArrayDebug( $val=False,$name='Deubg' ){
    if( _DEBUG_ ){
      $this->Debug->arrayView($val, $name, _DEBUG_);
    }
    return;
  }


  // *���* �ե�����
  function deleteFile($root=False,$file=False){
    if( $root!=False && $file!=False  && file_exists($root.$file) ){ 
      chmod ($root.$file, 0777); 
      unlink($root.$file);
    }
    return;
  }


  // *���åץ���* �����å�
  function upTemp($fileS=False,$temp_root=False,$temp_file=False,$mail_confirm=False){
    $this->tempS['root'] = $temp_root;
    $this->tempS['file'] = $temp_file;
    $this->setSendMax($_SESSION['user']['send_now']);

    if( $fileS==False || (isset($fileS) && $fileS['error']==4) ){
      $this->errorNum = 1;

    }else{

      $this->getWordcode($fileS['tmp_name']);

      $dataS=file($fileS['tmp_name']);
      $this->setNumFileLine($dataS);

      $numFileLine = 1;
      $numOk       = 0;
      $numNg       = 0;
      $numPc       = 0;
      $numMobile   = 0;
      $flagPc      = 0;
      $flagMobile  = 0;
      $flagType    = 0;
      foreach( $dataS as $oneData ){
       if( $oneData ){
            echo $this->sendMax;
          if(0 > $this->sendMax){
            $this->errorNum = 2;
            break;
          }
          if($numOk>$this->sendMax){
            $this->errorNum = 2;
            break;
          }
          $oneData = $this->getConvertData($oneData);
          if( $this->checkData( $oneData,$numFileLine ) ){
            $this->setWrite( $oneData );
            list($numPc,$numMobile)=$this->checkMailCareer( $oneData,$numPc,$numMobile );
            $numOk++;
          }else{
            $numNg++;
          }
          
        }
        $numFileLine++;
      }
      //$this->setWrite( "��������λ��ǧ�ѡ�������,{$mail_confirm},%param1%,%param2%,%param3%,%param4%,%param5%" );

      $this->numS['fileLine'] = $numFileLine-1;
      $this->numS['ok']       = $numOk;
      $this->numS['ng']       = $numNg;
      $this->numS['pc']       = $numPc;
      $this->numS['mobile']   = $numMobile;

      if( $this->numS['ok']==0 ){
        $this->errorNum = 3;
      }

      if( $this->numS['fileLine']==0){
        $this->errorNum = 4;
      }

      // PC & Mobile
      if( $numPc!=0 && $numMobile!=0 ){
        $flagPc     = 1;
        $flagMobile = 1;
        $flagType   = 3;
      // PC
      }else if( $numPc!=0 ){
        $flagPc     = 1;
        $flagMobile = 0;
        $flagType   = 1;
      // Mobile
      }else if( $numMobile!=0 ){
        $flagPc     = 0;
        $flagMobile = 1;
        $flagType   = 2;
      }

      $this->flagS['pc']     = $flagPc;
      $this->flagS['mobile'] = $flagMobile;
      $this->flagS['type']   = $flagType;

    }

    $this->setError($this->errorNum);

    return;
  }


  // *����* �ե�����ιԿ�
  function setNumFileLine($dataS){
    $this->numS['fileLine'] = count($dataS);
    return;
  }


  // *����* �����³����
  function setSendMax($num=False){
    if($num!=False){
      $this->sendMax = $num;
    }
    return;
  }


  // *����* �񤭹���
  function setWrite( $str=False,$mode=False ){
    if($mode==False){
      if( !file_exists($this->tempS['root'].$this->tempS['file']) ){ 
        $mode = 'w';
      }else{
        $mode = 'a';
      }
    }

    $explodeS = explode(',',$str);

    $i=0;
    $writeStr = "";
    while ( $i<=6 ){
//      echo "{$i}={$explodeS[$i]}<br>";

      if( isset($explodeS[$i]) ){
        $writeStr .= $explodeS[$i];
      }
      $writeStr .= ",";
      $i++;
    }
    $writeStr .= "\n";

//echo nl2br($writeStr);

    if( !$fp=fopen($this->tempS['root'].$this->tempS['file'],$mode) ){
      $this->errorNum = 91;
    }

    if( !fwrite($fp, $writeStr) ){
      $this->errorNum = 92;
    }

    flock($fp, LOCK_UN);
    fclose($fp);
    chmod ($this->tempS['root'].$this->tempS['file'], 0777); 

    return;
  }


  // *����* �ǡ����Υ���С���
  function getConvertData($str=False){

    $str = mb_convert_encoding($str,'EUC-JP','SJIS');
//    $str = $this->getChangeWordcode($str,$this->wordcode,'EUC-JP');
    $str = $this->nl2Del($str);
    $str = str_replace("\\", "��", $str);
//    $str = str_replace(",", "��", $str);
    $str = str_replace("��", "��", $str);
    $str = str_replace('"', "��", $str);
    $str = str_replace("'", "��", $str);
    //$str = str_replace(":", "��", $str);
    $str = htmlspecialchars($str,ENT_QUOTES);

    $explodeStr = explode(",",$str,3);
    $explodeStr[1] = mb_convert_kana($explodeStr[1], 'as');
    $explodeStr[1] = str_replace(" ","",$explodeStr[1]);

    $str = "{$explodeStr[0]},{$explodeStr[1]},{$explodeStr[2]}";

    return $str;
  }


  // *����* ʸ���������Ѵ�
  function getChangeWordcode($str=False,$before=False,$after=False){
    if($str!="" && ($before!=$after) ){
      $str = mb_convert_encoding( $str, $after,$before );
    }
    return $str;
  }


  // *����* �ե������ʸ��������
  function getWordcode($rootFile=False){

    if( file_exists($rootFile) ){
      $handle = fopen($rootFile, 'r');
      $i = 1;
      $searchWord = "";
      while( !feof($handle) ) {
        $searchWord .= fgets($handle, 4096);
        $i++;
        if($i>10){
          break;
        }
      }
      fclose($handle);

      $searchWord = str_replace("\n","",$searchWord);
      $searchWord = str_replace("\r","",$searchWord);

      $this->wordcode = mb_detect_encoding($searchWord);

    }

    return ;
  }


  // *�����å�* ���ɥ쥹�Υ���ꥢ
  function checkMailCareer( $str=False,$numPc=False,$numMobile=False ){

    require_once(_DIR_LIB_.'check/Check.php');
    $Check = new Check() ;

    if($str!=False){
      $str .= ",";
      list($name,$mail,$paramS) = explode(",",$str);
      if( $Check->isDocomo($mail) || $Check->isVodafone($mail) || $Check->isAu($mail) ){
        $numMobile++;
      }else{
        $numPc++;
      }
    }

    return array($numPc,$numMobile);
  }


  // *�����å�* �ǡ����Υ����å�
  function checkData( $str=False,$num=False ){

    $return = True;

    $errorName = "line{$num}";
    $explodeS  = explode(',',$str);

    $name = "";
    $mail = "";

    if(isset($explodeS['0'])){
      $name = $explodeS['0'];
    }

    if(isset($explodeS['1'])){
      $mail = $explodeS['1'];
    }

    if( $mail=="" ){
      $this->dataErrorS[$errorName] = "{$num}���ܤ˥��ɥ쥹������ޤ���";
      $return = False;
    }else if( !preg_match("/^[\/\.!#&\-_0-9a-z\+]+\@[!#&\-_0-9a-z]+(\.[!#&\-_0-9a-z]+)+$/i",$mail) ){
      $this->dataErrorS[$errorName] = "{$num}���ܤΥ��ɥ쥹�� {$mail} �٤������Ǥ���";
      $return = False;
    }

    return $return;
  }


  // * ���顼
  function setError($errorNum=False){

    switch( $errorNum ){
      // ���ꥨ�顼
      case 1: $this->errorS['fileUp'] = "�᡼��ꥹ�Ȥ����åפ���Ƥ��ޤ���";   break;
      case 2: $this->errorS['fileUp'] = "���������{$this->sendMax}��ޤǤǤ�"; break;
      case 3: $this->errorS['fileUp'] = "����ʥ᡼�륢�ɥ쥹��0��Ǥ�"; break;
      case 4: $this->errorS['fileUp'] = "�᡼��ꥹ����˥ǡ�����¸�ߤ��ޤ���"; break;

      // ���곰���顼
      case 90: $this->errorS['fileUp'] = "ͽ�����̥����ƥ२�顼��ȯ���������ޤ���[ case:{$error} ]"; break;
      case 91: $this->errorS['fileUp'] = "ͽ�����̥����ƥ२�顼��ȯ���������ޤ���[ �񤭤��ߥե�����Υ����ץ󤬽���ޤ���Ǥ��� ]"; break;
      case 92: $this->errorS['fileUp'] = "ͽ�����̥����ƥ२�顼��ȯ���������ޤ���[ �ե�����ؤν񤭤��ߤ�����ޤ���Ǥ��� ]"; break;
    }

    if($this->errorS!=""){
      $this->dataErrorS="";
    }

    return ;
  }

}
?>
