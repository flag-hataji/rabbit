<?php
class Manager extends ItmManager
{

  function Manager(&$db, &$bean)
//  public function __construct(&$db, &$been)
  {
    $this->ItmManager($db, $bean);
//    parent::__construct($db, $bean);
  }

  function setInsert()
  {
    $this->init();
    $this->bean->setSession('inputs', $this->bean->getInputs());
    return true ;
  }

  function setWrite()
  {
    $this->bean->setInputs( array_merge($this->bean->getSession('inputs'), $this->bean->getInputs()) ) ;
    unset($this->bean->inputs['submit']);
    $this->bean->setSession('inputs', $this->bean->getInputs());
    return true ;
  }

  function setInsertBack()
  {
    $this->bean->setInputs( array_merge($this->bean->getSession('inputs'), $this->bean->getInputs()) ) ;
    unset($this->bean->inputs['submit']);
    $this->bean->setSession('inputs', $this->bean->getInputs());
    return true ;
  }
  function setConfirm()
  {
    $this->bean->setInputs( array_merge($this->bean->getSession('inputs'), $this->bean->getInputs()) ) ;
    $this->setConvert();
    if(! $this->setInputCheck() ){
      return false ;
    }
    unset($this->bean->inputs['submit']);
    $this->bean->setSession('inputs', $this->bean->getInputs());
    return true ;
  }
  function setBack()
  {
    $this->bean->setInputs( $this->bean->getSession('inputs') ) ;
    return true ;
  }
  function setError()
  {
    unset($this->bean->inputs['submit']);
    $this->bean->setSession('inputs', $this->bean->getInputs());
    return true ;
  }
  function setFinish()
  {
    $this->bean->setInputs( $this->bean->getSession('inputs') ) ;
    $this->setConvert();
    if(! $this->setInputCheck() ){
      return false ;
    }
    // DB “o˜^
    if( $this->setInsertDb() ){
      $this->bean->setSession('inputs',"") ;
    }else{
      die("db insert error");
    }
    return true ;
  }

  function setOver()
  {
    return ;
  }


  /* init
   * ‰Šú•Ï”‚Ì“o˜^A‰Šú‰»
   * 
   **/
  function init()
  {
    $this->bean->setInputs("");
    $this->bean->setSession('inputs', "");

    $this->bean->setInput('category_type', "1");
    $this->bean->setInput('category_id', "");
    $this->bean->setInput('category_name', "");
    $this->bean->setInput('delivery_num', 0);
    $this->bean->setInput('comment', "");
  }

  // setConvert
  function setConvert()
  {
    require_once LIB_PATH.'/convert/Convert.php';
    $conv = new Convert();

    $inputs = $this->bean->getInputs();

    $inputs['category_type'] = $conv->getConvert($inputs['category_type'],"as3");
    $inputs['category_id']   = $conv->getConvert($inputs['category_id'],"as3");
    $inputs['category_name'] = $conv->getConvert($inputs['category_name'],"KV3");
    $inputs['delivery_num']  = $conv->getConvert($inputs['delivery_num'],"as3");
    $inputs['comment']       = $conv->getConvert($inputs['comment'],"KV3");

    $this->bean->setInputs($inputs);
  }

  // setInputCheck
  function setInputCheck()
  {
    require_once dirname(__FILE__).'/InputCheck.php';
    $check = new InputCheck($this->db, $this->bean);
    $check->setCheck();
    $error = $check->getError() ;
    if( $error ){
      $this->bean->setVar("error", $error);
      return false ;
    }
    return true ;
  }

  function setInsertDb()
  {
    require_once PHP_PATH . '/ORMap/ORMap.php';
    require_once PHP_PATH . '/ORMap/TdClickCounter.php';
    $db_cc = new TdClickCounter($this->db, $this->bean);
    return $db_cc->setCounter2Insert();
  }

}
?>