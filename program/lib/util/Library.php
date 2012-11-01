<?PHP
	/*
		File名：Library.php

			用途：マスタ周りライブラリ共通クラス

		作成者：ITM kenji fujita
	
	*/

class Library {

	var $id   ="";	// ID
	var $name ="";	// NAME
	var $libs ="";	// マスタの連想配列

	/**
	* @return void
	* @desc 初期化
	*/
	function clear(){
		
		$this->id   = "";
		$this->name = "";
		$this->libs = "";
		
	}

	/**
	* @return string
	* @param キーの値 $id
	* @param 取得するパラメータ	
	* @param 非表示のデータも含めるか？ 含める=True
	* @desc プロパティのnameの値を返す
	*/
	function getLibParam($id, $param, $flag=false){
		
		$ary = $this->getLibData($id, $flag);
		return $ary[$param];
		
	}
	
	/**
	* @return Array
	* @param 非表示のデータも含めるか？ 含める=True
	* @desc マスタを ID => NAME の連想配列にして返す
	*/
	function getDataToAry($flag=false){

		$strs = "";
		foreach ($this->libs as $ary ) {

			// 非表示は取得しない
			if ( $flag==false and $ary['open']==false){		continue;		}

			// 値の取得
			$id   = $ary['id'];
			$name = $ary['name'];
			$str[$id] = $name;

		}

		return $str;

	}

	/**
	* @return Array
	* @param 非表示のデータも含めるか？ 含める=True
	* @desc マスタを ID => NAME の連想配列にして返す
	*/
	function getDataToNames($flag=false){

		$strs = "";
		foreach ($this->libs as $ary ) {

			// 非表示は取得しない
			if ( $flag==false and $ary['open']==false){		continue;		}

			// 値の取得
			$name = $ary['name'];
			$str[] = $name;

		}

		return $str;

	}	
	
	/**
	* @return String
	* @param キーの値 $id
	* @param 非表示のデータも含めるか？ 含める=True
	* @desc キーから値の取得
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
	* @param キーとなるNameの値 $name
	* @param 非表示のデータも含めるか？ 含める=True
	* @desc データからIDの取得
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
	* @param idの値
	* @param 非表示のデータも含めるか？ 含める=True
	* @desc idから値を検索しセットする
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
	* @param idの値 $id
	* @param 非表示のデータも含めるか？ 含める=True
	* @desc idから値を検索し取得する
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
	* @desc プロパティのIdの値を返す
	*/
	function getId(){
		return $this->id;
	}

	/**
	* @return string
	* @desc プロパティのnameの値を返す
	*/
	function getName(){
		return $this->name;
	}

}

?>