<?php
class Manager extends ItmManager
{

  function Manager(&$db, &$bean)
//  public function __construct(&$db, &$been)
  {
    $this->ItmManager($db, $bean);
//    parent::__construct($db, $bean);
  }


  function setMenu()
  {
    return ;
  }
}
?>