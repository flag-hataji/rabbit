<?PHP
/* 2005/07/25 Kenji FUjita ITM */

class ExHtml extends Html
{

  // constract
  function ExHtml(){
  	
//    $this->Util();
    if( get_magic_quotes_gpc() == 1 ){
      $_POST = $this->getMagicConvert($_POST);
      $_GET  = $this->getMagicConvert($_GET);
    }
    
  }

  /**
  * @return String
  * @param �Ѵ�����
  * @desc SQL��¸�Ѥ˥������Ѵ�
  */
  function getSqlEncode($val){
		$val = str_replace( "'",  "��", $val);
		$val = str_replace( ",",  "��", $val);
		$val = str_replace( "\\", "��", $val);
		$val = str_replace( '"',  '��', $val);  	
  	return $val;
  }
  
  /**
  * @return String
  * @param $name hidden������Name��
  * @param $val hidden������Value��
  * @desc Hidden�������ͤ�����
  */
  function getHidden($name, $val){
  	return "<input type=\"hidden\" name=\"{$name}\" value=\"{$val}\">";
  }

  /**
  * @return string
  * @param $hiddens hidden�ǻ��Ѥ����ͤ�Ϣ������
  * @param $keyName ɽ�������Ϣ������
  * @desc hidden������������������Ϣ�������ǡ�
  */
  function getHiddenAry($hiddens,$keyName=""){
    $hidden  = "" ;

    if(! is_array($hiddens) && count($hiddens) > 0){
      echo ('MESOTTO hidden is array arges only '.__FILE__.' line='.__LINE__);
    }
    if( $keyName !=""){
      foreach( $hiddens as $key => $val ){
        $hidden .= "<input type='hidden' name='{$keyName}[{$key}]' value=\"".htmlspecialchars($val,ENT_QUOTES)."\" >\n";
      }
    }else{
      foreach( $hiddens as $key => $val ){
        $hidden .= "<input type='hidden' name='{$key}' value=\"".htmlspecialchars($val,ENT_QUOTES)."\" >\n";
      }
    }
    return $hidden ;
  }
  
  /**
  * @return void
  * @param $name SelectBox��Name����
  * @param $start ���ͤγ��ϰ���
  * @param $end ���ͤν�λ��
  * @param $set �ǥե���Ȥ�������
  * @desc SelectBox��HTML�����μ���
  */
  function showSelectNum( $name,$start,$end,$set ){
  	echo $this->getSelectNum( $name,$start,$end,$set );
  }

  /**
  * @return String
  * @param $name SelectBox��Name����
  * @param $start ���ͤγ��ϰ���
  * @param $end ���ͤν�λ��
  * @param $set �ǥե���Ȥ�������
  * @desc SelectBox��HTML�����μ���
  */
	function getSelectNum( $name,$start,$end,$set ){

		$str = "";
    $cnt = strlen($end);
    
		$str = "<select name='$name' >\n";
    while( $start <= $end ){
    	$num = sprintf("%0{$cnt}s", $start);
      $str .= "<option value='{$num}' " ;
      $str .= $this->getSelected($num ,$set) ;
      $str .=  ">{$num}</option>\n";
      ++$start ;
    }
    $str .=  "</select>\n";

    return $str;

	}

  /**
  * @return 
  * @param $name SelectBox��̾��
  * @param $ary  ɽ�������Ϣ������
  * @param $set  �ǥե���Ȥ����򤹤���
  * @desc SelectBox��ɽ��
  */
  function showSelectAry($name, $ary, $set){
  	echo $this->getSelectAry($name, $ary, $set);
  }
  
  /**
  * @return void
  * @param $ary  ɽ�������Ϣ������
  * @param $set  �ǥե���Ȥ����򤹤���
  * @desc SelectBox��Option����ɽ��
  */
  function showSelectAryOption($ary, $set){
  	echo $this->getSelectAryOption($ary, $set);
  }
  
  /**
  * @return 
  * @param $name SelectBox��̾��
  * @param $ary  ɽ�������Ϣ������
  * @param $set  �ǥե���Ȥ����򤹤���
  * @desc SelectBox�μ���
  */
  function getSelectAry($name, $ary, $set){
  	
  	$str  = "<select name=\"{$name}\">";
  	$str .= $this->getSelectAryOption($ary,$set);
  	$str .= "</select>";
  	
  	return $str;
  	
  }
  
	/**
	* @return 
  * @param $ary  ɽ�������Ϣ������
  * @param $set  �ǥե���Ȥ����򤹤���
  * @desc SelectBox��Option���μ���
	*/
	function getSelectAryOption($ary, $set){
		
		$str  = "";
		$mark = "";
		foreach ($ary as $key => $val ) {
			$mark = $this->getSelected($key, $set);
			$str .= "<option value=\"{$key}\" {$mark}>$val</option>";
		}
		return $str;
		
	}
	
	/**
	* @return void
  * @param $name SelectBox��̾��
  * @param $ary  ɽ�����������
  * @param $set  �ǥե���Ȥ����򤹤���
	* @desc SelectBox��ɽ��
	*/
	function getOptions($ary, $set){
		
		$str  = "";
		$mark = "";
		foreach ($ary as $val ) {
			$mark = $this->getSelected($val, $set);
			$str .= "<option value=\"{$val}\" {$mark}>$val</option>";
		}

		return $str;

	}
	
	/**
	* @return void
  * @param $name SelectBox��̾��
  * @param $ary  ɽ�����������
  * @param $set  �ǥե���Ȥ����򤹤���
	* @desc SelectBox��ɽ��
	*/
	function getSelects($name, $ary, $set){
		
		$str  = "";
		$mark = "";
		$str = "<select name=\"{$name}\">";
		$str .= $this->getOptions($ary, $set);
		$str .= "</select>";

		return  $str;

	}

	/**
	* @return 
  * @param $str  ��Ӥ������
  * @param $str1 ��Ӥ�����
  * @desc Selected��Ƚ��
	*/
  function getSelected($str,$str1){
    if( $str == $str1){
      return "selected" ;
    }else{
    	return "";
    }
  }
  
  /**
  * @return String
  * @param $start ���ͤγ��ϰ���
  * @param $end ���ͤν�λ��
  * @param $set �ǥե���Ȥ�������
  * @desc SelectBox��HTML�����μ���
  */
  function getOptionNum($start,$end,$set){
  	
		$str = "";
    $cnt = strlen($end);
    
    while( $start <= $end ){
    	$num = sprintf("%0{$cnt}s", $start);
      $str .= "<option value='{$num}' " ;
      $str .= $this->getSelected($num ,$set) ;
      $str .=  ">{$num}</option>\n";
      ++$start ;
    }

    return $str;

	}  	
  	
}
?>