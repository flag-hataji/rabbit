<?PHP
	/*
		File̾��Library.php

			���ӡ��ޥ�������饤�֥�궦�̥��饹

		�����ԡ�ITM kenji fujita
	
	*/

class Library {

	var $id   ="";	// ID
	var $name ="";	// NAME
	var $libs ="";	// �ޥ�����Ϣ������

	/**
	* @return void
	* @desc �����
	*/
	function clear(){
		
		$this->id   = "";
		$this->name = "";
		$this->libs = "";
		
	}

	/**
	* @return string
	* @param �������� $id
	* @param ��������ѥ�᡼��	
	* @param ��ɽ���Υǡ�����ޤ�뤫�� �ޤ��=True
	* @desc �ץ�ѥƥ���name���ͤ��֤�
	*/
	function getLibParam($id, $param, $flag=false){
		
		$ary = $this->getLibData($id, $flag);
		return $ary[$param];
		
	}
	
	/**
	* @return Array
	* @param ��ɽ���Υǡ�����ޤ�뤫�� �ޤ��=True
	* @desc �ޥ����� ID => NAME ��Ϣ������ˤ����֤�
	*/
	function getDataToAry($flag=false){

		$strs = "";
		foreach ($this->libs as $ary ) {

			// ��ɽ���ϼ������ʤ�
			if ( $flag==false and $ary['open']==false){		continue;		}

			// �ͤμ���
			$id   = $ary['id'];
			$name = $ary['name'];
			$str[$id] = $name;

		}

		return $str;

	}

	/**
	* @return Array
	* @param ��ɽ���Υǡ�����ޤ�뤫�� �ޤ��=True
	* @desc �ޥ����� ID => NAME ��Ϣ������ˤ����֤�
	*/
	function getDataToNames($flag=false){

		$strs = "";
		foreach ($this->libs as $ary ) {

			// ��ɽ���ϼ������ʤ�
			if ( $flag==false and $ary['open']==false){		continue;		}

			// �ͤμ���
			$name = $ary['name'];
			$str[] = $name;

		}

		return $str;

	}	
	
	/**
	* @return String
	* @param �������� $id
	* @param ��ɽ���Υǡ�����ޤ�뤫�� �ޤ��=True
	* @desc ���������ͤμ���
  */
  function getLibName($id, $flag=false){
   
  	$ary = $this->getLibData($id, $flag);
  	
  	if ( is_array($ary) ) {
  		return $ary['name'];
  	}else {
	     return "";
  	}

  }
  
	/**
	* @return String
	* @param �����Ȥʤ�Name���� $name
	* @param ��ɽ���Υǡ�����ޤ�뤫�� �ޤ��=True
	* @desc �ǡ�������ID�μ���
	*/
  function getLibId($name, $flag=false){

    foreach ($this->libs as $ary ){
      if ( $ary['name']==$name) {
      	return ( $ary['open']==true ) ? $ary['name'] : '';
      } 
    }
    return "";

  }

	/**
	* @return void
	* @param id����
	* @param ��ɽ���Υǡ�����ޤ�뤫�� �ޤ��=True
	* @desc id�����ͤ򸡺������åȤ���
	*/
	function setLibData($id, $flag=false){

		$ary = $this->getLibData($id, $flag);

		if ( is_array($ary) ) {
			$this->id   = $ary['id'];
			$this->name = $ary['name'];
		}else {
			$this->id  = "";
			$this->name = "";
		}

	}

	/**
	* @return Array
	* @param id���� $id
	* @param ��ɽ���Υǡ�����ޤ�뤫�� �ޤ��=True
	* @desc id�����ͤ򸡺�����������
	*/
	function getLibData($id, $flag=false){

		foreach ($this->libs as $ary ){
      if ( $ary['id'] == $id ) {
      	if ( $flag==false and $ary['open']==false ){
      		return '';
      	}
        return $ary; 
      } 
    }

    return '';

	}
	
	/**
	* @return string
	* @desc �ץ�ѥƥ���Id���ͤ��֤�
	*/
	function getId(){
		return $this->id;
	}

	/**
	* @return string
	* @desc �ץ�ѥƥ���name���ͤ��֤�
	*/
	function getName(){
		return $this->name;
	}

}

?>