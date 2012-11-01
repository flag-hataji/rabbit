<?PHP
/*

  登録関連

*/

  class Query{

    var $debug     = "";
    var $datPath   = "";

    Function Query($debug=False){

      if( $debug )   $this->debug   = $debug;

      return ;
    }


    /*
      td_pictmail UPDATE文
    */
    Function update_td_pictmail(){
      global $pField,$pVariable;

      if( $this->debug ) echo" - "._ROOT_PG_."Query.php | update_td_user() <br>\n";


      $query  = "UPDATE td_pictmail SET ";
      foreach($pField->dbS['td_pictmail'] as $num=>$value ){
        $name = $value['name'];

        $close = "";
        if( $value['key']=='text' || $value['key']=='date' ){
          $close = "'";
        }

        if( $name!='user_id' && isset($pVariable->inputS[$name]) ){
          if( !$close && !$pVariable->inputS[$name] ){
            $query .= "{$value['name']}=0, ";
          }else{
            $query .= "{$value['name']}={$close}{$pVariable->inputS[$name]}{$close}, ";
          }
        }
      }

      $query .= " date_update='now' ";
      $query .= " WHERE pictmail_id = {$pVariable->inputS['pictmail_id']} ";
      if( $this->debug ) echo" query =  {$query}<br>\n";

      return $query;
    }

    /*
      plan UPDATE文（プラン変更）
    */
    Function update_plan(){
      global $libUtil,$libCode,$expUtil,$expPostgres,$pField,$pVariable;

      if( $this->debug ) echo" - "._ROOT_PG_."Query.php | plan_td_pictmail() <br>\n";

      $mDataS = $expPostgres->getOne( "SELECT * FROM tm_plan WHERE plan_id={$pVariable->inputS['plan_pictmail_id']} ",PGSQL_ASSOC );

      $query  = "UPDATE td_pictmail SET ";
      $query .= " plan_pictmail_id={$mDataS['plan_id']}, send_max={$mDataS['send_max']}, send_now={$mDataS['send_max']}, month_max={$mDataS['month_max']}, month_now={$mDataS['month_max']}  ";
      $query .= " WHERE  pictmail_id={$pVariable->inputS['pictmail_id']} ";
      if( $this->debug ) echo" query =  {$query}<br>\n";

      return $query;
    }


  }

?>
