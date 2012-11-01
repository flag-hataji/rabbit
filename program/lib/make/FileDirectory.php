<?PHP

class FileDirectory {

  var $errorWord = "";
  var $errorNum  = 0;

  function FileDirectory(){
    $this->format();
  }

  // ���� - �����
  function format(){

    $this->errorWord = "";
    $this->errorNum  = 0;

    return ;
  }

  // �����å� - �ǥ��쥯�ȥ�¸��
  function existsDir($dir=False){
    $return = False;
    if( is_dir($dir) && file_exists($dir) ){
      $return = True;
    }
    return $return;
  }

  // �����å� - �ե�����¸��
  function existsFile($file=False){
    $return = False;
    if( is_file($file) && file_exists($file) ){
      $return = True;
    }
    return $return;
  }

  // ��� - �ե�����
  Function deleteFile($file=False){
    $return = False;
    if( $this->existsFile($file) ){
      @chmod ($file, 0777); 
      unlink($file);
      $return=True;
    }
    return $return;
  }

  // ��� - �ǥ��쥯�ȥ�
  Function deleteDir($dir=False){
    $return = False;
    if( $this->existsDir($dir) ){
      @chmod ($dir, 0777); 
      rmdir($dir);
      $return=True;
    }
    return $return;
  }


  // �ǥ��쥯�ȥ����
  Function makeDir( $dir=False ){

    $return=False;
    if( $this->existsDir($file) ){
      $this->errorNum = 81;
      $return=True;
    }else if(!mkdir($dir)){
      $this->errorNum = 82;
      $return=True;
    }

    return $return;
  }


  // �ե��������
  Function makeFile( $file=False, $str=False ){

    $return=False;
    if( $this->existsFile($file) ){
      $this->errorNum = 90;
      $return=True;
    }

    if( !$fp = fopen($file,'w') ){
      $this->errorNum = 91;
      $return=True;
    }

    if( !fwrite($fp, $str) ){
      $this->errorNum = 92;
      $return=True;
    }

    flock($fp, LOCK_UN);
    fclose($fp);

    return $return;
  }



  // �ե������ɵ�
  Function writePostscript( $file=False, $str=False ){

    $return=False;
    if( $this->existsFile($file) ){
      $mode = 'a';
    }else{
      $mode = 'w';
    }

    if( !$fp = fopen($file,$mode) ){
      $this->errorNum = 91;
      $return=True;
    }

    if( !fwrite($fp, $str) ){
      $this->errorNum = 92;
      $return=True;
    }

    flock($fp, LOCK_UN);
    fclose($fp);

    return $return;
  }


  // �ե�������
  Function writeSuperscribe( $file=False, $str=False ){

    $return=False;
    if( $this->deleteFile($file) ){
      $mode = 'w';

      if( !$fp = fopen($file,$mode) ){
        $this->errorNum = 91;
        $return=True;
      }

      if( !fwrite($fp, $str) ){
        $this->errorNum = 92;
        $return=True;
      }

      flock($fp, LOCK_UN);
      fclose($fp);

    }else{
      $return=True;
    }

    return $return;
  }




  // ���� - ���顼
  function setError(){

    $return=False;
    switch($this->errorNum){

      case  0:$this->errorWord="";
              $return=False;
              break;

      case 81:$this->errorWord="FAILURE : Directory is Exists";
              $return=True;
              break;
      case 82:$this->errorWord="FAILURE : Directory Make ";
              $return=True;
              break;

      case 90:$this->errorWord="FAILURE : WritingFile is Exists";
              $return=True;
              break;

      case 91:$this->errorWord="FAILURE : WritingFile Open";
              $return=True;
              break;

      case 92:$this->errorWord="FAILURE : WritingFile Write";
              $return=True;
              break;

      default:$this->errorWord="ERROR: is Mystery";
              $return=True;
              break;
    }

    return $return;
  }



}

?>
