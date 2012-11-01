<?PHP
/*

  File̾ : Postgres.php
         : Postgres.php


*/

class Postgres
{

  var $host       = "localhost";
  var $port       =  5432;
  var $dbname     = "rabbit-mail";
  var $user       = "postgres";

  var $connection = False;
  var $query      = "";
  var $result     = False;
  var $row        = 0;

  // bean 
  function getRow(){
    return $this->row ;
  }

  function getResult(){
    return $this->result ;
  }

  function getQuery(){
    return $this->Query ;
  }

  function getConnection(){
    return $this->connection ;
  }

  /*
   *  DataBase��³
   **/
  function Postgres($dbname=False, $user=False ,$host=False, $port=False){

    $this->setConnection($dbname, $user ,$host, $port);

  }

  /*
   *  DataBase��³
   **/
  function setConnection($dbname=False, $user=False ,$host=False, $port=False){

    if( $dbname ){ $this->dbname = $dbname ;}
    if( $user   ){ $this->user   = $user ;  }
    if( $host   ){ $this->host   = $host ;  }
    if( $port   ){ $this->port   = $port ;  }


    $this->connection = pg_connect("host={$this->host} port={$this->port} dbname={$this->dbname} user={$this->user}");
//    $this->connection = pg_pconnect("host={$this->host} port={$this->port} dbname={$this->dbname} user={$this->user}");

    if(! $this->connection ){
      die( pg_last_error() );
    }
  }


  /*
   *  ����ͤ��᤹
   **/
  function clear(){
    $this->query = "";
    if (! $this->result ){
      pg_freeresult($this->result);
    }
    $this->rows = 0;
  }


  /*
   *  ��³��λ
   **/
  function close(){
    if (! empty($this->connection) ) {
      pg_close($this->connection);
    }
  }


  /*
   *  SQL�μ¹� Select
   **/
  function executeQuery($query=False){

    $this->query = $query;

    if(! $this->query ){
      die("QUERY False");
    }

    $this->result = pg_query($this->connection, $this->query);

    $this->row = pg_num_rows($this->result);
    return $this->result ;
  }

  /*
   *  SQL�μ¹� insert update delete
   **/
  function executeUpdate($query=False){

    $this->query = $query;

    $this->result = pg_query($this->connection, $this->query);

    return pg_affected_rows($this->result) ;
  }
}
?>
