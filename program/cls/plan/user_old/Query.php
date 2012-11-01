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


  // *SET* update Query
  function setQueryUpdate($Manager=False,$place=False){

    $ExPostgres = $this->dbConnect();

    foreach($Manager->inputS as $key=>$value ){
      $this->sqlS[$key] = $this->getSql($value);
    }


    $query['td_pictmail']  = "UPDATE td_pictmail SET ";
    if($this->sqlS['plan_pictmail_id']!=""){
      $query['td_pictmail'] .= "plan_pictmail_id= {$this->sqlS['plan_pictmail_id']}, ";
    }
    if($this->sqlS['price_month']!=""){
      $query['td_pictmail'] .= "price_month  = {$this->sqlS['price_month']}, ";
    }
    if($this->sqlS['price_month6']!=""){
      $query['td_pictmail'] .= "price_month6 = {$this->sqlS['price_month6']}, ";
    }
    if($this->sqlS['price_year']!=""){
      $query['td_pictmail'] .= "price_year   = {$this->sqlS['price_year']}, ";
    }
    if($this->sqlS['send_max']!=""){
      $query['td_pictmail'] .= "send_max     = {$this->sqlS['send_max']}, ";
    }
    if($this->sqlS['send_now']!=""){
      $query['td_pictmail'] .= "send_now     = {$this->sqlS['send_now']}, ";
    }
    if($this->sqlS['flag_dm']!=""){
      $query['td_pictmail'] .= "flag_dm      = {$this->sqlS['flag_dm']}, ";
    }
    $query['td_pictmail'] .= "date_update  = 'now' ";
    $query['td_pictmail'] .= "WHERE user_id={$this->sqlS['user_id']}";

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
