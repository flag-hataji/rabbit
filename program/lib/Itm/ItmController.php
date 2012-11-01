<?php
class ItmController
{
  var $db     = null ;
  var $bean   = null ;

  function ItmController(&$db, &$bean)
//  function __construct(&$db)
  {
    $this->bean =& $bean ; 
    $this->bean->setVar('inputs'  ,$this->getInputsData());
    $this->bean->setVar('searches',$this->getSearchesData());
    $this->bean->setVar('submit_key',$this->getSubmitKey());
    $this->bean->setVar('submit_var',$this->getSubmitValue());
    $this->db   =& $db ;
  }

  function __destruct()
  {
    unset($this->inputs);
    unset($this->searches);
  }

  function getInputsData()
  {
    if(isset($_GET['inputs'])){
      return $_GET['inputs'] ;
    }elseif(isset($_POST['inputs'])){
      return $_POST['inputs'] ;
    }
  }

  function getSearchesData()
  {
    if(isset($_GET['searches'])){
      return $_GET['searches'] ;
    }elseif(isset($_POST['searches'])){
      return $_POST['searches'] ;
    }
  }

  function getSubmitKey()
  {
    if(! is_array($this->bean->getInput('submit')) ){
      return "";
    }
    $submit_key = @key($this->bean->getInput('submit'));
    if( ereg(".*_[xy]{1}$",$submit_key) ){
      $submit_key = substr($submit_key,0,-2);
    }
    return $submit_key ;
  }

  function getSubmitValue()
  {
    if(! is_array($this->bean->getInput('submit')) ){
      return "";
    }
    $submit = $this->bean->getInput('submit') ;

    return array_shift($submit) ;
  }
}


?>