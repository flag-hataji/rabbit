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
      // insert-list
      case 'insert-list':
        $this->setInsertList();
        break ;
      // update-list
      case 'update-list':
        $this->setUpdateList();
        break ;
      // delete-list
      case 'delete-list':
        $this->setDeleteList();
        break ;
      // insert
      case 'insert':
        $this->setInsert();
        break ;
      // update
      case 'update':
        $this->setUpdate();
        break ;
      // delete
      case 'delete':
        $this->setDelete();
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
      default :
        $this->setDefault();
    }
    if( LOG_FLAG ){
      $this->manager->setLog();
    }

    $this->setEnd();
  }


  // insert-list
  function setInsertList()
  {
    $this->bean->setSession('mode', 'insert');
    $this->bean->setVar('action', 'insert-list');

    $this->manager->setInsertList() ;
    $this->viewer->setInsertList();
    return ;
  }
  // update-list
  function setUpdateList()
  {
    $this->bean->setSession('mode', 'update');
    $this->bean->setVar('action', 'update-list');

    $this->manager->setUpdateList() ;
    $this->viewer->setUpdateList();
    return ;
  }
  // delete-list
  function setDeleteList()
  {
    $this->bean->setSession('mode', 'delete');
    $this->bean->setVar('action', 'delete-list');

    $this->manager->setDeleteList() ;
    $this->viewer->setDeleteList();
    return ;
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
  // update
  function setUpdate()
  {
    $this->bean->setSession('mode', 'update');
    $this->bean->setVar('action', 'update');

    $this->manager->setUpdate() ;
    $this->viewer->setUpdate();
    return ;
  }
  // delete
  function setDelete()
  {
    $this->bean->setSession('mode', 'delete');
    $this->bean->setVar('action', 'delete');

    $this->manager->setDelete() ;
    $this->viewer->setDelete();
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

  }

  function setEnd()
  {
  }


}

?>