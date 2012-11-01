<?PHP
  // 文字コードEUC
  ini_set("display_errors",1);

  require_once('../../program/cls/define/Setup.php');

  if (isset($_GET['val']) && $_GET['val']!="") {

      $isVal  = $_GET['val'];
      $isUserID = "";
      $isPlanID = "";
      list($isUserID,$isPlanID) = explode("_",$isVal,2);
      $isUserID = trim($isUserID);

      if ($isUserID!="") {
          $connect = @pg_connect("host="._DB_HOST_." port="._DB_PORT_." dbname="._DB_NAME_." user="._DB_USER_." ");
          $isQuery = "";
          $isQuery .= "UPDATE td_user SET flag_stepmail='t' WHERE user_id=".$isUserID;
          $result = pg_query($isQuery);
          if (!$result) {
              die("td_pictmail への UPDATE に失敗しました".__FILE__.__LINE__);
          }
          pg_close($connect);
          $_SESSION['user']['flag_stepmail'] = 't';
      }

      require_once("pg_finish_credit.html");
  }

  exit;
?>
