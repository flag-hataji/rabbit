<?PHP
/**
 * HTML関連の汎用クラス for php4.x.x
 *
 * HTML関連の汎用クラス とりあえず最低限利用する分だけに絞り込みました。
 *
 * @copyright 2006 ITManegement
 * @license http://www.itm.ne.jp/license/1_0.txt //ライセンス(存在しないけどね)
 * @version Release: @1.0.0@ //version
 * @link http://www.itm.ne.jp/package/Html // link
 * @since Class available since Release 1.0.0 //since
 * @deprecated Class deprecated in Release 2.0.0 //deprecated
 * @date 2006.10.18
 */


class Html
{

  var $error_message = null ;

  /**
   * コンストラクタ
   * @access public なくてOK　関数宣言でわかるから。
   * @param string $str 引数の説明
   * @return string 返値の説明
   * @throws exceptionclass [description] 　関数/メソッドが例外をスローする場合に記載
   */
  function __construct()
  {
    if( get_magic_quotes_gpc() == 1 ){
      $this->setError( __CLASS__ . ":" . __FUNCTION__ . ":" . __FILE__ . ":" . __LINE__ .":" . 'MAGIC_QUOTE IS ON this class is off only' );
      return false ;
    }
    if(! extension_loaded('mbstring')){
      $this->setError( __CLASS__ . ":" . __FUNCTION__ . ":" . __FILE__ . ":" . __LINE__ .":" . 'mbstring not loaded . you add extension mbstring module' );
      return false ;
    }
  }

  /**
   * デストラクタ __destruct()
   */
  function __deconstruct()
  {
  }

  /**
   * エラーメッセージ保存
   * @access private
   * @param  string $str エラー文章
   * @return void
   * @throws ParamException 
   */
  function setError($str = null)
  {
    if( $str === null ){ return false ;}

    $this->error_message = $str ;
  }

  /**
   * 最後のエラーメッセージを返す。
   * @access public
   * @return str $this->error_message エラー文章
   */
  function getError()
  {
    return $this->error_message ;
  }

  /**
   * 配列から hiddenタグの作成
   * 配列から hiddenタグの作成、データの改行は LFに統一される。
   * @access public
   * @param  array $hiddens $key=>name $val=>value の連想配列
   * @return str $str hiddenのタグ
   * @throws ParamException 
   */
  function getHidden($hiddens = null ){
    if( $hiddens === null ){ return false ;}
    if(! is_array($hiddens) ){
      $this->setError( __CLASS__ . ":" . __FUNCTION__ . ":" . __FILE__ . ":" . __LINE__ .":" . 'param not array' );
      return false ;
    }
    if( count($hiddens) == 0){
      $this->setError( __CLASS__ . ":" . __FUNCTION__ . ":" . __FILE__ . ":" . __LINE__ .":" . 'param is 0' );
      return false ;
    }

    $hidden  = "" ;
    foreach( $hiddens as $key => $val ){
      $hidden .= '<input type="hidden" name="' . $key . '" value="' . htmlspecialchars( $this->nl2LF($val) ) . " >\n";
    }
    return $hidden ;
  }


  /**
   * 配列から HTML表示用のデータを作成
   * データの改行は LFに統一される。
   * @access public
   * @param  void $args func_get_args()で習得
   * @return array $words 変換された文字列
   * @throws ParamException 
   */
  function getHtml(){
    $args = func_get_args();

    if( $args == "" ){
      $this->setError( __CLASS__ . ":" . __FUNCTION__ . ":" . __FILE__ . ":" . __LINE__ .":" . 'param not value' );
      return false ;
    }

    if( count($args) == 1){
      return nl2br(htmlspecialchars( $this->nl2LF($args[0]) ));
    }else{
      foreach( $args as $value ){
        $words[] = nl2br(htmlspecialchars( $this->nl2LF($value) ));
      }
      return $words ;
    }
  }




  /**
   * selected を出力
   * @access public
   * @param  string $value
   * @param  string $selected 
   * @return void  $value == $selected の場合 selectedを出力
   */
  function viewSelected($value, $selected){
    echo $this->getSelected($value, $selected);
  }
  /**
   * selected を返す
   * @access public
   * @param  string $value
   * @param  string $selected 
   * @return str $value == $selected の場合 selectedを返す
   */
  function getSelected($value, $selected){
    if($value === $selected){
      return "selected" ;
    }
  }


  /**
   * checked を出力する
   * @access public
   * @param  string $value
   * @param  mixed  $selected 
   * @return str $value == $selected の場合 selectedを返す
   * @throws ParamException 
   */
  function viewChecked($value, $mixed){
    echo $this->getChecked($value, $mixed);
  }
  /**
   * checked を返す
   * @access public
   * @param  string $value
   * @param  mixed  $selected 
   * @return str $value == $selected の場合 selectedを返す
   * @throws ParamException 
   */
  function getChecked($value, $mixed){
    if(is_array($mixed)){
      if(in_array($value, $mixed)){
        return "checked" ;
      }
    }elseif($value == $mixed){
      return "checked" ;
    }
  }

  /**
   * 数値の場合のセレクトリストの出力
   * @access public
   * @param  string $name
   * @param  integer $start
   * @param  integer $end
   * @param  integer $selected
   * @return void  $value == $selected の場合 selectedを出力
   * @throws ParamException 
   */
  function viewSelectList($name, $start, $end, $selected)
  {
    echo $this->getSelectList($name, $start, $end, $selected) ;
  }
  /**
   * 数値の場合のセレクトリストの作成
   * @access public
   * @param  string $name
   * @param  integer $start
   * @param  integer $end
   * @param  integer $selected
   * @return str $str 変換された文字列
   * @throws ParamException 
   */
  function getSelectList($name, $start, $end, $selected = null){
echo $selected;
    if($name == ""){
      $this->setError( __CLASS__ . ":" . __FUNCTION__ . ":" . __FILE__ . ":" . __LINE__ .":" . 'name not value' );
     return false ;
    }
    if(! ereg("^[0-9]*$", $start)){
      $this->setError( __CLASS__ . ":" . __FUNCTION__ . ":" . __FILE__ . ":" . __LINE__ .":" . 'start not integer' );
     return false ;
    }
    if(! ereg("^[0-9]*$", $end)){
      $this->setError( __CLASS__ . ":" . __FUNCTION__ . ":" . __FILE__ . ":" . __LINE__ .":" . 'start not integer' );
     return false ;
    }

    $str = "<select name='$name' >\n";
    while( $start <= $end ){
      $str .= "<option value='{$start}' " ;
      $str .= $this->getSelected($start ,$selected) ;
      $str .= ">{$start}</option>\n";
      ++$start ;
    }
    $str .= "</select>\n";

    return $str ;
  }

  /**
   * BRを改行コード(LF)に変換
   * @access public
   * @param  string $str
   * @return str $str 変換された文字列
   * @throws ParamException 
   */
  function br2LF( $str = null)
  {
    if($str === null){ return false ;}
    $str = str_replace("<br>","\n",$str);//UNIX
    return $str;
  }


  /**
   * 改行コードをUNIX(LF)に統一
   * @access public
   * @param  string $str
   * @return str $str 変換された文字列
   * @throws ParamException 
   */
  function nl2LF( $str = null)
  {
    if($str === null){ return false ;}
    $str = str_replace("\r\n","\n",$str);
    $str = str_replace("\r","\n",$str);
    return $str;
  }

  /**
   * 改行コードを削除
   * @access public
   * @param  string $str
   * @return str $str 変換された文字列
   * @throws ParamException 
   */
  function nl2Del( $str = null)
  {
    if($str === null){ return false ;}
    $str = str_replace("\r\n","",$str);
    $str = str_replace("\r",  "",$str);
    $str = str_replace("\n",  "",$str);
    return $str ;
  }

  /**
   * 変換文字を元に戻す
   * @access public
   * @param  string $str
   * @return str $str 変換された文字列
   * @throws ParamException 
   */
  function getDecodeTag( $str = null)
  {
    if($str === null){ return false ;}
    $str = str_replace("&amp;","&",$str);
    $str = str_replace("&quot;","\"",$str);
    $str = str_replace("&lt;","<",$str);
    $str = str_replace("&gt;",">",$str);
    return $str;
  }

  /**
   * sjisオリジナルの変換
   * @access public
   * @param  string $str
   * @return str $str 変換された文字列
   * @throws ParamException 
   */
  function getSjisChange($str = null)
  {
    if($str === null){ return false ;}
    $str = rawurlencode($str);
    $str = ereg_replace("%5C%5C","%5C",$str);
    $str = rawurldecode($str);
    return $str;
  }


  // textarea
  function getTextarea()
  {
    $args = func_get_args();

    if( $args == "" ){
      die("getTextarea : args empty");
    }

    if( count($args) == 1){
      return htmlspecialchars( $this->nl2LF( $args[0] ) ) ;
    }else{
      foreach( $args as $value ){
        $words[] = htmlspecialchars( $this->nl2LF( $value ) ) ;
      }
      return $words ;
    }
  }


  // textfield
  function getTextfield()
  {
    $args = func_get_args();

    if( $args == "" ){
      die("getTextfield : args empty");
    }

    if( count($args) == 1){
      return htmlspecialchars( $args[0] ) ;
    }else{
      foreach( $args as $value ){
        $words[] = htmlspecialchars( $value ) ;
      }
      return $words ;
    }
  }


}
