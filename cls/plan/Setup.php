<?PHP
/*
  ÀßÄê
*/


  // LOAD:LIBRARY
  require_once _ROOT_LIB_.'Debug.php';
  require_once _ROOT_LIB_.'Browse.php';
  require_once _ROOT_LIB_.'Util.php';
  require_once _ROOT_LIB_."Code.php";
  require_once _ROOT_LIB_."Convert.php";
  require_once _ROOT_LIB_."Check.php";
  require_once _ROOT_LIB_."Tool.php";
  require_once _ROOT_LIB_.'Mail.php';
  require_once _ROOT_LIB_.'Postgres.php';
  require_once _ROOT_LIB_.'Browse.php';
  require_once _ROOT_LIB_.'Browse.php';

  // LOAD:Expantion
  require_once _ROOT_COMMON_EXP_."ExpDistribution.php";
  require_once _ROOT_COMMON_EXP_."ExpUtil.php";
  require_once _ROOT_COMMON_EXP_."ExpConvert.php";
  require_once _ROOT_COMMON_EXP_."ExpCheck.php";
  require_once _ROOT_COMMON_EXP_."ExpPostgres.php";
  require_once _ROOT_COMMON_EXP_."ExpAttest.php";


  // LOAD:Master
  require_once _ROOT_COMMON_MASTER_."MstAry.php";

  // SET:LIBRARY
  $libDebug    = new Debug();
  $libBrowse   = new Browse();
  $libUtil     = new Util();
  $libCode     = new Code();
  $libConvert  = new Convert();
  $libCheck    = new Check();
  $libTool     = new Tool();
  $libMail     = new Mail();
  $libPostgres = new Postgres();
  $libBrowse   = new Browse();

  // SET:Expantion
  $expDistribution = new ExpDistribution($_POST,$_GET);
  $expUtil         = new ExpUtil();
  $expConvert      = new ExpConvert($libUtil,$libCode);
  $expCheck        = new ExpCheck();
  $expPostgres     = new ExpPostgres();
  $expAttest       = new ExpAttest();

  // SET:Mst
  $mstAry = new MstAry();

?>
