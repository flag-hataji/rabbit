<?PHP
/*

  ÅÐÏ¿´ØÏ¢

*/

  class Query{

    var $debug     = "";
    var $datPath   = "";

    Function Query($debug=False){

      if( $debug )   $this->debug   = $debug;

      return ;
    }



    /*
      update_td_pictmail updateÊ¸
    */
    Function update_td_pictmail(){
      global $libUtil,$pField,$pVariable,$expPostgres;

      if( $this->debug ) echo" - "._ROOT_PG_."Query.php | update_td_pictmail() <br>\n";

      $query  = "UPDATE td_pictmail SET ";
      //$query .= " month_now=(month_now-1), ";
      $query .= " send_now=(send_now-SEND_NUM), ";
      $query .= " date_update='now' ";
      $query .= " WHERE pictmail_id = {$_SESSION['user']['pictmail_id']} ";

      return $query;
    }



    /*
      td_log INSERTÊ¸
    */
    Function insert_td_log(){
      global $libUtil,$pField,$pVariable,$expPostgres;

      if( $this->debug ) echo" - "._ROOT_PG_."Query.php | insert_td_log() <br>\n";

      $inputS = $libUtil->getSql($pVariable->inputS);

      $column  = "";
      $values  = "";

      $column .= "user_id,";
      $values .= "{$inputS['user_id']},";

      $column .= "name_from,";
      $values .= "'{$inputS['name_from']}',";

      $column .= "mail_from,";
      $values .= "'{$inputS['mail_from']}',";

      $column .= "month_count,";
      $values .= (($_SESSION['user']['month_max']-$_SESSION['user']['month_now'])+1).",";

      $column .= "send_count,";
      $values .= count(file(_ROOT_PG_DAT_.$inputS['file_mail'])).",";

      $column .= "ip,";
      $values .= "'{$inputS['ip']}',";

      $column .= "host,";
      $values .= "'{$inputS['host']}',";

      $column = substr($column,0,-1);
      $values = substr($values,0,-1);
      $query  = "INSERT INTO td_log({$column}) VALUES ({$values})";

      return $query;
    }


    /*
      td_message INSERTÊ¸
    */
    Function insert_td_message(){
      global $libUtil,$pField,$pVariable,$expPostgres;

      if( $this->debug ) echo" - "._ROOT_PG_."Query.php | insert_td_message() <br>\n";


      $inputS = $libUtil->getSql($pVariable->inputS);
/*
      $subject = str_replace("\"", "#¡É#", $subject);
      $subject = str_replace("'",  "#¡Ç#",  $subject);
      $subject = str_replace(",",  "#¡¢#",  $subject);

      $message = str_replace("\"", "#¡É#", $message);
      $message = str_replace("'",  "#¡Ç#",  $message);
      $message = str_replace(",",  "#¡¢#",  $message);
*/

      $column  = "";
      $values  = "";

      $column .= "message_id,";
      $values .= "{$inputS['message_id']},";

      $column .= "user_id,";
      $values .= "{$inputS['user_id']},";

      $column .= "count,";
      $values .= (($_SESSION['user']['month_max']-$_SESSION['user']['month_now'])+1).",";

      $column .= "email_from,";
      $values .= "'{$inputS['mail_from']}',";

      $column .= "email_from_name,";
      $values .= "'{$inputS['name_from']}',";


      $column .= "email_error,";
      $values .= "'{$inputS['mail_error']}',";

      $column .= "subject,";
      $values .= "'{$inputS['subject']}',";

      $column .= "message,";
      $values .= "'{$inputS['message']}',";

      $column .= "message_html,";
      $values .= "'{$inputS['message_html']}',";

      $column .= "flag_html,";
      $values .= "{$inputS['flag_html']},";

      $column .= "send_date,";
      $values .= "'{$inputS['send_date']}',";

      $column = substr($column,0,-1);
      $values = substr($values,0,-1);

      $query  = "INSERT INTO td_message({$column}) VALUES ({$values})";

      return $query;
    }

    /*
      td_mailq INSERTÊ¸
    */
    Function insert_td_mailq(){
      global $libUtil,$pField,$pVariable,$expPostgres;

      if( $this->debug ) echo" - "._ROOT_PG_."Query.php | insert_td_mailq() <br>\n";


      $column  = "";
      $values  = "";

      $inputS = $libUtil->getSql($pVariable->inputS);

      $column .= "email,";
      $values .= "'EMAIL',";

      $column .= "email_name,";
      $values .= "'EMAIL_NAME',";

      $column .= "message_id,";
      $values .= "{$inputS['message_id']},";

      $column .= "flag_pc,";
      $values .= "'FLAG_PC',";

      $column .= "parameter1,";
      $values .= "'PARAMETER1',";

      $column .= "parameter2,";
      $values .= "'PARAMETER2',";

      $column .= "parameter3,";
      $values .= "'PARAMETER3',";

      $column .= "parameter4,";
      $values .= "'PARAMETER4',";

      $column .= "parameter5,";
      $values .= "'PARAMETER5',";

      $column = substr($column,0,-1);
      $values = substr($values,0,-1);

      $query  = "INSERT INTO td_mailq({$column}) VALUES ({$values})";

      return $query;
    }


  }

?>
