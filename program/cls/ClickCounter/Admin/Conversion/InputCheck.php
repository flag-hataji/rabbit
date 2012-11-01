<?php
class InputCheck extends Web
{

  var $check = "";
  var $bean  = "";
  var $db    = "";
  var $error = false ;

  var $log   = false ;

  function InputCheck(&$db, &$bean)
  {
    require_once LIB_PATH.'/check/Check.php';
    $this->check = new Check();

    $this->bean =& $bean ;
    if($db){
      $this->db =& $db ;
    }

    $this->error = "";
    $this->startTag = "<b><font color=\"#FF0000\">";
    $this->endTag   = "</font></b>";
  }


  function setError($key, $val,$message)
  {
    $this->error['inputs'][$key]  = $val ;
    $this->error['code'][$key]    = $message ;
    $this->error['message'][$key] = $this->startTag.$message.$this->endTag  ;
  }

  function getError()
  {
    return $this->error ;
  }

  function setCheck()
  {
    $this->inputs =& $this->bean->getInputs() ;


    // title
    if(! $this->check->isInput( $this->bean->getInput('title') ) ){
      $this->setError("title", $this->bean->getInput('title'), "コンバージョン名をご入力ください。");
    }

    // url
    if( $this->check->isInput( $this->bean->getInput('url') ) ){
      if(! $this->check->isUrl( $this->bean->getInput('url') ) ){
        $this->setError("url", $this->bean->getInput('url'), "URLの形式を見直してください。");
      }
    }else{
      $this->setError("url_null", $this->bean->getInput('url'), "URLを記入してください。");
    }

    // comment
//    if(! $this->check->isInput( $this->bean->getInput('comment') ) ){
//      $this->setError("comment", $this->bean->getInput('comment'), "本文(メルマガ)をご入力ください。");
//    }

    // ログ取得するか
    if( $this->log && is_array($this->error['message']) ){
      $this->setFromError();
    }
  }

  function setFromError(){

    $query = "SELECT error_id+1 FROM kt_td_form_error ORDER BY error_id DESC LIMIT 1  " ;

    $result = mysql_query($query);

    $error_id = 1 ;
    if( $result ){
      list($error_id) = mysql_fetch_array($result);
    }

    $i = 1 ;
    foreach( $this->error['code'] as $key => $val){
      $querys[] = "
        INSERT INTO kt_td_form_error (
        error_id,
        number,
        error_cd,
        comment,
        medium_cd,
        ip,
        input_data,
        delete_flag,
        insert_date,
        update_date,
        code,
        alias
      ) VALUES (
        $error_id,
        $i,
        '{$key}',
        '{$val}',
        '{$_SESSION['mediumCode']}',
        '{$_SERVER['REMOTE_ADDR']}',
        '{$errorInput[$key]}',
        '0',
        now(),
        now(),
        '".$this->bean->getSession('page_number')."',
        '".($this->bean->getSession('page_number') % 3)."'
        ) ";
      ++$i ;
    }

    foreach( $querys as $val ){
      mysql_query($val);
    }
  }

}
?>