<?PHP
/*
 2005/02/08 Sunao Kiyosue ITM 
 文字コード：EUC-JP
 HTML関連
*/

class Html extends Util
{

  // constract
  function Util(){
    $this->Util();
    if( get_magic_quotes_gpc() ==1 ){
      $_POST = $this->getMagicConvert($_POST);
      $_GET  = $this->getMagicConvert($_GET);
    }
  }

  // private
  function getMagicConvert($strings){
    if( $strings == ""){
      return ;
    }
    foreach( $strings as $key => $val ){
      if(! is_array($val) ){
        $strings[$key] = stripslashes($strings[$key]);
      }else{
        $strings[$key] = $this->getMagicConvert($val);
      }
    }
    return $strings ;
  }

  //public
  function getHidden($hiddens,$keyName=""){
    $hidden  = "" ;

    if(! is_array($hiddens) && count($hiddens) > 0){
      echo "MESOTTO hidden is array arges only ".__FILE__." line=".__LINE__;
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

  //public
  function getTextarea(){
    $args = func_get_args();

    if( $args == "" ){
      echo('getTextarea : args empty '.__FILE__.' line='.__LINE__);
    }

    if( count($args) == 1){
      return htmlspecialchars($this->nl2LF($args[0]),ENT_QUOTES) ;
    }else{
      foreach( $args as $val ){
        $words[] = htmlspecialchars($this->nl2LF($val),ENT_QUOTES) ;
      }
      return $words ;
    }
  }

  //public
  function getTextfield(){
    $args = func_get_args();

    if( $args == "" ){
      echo('getTextfield : args empty '.__FILE__.' line='.__LINE__);
    }

    if( count($args) == 1){
      return htmlspecialchars($this->nl2Del($args[0]),ENT_QUOTES) ;
    }else{
      foreach( $args as $val ){
        $words[] = htmlspecialchars($this->nl2Del($val),ENT_QUOTES) ;
      }
      return $words ;
    }
  }

  //public
  function getHtml(){
    $args = func_get_args();

    if( $args == "" ){
      echo('getHtml : args empty '.__FILE__.' line='.__LINE__);
    }

    if( count($args) == 1){
      return nl2br(htmlspecialchars($this->nl2LF($args[0]),ENT_QUOTES));
    }else{
      foreach( $args as $val ){
        $words[] = nl2br(htmlspecialchars($this->nl2LF($val),ENT_QUOTES));
      }
      return $words ;
    }
  }

  //public
  function getSql( ){
    $args = func_get_args();

    if( $args == "" ){
      echo('getSql : args empty '.__FILE__.' line='.__LINE__);
    }

    if( count($args) == 1){
      $args[0] = addslashes($this->nl2LF($args[0]));
      return $args[0] ;
    }else{
      foreach( $args as $key => $val ){
        $val = addslashes($this->nl2LF($val));
        $words[$key] = $val ;
      }
      return $words ;
    }
  }

  //public
  function showSelect( $name,$start,$end,$set,$empty=False ){
    ++$end ;
    echo "<select name='$name' >\n";
    if($empty!=False){
      echo "<option value=''>{$empty}</option>\n";
    }
    while( $start < $end ){
      echo "<option value='{$start}' " ;
      echo $this->getSelected($start ,$set) ;
      echo ">{$start}</option>\n";
      ++$start ;
    }
    echo "</select>\n";
  }

  //public
  function getSelect( $name,$start,$end,$set,$empty=False ){
    ++$end ;
    $str = "";
    $str .= "<select name='$name' >\n";
    if($empty!=False){
      $str .= "<option value=''>{$empty}</option>\n";
    }
    while( $start < $end ){
      $str .= "<option value='{$start}' " ;
      $str .= $this->getSelected($start ,$set) ;
      $str .= ">{$start}</option>\n";
      ++$start ;
    }
    $str .= "</select>\n";
    return $str ;
  }

  //public
  function getSelected($str,$str1){
    if( $str == $str1){
      return "selected" ;
    }
  }
  //public
  function showSelected($str,$str1){
    if( $str == $str1){
      echo "selected" ;
    }
  }
  //public
  function getChecked($str,$str1){
    if( is_array($str1) ){
      return $this->getCheckedArray($str, $str1);
    }else{
      return $this->getCheckedString($str, $str1);
    }
  }
  function getCheckedString($str, $str1){
    if( $str == $str1){
      return "checked" ;
    }
  }
  function getCheckedArray($str, $str1){
    foreach($str1 as $val){
      $checked = $this->getCheckedString($str, $val);
      if( $checked == 'checked' ){
        return 'checked' ;
      }
    }
  }

  //public
  function showChecked($str,$str1){
    if( $str == $str1){
      echo "checked" ;
    }
  }
  function showCheckedArray($str,$ary){
    if(is_array($ary)){
      foreach($ary as $val){
        $this->showChecked($str,$val);
      }
    }
  }
}
?>