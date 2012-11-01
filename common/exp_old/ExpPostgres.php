<?PHP
/*

  �ɲá���ĥ : Postgres����

*/

class ExpPostgres extends Postgres
{

  var $pgsql_mode = PGSQL_BOTH ;

  /*
   * nextval����
   */
  Function getNextval( $sequence=False ){

    $query = "SELECT nextval( '{$sequence}' )";

    $this->executeQuery($query);

    $data = pg_fetch_array($this->getResult(),0);

    return $data['nextval'];
  }


  /*
   * �ǡ���������ʣ���ǡ�����
   */
  Function getPlurality( $query=False, $pgsql_mode=False ){

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

    return $data;
  }


  /*
   * �ǡ���������ñ��ǡ�����
   */
  Function getOne( $query=False, $pgsql_mode=False ){

    if($pgsql_mode){
      $this->pgsql_mode = $pgsql_mode;
    }

    $this->executeQuery($query);
    $data = "";
    if( $this->getRow()!=0 ){
      $data = pg_fetch_array( $this->getResult(),0,$this->pgsql_mode );
    }
    

    return $data;
  }


  /*
   * ��Ͽ
   */
  Function registQuery($query=False){

    // BEGIN
    pg_query($this->connection, 'BEGIN');


    if( is_array($query) ){

      foreach( $query as $key=>$value ){

        if( $value && !$this->executeUpdate($value) ){

          // ROLLBACK
          pg_query($this->connection, 'ROLLBACK');

          return False;
        }
      }
    }else{

      if( !$this->executeUpdate($query) ){

        // ROLLBACK
        pg_query($this->connection, 'ROLLBACK');

        return False;
      }

    }

    // COMMIT
    pg_query($this->connection, 'COMMIT');

    return True;
  }

}

?>
