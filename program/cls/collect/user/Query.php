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


  // *SET* insert Query
  function setQueryInsert($Manager=False){
    $ExPostgres = $this->dbConnect();

    foreach($Manager->inputS as $key=>$value ){
      $this->sqlS[$key] = $this->getSql($value);
    }

    $column  = "";
    $values  = "";

    $column  .= "collect_id,";
    $values  .= "{$this->sqlS['collect_id']},";
    $column  .= "tool_id,";
    $values  .= "{$this->sqlS['tool_id']},";
    $column  .= "mail,";
    $values  .= "'{$this->sqlS['mail']}',";
    $column  .= "ip,";
    $values  .= "'{$this->sqlS['ip']}',";
    $column  .= "host,";
    $values  .= "'{$this->sqlS['host']}',";


    if(isset($_SESSION['user']['user_id'])){
      $column .= "user_id,";
      $values .= $_SESSION['user']['user_id'].",";
    }

    $column = substr($column,0,-1);
    $values = substr($values,0,-1);
    $query['td_collect']  = "INSERT INTO td_collect({$column}) VALUES ({$values})";

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

    $query['td_collect']  = "UPDATE td_collect SET ";
    $query['td_collect'] .= "flag_download = 1 ";
    $query['td_collect'] .= "WHERE collect_id={$this->sqlS['collect_id']}";

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
