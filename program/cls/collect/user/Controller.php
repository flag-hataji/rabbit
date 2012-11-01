<?PHP
/*
  物件管理：コントロール
*/
class Controller extends Html {

  var $pageS = "";

  function Controller(){

    if($this->isRequire(_PG_ROOT_._PG_FILE_MANAGER_)){
      require_once(_PG_ROOT_._PG_FILE_MANAGER_);
      $this->Manager = new Manager();
    }else{
      die("Error :"._PG_ROOT_._PG_FILE_CONTOROLLER_." on line ".__LINE__." "._PG_ROOT_._PG_FILE_MANAGER_." Require Error");
    }

    $this->pageS['place'] = $this->setPlace();
    $this->pageS['mode']  = $this->setMode();

    switch( $this->pageS['place'] ){
      case "download":
        $this->pageDownload();
        break;

      case "seek":
        $this->pageSeek();
        break;

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
        $mode = "new";
      }
    }
    return $mode;
  }

  // *SET* 現在地
  function setPlace($place=False){
    if($place==""){
      if( isset($_GET['collect_id']) ){
        $place = "download";
      }else if( isset($_POST['post']) ){
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

    switch( $this->pageS['mode'] ){

      // 新規登録
      case "new": 
        switch( $this->pageS['place'] ){
          case "download": 
            $this->pageS['html']  = _PG_ROOT_HTML_._PG_HTML_DOWNLOAD_;
            $this->pageS['title'] = _PG_TITLE_DOWNLOAD_;
            break;
          case "error": 
            $this->pageS['html']  = _PG_ROOT_HTML_._PG_HTML_ERROR_;
            $this->pageS['title'] = _PG_TITLE_ERROR_;
            break;
          case "seek": 
            $this->pageS['html']  = _PG_ROOT_HTML_._PG_HTML_NEW_SEEK_;
            $this->pageS['title'] = _PG_TITLE_NEW_SEEK_;
            break;
          case   "list":
          case   "delete":
            $this->pageS['html']  = _PG_ROOT_HTML_._PG_HTML_NEW_LIST_;
            $this->pageS['title'] = _PG_TITLE_NEW_LIST_;
            break;
          case   "write":
          case "rewrite": 
            $this->pageS['html']  = _PG_ROOT_HTML_._PG_HTML_WRITE_;
            $this->pageS['title'] = _PG_TITLE_NEW_WRITE_;
            break;
          case "confirm": 
            $this->pageS['html']  = _PG_ROOT_HTML_._PG_HTML_CONFIRM_;
            $this->pageS['title'] = _PG_TITLE_NEW_CONFIRM_;
            break;
          case "finish": 
            $this->pageS['html']  = _PG_ROOT_HTML_._PG_HTML_FINISH_;
            $this->pageS['title'] = _PG_TITLE_NEW_FINISH_;
            break;
        }
        break;

      // 修正・削除
      case "renew": 
        switch( $this->pageS['place'] ){
          case "download": 
            $this->pageS['html']  = _PG_ROOT_HTML_._PG_HTML_DOWNLOAD_;
            $this->pageS['title'] = _PG_TITLE_DOWNLOAD_;
            break;
          case "error": 
            $this->pageS['html']  = _PG_ROOT_HTML_._PG_HTML_ERROR_;
            $this->pageS['title'] = _PG_TITLE_ERROR_;
            break;
          case "seek": 
            $this->pageS['html']  = _PG_ROOT_HTML_._PG_HTML_RENEW_SEEK_;
            $this->pageS['title'] = _PG_TITLE_RENEW_SEEK_;
            break;
          case   "list":
          case   "delete":
          case   "permission":
            $this->pageS['html']  = _PG_ROOT_HTML_._PG_HTML_RENEW_LIST_;
            $this->pageS['title'] = _PG_TITLE_RENEW_LIST_;
            break;
          case   "write":
          case "rewrite": 
            $this->pageS['html']  = _PG_ROOT_HTML_._PG_HTML_WRITE_;
            $this->pageS['title'] = _PG_TITLE_RENEW_WRITE_;
            break;
          case "confirm": 
            $this->pageS['html']  = _PG_ROOT_HTML_._PG_HTML_CONFIRM_;
            $this->pageS['title'] = _PG_TITLE_RENEW_CONFIRM_;
            break;
          case "finish": 
          case "finish_renew": 
            $this->pageS['html']  = _PG_ROOT_HTML_._PG_HTML_FINISH_;
            $this->pageS['title'] = _PG_TITLE_RENEW_FINISH_;
            break;
        }
        break;

    }

    return ;
  }


  // *PAGE* ダウンロードページ
  function pageDownload(){

    $this->isDebug();
    $this->Manager->setName();
    $this->Manager->setDefault();
    $this->Manager->checkId();

    if( $this->Manager->errorS!="" ){
      $this->pageS['place'] = "error";
      $this->setPage();
      require_once(_PG_ROOT_HTML_._PG_HTML_ERROR_);
      exit;
   }else{
      require_once(_PG_ROOT_._PG_FILE_QUERY_);
      $Query = new Query();
      $this->pageS['place'] = "download";
      $this->setPage();
      $Query->setQueryUpdate($this->Manager);
    }

    return ;
  }

  // *PAGE* 入力ページ
  function pageWrite(){

    $this->isDebug();
    $this->Manager->setName();
    $this->Manager->setDefault();
    $this->Manager->checkTool();

    if( $this->Manager->errorS!="" ){
      $this->pageS['place'] = "error";
      $this->setPage();
    }else{
      $this->pageS['place'] = "write";
      $this->setPage();
      $this->Manager->setDefaultToInput();
      $this->Manager->setInputToWrite();
    }

    $this->Manager->setSessionPlace($this->pageS['place']);
    require_once(_PG_ROOT_._PG_FILE_VIEWER_);
    $Viewer = new Viewer($this->pageS,$this->Manager);
    $Viewer->showPage();

    return ;
  }


  // *PAGE* 完了/エラー入力ページ
  function pageConfirm(){

    require_once(_PG_ROOT_._PG_FILE_VIEWER_);

    $this->Manager->setName();
    $this->Manager->setDefault();
    $this->Manager->setPostToInput();
    $this->Manager->setInputToWrite();
    $this->Manager->checkInput($this->pageS['mode']);

    if( $this->Manager->errorS!="" ){
      $this->pageS['place'] = "write";
    }else{
      $this->pageS['place'] = "finish";

      if( $this->Manager->getSessionPlace()!='finish' ){
        $this->Manager->setSessionPlace($this->pageS['place']);
        $this->Manager->setName();
        $this->Manager->setDefault();
        $this->Manager->setPostToInput();

        $Viewer = new Viewer($this->pageS,$this->Manager);

        require_once(_PG_ROOT_._PG_FILE_QUERY_);
        $Query = new Query();

        require_once(_PG_ROOT_._PG_FILE_MAILER_);
        $Mailer = new Mailer();

        $this->Manager->setNewRegist();
        $Query->setQueryInsert($this->Manager);
        $Mailer->sendMail($this->Manager->inputS,$Viewer->setViewDataS($this->Manager->inputS),$this->Manager->nameS);

      }

    }
    $this->setPage();

    $this->isDebug();
    $this->Manager->setSessionPlace($this->pageS['place']);

    $Viewer = new Viewer($this->pageS,$this->Manager);
    $Viewer->showPage();

  }

}

?>
