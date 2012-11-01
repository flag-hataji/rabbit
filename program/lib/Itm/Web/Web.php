<?php

class Web
{
  var $web = null ;

  function Web()
  {
  }

  function setHtmlObject()
  {
    if(! is_object($this->web) ){
      require_once LIB_PATH.'/util/Util.php';
      require_once LIB_PATH.'/util/Html.php';
      $this->web = new Html() ;
    }
  }

  function getObject()
  {
    return $this->web ;
  }

  function getHtml($var)
  {
    $this->setHtmlObject();
    return $this->web->getHtml($var);
  }
  function nl2LF($var)
  {
    $this->setHtmlObject();
    return $this->web->nl2LF($var);
  }

  function getSelected($key,$selected)
  {
    $this->setHtmlObject();
    return $this->web->getSelected($key,$selected);
  }
  function viewChecked($key,$selected)
  {
    $this->setHtmlObject();
    echo $this->web->getChecked($key,$selected);
  }
  function getChecked($key,$selected)
  {
    $this->setHtmlObject();
    return $this->web->getChecked($key,$selected);
  }

}
?>