<?PHP
  // 文字コードEUC
  ini_set("display_errors",1);
  session_start();

  require_once('../../../program/cls/define/Setup.php');

  if (isset($_GET['val']) && $_GET['val']!="") {

/*
      $isVal  = $_GET['val'];
      $isUserID = "";
      $isPlanID = "";
      list($isUserID,$isPlanID) = explode("_",$isVal,2);
      $isUserID = trim($isUserID);
      $isPlanID = trim($isPlanID);

      if ($isUserID!="" && $isPlanID!="") {

          $connect = @pg_connect("host="._DB_HOST_." port="._DB_PORT_." dbname="._DB_NAME_." user="._DB_USER_." ");

          $isQuery = "";
          $isQuery .= "SELECT * FROM tm_plan WHERE plan_id=".$isPlanID." ";
          $result = pg_query($isQuery);
          $isResult = pg_query($isQuery);
          $isCount = pg_num_rows($isResult);
          if ($isCount!=0){
              $isDataS = pg_fetch_assoc($isResult,0);
          }
          pg_free_result($isResult);

          $isQuery = "";
          $isQuery .= "UPDATE td_pictmail SET ";
          $isQuery .= "plan_pictmail_id=".$isPlanID.", ";
          $isQuery .= "price_month  = {$isDataS['price_month']}, ";
          $isQuery .= "price_month6 = {$isDataS['price_month6']}, ";
          $isQuery .= "price_year   = {$isDataS['price_year']}, ";
          $isQuery .= "month_max    = {$isDataS['month_max']}, ";
          if ($isPlanID==7) {
              $isQuery .= "send_now=send_now+{$isDataS['send_max']},";
              $isQuery .= "send_max=send_max+{$isDataS['send_max']}, ";
          } else {
              $isQuery .= "send_now     = {$isDataS['send_max']},";
              $isQuery .= "send_max     = {$isDataS['send_max']}, ";
          }
//          $isQuery .= "send_now     = {$isDataS['send_max']},";
//          $isQuery .= "send_max     = {$isDataS['send_max']}, ";
          $isQuery .= "month_now    = 0";


          $isQuery .= "WHERE user_id=".$isUserID." ";
          $result = pg_query($isQuery);
          if (!$result) {
              die("td_pictmail への UPDATE に失敗しました".__FILE__.__LINE__);
          }
          pg_close($connect);
          $_SESSION['user']['plan_pictmail_id'] = $isPlanID;
          $_SESSION['user']['price_month'] = $isDataS['price_month'];
          $_SESSION['user']['price_month6'] = $isDataS['price_month6'];
          $_SESSION['user']['price_year'] = $isDataS['price_year'];
          $_SESSION['user']['send_max'] = $isDataS['send_max'];
          $_SESSION['user']['month_max'] = $isDataS['month_max'];
          $_SESSION['user']['month_now'] = 0;
          $_SESSION['user']['send_now'] = $isDataS['send_max'];

      }
*/

      require_once("pg_finish_credit.html");
  }

  exit;
?>
