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
    $_SESSION['collect']['id']       = $this->inputS['id'];
    $_SESSION['collect']['password'] = $this->inputS['password'];
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

    $this->nameS['collect_id'] = "メール収集ID";
    $this->nameS['user_id']    = "ユーザーID";
    $this->nameS['tool_id']    = "ダウンロードツール";
    $this->nameS['mail']       = "メールアドレス";
    $this->nameS['ip']         = "IP";
    $this->nameS['host']       = "ホスト";
    $this->nameS['flag_download'] = "ダウンロードフラグ";

    $this->showArrayDebug($this->nameS,'$this->nameS');

  }

  // *SET* $this->defaultS => $this->inputS
  function setDefault(){

    $this->defaultS['collect_id'] = "";
    $this->defaultS['user_id']    = "";
    $this->defaultS['tool_id']    = "";
    $this->defaultS['mail']       = "";
    $this->defaultS['ip']         = "";
    $this->defaultS['host']       = "";
    $this->defaultS['flag_download']       = 2;

    if(isset($_SESSION['user']['user_id']) && $_SESSION['user']['user_id']!=""){
      $this->defaultS['user_id']  = $_SESSION['user']['user_id'];
    }
    if(isset($_SESSION['user']['mail']) && $_SESSION['user']['mail']!=""){
      $this->defaultS['mail']  = $_SESSION['user']['mail'];
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

    $column .= "tmain.collect_id,";
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
    $column .= "tmain.collect,";
    $column .= "tmain.flag_pictmail,";
    $column .= "tmain.flag_stepmail,";

    $column = substr($column,0,-1);

    $query .= "SELECT {$column} FROM td_collect AS tmain ";
    $query .= " WHERE tmain.collect_id={$_SESSION['collect']['collect_id']} ";

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

    $this->inputS['mail']        = $Convert->getConvert($this->inputS['mail'],'KVa2');

  }

  // *CONVERT* $this->writeS
  function convertWrite(){

    $this->writeS['mail'] = $this->getTextfield($this->writeS['mail']); 

    foreach( $this->writeS as $key=>$value ){
      $this->writeS[$key] = mb_convert_encoding($value, $this->outputCode, $this->charaCode );
    }

    return ;
  }


  // *CHECK* ツール
  function checkTool(){

    if( !isset($_POST['inputS']['tool_id']) || $_POST['inputS']['tool_id']=="" ){
      $this->errorS['tool_id'] = "{$this->nameS['tool_id']} が正しくありません";
    }else{
      $query  = "SELECT * FROM tm_tool WHERE tool_id={$_POST['inputS']['tool_id']} ";
      $ExPostgres = $this->dbConnect();
      $ExPostgres->executeQuery($query);
      if($ExPostgres->getRow()!=0){
        $dataS = pg_fetch_assoc( $ExPostgres->getResult(),0 );
        $this->inputS['tool_id'] = $dataS['tool_id'];
        $this->viewS['tool_id']  = $dataS['tool'];
        $this->writeS['tool_id'] = $dataS['tool_id'];
      }else{
        $this->errorS['tool_id'] = "{$this->nameS['tool_id']} が正しくありません";
      }
      $ExPostgres->close();
    }

    $this->showArrayDebug($this->errorS,'$this->errorS');

    return;
  }

  // *CHECK* ID
  function checkId(){

    if( !isset($_GET['collect_id']) || $_GET['collect_id']=="" ){
      $this->errorS['collect_id'] = "ダウンロード希望を行ってください";
    }else{
      $query  = "SELECT * FROM td_collect WHERE collect_id={$_GET['collect_id']} ";
      $ExPostgres = $this->dbConnect();
      $ExPostgres->executeQuery($query);
      if($ExPostgres->getRow()!=0){
        $dataS = pg_fetch_assoc( $ExPostgres->getResult(),0 );
        $this->inputS['collect_id'] = $dataS['collect_id'];
      }else{
        $this->errorS['collect_id'] = "ダウンロード希望を行ってください";
      }
      $ExPostgres->close();
    }

    $this->showArrayDebug($this->errorS,'$this->errorS');

    return;
  }


  // *CHECK* $this->inputS
  function checkInput($mode=False){
    $ExPostgres = $this->dbConnect();

    require_once(_DIR_LIB_.'check/Check.php');
    $Check = new Check() ;

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

    $this->inputS['collect_id']  = $ExPostgres->getNextval('td_collect_seq');
    $this->inputS['ip']          = $Browse->remote_address;
    $this->inputS['host']        = $Browse->remote_host;

    $ExPostgres->close();
  }

}
?>
