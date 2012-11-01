<?PHP
/*

  変数関連

*/

  class CheckSp {

    var $debug   = '';

    Function CheckSp($debug=False){

      if( $debug ) $this->debug = True;

      return ;
    }


    /*
     * 確認特殊チェック
     */
    Function checkConfirm($dataS=False){
      Global $expPostgres,$pField;

      if( $this->debug ) echo" - "._ROOT_PG_."CheckSp.php | checkConfirm() <br>\n";

      $errorS = "";

      return $errorS;
    }


  
    /*
     * 確認特殊チェック
     */
    Function checkConfirmPlan($dataS=False){
      Global $expPostgres,$pField;

      if( $this->debug ) echo" - "._ROOT_PG_."CheckSp.php | checkConfirm() <br>\n";

      $errorS = "";

      if( _ADMIN_ ){
        $query = "SELECT count(*) FROM td_pictmail WHERE plan_pictmail_id={$dataS['inputS']['plan_pictmail_id']} AND user_id={$dataS['inputS']['user_id']} ";
        $countS = $expPostgres->getOne( $query );
        if( $countS['count']!=0 ){
          $errorS['plan']  = "選択したプランで既に登録しています。";
        }
      }

      return $errorS;
    }


  }

?>
