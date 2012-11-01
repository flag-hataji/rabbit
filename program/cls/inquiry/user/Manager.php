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

  // *SET* SESSION ログイン情報
  function setSessionLogin($place=False){
    $_SESSION['inquiry']['id']       = $this->inputS['id'];
    $_SESSION['inquiry']['password'] = $this->inputS['password'];
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

    $this->nameS['inquiry_id']     = "お問い合わせID";
    $this->nameS['user_id']     = "ユーザーID";
    $this->nameS['name']        = "名前";
    $this->nameS['name_family'] = "名前：姓";
    $this->nameS['name_first']  = "名前：名";
    $this->nameS['kana']        = "名前（フリガナ）";
    $this->nameS['kana_family'] = "名前：姓（フリガナ）";
    $this->nameS['kana_first']  = "名前：名（フリガナ）";
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
    $this->nameS['inquiry']     = "お問合せ内容";
    $this->nameS['name_company']  = "会社名";
    $this->nameS['kana_company']  = "会社名（フリガナ）";

    $this->showArrayDebug($this->nameS,'$this->nameS');

  }

  // *SET* $this->defaultS => $this->inputS
  function setDefault(){

    $this->defaultS['inquiry_id']      = "";
    $this->defaultS['user_id']      = "";
    $this->defaultS['name']         = "";
    $this->defaultS['name_family']  = "";
    $this->defaultS['name_first']   = "";
    $this->defaultS['kana']         = "";
    $this->defaultS['kana_family']  = "";
    $this->defaultS['kana_first']   = "";
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
    $this->defaultS['inquiry']      = "";
    $this->defaultS['name_company']  = "";
    $this->defaultS['kana_company']  = "";

    if(isset($_SESSION['user']['user_id']) && $_SESSION['user']['user_id']!=""){
      $this->defaultS['user_id']  = $_SESSION['user']['user_id'];
    }
    if(isset($_SESSION['user']['name_company']) && $_SESSION['user']['name_company']!=""){
      $this->defaultS['name_company']  = $_SESSION['user']['name_company'];
    }
    if(isset($_SESSION['user']['kana_company']) && $_SESSION['user']['kana_company']!=""){
      $this->defaultS['kana_company']  = $_SESSION['user']['kana_company'];
    }
    if(isset($_SESSION['user']['name_family']) && $_SESSION['user']['name_family']!=""){
      $this->defaultS['name_family']  = $_SESSION['user']['name_family'];
    }
    if(isset($_SESSION['user']['name_first']) && $_SESSION['user']['name_first']!=""){
      $this->defaultS['name_first']  = $_SESSION['user']['name_first'];
    }
    if(isset($_SESSION['user']['kana_family']) && $_SESSION['user']['kana_family']!=""){
      $this->defaultS['kana_family']  = $_SESSION['user']['kana_family'];
    }
    if(isset($_SESSION['user']['kana_first']) && $_SESSION['user']['kana_first']!=""){
      $this->defaultS['kana_first']  = $_SESSION['user']['kana_first'];
    }
    if(isset($_SESSION['user']['mail']) && $_SESSION['user']['mail']!=""){
      $this->defaultS['mail']  = $_SESSION['user']['mail'];
    }
    if(isset($_SESSION['user']['tel']) && $_SESSION['user']['tel']!=""){
      list($tel_1,$tel_2,$tel_3) = explode("-",$_SESSION['user']['tel']);
      $this->defaultS['tel_1']  = $tel_1;
      $this->defaultS['tel_2']  = $tel_2;
      $this->defaultS['tel_3']  = $tel_3;
    }
    if(isset($_SESSION['user']['mobile']) && $_SESSION['user']['mobile']!=""){
      list($mobile_1,$mobile_2,$mobile_3) = explode("-",$_SESSION['user']['mobile']);
      $this->defaultS['mobile_1']  = $mobile_1;
      $this->defaultS['mobile_2']  = $mobile_2;
      $this->defaultS['mobile_3']  = $mobile_3;
    }
    if(isset($_SESSION['user']['fax']) && $_SESSION['user']['fax']!=""){
      list($fax_1,$fax_2,$fax_3) = explode("-",$_SESSION['user']['fax']);
      $this->defaultS['fax_1']  = $fax_1;
      $this->defaultS['fax_2']  = $fax_2;
      $this->defaultS['fax_3']  = $fax_3;
    }

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

    $column .= "tmain.inquiry_id,";
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
    $column .= "tmain.inquiry,";
    $column .= "tmain.flag_pictmail,";
    $column .= "tmain.flag_stepmail,";

    $column = substr($column,0,-1);

    $query .= "SELECT {$column} FROM td_inquiry AS tmain ";
    $query .= " WHERE tmain.inquiry_id={$_SESSION['inquiry']['inquiry_id']} ";

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
    $this->inputS['kana_company']= $Convert->getConvert($this->inputS['kana_company'],'KCVa2');
    $this->inputS['inquiry']     = $Convert->getConvert($this->inputS['inquiry'],'KVa2');
    $this->inputS['name_family'] = $Convert->getConvert($this->inputS['name_family'],'KVa2');
    $this->inputS['name_first']  = $Convert->getConvert($this->inputS['name_first'],'KVa2');
    $this->inputS['kana_family'] = $Convert->getConvert($this->inputS['kana_family'],'KCVa2');
    $this->inputS['kana_first']  = $Convert->getConvert($this->inputS['kana_first'],'KCVa2');
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

    $this->writeS['inquiry']      = $this->getTextarea($this->writeS['inquiry']); 

    foreach( $this->writeS as $key=>$value ){
      $this->writeS[$key] = mb_convert_encoding($value, $this->outputCode, $this->charaCode );
    }

  }


  // *CHECK* $this->inputS
  function checkInput($mode=False){
    $ExPostgres = $this->dbConnect();

    require_once(_DIR_LIB_.'check/Check.php');
    $Check = new Check() ;

    if( !$Check->isInput($this->inputS['name_first']) )  $this->errorS['name']     = "{$this->nameS['name_first']} が未入力です";
    if( !$Check->isInput($this->inputS['name_family']) ) $this->errorS['name'] = "{$this->nameS['name_family']} が未入力です";
    if( !$Check->isInput($this->inputS['mail']) )        $this->errorS['mail'] = "{$this->nameS['mail']} が未入力です";

    if( !$Check->isInput($this->inputS['inquiry']) )    $this->errorS['inquiry'] = "{$this->nameS['inquiry']} が未入力です";


    if( !$Check->isInput($this->inputS['kana_first']) ){
      $this->errorS['kana'] = "{$this->nameS['kana_first']} が未入力です";
    }else if( !$Check->isKataKana($this->inputS['kana_first']) ){
      $this->errorS['kana'] = "{$this->nameS['kana_first']} はカタカナでご入力くださいす";
    }

    if( !$Check->isInput($this->inputS['kana_family']) ){
      $this->errorS['kana'] = "{$this->nameS['kana_family']} が未入力です";
    }else if( !$Check->isKataKana($this->inputS['kana_family']) ){
      $this->errorS['kana'] = "{$this->nameS['kana_family']} はカタカナでご入力くださいす";
    }

    if( !$Check->isInput($this->inputS['tel']) && !$Check->isInput($this->inputS['mobile']) ){
        $this->errorS['tel'] = "{$this->nameS['tel']}か{$this->nameS['mobile']} はどちらか必ずご入力ください。";
        $this->errorS['mobile'] = "{$this->nameS['tel']}か{$this->nameS['mobile']} はどちらか必ずご入力ください。";
    }

    if( $Check->isInput($this->inputS['tel_3']) ){
      if( $Check->isInput($this->inputS['tel_3']) && !$Check->isNumber($this->inputS['tel_3']) ){
        $this->errorS['tel'] = "{$this->nameS['tel_3']} は半角英数でご入力ください";
      }else if( !$Check->isLen($this->inputS['tel_3'],7) ){
        $this->errorS['tel'] = "{$this->nameS['tel_3']} は7字以内に収めてください。";
      }
    }

    if( $Check->isInput($this->inputS['tel_2']) ){
      if( $Check->isInput($this->inputS['tel_2']) && !$Check->isNumber($this->inputS['tel_2']) ){
        $this->errorS['tel'] = "{$this->nameS['tel_2']} は半角英数でご入力ください";
      }else if( !$Check->isLen($this->inputS['tel_2'],7) ){
        $this->errorS['tel'] = "{$this->nameS['tel_2']} は7字以内に収めてください。";
      }
    }

    if( $Check->isInput($this->inputS['tel_1']) ){
      if( $Check->isInput($this->inputS['tel_1']) && !$Check->isNumber($this->inputS['tel_1']) ){
        $this->errorS['tel'] = "{$this->nameS['tel_1']} は半角英数でご入力ください";
      }else if( !$Check->isLen($this->inputS['tel_1'],7) ){
        $this->errorS['tel'] = "{$this->nameS['tel_1']} は7字以内に収めてください。";
      }
    }

    if( $Check->isInput($this->inputS['mobile_3']) ){
      if( $Check->isInput($this->inputS['mobile_3']) && !$Check->isNumber($this->inputS['mobile_3']) ){
        $this->errorS['mobile'] = "{$this->nameS['mobile_3']} は半角英数でご入力ください";
      }else if( !$Check->isLen($this->inputS['mobile_3'],7) ){
        $this->errorS['mobile'] = "{$this->nameS['mobile_3']} は7字以内に収めてください。";
      }
    }

    if( $Check->isInput($this->inputS['mobile_2']) ){
      if( $Check->isInput($this->inputS['mobile_2']) && !$Check->isNumber($this->inputS['mobile_2']) ){
        $this->errorS['mobile'] = "{$this->nameS['mobile_2']} は半角英数でご入力ください";
      }else if( !$Check->isLen($this->inputS['mobile_2'],7) ){
        $this->errorS['mobile'] = "{$this->nameS['mobile_2']} は7字以内に収めてください。";
      }
    }

    if( $Check->isInput($this->inputS['mobile_1']) ){
      if( $Check->isInput($this->inputS['mobile_1']) && !$Check->isNumber($this->inputS['mobile_1']) ){
        $this->errorS['mobile'] = "{$this->nameS['mobile_1']} は半角英数でご入力ください";
      }else if( !$Check->isLen($this->inputS['mobile_1'],7) ){
        $this->errorS['mobile'] = "{$this->nameS['mobile_1']} は7字以内に収めてください。";
      }
    }

    if( $Check->isInput($this->inputS['fax_3']) ){
      if( $Check->isInput($this->inputS['fax_3']) && !$Check->isNumber($this->inputS['fax_3']) ){
        $this->errorS['fax'] = "{$this->nameS['fax_3']} は半角英数でご入力ください";
      }else if( !$Check->isLen($this->inputS['fax_3'],7) ){
        $this->errorS['fax'] = "{$this->nameS['fax_3']} は7字以内に収めてください。";
      }
    }

    if( $Check->isInput($this->inputS['fax_2']) ){
      if( $Check->isInput($this->inputS['fax_2']) && !$Check->isNumber($this->inputS['fax_2']) ){
        $this->errorS['fax'] = "{$this->nameS['fax_2']} は半角英数でご入力ください";
      }else if( !$Check->isLen($this->inputS['fax_2'],7) ){
        $this->errorS['fax'] = "{$this->nameS['fax_2']} は7字以内に収めてください。";
      }
    }

    if( $Check->isInput($this->inputS['fax_1']) ){
      if( $Check->isInput($this->inputS['fax_1']) && !$Check->isNumber($this->inputS['fax_1']) ){
        $this->errorS['fax'] = "{$this->nameS['fax_1']} は半角英数でご入力ください";
      }else if( !$Check->isLen($this->inputS['fax_1'],7) ){
        $this->errorS['fax'] = "{$this->nameS['fax_1']} は7字以内に収めてください。";
      }
    }

    if( !$Check->isInput($this->inputS['mail']) ){
      $this->errorS['mail'] = "{$this->nameS['mail']} が未入力です";
    }else if( !$Check->isMail($this->inputS['mail']) ){
      $this->errorS['mail'] = "{$this->nameS['mail']} の {$this->writeS['mail']} は正しいメールアドレスではありません。";
    }else if( !$Check->isLen($this->inputS['mail'],100) ){
      $this->errorS['mail'] = "{$this->nameS['mail']} は100字以内に収めてください。";
    }

    $ExPostgres->close();
  }


  // *SET* 新規登録
  function setNewRegist(){

    require_once(_DIR_LIB_."util/Browse.php");
    $Browse = new Browse();

    $ExPostgres = $this->dbConnect();

    $this->inputS['inquiry_id']     = $ExPostgres->getNextval('td_inquiry_seq');
    $this->inputS['ip']   = $Browse->remote_address;
    $this->inputS['host'] = $Browse->remote_host;

    $ExPostgres->close();
  }

}
?>
