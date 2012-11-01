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
  * @param 変換数値
  * @desc SQL保存用にタグの変換
  */
  function getSqlEncode($val){
		$val = str_replace( "'",  "’", $val);
		$val = str_replace( ",",  "，", $val);
		$val = str_replace( "\\", "￥", $val);
		$val = str_replace( '"',  '”', $val);  	
  	return $val;
  }
  
  /**
  * @return String
  * @param $name hiddenタグのName値
  * @param $val hiddenタグのValue値
  * @desc Hiddenタグの値を生成
  */
  function getHidden($name, $val){
  	return "<input type=\"hidden\" name=\"{$name}\" value=\"{$val}\">";
  }

  /**
  * @return string
  * @param $hiddens hiddenで使用する値の連想配列
  * @param $keyName 表示される連想配列
  * @desc hiddenタグの生成、取得（連想配列版）
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
  * @param $name SelectBoxのNameの値
  * @param $start 数値の開始位置
  * @param $end 数値の終了値
  * @param $set デフォルトの選択値
  * @desc SelectBoxのHTMLタグの取得
  */
  function showSelectNum( $name,$start,$end,$set ){
  	echo $this->getSelectNum( $name,$start,$end,$set );
  }

  /**
  * @return String
  * @param $name SelectBoxのNameの値
  * @param $start 数値の開始位置
  * @param $end 数値の終了値
  * @param $set デフォルトの選択値
  * @desc SelectBoxのHTMLタグの取得
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
  * @param $name SelectBoxの名前
  * @param $ary  表示される連想配列
  * @param $set  デフォルトで選択する値
  * @desc SelectBoxの表示
  */
  function showSelectAry($name, $ary, $set){
  	echo $this->getSelectAry($name, $ary, $set);
  }
  
  /**
  * @return void
  * @param $ary  表示される連想配列
  * @param $set  デフォルトで選択する値
  * @desc SelectBoxのOption部の表示
  */
  function showSelectAryOption($ary, $set){
  	echo $this->getSelectAryOption($ary, $set);
  }
  
  /**
  * @return 
  * @param $name SelectBoxの名前
  * @param $ary  表示される連想配列
  * @param $set  デフォルトで選択する値
  * @desc SelectBoxの取得
  */
  function getSelectAry($name, $ary, $set){
  	
  	$str  = "<select name=\"{$name}\">";
  	$str .= $this->getSelectAryOption($ary,$set);
  	$str .= "</select>";
  	
  	return $str;
  	
  }
  
	/**
	* @return 
  * @param $ary  表示される連想配列
  * @param $set  デフォルトで選択する値
  * @desc SelectBoxのOption部の取得
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
  * @param $name SelectBoxの名前
  * @param $ary  表示される配列
  * @param $set  デフォルトで選択する値
	* @desc SelectBoxの表示
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
  * @param $name SelectBoxの名前
  * @param $ary  表示される配列
  * @param $set  デフォルトで選択する値
	* @desc SelectBoxの表示
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
  * @param $str  比較される値
  * @param $str1 比較する値
  * @desc Selectedの判別
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
  * @param $start 数値の開始位置
  * @param $end 数値の終了値
  * @param $set デフォルトの選択値
  * @desc SelectBoxのHTMLタグの取得
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