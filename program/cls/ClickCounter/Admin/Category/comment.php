<?PHP
  session_start();

  require_once realpath(dirname(__FILE__).'/../../configure.php');

  require_once realpath(dirname(__FILE__).'/../../Model/Bean.php') ;
  $bean = new Bean();

  $query = "SELECT comment1 FROM td_cc_category WHERE user_id = ". $_SESSION['user']['user_id'] . " AND category_id=".pg_escape_string($_GET['id']) ;
  $result = pg_query($db, $query);
  list($comment) = pg_fetch_array($result);
  $bean->setView("comment", $comment);

  require_once dirname($_SERVER['SCRIPT_FILENAME']).'/comment.html';

?>
