<?PHP
/*

  �ե����롦CSV��¸���饹��

*/

class Csv{

  var $name  = '';        // �ե�����̾
  var $path  = '';        // �񤭹�����ե�����ѥ�
  var $code  = 'EUC-JP';  // ��¸ʸ��������
  var $mode  = 'a';       // �񤭹��ߥ⡼��

  var $error = "";				// ERROR����
  
  /**
   * CSV��¸
   */
  Function isWrite( $path=False, $data=False, $code=False, $mode=False ){

    if( ! ($path===false) ) $this->path = $path;
    if( ! ($code===false) ) $this->code = $code;
    if( ! ($mode===false) ) $this->mode = $mode;

    // �ǡ����μ���
    $regist = "";
    if( is_array($data) ){
      foreach( $data as $key=>$value ){
        $regist = $value."\n";
      }
    }else{
      $regist = $data;
    }
    
    // ��¸ʸ��������
    if ( $code!="EUC-JP" ) {
    	$regist = mb_convert_encoding($regist, $code, "EUC-JP");
    }

    // �ե�����ν񤭹���
    $fopen = fopen($this->path, $this->mode);
    flock($fopen,LOCK_EX);
    $flag = fwrite($fopen, $regist);
    flock($fopen, LOCK_UN);
    fclose($fopen);         

    // �񤭹��߼���
    if ( $flag === false ){
    	$this->error = "�ե�����ν񤭹��ߤ˼��Ԥ��ޤ���";
    	return false;
    }

    return True;
  }

}
?>