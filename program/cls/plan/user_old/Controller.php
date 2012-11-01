<?PHP
/*
  物件管理：コントロール
*/
class Controller extends Html {

  var $pageS = "";
  var $dataS = "";

  function Controller(){

    $this->pageS['place'] = $this->setPlace();
    $this->pageS['mode']  = $this->setMode();

    $this->dataS->error="";
    $this->dataS->inputS['user_id']="";
    $this->dataS->inputS['plan_id']="";
    $this->dataS->inputS['auto_money']="";

    switch( $this->pageS['place'] ){
      case "write":
      case "rewrite":
        $this->pageWrite();
        break;

      case "confirm":
        $this->pageConfirm();
        break;

      case "finish":
      case "finish_renew":
        $this->pageFinish();
        break;

      default:
        die("Error :"._PG_ROOT_._PG_FILE_CONTOROLLER_." on line ".__LINE__." Place is [{$this->pageS['place']}] UNKNOWN ");
    }

  }

  // *Debug*
  function isDebug(){
    if(_DEBUG_){
      require_once(_DIR_LIB_.'debug/Debug.php');
      $this->Debug = new Debug();
      echo "Now Mode = {$this->pageS['place']}<br>\n";
      echo "RegistMode = {$this->pageS['mode']}<br>\n";
    }
  }

  // *CHECK* 存在
  function isRequire($path){
    return file_exists($path) ? True : False ;
  }

  // *SET* 登録モード
  function setMode($mode=False){
    if($mode==""){
      if( isset($_POST['mode']) ){
        $mode = $_POST['mode'];
      }else if( isset($_GET['mode']) ){
        $mode = $_GET['mode'];
      }else{
        $mode = "renew";
      }
    }
    return $mode;
  }

  // *SET* 現在地
  function setPlace($place=False){
    if($place==""){
      if( isset($_POST['post']) ){
        $place = @key($_POST['post']);
      }else if( isset($_GET['get']) ){
        $place = $_GET['get'];
      }else if( isset($_POST['hidden']) ){
        $place = $_POST['hidden'];
      }else{
        $place = "write";
      }
    }
    return $place;
  }


  // *SET* ページ
  function setPage(){

    switch( $this->pageS['place'] ){
      case   "write":
      case "rewrite": 
        $this->pageS['html']  = _PG_ROOT_HTML_._PG_HTML_WRITE_;
        $this->pageS['title'] = _PG_TITLE_WRITE_;
        break;
      case "confirm": 
        $this->pageS['html']  = _PG_ROOT_HTML_._PG_HTML_CONFIRM_;
        $this->pageS['title'] = _PG_TITLE_CONFIRM_;
        break;
      case "finish": 
      case "finish_renew": 
        $this->pageS['html']  = _PG_ROOT_HTML_._PG_HTML_FINISH_;
        $this->pageS['title'] = _PG_TITLE_FINISH_;
        break;
    }

    return ;
  }


  // *PAGE* 入力ページ
  function pageWrite(){
    $this->setPage();
    $this->isDebug();
    switch( $this->pageS['place'] ){
      case "rewrite": 
        break;
      case "write":
        break;
    }
    require_once(_PG_ROOT_._PG_FILE_VIEWER_);
    $Viewer = new Viewer($this->pageS,$this->dataS);
    $Viewer->showPage();
  }

  // *PAGE* 確認/エラー入力ページ
  function pageConfirm(){

    $this->setDataS();

    if( $this->dataS->error!="" ){
      $this->pageS['place'] = "write";
    }
    $this->setPage();

    $this->isDebug();

    require_once(_PG_ROOT_._PG_FILE_VIEWER_);
    $Viewer = new Viewer($this->pageS,$this->dataS);
    $Viewer->showPage();

  }


  // *PAGE* 完了ページ
  function pageFinish(){

    $this->setDataS();
    $this->setPage();
    $this->isDebug();

    require_once(_PG_ROOT_._PG_FILE_VIEWER_);
    $Viewer = new Viewer($this->pageS,$this->dataS);

    $dataS = $Viewer->getViewDataSConfirm();

    $a8Margin = (($dataS['org']['price_month6']+$dataS['org']['price_first'])*0.1);
    $a8Date = date('YmdHis');
    $a8so = $_SESSION['user']['user_id'];
    $a8Url =  "https://px.a8.net/cgi-bin/a8fly/sales?pid=s00000001947003&so={$a8so}&si={$a8Margin}.1.{$a8Margin}.{$dataS['plan_id']}&ts={$a8Date}";
    $_SESSION['user']['a8Tag'] = "IMG SRC=\"{$a8Url}\" width=\"1\" height=\"1\"";

    require_once(_PG_ROOT_._PG_FILE_MAILER_);
    $Mailer = new Mailer();
    $Mailer->sendMailFinish($dataS);
    $Viewer->showPage();
    unset($_SESSION['user']['a8Tag']);
  }


  function setDataS(){

    $this->dataS->error="";
    $this->dataS->inputS['user_id']="";
    $this->dataS->inputS['plan_id']="";
    $this->dataS->inputS['auto_money']="";

    if(isset($_POST['inputS']['plan_id'])){
      $this->dataS->inputS['user_id']=$_POST['inputS']['user_id'];
      $this->dataS->inputS['plan_id']=$_POST['inputS']['plan_id'];
    }else{
      $this->dataS->error.="プランをご選択ください<br>";
    }

    if(isset($_POST['inputS']['pay'])){
      $this->dataS->inputS['pay']=$_POST['inputS']['pay'];
    }else{
      $this->dataS->error.="支払い方法をご選択ください<br>";
    }

    if( $this->dataS->error!="" ){
      $this->pageS['place'] = "write";
    }

    if(isset($_POST['inputS']['auto_money'])){
      $this->dataS->inputS['auto_money']=$_POST['inputS']['auto_money'];
    }else{
      $this->dataS->error.="二回目以降の支払い希望をご選択ください<br>";
    }




    return ;
  }

}

?>
