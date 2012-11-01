<?PHP
/*

  ��Ͽ��Ϣ

*/

  class Query{

    var $debug     = "";
    var $datPath   = "";

    Function Query($debug=False){

      if( $debug )   $this->debug   = $debug;

      return ;
    }


    /*
      td_user INSERTʸ
    */
    Function sign_up(){

      if( $this->debug ) echo" - "._ROOT_PG_."Query.php | sign_up() <br>\n";

      $query['td_user']     = $this->insert_td_user('td_user');
      $query['td_pictmail'] = $this->insert_td_pictmail('td_pictmail');

      return $query;
    }


    /*
      td_user INSERTʸ
    */
    Function insert_td_user(){

      if( $this->debug ) echo" - "._ROOT_PG_."Query.php | insert_td_user() <br>\n";

      $query = $this->setting_insert('td_user');
      if( $this->debug ) echo" query =  {$query}<br>\n";

      return $query;
    }


    /*
      td_pictmail INSERTʸ
    */
    Function insert_td_pictmail(){

      if( $this->debug ) echo" - "._ROOT_PG_."Query.php | insert_td_pictmail() <br>\n";

      $query = $this->setting_insert('td_pictmail');
      if( $this->debug ) echo" query =  {$query}<br>\n";

      return $query;
    }


    /*
      INSERTʸ����
    */
    Function setting_insert($table=False){
      global $pField,$pVariable,$libBrowse;

      if( $this->debug ) echo" - "._ROOT_PG_."Query.php | setting_insert() <br>\n";

      if(isset($_POST['roots'])){
        $pVariable->inputS['comment'] .= $_POST['roots'];
      }
      $pVariable->inputS['comment'] .= "\n";
      $pVariable->inputS['comment'] .= "��⡼�ȥ��ɥ쥹����{$libBrowse->remote_address}\n";
      $pVariable->inputS['comment'] .= "��⡼�ȥۥ��ȡ�����{$libBrowse->remote_host}\n";
      $pVariable->inputS['comment'] .= "ü�����ࡡ����������{$libBrowse->agent}\n";
      $pVariable->inputS['comment'] .= "ü���С�����󡡡���{$libBrowse->type}\n";
      $pVariable->inputS['comment'] .= "�֥饦��������������{$libBrowse->generation}\n";



      $column = "";
      $values = "";
      foreach($pField->dbS[$table] as $num=>$value ){
        $close = "";
        if( $value['key']=='text' || $value['key']=='date' ){
          $close = "'";
        }
        $name    = $value['name'];
        $column .= " {$name},";
        if( isset($pVariable->inputS[$name]) && $pVariable->inputS[$name] ){
          $values .= "{$close}{$pVariable->inputS[$name]}{$close}";
        }else{
          $values .= "{$close}{$value['default']}{$close}";
        }
        $values .= ",";
      }

      $column = substr($column,0,-1);
      $values = substr($values,0,-1);
      $query  = "INSERT INTO {$table}({$column}) VALUES ({$values})";

      return $query;
    }

    /*
      td_user UPDATEʸ
    */
    Function update_td_user(){
      global $pField,$pVariable;

      if( $this->debug ) echo" - "._ROOT_PG_."Query.php | update_td_user() <br>\n";


      $query  = "UPDATE td_user SET ";
      foreach($pField->dbS['td_user'] as $num=>$value ){
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
      $query .= " WHERE user_id = {$pVariable->inputS['user_id']} ";
      if( $this->debug ) echo" query =  {$query}<br>\n";

      return $query;
    }

    /*
      td_user UPDATEʸ�ʥץ���ѹ���
    */
    Function plan_td_pictmail($dataS=False){
      global $pField,$pVariable;

      if( $this->debug ) echo" - "._ROOT_PG_."Query.php | plan_td_pictmail({$dataS}) <br>\n";


      $query  = "UPDATE td_pictmail SET ";
      $query .= " date_update='now' ";
      $query .= " WHERE plan_id = {$dataS['plan_id']} AND user_id={$dataS['user_id']} ";
      if( $this->debug ) echo" query =  {$query}<br>\n";

      return $query;
    }

    /*
      delete_td_pictmail UPDATEʸ�ʺ����
    */
    Function delete_td_pictmail($user_id=False){
      global $pField,$pVariable;

      if( $this->debug ) echo" - "._ROOT_PG_."Query.php | delete_td_user({$user_id}) <br>\n";


      $query  = "UPDATE td_pictmail SET ";
      $query .= " flag_del=1, ";
      $query .= " date_update='now' ";
      $query .= " WHERE user_id = {$user_id} ";
      if( $this->debug ) echo" query =  {$query}<br>\n";

      return $query;
    }

  }

?>
