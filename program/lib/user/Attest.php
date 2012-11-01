<?PHP
/*

*/
class Attest {

  function Attest(){


    $column  = "td_user.user_id, ";
    $column .= "td_user.job_id, ";
    $column .= "td_user.id, ";
    $column .= "td_user.password, ";
    $column .= "td_user.name_family, ";
    $column .= "td_user.name_first, ";
    $column .= "td_user.kana_family, ";
    $column .= "td_user.kana_first, ";
    $column .= "td_user.birthday, ";
    $column .= "td_user.mail, ";
    $column .= "td_user.tel, ";
    $column .= "td_user.mobile, ";
    $column .= "td_user.fax, ";
    $column .= "td_user.zip, ";
    $column .= "td_user.area, ";
    $column .= "td_user.address1, ";
    $column .= "td_user.address2, ";
    $column .= "td_user.comment, ";
    $column .= "td_user.date_insert, ";
    $column .= "td_user.date_update, ";
    $column .= "td_user.flag_gender, ";
    $column .= "td_user.flag_pictmail, ";
    $column .= "td_user.flag_stepmail, ";
    $column .= "td_user.name_company, ";
    $column .= "td_user.kana_company, ";
    $column .= "td_user.flag_cc, ";


    $column .= "td_pictmail.pictmail_id, ";
    $column .= "td_pictmail.plan_pictmail_id, ";
    $column .= "td_pictmail.account, ";
    $column .= "td_pictmail.price_month, ";
    $column .= "td_pictmail.price_month6, ";
    $column .= "td_pictmail.price_year, ";
    $column .= "td_pictmail.send_max, ";
    $column .= "td_pictmail.send_now, ";
    $column .= "td_pictmail.flag_permission, ";
    $column .= "td_pictmail.flag_dm, ";
    $column .= "td_pictmail.flag_del, ";

    $column .= "tm_plan.plan, ";
    $column .= "tm_plan.flag_type, ";


    $column = substr($column,0,-2);

    $dataS = "";


    if(isset($_POST['id'])){
      $_SESSION['user']['id'] = htmlspecialchars($_POST['id']);
    }
    if(isset($_POST['password'])){
      $_SESSION['user']['password'] = htmlspecialchars($_POST['password']);
    }

    $query  = "SELECT {$column} FROM td_user ";
    $query .= "JOIN td_pictmail ON td_pictmail.user_id = td_user.user_id ";
    $query .= "JOIN tm_plan ON tm_plan.plan_id = td_pictmail.plan_pictmail_id ";
    $query .= "WHERE flag_permission=1 AND td_pictmail.flag_del!=1 AND td_user.id='{$_SESSION['user']['id']}' AND td_user.password='{$_SESSION['user']['password']}'";

    $ExPostgres = $this->dbConnect();
    $ExPostgres->executeQuery($query);
    if( $ExPostgres->getRow()!=0) {
        $dataS = pg_fetch_assoc( $ExPostgres->getResult(),0 );
        pg_free_result( $ExPostgres->getResult() );
    }
    $ExPostgres->close();

    unset($_SESSION['user']);

    if($dataS==""){
      header("Location: "._URL_."login/login_error.html");
      exit;
    }

    foreach($dataS as $key=>$val){
      $_SESSION['user'][$key] = $val;
    }

  }

  // DBÀÜÂ³
  function dbConnect(){
    require_once(_DIR_LIB_."db/Postgres.php");
    require_once(_DIR_LIB_."db/ExPostgres.php");
    $ExPostgres = new ExPostgres(_DB_NAME_,_DB_USER_,_DB_HOST_,_DB_PORT_);
    return $ExPostgres;
  }

}
?>
