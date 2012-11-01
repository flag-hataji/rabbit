<?PHP
  session_start();

  require_once realpath(dirname(__FILE__).'/../configure.php');

  require_once realpath(dirname(__FILE__).'/../Model/Bean.php') ;
  $bean = new Bean();

  require_once LIB_PATH.'/Itm/ItmController.php';
  require_once realpath(dirname(__FILE__).'/Controller.php');
  new Controller($db, $bean) ;
?>
