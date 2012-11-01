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

  "1" :  ʸ�������Ƭ����������ˤ���ۥ磻�ȥ��ڡ����������   trim
  "2" :  ʸ�������Ƭ����������ˤ���ۥ磻�ȥ��ڡ������Ѥ������   mbTrim
  "3" :  Ϣ³����Ⱦ�Ѷ�����ĤˤޤȤ��(���Ĥ�Ⱦ�Ѥ򣱤Ĥ���)
  "4" :  Ϣ³�������Ѷ�����ĤˤޤȤ��(���Ĥ�Ⱦ�Ѥ��Ĥ���)
  "5" :  Ⱦ�Ѷ������
  "6" :  ���Ѷ������

  ex
  ���ѥ������� �� ���ѥ��ڡ�����Ⱦ�Ѥ� ����Υ��ڡ�������(���Ѥ�)�����̾���ʤ�
  KV2
  ����ǿ��ͤ�Ⱦ�Ѥ����줷���վ��
  KVn2
  �������̾���͵ڤӱѻ���Ⱦ�Ѥ���
  KVa2

  ��������
  2005/07/02 Sunao Kiyosue 
________________________________________________________________*/


class Convert{

  var $encoding = "" ;
  var $str      = "" ;
  var $option   = "" ;
  var $mbOption = "" ;
  var $num      = "" ;

  function Convert($encoding = "EUC_JP"){
    if( substr(phpversion(),0,1) == 3){
      die("PHP VERSION False");
    }
    mb_internal_encoding($encoding);
  }

  //public
  function setEncoding($encoding = "EUC_JP"){
    $this->encoding = $encoding ;
    mb_internal_encoding($this->encoding);
  }

  //  
   function makeOption(){
    $length = strlen($this->option) ;
    $this->mbOption = null ;
    $this->num      = null ;
    $tmp  = "";
    $i = 0 ;
    while( $i < $length ){
      $tmp = substr($this->option,$i,1);
      if( ereg("^[0-9]", $tmp) ){
        $this->num[$i] = $tmp ;
      }else{
        $this->mbOption .= $tmp ;
      }
      ++$i ;
    }
  }

  // public
  function getConvert($str,$option){

    $this->str    = $str    ;
    $this->option = $option ;


    $this->makeOption();
    if($this->mbOption!=""){
      $this->str = mb_convert_kana($this->str, $this->mbOption);
    }
    if( count($this->num) ){
      foreach( $this->num as $key => $val ){
        $this->setConvert( $val );
      }
    }
    return $this->str ;
  }


  // 
   function setConvert( $num ){

    switch ($num){
      case "1" :  $this->str = trim($this->str); break ;
      case "2" :  $this->str = $this->mbTrim($this->str); break ;
      case "3" :  $this->str = ereg_replace("[ ]{2,}",' ',$this->str); break ;
      case "4" :  $this->str = mb_ereg_replace("[��]{2,}",'��',$this->str); break ;
      case "5" :  $this->str = str_replace(" ","",$this->str); break ;//�������
      case "6" :  $this->str = mb_ereg_replace("��","",$this->str); break ;//�������
    }
    return ;
  }


  // mbTrim  
   function mbTrim($str){
    $str = mb_ereg_replace("^[�� \t\n\r\0\x0B]+","",$str);
    $str = mb_ereg_replace("[�� \t\n\r\0\x0B]+$","",$str);
    return $str ;
  }

}
?>