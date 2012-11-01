<?PHP
/*

  �ѿ���Ϣ

*/

  class CheckSp {

    var $debug   = '';

    Function CheckSp($debug=False){

      if( $debug ) $this->debug = True;

      return ;
    }


    /*
     * ����������å�
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
     * ��ǧ�ü�����å�
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
          $errorS['Input_mail']  = "���Ϥ��줿�᡼�륢�ɥ쥹�ϴ��˻��Ѥ���Ƥ���ޤ���";
        }
      }

      if($dataS['id']!=""){
        $query = "SELECT count(*) FROM td_user WHERE id = '{$dataS['id']}'";

        if( $dataS['user_id']!="" ){
          $query .= " AND user_id!={$dataS['user_id']} ";
        }

        $countS = $expPostgres->getOne( $query );
        if( $countS['count']!=0 ){
          $errorS['Input_id']  = "���Ϥ��줿ID�ϴ��˻��Ѥ���Ƥ���ޤ���";
        }
      }

      if($dataS['tel']=="" && $dataS['mobile']==""){
        $errorS['Input_tel']  = "{$pField->nameS['tel']}�⤷����{$pField->nameS['mobile']}�����Ϥ���������";
      }

      $idCount = mbstrlen($dataS['id']);
      if($idCount>16 || $idCount<4){
        $errorS['Input_id']  = "ID��4��16ʸ����Ⱦ�ѱѿ��Ǥ����Ϥ���������";
      }

      $passwordCount = mbstrlen($dataS['password']);
      if($passwordCount>16 || $passwordCount<6){
        $errorS['Input_password']  = "�ѥ���ɤ�6��16ʸ����Ⱦ�ѱѿ��Ǥ����Ϥ���������";
      }

      if( $dataS['password']==$dataS['id'] ){
        $errorS['password_id']  = "ID�ȥѥ���ɤϽ�ʣ���ʤ��ͤ����Ϥ���������";
      }

      if(!isset($_POST['roots']) &&  $dataS['user_id']=="" ){
        $errorS['roots']  = "���褫���褿�����򤷤Ƥ���������";
      }


      return $errorS;
    }


  }

?>
