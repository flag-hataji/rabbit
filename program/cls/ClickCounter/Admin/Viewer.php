<?php

class Viewer extends ItmViewer
{
//  private $html ;
  var $html ;

  function Viewer(&$db, &$bean)
//  public function __construct(&$db, &$bean)
  {
//    parent::__construct($db, $bean);
    $this->ItmViewer($db, $bean);
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

  //-- --//
  // menu
  function setMenu()
  {
    $this->bean->setView('navi', "ナビ") ;
    $this->bean->setView('title', "タイトル") ;
    $this->bean->setView('message', "メッセーシ") ;
    require_once dirname($_SERVER['SCRIPT_FILENAME']).'/menu.html';
  }


 // -- 表示用パーツ --//
  function viewCategorySelectList($selected, $name, $name2)
  {
    $this->setClassLoad('category', PHP_PATH . '/Model/Category.php');
    echo $this->object['category']->getSelectList($selected, $name, $name2);
  }


  function viewCategorySelect($selected)
  {
    echo $this->getCategorySelect($selected) ;
  }
  function getCategorySelect($selected)
  {
    $this->setClassLoad('category', PHP_PATH . '/Model/Category.php');
    return $this->object['category']->getDataName($selected);
  }

}

?>