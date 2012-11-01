<?PHP
/*

  追加・拡張 : Postgres使用

*/

class ExPostgres extends Postgres
{

  var $pgsql_mode = PGSQL_BOTH ;


  Function ExPostgres($dbname=False, $user=False ,$host=False, $port=False){

    $this->setConnection($dbname, $user ,$host, $port);

    return ;
  }


  /*
   * nextval取得
   */
  Function getNextval( $sequence=False ){

    $query = "SELECT nextval( '{$sequence}' )";

    $this->executeQuery($query);

    $data = pg_fetch_array($this->getResult(),0);

    return $data['nextval'];
  }


  /*
   * データ取得（複数データ）
   */
  Function getPlural( $query=False, $pgsql_mode=PGSQL_ASSOC ){

    if($pgsql_mode){
      $this->pgsql_mode = $pgsql_mode;
    }

    $this->executeQuery($query);
    $data = "";
    if( $this->getRow()!=0 ){
      for( $i=0;$i<=($this->getRow()-1);$i++){
        $data[$i+1] = pg_fetch_array( $this->getResult(),$i,$this->pgsql_mode );
      }
    }

    $data['count'] = $this->getRow();

    pg_free_result( $this->getResult() );

    return $data;
  }


  /*
   * データ取得（単一データ）
   */
  Function getOne( $query=False, $pgsql_mode=PGSQL_ASSOC ){

    if($pgsql_mode){
      $this->pgsql_mode = $pgsql_mode;
    }

    $this->executeQuery($query);
    $data = "";
    if( $this->getRow()!=0 ){
      $data = pg_fetch_array( $this->getResult(),0,$this->pgsql_mode );
    }
    
    pg_free_result( $this->getResult() );

    return $data;
  }


  /*
   * 登録
   */
  Function registQuery($query=False){

    $return = True;

    // BEGIN
    pg_query($this->connection, 'BEGIN');

    if( isset($query) && $query!="" ){
      if( is_array($query) ){
        foreach( $query as $key=>$value ){
          if( $value && !$this->executeUpdate($value) ){
            // ROLLBACK
            pg_query($this->connection, 'ROLLBACK');
            $return = False;
            break;
          }
        }
      }else{
        if( !$this->executeUpdate($query) ){
          // ROLLBACK
          pg_query($this->connection, 'ROLLBACK');
          $return = False;
        }
      }
    }

    if($return){
      // COMMIT
      pg_query($this->connection, 'COMMIT');
    }

    return $return;
  }


}

?>
