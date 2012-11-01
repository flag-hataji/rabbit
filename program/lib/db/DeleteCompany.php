<?PHP
/*


*/

class DeleteCompany extends Postgres{

  function DeleteCompany($company_id=False){

    $this->setConnection();

    // introduce
    $this->executeQuery("SELECT * FROM td_introduce WHERE company_id={$company_id} ");
    $dataS = "";
    if( $this->getRow()!=0 ){
      for( $i=0;$i<=($this->getRow()-1);$i++){
        $dataS[$i+1] = pg_fetch_array( $this->getResult(),$i,PGSQL_ASSOC );
      }
    }
    $dataS['count'] = $this->getRow();
    $idQuery = "";
    $i=1;
    while($dataS['count']>=$i){
      $idQuery .=  " introduce_id={$dataS[$i]['introduce_id']} OR ";

      $i++;
    }
    if($idQuery!=""){
      $idQuery = "(".substr($idQuery,0,-3).")";
      $query['td_introduce_wage']      = "DELETE FROM td_introduce_wage WHERE {$idQuery}";
      $query['td_introduce_academic']  = "DELETE FROM td_introduce_wage WHERE {$idQuery}";
      $query['td_introduce_insurance'] = "DELETE FROM td_introduce_wage WHERE {$idQuery}";
      $query['td_introduce_allowance'] = "DELETE FROM td_introduce_wage WHERE {$idQuery}";
      $query['td_introduce_select']    = "DELETE FROM td_introduce_wage WHERE {$idQuery}";
    }
    $query['td_introduce'] = "DELETE FROM td_introduce WHERE company_id={$company_id}";


    // dispatch
    $this->executeQuery("SELECT * FROM td_dispatch WHERE company_id={$company_id} ");
    $dataS = "";
    if( $this->getRow()!=0 ){
      for( $i=0;$i<=($this->getRow()-1);$i++){
        $dataS[$i+1] = pg_fetch_array( $this->getResult(),$i,PGSQL_ASSOC );
      }
    }
    $dataS['count'] = $this->getRow();
    $idQuery = "";
    $i=1;
    while($dataS['count']>=$i){
      $idQuery .=  " dispatch_id={$dataS[$i]['dispatch_id']} OR ";

      $i++;
    }
    if($idQuery!=""){
      $idQuery = "(".substr($idQuery,0,-3).")";
      $query['td_dispatch_wage'] = "DELETE FROM td_dispatch_wage WHERE {$idQuery}";
      $query['td_dispatch_os']   = "DELETE FROM td_dispatch_os   WHERE {$idQuery}";
      $query['td_dispatch_oa']   = "DELETE FROM td_dispatch_oa   WHERE {$idQuery}";
    }
    $query['td_dispatch'] = "DELETE FROM td_dispatch WHERE company_id={$company_id}";

    // BEGIN
    pg_query($this->connection, 'BEGIN');


    $return = True;
    if( is_array($query) ){

      foreach( $query as $key=>$value ){

        if( $value && !$this->executeUpdate($value) ){

          // ROLLBACK
          pg_query($this->connection, 'ROLLBACK');

          $return=False;
        }
      }
    }else{

      if( !$this->executeUpdate($query) ){

        // ROLLBACK
        pg_query($this->connection, 'ROLLBACK');

        $return=False;
      }

    }

    // COMMIT
    pg_query($this->connection, 'COMMIT');

    pg_free_result( $this->getResult() );

    echo $return;


    return $return;
  }

}

?>
