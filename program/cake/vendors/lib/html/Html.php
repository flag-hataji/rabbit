<?PHP
/**
 * HTML��Ϣ�����ѥ��饹 for php4.x.x
 *
 * HTML��Ϣ�����ѥ��饹 �Ȥꤢ������������Ѥ���ʬ�����˹ʤ���ߤޤ�����
 *
 * @copyright 2006 ITManegement
 * @license http://www.itm.ne.jp/license/1_0.txt //�饤����(¸�ߤ��ʤ����ɤ�)
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
   * ���󥹥ȥ饯��
   * @access public �ʤ���OK���ؿ�����Ǥ狼�뤫�顣
   * @param string $str ����������
   * @return string ���ͤ�����
   * @throws exceptionclass [description] ���ؿ�/�᥽�åɤ��㳰�򥹥�������˵���
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
   * �ǥ��ȥ饯�� __destruct()
   */
  function __deconstruct()
  {
  }

  /**
   * ���顼��å�������¸
   * @access private
   * @param  string $str ���顼ʸ��
   * @return void
   * @throws ParamException 
   */
  function setError($str = null)
  {
    if( $str === null ){ return false ;}

    $this->error_message = $str ;
  }

  /**
   * �Ǹ�Υ��顼��å��������֤���
   * @access public
   * @return str $this->error_message ���顼ʸ��
   */
  function getError()
  {
    return $this->error_message ;
  }

  /**
   * ���󤫤� hidden�����κ���
   * ���󤫤� hidden�����κ������ǡ����β��Ԥ� LF�����줵��롣
   * @access public
   * @param  array $hiddens $key=>name $val=>value ��Ϣ������
   * @return str $str hidden�Υ���
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
   * ���󤫤� HTMLɽ���ѤΥǡ��������
   * �ǡ����β��Ԥ� LF�����줵��롣
   * @access public
   * @param  void $args func_get_args()�ǽ���
   * @return array $words �Ѵ����줿ʸ����
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
   * selected �����
   * @access public
   * @param  string $value
   * @param  string $selected 
   * @return void  $value == $selected �ξ�� selected�����
   */
  function viewSelected($value, $selected){
    echo $this->getSelected($value, $selected);
  }
  /**
   * selected ���֤�
   * @access public
   * @param  string $value
   * @param  string $selected 
   * @return str $value == $selected �ξ�� selected���֤�
   */
  function getSelected($value, $selected){
    if($value === $selected){
      return "selected" ;
    }
  }


  /**
   * checked ����Ϥ���
   * @access public
   * @param  string $value
   * @param  mixed  $selected 
   * @return str $value == $selected �ξ�� selected���֤�
   * @throws ParamException 
   */
  function viewChecked($value, $mixed){
    echo $this->getChecked($value, $mixed);
  }
  /**
   * checked ���֤�
   * @access public
   * @param  string $value
   * @param  mixed  $selected 
   * @return str $value == $selected �ξ�� selected���֤�
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
   * ���ͤξ��Υ��쥯�ȥꥹ�Ȥν���
   * @access public
   * @param  string $name
   * @param  integer $start
   * @param  integer $end
   * @param  integer $selected
   * @return void  $value == $selected �ξ�� selected�����
   * @throws ParamException 
   */
  function viewSelectList($name, $start, $end, $selected)
  {
    echo $this->getSelectList($name, $start, $end, $selected) ;
  }
  /**
   * ���ͤξ��Υ��쥯�ȥꥹ�Ȥκ���
   * @access public
   * @param  string $name
   * @param  integer $start
   * @param  integer $end
   * @param  integer $selected
   * @return str $str �Ѵ����줿ʸ����
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
   * BR����ԥ�����(LF)���Ѵ�
   * @access public
   * @param  string $str
   * @return str $str �Ѵ����줿ʸ����
   * @throws ParamException 
   */
  function br2LF( $str = null)
  {
    if($str === null){ return false ;}
    $str = str_replace("<br>","\n",$str);//UNIX
    return $str;
  }


  /**
   * ���ԥ����ɤ�UNIX(LF)������
   * @access public
   * @param  string $str
   * @return str $str �Ѵ����줿ʸ����
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
   * ���ԥ����ɤ���
   * @access public
   * @param  string $str
   * @return str $str �Ѵ����줿ʸ����
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
   * �Ѵ�ʸ���򸵤��᤹
   * @access public
   * @param  string $str
   * @return str $str �Ѵ����줿ʸ����
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
   * sjis���ꥸ�ʥ���Ѵ�
   * @access public
   * @param  string $str
   * @return str $str �Ѵ����줿ʸ����
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
