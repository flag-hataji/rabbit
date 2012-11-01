<?PHP
/*
  �����Ѵ��ط����饹
  getConvert(�Ѵ�������ʸ����,���ץ����);
  ���ץ����ϥǥե���Ȥ�KV3�Ǥ���
  ���ץ���� : �ʲ��Υ��ץ������Ѵ����˻��ꤷ�ޤ����ǥե���Ȥ�"KV"�Ǥ���
  "r" :  �����ѡױѻ����Ⱦ�ѡפ��Ѵ�
  "R" :  ��Ⱦ�ѡױѻ�������ѡפ��Ѵ�
  "n" :  �����ѡ׿������Ⱦ�ѡפ��Ѵ�
  "N" :  ��Ⱦ�ѡ׿���������ѡפ��Ѵ�
  "a" :  �����ѡױѿ������Ⱦ�ѡפ��Ѵ�
  "A" :  ��Ⱦ�ѡױѿ���������ѡפ��Ѵ�
  "s" :  �����ѡץ��ڡ������Ⱦ�ѡפ��Ѵ� (U+3000 -> U+0020)
  "S" :  ��Ⱦ�ѡץ��ڡ���������ѡפ��Ѵ� (U+0020 -> U+3000)
  "k" :  �������Ҳ�̾�פ��Ⱦ���Ҳ�̾�פ��Ѵ�
  "K" :  ��Ⱦ���Ҳ�̾�פ�������Ҳ�̾�פ��Ѵ�
  "h" :  �����ѤҤ鲾̾�פ��Ⱦ���Ҳ�̾�פ��Ѵ�
  "H" :  ��Ⱦ���Ҳ�̾�פ�����ѤҤ鲾̾�פ��Ѵ�
  "c" :  �����Ѥ�����̾�פ�����ѤҤ鲾̾�פ��Ѵ�
  "C" :  �����ѤҤ鲾̾�פ�����Ѥ�����̾�פ��Ѵ�
  "V" :  �����դ���ʸ�����ʸ�����Ѵ���"K","H"�ȶ��˻��Ѥ��ޤ���

  "1" :  ʸ����򥹥�å���ǥ������Ȥ���     addslashes
  "2" :  ʸ����κǽ��ʸ������ʸ���ˤ���   ucfirst
  "3" :  ʸ�������Ƭ����������ˤ���ۥ磻�ȥ��ڡ����������   trim
  "4" :  ʸ�������ʸ���ˤ���   strtoupper
  "5" :  ʸ�����ʸ���ˤ���   strtolower
  "6" :  �ü�ʸ����HTML����ƥ��ƥ����Ѵ����� htmlspecialchars
  "7" :  mb_trim
  "8" :  addslashes�ǥ������Ȥ��줿ʸ����Υ���������ʬ�������
  "9" :  Ϣ³����Ⱦ�Ѷ������

  ex.
  $str = "  �����ʎݎ�������������������";
  $str = $cConvert->getConvert($str,'KV3');
  echo"$str";// "�����ϥ󥫥�����������������" �Ƚ��Ϥ���ޤ���
________________________________________________________________*/


/**
 * ����С��ȥ��饹
 */
class Convert
{

  var $str      = "";
  var $option   = "KV3";
  var $mbOption = "";

  /**
   * ���󥹥ȥ饯��
   * mb�ط��Υ⥸�塼�뤬�Ȥ��뤫�����å�
   * ����ʸ�������ɤ���꤬�ʤ��¤�EUC������
   */
  function Convert( $code = null ){
    if( substr(phpversion(),0,1) == 3){
      die("PHP VERSION False = ".phpversion() );
    }
    if( $code ){
        mb_internal_encoding($code);
    } else {
      if( mb_internal_encoding() != "UTF8"){
        mb_internal_encoding("UTF8");
      }
    }
  }

  /**
   * �Ѵ�����
   * $str �� $option �ˤ������ä��Ѵ�
   * $option �����ϥإå�����ʬ�Υ����Ȥ򻲾�
   * param mixed $str
   * param str $option
   * return $str �Ѵ����줿ʸ����
   */
  function getConvert($str, $option=""){

    $this->str = $str ;
    if($option!=""){
      $this->option = $option ;
    }
    if($str==""){
      return ;
    }

    // option�β���
    $length = strlen($this->option) ;
    $this->mbOption = "";
    $tmp  = "";
    $num  = "";
    $i = 0 ;
    while( $i < $length ){
      $tmp = substr($this->option,$i,1);
      if( ereg("^[0-9]",$tmp) ){
        $num[$i] = $tmp ;
      }else{
        $this->mbOption .= $tmp ;
      }
      ++$i ;
    }

    if($this->mbOption!=""){
      $this->str = mb_convert_kana($this->str, $this->mbOption);
    }

    if( count($num) ){
      foreach( $num as $key => $val ){
        $this->getConvertData( $val );
      }
    }

    return $this->str ;
  }


  /**
   * ����������б������Ѵ���Ԥ���
   * param int $num
   */
  function getConvertData( $num ){

    switch ($num){
      case "1" :  $this->str = addslashes($this->str); break ;
      case "2" :  $this->str = ucfirst($this->str); break ;
      case "3" :  $this->str = trim($this->str); break ;
      case "4" :  $this->str = strtoupper($this->str); break ;
      case "5" :  $this->str = strtolower($this->str); break ;
      case "6" :  $this->str = htmlspecialchars($this->str); break ;
      case "7" :  $this->str = mb_trim($this->str); break ;
      case "8" :  $this->str = stripslashes($this->str); break ;
      case "9" :  $this->str = ereg_replace("[ ]{2,}",' ',$this->str);
    }
    return ;
  }

  /**
   * �ޥ���Х��Ȥ����Ѥ�ޤ�trim��Ԥ�
   * ʸ�������Ƭ����������ˤ���ۥ磻�ȥ��ڡ����������
   * param string $str �Ѵ�����ʸ����
   * return string $str �Ѵ����줿ʸ����
   */
  function mb_trim($str){

    $str = mb_ereg_replace("^[�� ]+","",$str);
    $str = mb_ereg_replace("[�� ]+$","",$str);

    return $str ;
  }


}
