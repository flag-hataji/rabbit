<?php
class Controller extends ItmController
{
  var $manager = null ;
  var $viewer  = null ;

//  public function __construct(&$db, &$bean)
 function Controller(&$db, &$bean)
  {
    $this->ItmController($db, $bean);
//    parent::__construct($db);
    $this->setClassLoader();
    $this->setDistribution();
  }

  function setClassLoader()
  {
    require_once LIB_PATH.'/Itm/Web/Web.php';
    require_once LIB_PATH.'/Itm/ItmManager.php';
    require_once dirname(__FILE__).'/Manager.php';
    require_once LIB_PATH.'/Itm/ItmViewer.php';
    require_once dirname(__FILE__).'/Viewer.php';
    $this->manager = new Manager($this->db, $this->bean);
    $this->viewer  = new Viewer( $this->db, $this->bean);
    $this->bean->setObject('manager', $this->manager);
    $this->bean->setObject('viewer', $this->viewer);

    require_once PHP_PATH . '/Model/Table.php';
  }


  function setDistribution()
  {

    $this->setStart();

    switch($this->bean->getVar('submit_key')){
      // insert
      case 'insert':
        $this->setInsert();
        break ;
      // wirte
      case 'write':
        $this->setWrite();
        break ;
      // insert-back
      case 'insert-back':
        $this->setInsertBack();
        break ;
      //confirm
      case 'confirm':
        $this->setConfirm();
        break ;
      // back
      case 'back':
        $this->setBack();
        break ;
      // finish
      case 'finish':
        $this->setFinish();
        break ;
      // over
      case 'over':
        $this->setOver();
        break ;
      default :
        $this->setDefault();
    }
    if( LOG_FLAG ){
      $this->manager->setLog();
    }

    $this->setEnd();
  }


  // insert
  function setInsert()
  {
    $this->bean->setSession('mode', 'insert');
    $this->bean->setVar('action', 'insert');

    $this->manager->setInsert() ;
    $this->viewer->setInsert();
    return ;
  }
  // write
  function setWrite()
  {
    $this->bean->setVar('action', 'write');

    $this->manager->setWrite() ;
    $this->viewer->setWrite();
    return ;
  }
  // insertback
  function setInsertBack()
  {
    $this->bean->setVar('action', 'insert-back');

    $this->manager->setInsertBack() ;
    $this->viewer->setInsertBack();
    return ;
  }
  // confirm
  function setConfirm()
  {
    $this->bean->setVar('action', 'confirm');

    if( $this->manager->setConfirm() ){
      $this->viewer->setConfirm();
    } else {
      $this->manager->setError();
      $this->viewer->setError();
    }
    return ;
  }
  // back
  function setBack()
  {
    $this->bean->setVar('action', 'back');

    $this->manager->setBack() ;
    $this->viewer->setBack();
    return ;
  }
  // finish
  function setFinish()
  {
    $this->bean->setVar('action', 'finish');

    if( $this->manager->setFinish() ){
      $this->viewer->setFinish();
    } else {
      $this->manager->setError();
      $this->viewer->setError();
    }
    return ;
  }
  // over
  function setOver()
  {
    $this->bean->setSession('mode', 'over');
    $this->bean->setVar('action', 'over');
    $this->manager->setOver();
    $this->viewer->setOver();
    return ;
  }

  // default
  function setDefault()
  {
    $this->setInsert();
    return ;
  }


  function setStart()
  {
    $viewer =& $this->bean->getObject('viewer');
    $viewer->setClassLoad('cc_setup', PHP_PATH . '/Model/ClickCounterSetup.php');
    $cc_setup =& $this->bean->getObject('cc_setup');

    $cc_setup->setFolder();
    $this->bean->setView('used_count', $cc_setup->getClickCounterNum());

    if(!  $cc_setup->isCheckCounterNum() ){
      $this->bean->setVar('submit_key', 'over') ;
    }
  }

  function setEnd()
  {
  }


}

?>