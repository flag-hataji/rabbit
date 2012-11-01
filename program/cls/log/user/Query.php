<?PHP

class Query extends Html {

  function Query(){

    if( _DEBUG_ ){
      require_once(_DIR_LIB_.'debug/Debug.php');
      $this->Debug = new Debug();
    }

  }

  // DBÀÜÂ³
  function dbConnect(){
    require_once(_DIR_LIB_."db/Postgres.php");
    require_once(_DIR_LIB_."db/ExPostgres.php");
    $ExPostgres = new ExPostgres(_DB_NAME_,_DB_USER_,_DB_HOST_,_DB_PORT_);
    return $ExPostgres;
  }

  // *SET* remake Query
  function setQueryRemake($dispatch_id=False){
    $ExPostgres = $this->dbConnect();

    $query['td_dispatch']  = "UPDATE td_dispatch SET ";
    $query['td_dispatch'] .= "date_make='now' ";
    $query['td_dispatch'] .= "WHERE dispatch_id={$dispatch_id}";
    if( _DEBUG_!="" ){
      echo "setQueryInsert : {$query['td_dispatch']}<br>\n";
    }
    $ExPostgres->registQuery($query);
    $ExPostgres->close();
  }


  // *SET* delete Query
  function setQueryDelete($log_id=False,$flag_permission=False){

    if($log_id!=False){
      $query['td_pictmail']  = "UPDATE td_pictmail SET flag_del=1 WHERE log_id={$log_id}";
      $ExPostgres = $this->dbConnect();
      $ExPostgres->registQuery($query);
      $ExPostgres->close();
    }

  }

  // *SET* permission Query
  function setQueryPermission($log_id=False,$flag_permission=False){

    if($log_id!=False || $flag_permission!=False){
      $query['td_pictmail']  = "UPDATE td_pictmail SET flag_permission={$flag_permission} WHERE log_id={$log_id}";
      $ExPostgres = $this->dbConnect();
      $ExPostgres->registQuery($query);
      $ExPostgres->close();
    }

  }

  // *SET* insert Query
  function setQueryInsert($Manager=False){
    $ExPostgres = $this->dbConnect();

    foreach($Manager->inputS as $key=>$value ){
      $this->sqlS[$key] = $this->getSql($value);
    }

    $column  = "";
    $values  = "";


    if( $this->sqlS['dispatch_id']!="" ){
      $column .= "dispatch_id,";
      $values .= "{$this->sqlS['dispatch_id']},";
    }
    if( $this->sqlS['company_id']!="" ){
      $column .= "company_id,";
      $values .= "{$this->sqlS['company_id']},";
    }
    if( $this->sqlS['branch_id']!="" ){
      $column .= "branch_id,";
      $values .= "{$this->sqlS['branch_id']},";
    }
    if( $this->sqlS['industry_2_id']!="" ){
      $column .= "industry_2_id,";
      $values .= $this->sqlS['industry_2_id'].",";
    }
    if( $this->sqlS['dispatch_job_2_id']!="" ){
      $column .= "dispatch_job_2_id,";
      $values .= $this->sqlS['dispatch_job_2_id'].",";
    }
    if( $this->sqlS['area_id'] ){
      $column .= "area_id,";
      $values .= $this->sqlS['area_id'].",";
    }
    if( $this->sqlS['english_id'] ){
      $column .= "english_id,";
      $values .= $this->sqlS['english_id'].",";
    }
    if( $this->sqlS['wage'] ){
      $column .= "wage,";
      $values .= $this->sqlS['wage'].",";
    }
    if( $this->sqlS['place'] ){
      $column .= "place,";
      $values .= "'{$this->sqlS['place']}',";
    }
    if( $this->sqlS['comment1'] ){
      $column .= "comment1,";
      $values .= "'{$this->sqlS['comment1']}',";
    }
    if( $this->sqlS['comment2'] ){
      $column .= "comment2,";
      $values .= "'{$this->sqlS['comment2']}',";
    }
    if( $this->sqlS['comment3'] ){
      $column .= "comment3,";
      $values .= "'{$this->sqlS['comment3']}',";
    }
    if( $this->sqlS['comment'] ){
      $column .= "comment4,";
      $values .= "'{$this->sqlS['comment4']}',";
    }
    if( $this->sqlS['comment5'] ){
      $column .= "comment5,";
      $values .= "'{$this->sqlS['comment5']}',";
    }
    if( $this->sqlS['license'] ){
      $column .= "license,";
      $values .= "'{$this->sqlS['license']}',";
    }
    if( $this->sqlS['work_start'] ){
      $column .= "work_start,";
      $values .= "'{$this->sqlS['work_start']}',";
    }
    if( $this->sqlS['work_end'] ){
      $column .= "work_end,";
      $values .= "'{$this->sqlS['work_end']}',";
    }
    if( $this->sqlS['age_min'] ){
      $column .= "age_min,";
      $values .= $this->sqlS['age_min'].",";
    }
    if( $this->sqlS['age_max'] ){
      $column .= "age_max,";
      $values .= $this->sqlS['age_max'].",";
    }
    if( $this->sqlS['year_exp'] ){
      $column .= "year_exp,";
      $values .= $this->sqlS['year_exp'].",";
    }
    if( $this->sqlS['holiday_newyear'] ){
      $column .= "holiday_newyear,";
      $values .= $this->sqlS['holiday_newyear'].",";
    }
    if( $this->sqlS['holiday_summer'] ){
      $column .= "holiday_summer,";
      $values .= $this->sqlS['holiday_summer'].",";
    }
    if( $this->sqlS['holiday_year'] ){
      $column .= "holiday_year,";
      $values .= $this->sqlS['holiday_year'].",";
    }
    if( $this->sqlS['holiday_year'] ){
      $column .= "holiday_other,";
      $values .= "'{$this->sqlS['holiday_other']}',";
    }
    if( $this->sqlS['flag_holiday1'] ){
      $column .= "flag_holiday1,";
      $values .= "'{$this->sqlS['flag_holiday1']}',";
    }
    if( $this->sqlS['flag_holiday2'] ){
      $column .= "flag_holiday2,";
      $values .= "'{$this->sqlS['flag_holiday2']}',";
    }
    if( $this->sqlS['flag_holiday3'] ){
      $column .= "flag_holiday3,";
      $values .= "'{$this->sqlS['flag_holiday3']}',";
    }
    if( $this->sqlS['flag_holiday4'] ){
      $column .= "flag_holiday4,";
      $values .= "'{$this->sqlS['flag_holiday4']}',";
    }
    if( $this->sqlS['flag_holiday5'] ){
      $column .= "flag_holiday5,";
      $values .= "'{$this->sqlS['flag_holiday5']}',";
    }
    if( $this->sqlS['flag_holiday6'] ){
      $column .= "flag_holiday6,";
      $values .= "'{$this->sqlS['flag_holiday6']}',";
    }
    if( $this->sqlS['flag_holiday7'] ){
      $column .= "flag_holiday7,";
      $values .= "'{$this->sqlS['flag_holiday7']}',";
    }
    if( $this->sqlS['flag_age'] ){
      $column .= "flag_age,";
      $values .= $this->sqlS['flag_age'].",";
    }
    if( $this->sqlS['flag_exp'] ){
      $column .= "flag_exp,";
      $values .= $this->sqlS['flag_exp'].",";
    }
    if( $this->sqlS['flag_gender'] ){
      $column .= "flag_gender,";
      $values .= $this->sqlS['flag_gender'].",";
    }
    if( $this->sqlS['flag_engineer'] ){
      $column .= "flag_engineer,";
      $values .= $this->sqlS['flag_engineer'].",";
    }
    if( $this->sqlS['flag_english'] ){
      $column .= "flag_english,";
      $values .= $this->sqlS['flag_english'].",";
    }
    if( $this->sqlS['flag_hurry'] ){
      $column .= "flag_hurry,";
      $values .= $this->sqlS['flag_hurry'].",";
    }
    if( $this->sqlS['flag_ttp'] ){
      $column .= "flag_ttp,";
      $values .= $this->sqlS['flag_ttp'].",";
    }
    if( $this->sqlS['flag_term'] ){
      $column .= "flag_term,"; 
      $values .= $this->sqlS['flag_term'].",";
    }
    if( $this->sqlS['flag_worktime'] ){
      $column .= "flag_worktime,";
      $values .= $this->sqlS['flag_worktime'].",";
    }
    if( $this->sqlS['flag_company'] ){
      $column .= "flag_company,";
      $values .= $this->sqlS['flag_company'].",";
    }
    if( $this->sqlS['flag_detail'] ){
      $column .= "flag_detail,";
      $values .= $this->sqlS['flag_detail'].",";
    }

    $column .= "flag_topics,";
    if( $this->sqlS['flag_topics']==1 ){
      $values .= "1,";
    }else{
      $values .= "0,";
    }

    if( $this->sqlS['sort'] ){
      $column .= "sort,";
      $values .= $this->sqlS['sort'].",";
    }
    if( $this->sqlS['flag_show'] ){
      $column .= "flag_show,";
      $values .= $this->sqlS['flag_show'].",";
    }

    $column .= "date_insert,";
    $values .= "'now',";

    $column .= "date_update,";
    $values .= "'now',";

    $column = substr($column,0,-1);
    $values = substr($values,0,-1);
    $query['td_dispatch']  = "INSERT INTO td_dispatch({$column}) VALUES ({$values})";


    if( !$ExPostgres->registQuery($query) ){
      die(_PG_ROOT_._PG_FILE_MANAGER_." on line ".__LINE__." QUERY Run Error");
    }

    $ExPostgres->close();
  }


  // *SET* update Query
  function setQueryUpdate($Manager=False,$place=False){

    $ExPostgres = $this->dbConnect();

    foreach($Manager->inputS as $key=>$value ){
      $this->sqlS[$key] = $this->getSql($value);
    }

    $query['td_log']  = "UPDATE td_log SET ";
    if($this->sqlS['job_id']!=""){
      $query['td_log'] .= "job_id = {$this->sqlS['job_id']}, ";
    }
    $query['td_log'] .= "id = '{$this->sqlS['id']}', ";
    $query['td_log'] .= "password = '{$this->sqlS['password']}', ";
    $query['td_log'] .= "name_family = '{$this->sqlS['name_family']}', ";
    $query['td_log'] .= "name_first  = '{$this->sqlS['name_first']}', ";
    $query['td_log'] .= "kana_family = '{$this->sqlS['kana_family']}', ";
    $query['td_log'] .= "kana_first  = '{$this->sqlS['kana_first']}', ";
    if($this->sqlS['birthday']!=""){
      $query['td_log'] .= "birthday  = '{$this->sqlS['birthday']}', ";
    }else{
      $query['td_log'] .= "birthday  = null, ";
    }
    $query['td_log'] .= "mail   = '{$this->sqlS['mail']}', ";
    $query['td_log'] .= "tel    = '{$this->sqlS['tel']}', ";
    $query['td_log'] .= "mobile = '{$this->sqlS['mobile']}', ";
    $query['td_log'] .= "fax    = '{$this->sqlS['fax']}', ";
    $query['td_log'] .= "zip    = {$this->sqlS['zip']}, ";
    $query['td_log'] .= "area   = '{$this->sqlS['area']}', ";
    $query['td_log'] .= "address1 = '{$this->sqlS['address1']}', ";
    $query['td_log'] .= "address2 = '{$this->sqlS['address2']}', ";
    $query['td_log'] .= "comment  = '{$this->sqlS['comment']}', ";
    $query['td_log'] .= "name_company  = '{$this->sqlS['name_company']}', ";
    $query['td_log'] .= "kana_company  = '{$this->sqlS['kana_company']}', ";
    if($this->sqlS['birthday']!=""){
      $query['td_log'] .= "flag_gender = {$this->sqlS['flag_gender']}, ";
    }else{
      $query['td_log'] .= "flag_gender = 3, ";
    }
    if($this->sqlS['flag_pictmail']!=""){
      $query['td_log'] .= "flag_pictmail = '{$this->sqlS['flag_pictmail']}', ";
    }
    if($this->sqlS['flag_stepmail']!=""){
      $query['td_log'] .= "flag_stepmail = '{$this->sqlS['flag_stepmail']}', ";
    }
    $query['td_log'] .= "date_update = 'now' ";
    $query['td_log'] .= "WHERE log_id={$this->sqlS['log_id']}";

    if( _DEBUG_ ){
      foreach($query as $key=>$value){
        echo "setQueryUpdate {$key}: {$value}<br>\n";
      }
    }

    if( !$ExPostgres->registQuery($query) ){
      die(_PG_ROOT_._PG_FILE_MANAGER_." on line ".__LINE__." QUERY Run Error");
    }

    $ExPostgres->close();
  }




}
?>
