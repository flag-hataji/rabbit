<?php
class Controller extends ItmController
{
  var $manager = null ;
  var $viewer  = null ;

//  public function __construct(&$db)
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
  }


  function setDistribution()
  {

    $this->setStart();

    switch($this->bean->getVar('submit_key')){
      // menu
      case 'menu' :
        $this->setMenu();
        break ;
      default :
        $this->setDefault();
    }
    if( LOG_FLAG ){
      $this->manager->setLog();
    }

    $this->setEnd();
  }
  // menu
  function setMenu()
  {
    $this->bean->setSession('mode', 'view');
    $this->bean->setVar('action', 'menu');
    $this->manager->setMenu();
    $this->viewer->setMenu();
    return ;
  }

  // default
  function setDefault()
  {
    $this->setMenu();
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