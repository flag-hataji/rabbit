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
  function setQueryDelete($inquiry_id=False,$flag_permission=False){

    if($inquiry_id!=False){
      $query['td_pictmail']  = "UPDATE td_pictmail SET flag_del=1 WHERE inquiry_id={$inquiry_id}";
      $ExPostgres = $this->dbConnect();
      $ExPostgres->registQuery($query);
      $ExPostgres->close();
    }

  }

  // *SET* permission Query
  function setQueryPermission($inquiry_id=False,$flag_permission=False){

    if($inquiry_id!=False || $flag_permission!=False){
      $query['td_pictmail']  = "UPDATE td_pictmail SET flag_permission={$flag_permission} WHERE inquiry_id={$inquiry_id}";
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

    $column  .= "inquiry_id,";
    $values  .= "{$this->sqlS['inquiry_id']},";
    $column  .= "name_family,";
    $values  .= "'{$this->sqlS['name_family']}',";
    $column  .= "name_first,";
    $values  .= "'{$this->sqlS['name_first']}',";
    $column  .= "kana_family,";
    $values  .= "'{$this->sqlS['kana_family']}',";
    $column  .= "kana_first,";
    $values  .= "'{$this->sqlS['kana_first']}',";
    $column  .= "mail,";
    $values  .= "'{$this->sqlS['mail']}',";
    $column  .= "tel,";
    $values  .= "'{$this->sqlS['tel']}',";
    $column  .= "mobile,";
    $values  .= "'{$this->sqlS['mobile']}',";
    $column  .= "fax,";
    $values  .= "'{$this->sqlS['fax']}',";
    $column  .= "inquiry,";
    $values  .= "'{$this->sqlS['inquiry']}',";
    $column  .= "name_company,";
    $values  .= "'{$this->sqlS['name_company']}',";
    $column  .= "kana_company,";
    $values  .= "'{$this->sqlS['kana_company']}',";
    $column .= "date_insert,";
    $values .= "'now',";
    $column .= "date_update,";
    $values .= "'now',";

    if(isset($_SESSION['user']['user_id'])){
      $column .= "user_id,";
      $values .= $_SESSION['user']['user_id'].",";
    }

    $column = substr($column,0,-1);
    $values = substr($values,0,-1);
    $query['td_inquiry']  = "INSERT INTO td_inquiry({$column}) VALUES ({$values})";

    if( !$ExPostgres->registQuery($query) ){
      die(_PG_ROOT_._PG_FILE_MANAGER_." on line ".__LINE__." QUERY Run Error");
    }

    $ExPostgres->close();
  }


  // *SET* update Query
  function setQueryUpdate($Manager=False){
    $ExPostgres = $this->dbConnect();

    foreach($Manager->inputS as $key=>$value ){
      $this->sqlS[$key] = $this->getSql($value);
    }

    $query['td_inquiry']  = "UPDATE td_inquiry SET ";
    if($this->sqlS['job_id']!=""){
      $query['td_inquiry'] .= "job_id = {$this->sqlS['job_id']}, ";
    }
    $query['td_inquiry'] .= "id = '{$this->sqlS['id']}', ";
    $query['td_inquiry'] .= "password = '{$this->sqlS['password']}', ";
    $query['td_inquiry'] .= "name_family = '{$this->sqlS['name_family']}', ";
    $query['td_inquiry'] .= "name_first  = '{$this->sqlS['name_first']}', ";
    $query['td_inquiry'] .= "kana_family = '{$this->sqlS['kana_family']}', ";
    $query['td_inquiry'] .= "kana_first  = '{$this->sqlS['kana_first']}', ";
    if($this->sqlS['birthday']!=""){
      $query['td_inquiry'] .= "birthday  = '{$this->sqlS['birthday']}', ";
    }else{
      $query['td_inquiry'] .= "birthday  = null, ";
    }
    $query['td_inquiry'] .= "mail   = '{$this->sqlS['mail']}', ";
    $query['td_inquiry'] .= "tel    = '{$this->sqlS['tel']}', ";
    $query['td_inquiry'] .= "mobile = '{$this->sqlS['mobile']}', ";
    $query['td_inquiry'] .= "fax    = '{$this->sqlS['fax']}', ";
    $query['td_inquiry'] .= "zip    = {$this->sqlS['zip']}, ";
    $query['td_inquiry'] .= "area   = '{$this->sqlS['area']}', ";
    $query['td_inquiry'] .= "address1 = '{$this->sqlS['address1']}', ";
    $query['td_inquiry'] .= "address2 = '{$this->sqlS['address2']}', ";
    $query['td_inquiry'] .= "comment  = '{$this->sqlS['comment']}', ";
    $query['td_inquiry'] .= "name_company  = '{$this->sqlS['name_company']}', ";
    $query['td_inquiry'] .= "kana_company  = '{$this->sqlS['kana_company']}', ";
    if($this->sqlS['birthday']!=""){
      $query['td_inquiry'] .= "flag_gender = {$this->sqlS['flag_gender']}, ";
    }else{
      $query['td_inquiry'] .= "flag_gender = 3, ";
    }
    if($this->sqlS['flag_pictmail']!=""){
      $query['td_inquiry'] .= "flag_pictmail = '{$this->sqlS['flag_pictmail']}', ";
    }
    if($this->sqlS['flag_stepmail']!=""){
      $query['td_inquiry'] .= "flag_stepmail = '{$this->sqlS['flag_stepmail']}', ";
    }
    $query['td_inquiry'] .= "date_update = 'now' ";
    $query['td_inquiry'] .= "WHERE inquiry_id={$this->sqlS['inquiry_id']}";

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
