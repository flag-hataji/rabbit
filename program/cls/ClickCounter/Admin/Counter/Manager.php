<?php
class Manager extends ItmManager
{

  function Manager(&$db, &$bean)
//  public function __construct(&$db, &$been)
  {
    $this->ItmManager($db, $bean);
//    parent::__construct($db, $bean);
  }

  function setUpdateListSearch()
  {
    return true ;
  }
  function setUpdateList()
  {
    // ŒŸõ‚ð‰Šú‰»
    $this->bean->setSession('searches',"");
    $this->bean->setVar('searches',"");
    return true ;
  }
  function setDeleteListSearch()
  {
    return true ;
  }
  function setDeleteList()
  {
    return true ;
  }
  function setInsert()
  {
    $this->init();
    $this->bean->setSession('inputs', $this->bean->getInputs());
    return true ;
  }
  function setUpdate()
  {
    $this->getData($this->bean->getVar('submit_var'));
    $this->bean->setSession('inputs', $this->bean->getInputs());
    return true ;
  }
  function setDelete()
  {
    $this->getData($this->bean->getVar('submit_var'));
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
    // urlcode‚Ì”­s
    if( $this->bean->getSession('mode') == 'insert'){
      $cc_setup =& $this->bean->getObject('cc_setup');
      $this->bean->setInput('url_cd', $cc_setup->getUrlCd());
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
    switch( $this->bean->getSession('mode') ){
      case 'insert' :
        $bool = $this->setInsertDb() ;
        break ;
      case 'update' :
        $bool = $this->setUpdateDb() ;
        break ;
      case 'delete' :
        $bool = $this->setDeleteDb() ;
        break ;
      default ;
        die("not select mode".__FILE__.__LINE__);
    }

    if( $bool ){
      $this->bean->setSession('inputs',"") ;
    }else{
      die('db error case=' . $this->bean->getSession('mode'));
    }
    return true ;
  }

  function setOver()
  {
    return ;
  }
  function setNonCategory()
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

    $this->bean->setInput('clickcounter_id', "");
    $this->bean->setInput('url_cd', "");
    $this->bean->setInput('url', "");
    $this->bean->setInput('title', "");
    $this->bean->setInput('comment', "");

  }

  // setConvert
  function setConvert()
  {
    require_once LIB_PATH.'/convert/Convert.php';
    $conv = new Convert();

    $inputs = $this->bean->getInputs();

    $inputs['url_cd']        = $conv->getConvert($inputs['url_cd'],"as3");
    $inputs['url']           = $conv->getConvert($inputs['url'],"as3");
    $inputs['title']         = $conv->getConvert($inputs['title'],"KV3");
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

  // db contlloer
  function setInsertDb()
  {
    require_once PHP_PATH . '/ORMap/ORMap.php';
    require_once PHP_PATH . '/ORMap/TdClickCounter.php';
    $db_cc = new TdClickCounter($this->db, $this->bean);
    return $db_cc->setInsert();
  }
  function setUpdateDb()
  {
    require_once PHP_PATH . '/ORMap/ORMap.php';
    require_once PHP_PATH . '/ORMap/TdClickCounter.php';
    $db_cc = new TdClickCounter($this->db, $this->bean);
    return $db_cc->setUpdate();
  }
  function setDeleteDb()
  {
    require_once PHP_PATH . '/ORMap/ORMap.php';
    require_once PHP_PATH . '/ORMap/TdClickCounter.php';
    $db_cc = new TdClickCounter($this->db, $this->bean);
    return $db_cc->setDelete();
  }
  function getData($id)
  {
    require_once PHP_PATH . '/ORMap/ORMap.php';
    require_once PHP_PATH . '/ORMap/TdClickCounter.php';
    $db_cc = new TdClickCounter($this->db, $this->bean);
    return $db_cc->getData($id);
  }

}
?>