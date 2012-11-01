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
  }

  // *SET* SESSION 検索初期化
  function setSessionSeekFormat(){
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['user_id']  = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['plan_pictmail_id']  = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['name_family']  = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['name_first']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['kana_family']  = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['kana_first']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['birthday_y']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['birthday_m']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['birthday_d']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['birthday']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert1']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert_y1']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert_m1']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert_d1']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert2']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert_y2']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert_m2']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert_d2']   = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['name_company'] = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['kana_company'] = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['mail']  = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['tel_1'] = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['tel_2'] = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['tel_3'] = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['tel'] = "";
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['comment'] = "";
  }

  // *SET* SESSION 検索
  function setSessionSeek(){
    if(isset($_POST['seekS'])){
      unset($_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']);
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['birthday'] = "";
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['tel'] = "";
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['user_id'] = $_POST['seekS']['user_id'];
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['plan_pictmail_id'] = $_POST['seekS']['plan_pictmail_id'];
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['name_family']  = $_POST['seekS']['name_family'];
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['name_first']   = $_POST['seekS']['name_first'];
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['kana_family']  = $_POST['seekS']['kana_family'];
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['kana_first']   = $_POST['seekS']['kana_first'];
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['birthday_y']   = $_POST['seekS']['birthday_y'];
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['birthday_m']   = $_POST['seekS']['birthday_m'];
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['birthday_d']   = $_POST['seekS']['birthday_d'];
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert1'] = "";
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert_y1']   = $_POST['seekS']['date_insert_y1'];
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert_m1']   = $_POST['seekS']['date_insert_m1'];
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert_d1']   = $_POST['seekS']['date_insert_d1'];
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert2'] = "";
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert_y2']   = $_POST['seekS']['date_insert_y2'];
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert_m2']   = $_POST['seekS']['date_insert_m2'];
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert_d2']   = $_POST['seekS']['date_insert_d2'];
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['name_company'] = $_POST['seekS']['name_company'];
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['kana_company'] = $_POST['seekS']['kana_company'];
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['comment'] = $_POST['seekS']['comment'];
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['mail']  = $_POST['seekS']['mail'];
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['tel_1'] = $_POST['seekS']['tel_1'];
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['tel_2'] = $_POST['seekS']['tel_2'];
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['tel_3'] = $_POST['seekS']['tel_3'];

      if($_POST['seekS']['tel_1']!="" && $_POST['seekS']['tel_2']!="" && $_POST['seekS']['tel_3']!="" ){
        $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['tel'] = "{$_POST['seekS']['tel_1']}-{$_POST['seekS']['tel_2']}-{$_POST['seekS']['tel_3']}";
      }

      if($_POST['seekS']['birthday_y']!="" && $_POST['seekS']['birthday_m']!="" && $_POST['seekS']['birthday_d']!="" ){
        $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['birthday']  = sprintf('%04d',$_POST['seekS']['birthday_y'])."-";
        $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['birthday'] .= sprintf('%02d',$_POST['seekS']['birthday_m'])."-";
        $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['birthday'] .= sprintf('%02d',$_POST['seekS']['birthday_d']);
      }

      if($_POST['seekS']['date_insert_y1']!="" && $_POST['seekS']['date_insert_m1']!="" && $_POST['seekS']['date_insert_d1']!="" ){
        $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert1']  = sprintf('%04d',$_POST['seekS']['date_insert_y1'])."-";
        $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert1'] .= sprintf('%02d',$_POST['seekS']['date_insert_m1'])."-";
        $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert1'] .= sprintf('%02d',$_POST['seekS']['date_insert_d1']);
      }

      if($_POST['seekS']['date_insert_y2']!="" && $_POST['seekS']['date_insert_m2']!="" && $_POST['seekS']['date_insert_d2']!="" ){
        $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert2']  = sprintf('%04d',$_POST['seekS']['date_insert_y2'])."-";
        $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert2'] .= sprintf('%02d',$_POST['seekS']['date_insert_m2'])."-";
        $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert2'] .= sprintf('%02d',$_POST['seekS']['date_insert_d2']);
      }
    }
  }


  // *SET* SESSION ページ位置
  function setSessionPlace($place=False){
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['place'] = $place;
  }

  // *GET* SESSION ページ位置
  function getSessionPlace(){
    return $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['place'];
  }


  // *SET* Name
  function setName(){

    $this->nameS['user_id']     = "ユーザーID";
    $this->nameS['job_id']      = "職業ID";
    $this->nameS['id']          = "ログインID";
    $this->nameS['password']    = "パスワード";
    $this->nameS['name']        = "名前";
    $this->nameS['name_family'] = "名前：姓";
    $this->nameS['name_first']  = "名前：名";
    $this->nameS['kana']        = "名前（フリガナ）";
    $this->nameS['kana_family'] = "名前：姓（フリガナ）";
    $this->nameS['kana_first']  = "名前：名（フリガナ）";
    $this->nameS['birthday']    = "生年月日";
    $this->nameS['birthday_y']  = "誕生日：年";
    $this->nameS['birthday_m']  = "誕生日：月";
    $this->nameS['birthday_d']  = "誕生日：日";
    $this->nameS['mail']        = "メールアドレス";
    $this->nameS['tel']         = "電話番号";
    $this->nameS['tel_1']       = "電話番号（上部）";
    $this->nameS['tel_2']       = "電話番号（中部）";
    $this->nameS['tel_3']       = "電話番号（下部）";
    $this->nameS['mobile']      = "携帯電話";
    $this->nameS['mobile_1']    = "携帯電話（上部）";
    $this->nameS['mobile_2']    = "携帯電話（中部）";
    $this->nameS['mobile_3']    = "携帯電話（下部）";
    $this->nameS['fax']         = "FAX番号";
    $this->nameS['fax_1']       = "FAX番号（上部）";
    $this->nameS['fax_2']       = "FAX番号（中部）";
    $this->nameS['fax_3']       = "FAX番号（下部）";
    $this->nameS['zip']         = "郵便番号";
    $this->nameS['area']        = "都道府県";
    $this->nameS['address1']    = "市区町村丁目番地";
    $this->nameS['address2']    = "ビル名";
    $this->nameS['comment']     = "備考";
    $this->nameS['flag_gender'] = "性別";
    $this->nameS['flag_pictmail'] = "メール一括配信使用";
    $this->nameS['flag_stepmail'] = "ステップメール使用";
    $this->nameS['name_company']  = "会社名";
    $this->nameS['kana_company']  = "会社名（フリガナ）";
    $this->nameS['date_insert']   = "登録日";

    $this->showArrayDebug($this->nameS,'$this->nameS');

  }

  // *SET* $this->defaultS => $this->inputS
  function setDefault(){

    $this->defaultS['user_id']      = "";
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

    $column .= "tmain.user_id,";
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

    $query .= "SELECT {$column} FROM td_user AS tmain ";
    $query .= " WHERE tmain.user_id={$_GET['user_id']} ";

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
    $this->inputS['user_id']     = $ExPostgres->getNextval('td_user_seq');
    $ExPostgres->close();
  }

}
?>
