<?PHP
/*

  追加・拡張 :メンバー認証


*/
  class ExpAttest
  {

    Function ExpAttest(){


      return ;
    }


    Function check(){
      Global $libPostgres;


      $check = False;

      if( (!isset($_SESSION['user']['id']) || $_SESSION['user']['id']=="") || (!isset($_SESSION['user']['password']) || $_SESSION['user']['password']=="") ){

        $check = True;

      }else{

        $query = "SELECT count(*) FROM td_user WHERE id='{$_SESSION['user']['id']}' AND password='{$_SESSION['user']['password']}'";

        $libPostgres->executeQuery($query);
        $data = "";
        if( $libPostgres->getRow()!=0 ){
          $data = pg_fetch_array( $libPostgres->getResult(),0 );
        }
        if($data['count']==0){
          $check = True;
        }

      }

      if( $check ){
        header("Location: "._URL_MEMBER_TOP_);
      }


      return ;
    }

  }

?>
