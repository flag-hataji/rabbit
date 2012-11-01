<?PHP

class Query extends Html {

  function Query(){

    if( _DEBUG_ ){
      require_once(_DIR_LIB_.'debug/Debug.php');
      $this->Debug = new Debug();
    }

  }

  // DB接続
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
  function setQueryDelete($user_id=False,$flag_permission=False){

    if($user_id!=False){
      $query['td_pictmail']  = "UPDATE td_pictmail SET flag_del=1 WHERE user_id={$user_id}";
      $ExPostgres = $this->dbConnect();
      $ExPostgres->registQuery($query);
      $ExPostgres->close();
    }

  }

  // *SET* permission Query
  function setQueryPermission($user_id=False,$flag_permission=False){

    if($user_id!=False || $flag_permission!=False){
      $query['td_pictmail']  = "UPDATE td_pictmail SET flag_permission={$flag_permission} WHERE user_id={$user_id}";
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

    $column  .= "user_id,";
    $values  .= "{$this->sqlS['user_id']},";
    if($this->sqlS['job_id']!=""){
      $column  .= "job_id,";
      $values  .= "{$this->sqlS['job_id']},";
    }
    $column  .= "id,";
    $values  .= "'{$this->sqlS['id']}',";
    $column  .= "password,";
    $values  .= "'{$this->sqlS['password']}',";
    $column  .= "name_family,";
    $values  .= "'{$this->sqlS['name_family']}',";
    $column  .= "name_first,";
    $values  .= "'{$this->sqlS['name_first']}',";
    $column  .= "kana_family,";
    $values  .= "'{$this->sqlS['kana_family']}',";
    $column  .= "kana_first,";
    $values  .= "'{$this->sqlS['kana_first']}',";
    if($this->sqlS['birthday']!=""){
      $column  .= "birthday,";
      $values  .= "'{$this->sqlS['birthday']}',";
    }else{
      $column  .= "birthday,";
      $values  .= "null,";
    }
    $column  .= "mail,";
    $values  .= "'{$this->sqlS['mail']}',";
    $column  .= "tel,";
    $values  .= "'{$this->sqlS['tel']}',";
    $column  .= "mobile,";
    $values  .= "'{$this->sqlS['mobile']}',";
    $column  .= "fax,";
    $values  .= "'{$this->sqlS['fax']}',";
    $column  .= "zip,";
    $values  .= "{$this->sqlS['zip']},";
    $column  .= "area,";
    $values  .= "'{$this->sqlS['area']}',";
    $column  .= "address1,";
    $values  .= "'{$this->sqlS['address1']}',";
    $column  .= "address2,";
    $values  .= "'{$this->sqlS['address2']}',";
    $column  .= "comment,";
    $values  .= "'{$this->sqlS['comment']}',";
    $column  .= "name_company,";
    $values  .= "'{$this->sqlS['name_company']}',";
    $column  .= "kana_company,";
    $values  .= "'{$this->sqlS['kana_company']}',";
    if($this->sqlS['flag_gender']!=""){
      $column  .= "flag_gender,";
      $values  .= "{$this->sqlS['flag_gender']},";
    }else{
      $column  .= "flag_gender,";
      $values  .= "3,";
    }
    if($this->sqlS['flag_pictmail']!=""){
      $column  .= "flag_pictmail,";
      $values  .= "'t',";
    }
    if($this->sqlS['flag_stepmail']!=""){
      $column  .= "flag_stepmail,";
      $values  .= "'{$this->sqlS['flag_stepmail']}',";
    }

    $column  .= "flag_cc,";
    $values  .= "'F',";

    $column .= "date_insert,";
    $values .= "'now',";

    $column .= "date_update,";
    $values .= "'now',";

    $column = substr($column,0,-1);
    $values = substr($values,0,-1);
    $query['td_user']  = "INSERT INTO td_user({$column}) VALUES ({$values})";

    $column  = "";
    $values  = "";
    $column  .= "user_id,";
    $values  .= "{$this->sqlS['user_id']},";
    $column  .= "send_max,";
    $values  .= "{$this->sqlS['send_max']}, ";
    $column .= "date_insert,";
    $values .= "'now',";
    $column .= "date_update,";
    $values .= "'now',";
    $column = substr($column,0,-1);
    $values = substr($values,0,-1);
    $query['td_pictmail']  = "INSERT INTO td_pictmail({$column}) VALUES ({$values})";



    $column  = "";
    $values  = "";
    $column  .= "user_id,";
    $values  .= "{$this->sqlS['user_id']},";
    $column  .= "send_max,";
    $values  .= "{$this->sqlS['send_max']},";
    $column .= "date_insert,";
    $values .= "'now',";
    $column .= "date_update,";
    $values .= "'now',";
    $column .= "send_now,";
    $values .= "{$this->sqlS['send_max']},";

    $column = substr($column,0,-1);
    $values = substr($values,0,-1);

    $query['td_pictmail']  = "INSERT INTO td_pictmail({$column}) VALUES ({$values})";


    $column  = "";
    $values  = "";
    $column  .= "user_ex1_id,";
    $values  .= "{$this->sqlS['user_ex1_id']},";
    $column  .= "user_id,";
    $values  .= "{$this->sqlS['user_id']},";
    $column  .= "root_id,";
    $values  .= "{$this->sqlS['root_id']},";
    if($this->sqlS['medium_id']!=""){
      $column  .= "medium_id,";
      $values  .= "{$this->sqlS['medium_id']},";
    }
    if($this->sqlS['text_root']!=""){
      $column  .= "text_root,";
      $values  .= "'{$this->sqlS['text_root']}',";
    }
    if($this->sqlS['text_medium']!=""){
      $column  .= "text_medium,";
      $values  .= "'{$this->sqlS['text_medium']}',";
    }
    $column  .= "ip,";
    $values  .= "'{$this->sqlS['ip']}',";
    $column  .= "host,";
    $values  .= "'{$this->sqlS['host']}',";
    if($this->sqlS['referrer']!=""){
      $column  .= "referrer,";
      $values  .= "'{$this->sqlS['referrer']}',";
    }
    $column = substr($column,0,-1);
    $values = substr($values,0,-1);
    $query['td_user_ex1']  = "INSERT INTO td_user_ex1({$column}) VALUES ({$values})";


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

    $query['td_user']  = "UPDATE td_user SET ";
    if($this->sqlS['job_id']!=""){
      $query['td_user'] .= "job_id = {$this->sqlS['job_id']}, ";
    }
    $query['td_user'] .= "id = '{$this->sqlS['id']}', ";
    $query['td_user'] .= "password = '{$this->sqlS['password']}', ";
    $query['td_user'] .= "name_family = '{$this->sqlS['name_family']}', ";
    $query['td_user'] .= "name_first  = '{$this->sqlS['name_first']}', ";
    $query['td_user'] .= "kana_family = '{$this->sqlS['kana_family']}', ";
    $query['td_user'] .= "kana_first  = '{$this->sqlS['kana_first']}', ";
    if($this->sqlS['birthday']!=""){
      $query['td_user'] .= "birthday  = '{$this->sqlS['birthday']}', ";
    }else{
      $query['td_user'] .= "birthday  = null, ";
    }
    $query['td_user'] .= "mail   = '{$this->sqlS['mail']}', ";
    $query['td_user'] .= "tel    = '{$this->sqlS['tel']}', ";
    $query['td_user'] .= "mobile = '{$this->sqlS['mobile']}', ";
    $query['td_user'] .= "fax    = '{$this->sqlS['fax']}', ";
    $query['td_user'] .= "zip    = {$this->sqlS['zip']}, ";
    $query['td_user'] .= "area   = '{$this->sqlS['area']}', ";
    $query['td_user'] .= "address1 = '{$this->sqlS['address1']}', ";
    $query['td_user'] .= "address2 = '{$this->sqlS['address2']}', ";
    $query['td_user'] .= "comment  = '{$this->sqlS['comment']}', ";
    $query['td_user'] .= "name_company  = '{$this->sqlS['name_company']}', ";
    $query['td_user'] .= "kana_company  = '{$this->sqlS['kana_company']}', ";
    if($this->sqlS['birthday']!=""){
      $query['td_user'] .= "flag_gender = {$this->sqlS['flag_gender']}, ";
    }else{
      $query['td_user'] .= "flag_gender = 3, ";
    }
    if($this->sqlS['flag_pictmail']!=""){
      $query['td_user'] .= "flag_pictmail = '{$this->sqlS['flag_pictmail']}', ";
    }
    if($this->sqlS['flag_stepmail']!=""){
      $query['td_user'] .= "flag_stepmail = '{$this->sqlS['flag_stepmail']}', ";
    }
    $query['td_user'] .= "date_update = 'now' ";
    $query['td_user'] .= "WHERE user_id={$this->sqlS['user_id']}";

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


  // *SET* insert Query
  function setQueryInsertStepmail($Manager=False){
    $ExPostgres = $this->dbConnect();

    foreach($Manager->inputS as $key=>$value ){
      $this->sqlS[$key] = $this->getSql($value);
    }

		$query = "INSERT INTO td_stepmail_member (";
		$query .= " user_id, ";
		$query .= " scenario_id, ";
		$query .= " step_no, ";
		$query .= " last_delivery_time, ";
		$query .= " name_family, ";
		$query .= " name_first, ";
		$query .= " email, ";
		$query .= " company, ";
		$query .= " post, ";
		$query .= " param1, ";
		$query .= " param2, ";
		$query .= " param3, ";
		$query .= " param4, ";
		$query .= " param5, ";
		$query .= " param6, ";
		$query .= " param7, ";
		$query .= " param8, ";
		$query .= " param9, ";
		$query .= " param10 ";
		$query .= ")";

		$query .= " VALUES ( ";
		$query .= " 55,";
		$query .= "  101,"; //シナリオID
		$query .= " '0',";
		$query .= " 'Now()',";
		$query .= " '{$this->sqlS['name_family']}',";
		$query .= " '{$this->sqlS['name_first']}',";
		$query .= " '{$this->sqlS['mail']}',";
		if($this->sqlS['name_company']){ $query .= " '{$this->sqlS['name_company']}',"; }else{ $query .= " '' ,";}
		$query .= " '' ,";
		$query .= " '{$this->sqlS['user_id']}' ,";
		$query .= " '' ,";
		$query .= " '' ,";
		$query .= " '' ,";
		$query .= " '' ,";
		$query .= " '' ,";
		$query .= " '' ,";
		$query .= " '' ,";
		$query .= " '' ,";
		$query .= " '' ";
		$query .= " ) ";

    if( !$ExPostgres->registQuery($query) ){
      die(_PG_ROOT_._PG_FILE_MANAGER_." on line ".__LINE__." QUERY Run Error");
    }

    $ExPostgres->close();
  }

}
?>
