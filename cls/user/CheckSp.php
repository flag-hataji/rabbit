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
     * ログインチェック
     */
    Function login(){
      Global $expPostgres;

      if( $this->debug ) echo" - "._ROOT_PG_."CheckSp.php | login() <br>\n";

      $return = False;

      if( 
          (isset($_SESSION['user']['id'])       && $_SESSION['user']['id']) && 
          (isset($_SESSION['user']['password']) && $_SESSION['user']['password'])
      ){

        $query  = "SELECT count(*) FROM td_user ";
        $query .= " JOIN td_pictmail ON td_user.user_id=td_pictmail.user_id  ";
        $query .= " WHERE td_user.id='{$_SESSION['user']['id']}' AND td_user.password='{$_SESSION['user']['password']}' ";
        $query .= " AND td_user.flag_pictmail='t'";
        $query .= " AND td_pictmail.flag_del!=1";

        if( $this->debug ) echo "{$query}<br>\n";

        $countS = $expPostgres->getOne( $query );
        if( $countS['count']!=0 ){
          $return = True;
        }

      }

      return $return;
    }


    /*
     * 確認特殊チェック
     */
    Function checkConfirm($dataS=False){
      Global $expPostgres,$pField;

      if( $this->debug ) echo" - "._ROOT_PG_."CheckSp.php | checkConfirm() <br>\n";

      $errorS = "";

      if($dataS['mail']!=""){
        $query  = "SELECT count(*) FROM td_user ";
        $query .= " JOIN td_pictmail ON td_pictmail.user_id=td_user.user_id ";
        $query .= " WHERE td_user.mail='{$dataS['mail']}'";
        if( $dataS['user_id']!="" ){
          $query .= " AND td_user.user_id!={$dataS['user_id']} ";
        }
        $query .= " AND td_pictmail.flag_del!=1";


        $countS = $expPostgres->getOne( $query );
        if( $countS['count']!=0 ){
          $errorS['Input_mail']  = "入力されたメールアドレスは既に使用されております。";
        }
      }

      if($dataS['id']!=""){
        $query = "SELECT count(*) FROM td_user WHERE id = '{$dataS['id']}'";

        if( $dataS['user_id']!="" ){
          $query .= " AND user_id!={$dataS['user_id']} ";
        }

        $countS = $expPostgres->getOne( $query );
        if( $countS['count']!=0 ){
          $errorS['Input_id']  = "入力されたIDは既に使用されております。";
        }
      }

      if($dataS['tel']=="" && $dataS['mobile']==""){
        $errorS['Input_tel']  = "{$pField->nameS['tel']}もしくは{$pField->nameS['mobile']}をご入力ください。";
      }

      $idCount = mbstrlen($dataS['id']);
      if($idCount>16 || $idCount<4){
        $errorS['Input_id']  = "IDは4〜16文字の半角英数でご入力ください。";
      }

      $passwordCount = mbstrlen($dataS['password']);
      if($passwordCount>16 || $passwordCount<6){
        $errorS['Input_password']  = "パスワードは6〜16文字の半角英数でご入力ください。";
      }

      if( $dataS['password']==$dataS['id'] ){
        $errorS['password_id']  = "IDとパスワードは重複しない値をご入力ください。";
      }

      if(!isset($_POST['roots']) &&  $dataS['user_id']=="" ){
        $errorS['roots']  = "何処から来たか選択してください。";
      }


      return $errorS;
    }


  }

?>
