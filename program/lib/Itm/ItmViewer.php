<?php
/*  */

class ItmViewer extends Web
{
//  public $db     = null ;
//  public $bean   = null ;
//  private $object = null ;
  var $db     = null ;
  var $bean   = null ;
  var $object = null ;

  // __construct
  function ItmViewer(&$db, &$bean)
//  public function __construct(&$db, &$bean)
  {
    $this->db   =& $db ;
    $this->bean =& $bean ;
  }

//  public function setClassLoad($key, $name)
  function setClassLoad($key, $name)
  {
    if( isset($this->object[$key]) ){
      return true ;
    }

    if( file_exists($name) ){
      require_once $name ;
    } elseif (file_exists($file = (dirname(__FILE__) . '/' . $filename))) {
      require_once $file ;
    } else {
        die($filename."not existed");
//      return false ;
    }

    $name = basename($name,".php");

    $this->object[$key] = new $name($this->db, $this->bean);
    $this->bean->setObject($key, $this->object[$key]);
  }


  function viewInputHtml($key)
  {
    echo $this->getHtml($this->bean->getInput($key)) ;
  }
  function viewSearchHtml($key)
  {
    echo $this->getHtml($this->bean->getSearch($key)) ;
  }

  function viewErrorMessages()
  {
    if(! is_array($this->bean->error['message']) ){
      return ;
    }
    foreach( $this->bean->error['message'] as $val ){
      echo $val."<br />\n";
    }
  }
  function viewErrorMessage()
  {
    $ary = func_get_args();
    foreach( $ary as $key=>$val ){
      if( isset($this->bean->error['code'][$val]) ){
        echo $this->bean->error['code'][$val] ;
      }
    }
  }

  function viewErrorTag()
  {
    $ary = func_get_args();
    foreach( $ary as $key=>$val ){
      if( isset($this->bean->error['code'][$val]) ){
        echo 'error_box';
        break ;
      }
    }
  }

}

?>