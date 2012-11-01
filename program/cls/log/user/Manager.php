<?PHP

class Manager extends Html {

  var $charaCode   = "EUC-JP";
  var $outputCode  = "EUC-JP";
  var $modeS       = "";
  var $defaultS    = "";
  var $inputS      = "";
  var $writeS      = "";
  var $errorS      = "";

  function Manager(){
    if( _DEBUG_ ){
      require_once(_DIR_LIB_.'debug/Debug.php');
      $this->Debug = new Debug();
    }
    require_once(_DIR_LIB_."ex/ViewerLib.php");
    $this->ViewerLib = new ViewerLib();
  }

  // DB接続
  function dbConnect(){
    require_once(_DIR_LIB_."db/Postgres.php");
    require_once(_DIR_LIB_."db/ExPostgres.php");
    $ExPostgres = new ExPostgres(_DB_NAME_,_DB_USER_,_DB_HOST_,_DB_PORT_);
    return $ExPostgres;
  }

  // *出力* デバッグ
  function showArrayDebug( $val=False,$name='Deubg' ){
    if( _DEBUG_ ){
      $this->Debug->arrayView($val, $name, _DEBUG_);
    }
    return;
  }

  // *SET* ページ数
  function setSessionPageNum($place=False){
    if( isset($_GET['page']) && is_numeric($_GET['page']) ){
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['page'] = $_GET['page'];
    }else if( isset($_POST['page']) && is_numeric($_POST['page']) ){
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['page'] = $_POST['page'];
    }else if( !isset($_SESSION[_SESSION_MODE_][_SESSION_NAME_]['page']) ){
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['page'] =1;
    }
    return;
  }

  // *SET* SESSION 検索初期化
  function setSessionSeekFormat(){
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['log_id']  = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert1']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert1_y']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert1_m']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert1_d']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert2']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert2_y']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert2_m']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert2_d']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['send_date1']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['send_date1_y']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['send_date1_m']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['send_date1_d']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['send_date2']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['send_date2_y']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['send_date2_m']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['send_date2_d']   = "";
    return;
  }

  // *SET* SESSION 検索
  function setSessionSeek(){
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['log_id']  = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert1']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert1_y']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert1_m']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert1_d']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert2']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert2_y']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert2_m']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert2_d']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['send_date1']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['send_date1_y']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['send_date1_m']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['send_date1_d']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['send_date2']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['send_date2_y']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['send_date2_m']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['send_date2_d']   = "";
    if(isset($_POST['seekS'])){
      unset($_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']);
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['log_id'] = $_POST['seekS']['log_id'];
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert1']     = "";
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert1_y']   = $_POST['seekS']['date_insert1_y'];
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert1_m']   = $_POST['seekS']['date_insert1_m'];
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert1_d']   = $_POST['seekS']['date_insert1_d'];
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert2']     = "";
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert2_y']   = $_POST['seekS']['date_insert2_y'];
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert2_m']   = $_POST['seekS']['date_insert2_m'];
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert2_d']   = $_POST['seekS']['date_insert2_d'];
      if($_POST['seekS']['date_insert1_y']!="" && $_POST['seekS']['date_insert1_m1']!="" && $_POST['seekS']['date_insert1_d']!="" ){
        $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert1']  = sprintf('%04d',$_POST['seekS']['date_insert1_y'])."-";
        $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert1'] .= sprintf('%02d',$_POST['seekS']['date_insert1_m'])."-";
        $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert1'] .= sprintf('%02d',$_POST['seekS']['date_insert1_d']);
      }
      if($_POST['seekS']['date_insert2_y']!="" && $_POST['seekS']['date_insert2_m']!="" && $_POST['seekS']['date_insert2_d']!="" ){
        $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert2']  = sprintf('%04d',$_POST['seekS']['date_insert2_y'])."-";
        $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert2'] .= sprintf('%02d',$_POST['seekS']['date_insert2_m'])."-";
        $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert2'] .= sprintf('%02d',$_POST['seekS']['date_insert2_d']);
      }
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['send_date1']     = "";
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['send_date1_y']   = $_POST['seekS']['send_date1_y'];
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['send_date1_m']   = $_POST['seekS']['send_date1_m'];
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['send_date1_d']   = $_POST['seekS']['send_date1_d'];
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['send_date2']     = "";
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['send_date2_y']   = $_POST['seekS']['send_date2_y'];
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['send_date2_m']   = $_POST['seekS']['send_date2_m'];
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['send_date2_d']   = $_POST['seekS']['send_date2_d'];
      if($_POST['seekS']['send_date1_y']!="" && $_POST['seekS']['send_date1_m1']!="" && $_POST['seekS']['send_date1_d']!="" ){
        $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['send_date1']  = sprintf('%04d',$_POST['seekS']['send_date1_y'])."-";
        $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['send_date1'] .= sprintf('%02d',$_POST['seekS']['send_date1_m'])."-";
        $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['send_date1'] .= sprintf('%02d',$_POST['seekS']['send_date1_d']);
      }
      if($_POST['seekS']['send_date2_y']!="" && $_POST['seekS']['send_date2_m']!="" && $_POST['seekS']['send_date2_d']!="" ){
        $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['send_date2']  = sprintf('%04d',$_POST['seekS']['send_date2_y'])."-";
        $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['send_date2'] .= sprintf('%02d',$_POST['seekS']['send_date2_m'])."-";
        $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['send_date2'] .= sprintf('%02d',$_POST['seekS']['send_date2_d']);
      }
    }
    return;
  }


  // *SET* SESSION ページ位置
  function setSessionPlace($place=False){
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['place'] = $place;
    return;
  }

  // *GET* SESSION ページ位置
  function getSessionPlace(){
    return $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['place'];
  }


  // *SET* Name
  function setName(){

    $this->nameS['log_id']      = "ログID";
    $this->nameS['user_id']     = "配信ユーザー";
    $this->nameS['name_from']   = "配信者名";
    $this->nameS['mail_from']   = "配信元アドレス";
    $this->nameS['month_count'] = "当月の配信回数";
    $this->nameS['send_count']  = "配信件数（合計）";
    $this->nameS['subject']     = "件名";
    $this->nameS['message']     = "本文(テキスト)";
    $this->nameS['message_html']     = "本文(HTML)";
    $this->nameS['send_date']   = "配信予定日時";
    $this->nameS['date_insert'] = "登録日時";
    $this->nameS['mail_error']        = "エラー配信先";
    $this->nameS['send_count_pc']     = "ＰＣアドレス";
    $this->nameS['send_count_mobile'] = "携帯アドレス";
    $this->nameS['flag_pc']           = "ＰＣアドレス";
    $this->nameS['flag_mobile']       = "携帯アドレス";
    $this->nameS['flag_type']         = "配信タイプ";
    $this->nameS['date_pc']           = "配信完了日（ＰＣ向け）";
    $this->nameS['date_mobile']       = "配信完了日（携帯向け）";



    $this->showArrayDebug($this->nameS,'$this->nameS');
    return;
  }

  // *SET* $this->defaultS => $this->inputS
  function setDefault(){

    $this->defaultS['log_id']      = "";
    $this->defaultS['job_id']       = "";
    $this->defaultS['id']           = "";
    $this->defaultS['password']     = "";
    $this->defaultS['name']         = "";
    $this->defaultS['name_family']  = "";
    $this->defaultS['name_first']   = "";
    $this->defaultS['kana']         = "";
    $this->defaultS['kana_family']  = "";
    $this->defaultS['kana_first']   = "";
    $this->defaultS['birthday']     = "";
    $this->defaultS['birthday_y']   = "";
    $this->defaultS['birthday_m']   = "";
    $this->defaultS['birthday_d']   = "";
    $this->defaultS['mail']         = "";
    $this->defaultS['tel']          = "";
    $this->defaultS['tel_1']        = "";
    $this->defaultS['tel_2']        = "";
    $this->defaultS['tel_3']        = "";
    $this->defaultS['mobile']       = "";
    $this->defaultS['mobile_1']     = "";
    $this->defaultS['mobile_2']     = "";
    $this->defaultS['mobile_3']     = "";
    $this->defaultS['fax']          = "";
    $this->defaultS['fax_1']        = "";
    $this->defaultS['fax_2']        = "";
    $this->defaultS['fax_3']        = "";
    $this->defaultS['zip']          = "";
    $this->defaultS['area']         = "";
    $this->defaultS['address1']     = "";
    $this->defaultS['address2']     = "";
    $this->defaultS['comment']      = "";
    $this->defaultS['flag_gender']  = "";
    $this->defaultS['flag_pictmail']    = "";
    $this->defaultS['flag_stepmail']    = "";
    $this->defaultS['name_company']     = "";
    $this->defaultS['kana_company']     = "";

    $this->showArrayDebug($this->inputS,'$this->inputS');

    return;
  }


  // *SET* $this->defaultS => $this->inputS
  function setDefaultToInput(){
    foreach( $this->defaultS as $key=>$val ){
      if( !isset($this->inputS[$key]) ){
        $this->inputS[$key] = $val;
      }
    }
  }


  // *SET* $_POST => $this->inputS
  function setPostToInput(){

    if(isset($_POST['inputS'])){
      $this->inputS = $_POST['inputS'] ;
    }else{
      $this->inputS = "" ;
    }
    $this->setDefaultToInput();
    $this->convertInput();

    $this->showArrayDebug($this->inputS,'$this->inputS');
  }

  // *SET* DB => $this->inputS
  function setDbToInput(){

    $column  = "";
    $query   = "";

    $column .= "tmain.log_id,";
    $column .= "tmain.id,";
    $column .= "tmain.password,";
    $column .= "tmain.name_family,";
    $column .= "tmain.name_first,";
    $column .= "tmain.kana_family,";
    $column .= "tmain.kana_first,";
    $column .= "tmain.name_company,";
    $column .= "tmain.kana_company,";
    $column .= "tmain.mail,";
    $column .= "tmain.tel,";
    $column .= "tmain.mobile,";
    $column .= "tmain.zip,";
    $column .= "tmain.area,";
    $column .= "tmain.address1,";
    $column .= "tmain.address2,";
    $column .= "tmain.comment,";
    $column .= "tmain.flag_pictmail,";
    $column .= "tmain.flag_stepmail,";

    $column = substr($column,0,-1);

    $query .= "SELECT {$column} FROM td_log AS tmain ";
    $query .= " WHERE tmain.log_id={$_GET['log_id']} ";

    $ExPostgres = $this->dbConnect();
    $ExPostgres->executeQuery($query);
    $dataS = pg_fetch_assoc( $ExPostgres->getResult(),0 );
    pg_free_result( $ExPostgres->getResult() );
    $ExPostgres->close();

    $this->inputS = $dataS ;
    $this->setDefaultToInput();

    $this->convertInput();
    $this->showArrayDebug($this->inputS,'$this->inputS');

    return ;
  }

  // *SET* $this->inputS => $this->writeS
  function setInputToWrite(){
    $this->writeS = $this->inputS;
    $this->convertWrite();
    $this->showArrayDebug($this->writeS,'$this->writeS');
  }


  // *CONVERT* $this->inputS
  function convertInput(){

    require_once(_DIR_LIB_.'convert/Convert.php');
    $Convert = new Convert() ;

    if( isset($_POST['charaCode']) ){
      $postCode = mb_detect_encoding($_POST['charaCode']);
      if( $this->charaCode!=$postCode ){
        foreach( $this->inputS as $key=>$value ){
          $this->inputS[$key] = mb_convert_encoding($value, $this->charaCode, $postCode );
        }
      }
    }

    $this->inputS['name_company']= $Convert->getConvert($this->inputS['name_company'],'KVa2');
    $this->inputS['kana_company']= $Convert->getConvert($this->inputS['kana_company'],'KVa2');
    $this->inputS['comment']     = $Convert->getConvert($this->inputS['comment'],'KVa2');
    $this->inputS['area']        = $Convert->getConvert($this->inputS['area'],'KVa2');
    $this->inputS['address1']    = $Convert->getConvert($this->inputS['address1'],'KVa2');
    $this->inputS['address2']    = $Convert->getConvert($this->inputS['address2'],'KVa2');
    $this->inputS['id']          = $Convert->getConvert($this->inputS['id'],'KVa2');
    $this->inputS['password']    = $Convert->getConvert($this->inputS['password'],'KVa2');
    $this->inputS['name_family'] = $Convert->getConvert($this->inputS['name_family'],'KVa2');
    $this->inputS['name_first']  = $Convert->getConvert($this->inputS['name_first'],'KVa2');
    $this->inputS['kana_family'] = $Convert->getConvert($this->inputS['kana_family'],'KVa2');
    $this->inputS['kana_first']  = $Convert->getConvert($this->inputS['kana_first'],'KVa2');
    $this->inputS['mail']        = $Convert->getConvert($this->inputS['mail'],'KVa2');
    $this->inputS['fax_1']       = $Convert->getConvert($this->inputS['fax_1'],'KVa2');
    $this->inputS['fax_2']       = $Convert->getConvert($this->inputS['fax_2'],'KVa2');
    $this->inputS['fax_3']       = $Convert->getConvert($this->inputS['fax_3'],'KVa2');
    $this->inputS['tel_1']       = $Convert->getConvert($this->inputS['tel_1'],'KVa2');
    $this->inputS['tel_2']       = $Convert->getConvert($this->inputS['tel_2'],'KVa2');
    $this->inputS['tel_3']       = $Convert->getConvert($this->inputS['tel_3'],'KVa2');
    $this->inputS['mobile_1']    = $Convert->getConvert($this->inputS['mobile_1'],'KVa2');
    $this->inputS['mobile_2']    = $Convert->getConvert($this->inputS['mobile_2'],'KVa2');
    $this->inputS['mobile_3']    = $Convert->getConvert($this->inputS['mobile_3'],'KVa2');

    if( $this->inputS['flag_gender']=="" ){   $this->inputS['flag_gender'] = 3; }
    if( $this->inputS['flag_pictmail']=="" ){   $this->inputS['flag_pictmail'] = 'f'; }
    if( $this->inputS['flag_stepmail']=="" ){   $this->inputS['flag_stepmail'] = 'f'; }

    if( $this->inputS['birthday']!="" ){
      list($this->inputS['birthday_y'],$this->inputS['birthday_m'],$this->inputS['birthday_d']) = explode("-",$this->inputS['birthday']);
    }else if($this->inputS['birthday_y']!="" && $this->inputS['birthday_m']!="" && $this->inputS['birthday_d']!=""){
      $this->inputS['birthday'] = sprintf("%04d-%02d-%02d",$this->inputS['birthday_y'],$this->inputS['birthday_m'],$this->inputS['birthday_d']);
    }

    if( $this->inputS['zip']!="" ){
      $this->inputS['zip'] = str_replace('-','',$this->inputS['zip']);
    }

    if( $this->inputS['tel']!="" ){
      list($this->inputS['tel_1'],$this->inputS['tel_2'],$this->inputS['tel_3']) = explode("-",$this->inputS['tel']);
    }else if($this->inputS['tel_1']!="" && $this->inputS['tel_2']!="" && $this->inputS['tel_3']!=""){
      $this->inputS['tel'] = "{$this->inputS['tel_1']}-{$this->inputS['tel_2']}-{$this->inputS['tel_3']}";
    }

    if( $this->inputS['mobile']!="" ){
      list($this->inputS['mobile_1'],$this->inputS['mobile_2'],$this->inputS['mobile_3']) = explode("-",$this->inputS['mobile']);
    }else if($this->inputS['mobile_1']!="" && $this->inputS['mobile_2']!="" && $this->inputS['mobile_3']!=""){
      $this->inputS['mobile'] = "{$this->inputS['mobile_1']}-{$this->inputS['mobile_2']}-{$this->inputS['mobile_3']}";
    }

    if( $this->inputS['fax']!="" ){
      list($this->inputS['fax_1'],$this->inputS['fax_2'],$this->inputS['fax_3']) = explode("-",$this->inputS['fax']);
    }else if($this->inputS['fax_1']!="" && $this->inputS['fax_2']!="" && $this->inputS['fax_3']!=""){
      $this->inputS['fax'] = "{$this->inputS['fax_1']}-{$this->inputS['fax_2']}-{$this->inputS['fax_3']}";
    }


  }

  // *CONVERT* $this->writeS
  function convertWrite(){

    $this->writeS['name_company'] = $this->getTextfield($this->writeS['name_company']); 
    $this->writeS['kana_company'] = $this->getTextfield($this->writeS['kana_company']); 
    $this->writeS['area']         = $this->getTextfield($this->writeS['area']); 
    $this->writeS['address1']     = $this->getTextfield($this->writeS['address1']); 
    $this->writeS['address2']     = $this->getTextfield($this->writeS['address2']); 
    $this->writeS['id']           = $this->getTextfield($this->writeS['id']); 
    $this->writeS['password']     = $this->getTextfield($this->writeS['password']); 
    $this->writeS['name_family']  = $this->getTextfield($this->writeS['name_family']); 
    $this->writeS['name_first']   = $this->getTextfield($this->writeS['name_first']); 
    $this->writeS['kana_family']  = $this->getTextfield($this->writeS['kana_family']); 
    $this->writeS['kana_first']   = $this->getTextfield($this->writeS['kana_first']); 
    $this->writeS['mail']         = $this->getTextfield($this->writeS['mail']); 
    $this->writeS['fax_1']        = $this->getTextfield($this->writeS['fax_1']); 
    $this->writeS['fax_2']        = $this->getTextfield($this->writeS['fax_2']); 
    $this->writeS['fax_3']        = $this->getTextfield($this->writeS['fax_3']); 
    $this->writeS['tel_1']        = $this->getTextfield($this->writeS['tel_1']); 
    $this->writeS['tel_2']        = $this->getTextfield($this->writeS['tel_2']); 
    $this->writeS['tel_3']        = $this->getTextfield($this->writeS['tel_3']); 

    $this->writeS['mobile_1']     = $this->getTextfield($this->writeS['mobile_1']); 
    $this->writeS['mobile_2']     = $this->getTextfield($this->writeS['mobile_2']); 
    $this->writeS['mobile_3']     = $this->getTextfield($this->writeS['mobile_3']); 

    $this->writeS['id']           = $this->getTextfield($this->writeS['id']); 
    $this->writeS['password']     = $this->getTextfield($this->writeS['password']); 

    $this->writeS['comment']      = $this->getTextarea($this->writeS['comment']); 

    foreach( $this->writeS as $key=>$value ){
      $this->writeS[$key] = mb_convert_encoding($value, $this->outputCode, $this->charaCode );
    }

  }


  // *CHECK* $this->inputS
  function checkInput(){

    require_once(_DIR_LIB_.'check/Check.php');
    $Check = new Check() ;
/*
    if( !$Check->isInput($this->inputS['company_id']) )        $this->errorS[company_id]        = "{$this->nameS['company_id']} が未入力です";
    if( !$Check->isInput($this->inputS['branch_id']) )         $this->errorS[branch_id]         = "{$this->nameS['branch_id']} が未入力です";
    if( !$Check->isInput($this->inputS['user_job_2_id']) ) $this->errorS[user_job_2_id] = "{$this->nameS['user_job_2_id']} が未入力です";
    if( !$Check->isInput($this->inputS['area_id']) )           $this->errorS[area_id]           = "{$this->nameS['area_id']} が未入力です";
    if( !$Check->isInput($this->inputS['wage']) )              $this->errorS[wage]              = "{$this->nameS['wage']} が未入力です";
    if( !$Check->isInput($this->inputS['comment1']) )          $this->errorS[comment1]          = "{$this->nameS['comment1']} が未入力です";
    if( !$Check->isInput($this->inputS['comment5']) )          $this->errorS[comment5]          = "{$this->nameS['comment5']} が未入力です";
    if( !$Check->isInput($this->inputS['flag_exp']) )          $this->errorS[flag_exp]          = "{$this->nameS['flag_exp']} が未入力です";
    if( !$Check->isInput($this->inputS['flag_term']) )         $this->errorS[flag_term]         = "{$this->nameS['flag_term']} が未入力です";
    if( !$Check->isInput($this->inputS['user_wage_code_s']) ) $this->errorS[user_wage_code_s] = "{$this->nameS['user_wage_code_s']} が未入力です";

    if( $Check->isInput($this->inputS['sort']) && !$Check->isNumber($this->inputS['sort']) )
      $this->errorS[wage]      = "{$this->nameS['sort']} は半角英数でご入力ください";

    if( $Check->isInput($this->inputS['wage']) && !$Check->isNumber($this->inputS['wage']) )
      $this->errorS[wage]      = "{$this->nameS['wage']} は半角英数でご入力ください";

    if( $Check->isInput($this->inputS['age_min']) && !$Check->isNumber($this->inputS['age_min']) )
      $this->errorS[age_min]   = "{$this->nameS['age_min']} は半角英数でご入力ください";

    if( $Check->isInput($this->inputS['age_max']) && !$Check->isNumber($this->inputS['age_max']) )
      $this->errorS[age_max]   = "{$this->nameS['age_max']} は半角英数でご入力ください";

    if( $Check->isInput($this->inputS['year_exp']) && !$Check->isNumber($this->inputS['year_exp']) )
      $this->errorS[year_exp]      = "{$this->nameS['year_exp']} は半角英数でご入力ください";
*/
  }

  // *SET* ID
  function setSequenceId(){
    $ExPostgres = $this->dbConnect();
    $this->inputS['log_id']     = $ExPostgres->getNextval('td_log_seq');
    $ExPostgres->close();
  }

}
?>
