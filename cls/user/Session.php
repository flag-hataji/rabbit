<?PHP
/*

  # SESSION設定

*/

  class Session{

    var $use   = "";
    var $debug = "";

    Function Session($use=False,$debug=False){

      if( !$use ) die("Error!! Not \$use "._ROOT_PG_."Session.php | format() ".__LINE__);
      if( $debug ) $this->debug = True;

      $this->use = $use;

      return ;
    }


    // * 初期化
    Function format(){

      if( $this->debug ) echo" - "._ROOT_PG_."Session.php | format() <br>\n";

      $_SESSION[$this->use] = "";
      unset($_SESSION[$this->use]);


      return ;
    }


    // * ログイン
    Function login($pDataS){
      global $expPostgres;

      if( $this->debug ) echo" - "._ROOT_PG_."Session.php | login({$pDataS}) <br>\n";

      if( $pDataS['id'] && $pDataS['password'] ){
        $_SESSION[$this->use]['id']       = htmlspecialchars($pDataS['id']);
        $_SESSION[$this->use]['password'] = htmlspecialchars($pDataS['password']);


        $column  = "td_user.user_id,";
        $column .= "td_user.id,";
        $column .= "td_user.password,";
        $column .= "td_user.name_family,";
        $column .= "td_user.name_first,";
        $column .= "td_user.kana_family,";
        $column .= "td_user.kana_first,";
        $column .= "td_user.mail,";
        $column .= "td_user.flag_pictmail,";
        $column .= "td_user.flag_stepmail,";
        $column .= "td_pictmail.pictmail_id,";
        $column .= "td_pictmail.plan_pictmail_id,";
        $column .= "td_pictmail.account,";
        $column .= "td_pictmail.send_max,";
        $column .= "td_pictmail.send_now,";
        $column .= "td_pictmail.month_now,";
        $column .= "td_pictmail.month_max,";
        $column .= "td_pictmail.flag_permission,";
        $column .= "td_pictmail.flag_dm";

        $query  = "SELECT {$column} FROM td_user ";
        $query .= " JOIN td_pictmail ON td_user.user_id=td_pictmail.user_id  ";
        $query .= " WHERE td_user.id='{$_SESSION['user']['id']}' AND td_user.password='{$_SESSION['user']['password']}' AND td_user.flag_pictmail='t' ";
        $query .= " AND td_pictmail.flag_del!=1 ";
//        $query .= " AND td_pictmail.flag_permission=1 ";

        $uDataS = $expPostgres->getOne( $query,PGSQL_ASSOC );
        if( $uDataS!="" ){
          foreach($uDataS as $key=>$value){
            $_SESSION[$this->use][$key] = $value;
          }
        }

        if( $this->debug ) echo "{$query}<br>\n";

      }

      return ;
    }


    // * ログアウト
    Function logout(){

      if( $this->debug ) echo" - "._ROOT_PG_."Session.php | logout() <br>\n";

      $_SESSION[$this->use]['id'] = "";
      $_SESSION[$this->use]['password'] = "";
      unset($_SESSION[$this->use]['id']);
      unset($_SESSION[$this->use]['password']);

      return ;
    }


    // * 現在地
    Function place($place=False){

      if( $this->debug ) echo" - "._ROOT_PG_."Session.php | place({$place}) <br>\n";
      if( !$place ) die("Error!! Not \$place ".__LINE__);

      $_SESSION[$this->use]['place'] = $place;

      return ;
    }


    // * 書き込みモード
    Function mode($mode=False){

      if( $this->debug ) echo" - "._ROOT_PG_."Session.php | mode({$mode}) <br>\n";

      if( !$mode ) die("Error!! Not mode Session ".__LINE__);

      $_SESSION[$this->use]['mode'] = $mode;

      return ;
    }


    // * リストデータ
    Function lists(){

      if( $this->debug ) echo" - "._ROOT_PG_."Session.php | lists() <br>\n";

      $page = 1;
      if( isset($_GET['page']) && $_GET['page'] ){
        $page = $_GET['page'];
      }else if( isset($_SESSION[$this->use]['list']['page']) && $_SESSION[$this->use]['list']['page'] ){
        $page = $_SESSION[$this->use]['list']['page'];
      }

      $_SESSION[$this->use]['list']['page'] = $page;

      return ;
    }

  }

?>
