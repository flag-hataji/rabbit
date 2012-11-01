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
      case "seek":
        $this->pageSeek();
        break;

      case "list":
        $this->pageList();
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

      case "permission":
        $this->pagePermission();
        break;

      case "cc":
        $this->pageCc();
        break;

      case "stepmail":
        $this->pageStepmail();
        break;


      case "delete":
        $this->pageDelete();
        break;


      case "all":
        $this->pageAllMake();
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
      if( isset($_POST['post']) ){
        $place = @key($_POST['post']);
      }else if( isset($_GET['get']) ){
        $place = $_GET['get'];
      }else if( isset($_POST['hidden']) ){
        $place = $_POST['hidden'];
      }else{
        $place = "list";
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
          case "seek": 
            $this->pageS['html']  = _PG_ROOT_HTML_._PG_HTML_RENEW_SEEK_;
            $this->pageS['title'] = _PG_TITLE_RENEW_SEEK_;
            break;
          case   "list":
          case   "delete":
          case   "permission":
          case   "cc":
          case   "stepmail":
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


  // *PAGE* 検索ページ
  function pageSeek(){
    $this->setPage();
    $this->isDebug();
    $this->Manager->setSessionPageNum();
    $this->Manager->setSessionSeekFormat();
    $this->Manager->setName();
    require_once(_PG_ROOT_._PG_FILE_VIEWER_);
    $Viewer = new Viewer($this->pageS,$this->Manager);
    $Viewer->showPage();
  }


  // *PAGE* リストページ
  function pageList(){
    $this->setPage();
    $this->isDebug();
    $this->Manager->setSessionPageNum();
    $this->Manager->setSessionSeek($this->pageS);
    $this->Manager->setName();
    require_once(_PG_ROOT_._PG_FILE_VIEWER_);
    $Viewer = new Viewer($this->pageS,$this->Manager);
    $Viewer->showPage();
  }


  // *PAGE* 入力ページ
  function pageWrite(){
    $this->setPage();
    $this->isDebug();
    $this->Manager->setName();
    $this->Manager->setDefault();
    switch( $this->pageS['place'] ){
      case "rewrite": $this->Manager->setPostToInput(); break;
      case "write":
        switch( $this->pageS['mode'] ){
          case "new":   $this->Manager->setDefaultToInput(); break;
          case "renew": $this->Manager->setDbToInput(); break;
        }
        break;
    }
    $this->Manager->setInputToWrite();
    $this->Manager->setSessionPlace($this->pageS['place']);
    require_once(_PG_ROOT_._PG_FILE_VIEWER_);
    $Viewer = new Viewer($this->pageS,$this->Manager);
    $Viewer->showPage();
  }

  // *PAGE* 確認/エラー入力ページ
  function pageConfirm(){

    $this->Manager->setName();
    $this->Manager->setDefault();
    $this->Manager->setPostToInput();
    $this->Manager->setInputToWrite();
    $this->Manager->checkInput($this->pageS['mode']);

    if( $this->Manager->errorS!="" ){
      $this->pageS['place'] = "write";
    }
    $this->setPage();


    $this->isDebug();
    $this->Manager->setSessionPlace($this->pageS['place']);

    require_once(_PG_ROOT_._PG_FILE_VIEWER_);
    $Viewer = new Viewer($this->pageS,$this->Manager);
    $Viewer->showPage();

  }


  // *PAGE* 完了ページ
  function pageFinish(){

    $this->setPage();
    $this->isDebug();

    require_once(_PG_ROOT_._PG_FILE_VIEWER_);
    $Viewer = new Viewer($this->pageS,$this->Manager);

//    if( $this->Manager->getSessionPlace()!='finish' ){
      $this->Manager->setSessionPlace($this->pageS['place']);
      $this->Manager->setName();
      $this->Manager->setDefault();
      $this->Manager->setPostToInput();

      require_once(_PG_ROOT_._PG_FILE_QUERY_);
      $Query = new Query();


      if($this->pageS['mode']=='new'){
        $this->Manager->setNewRegist();
        $Query->setQueryInsert($this->Manager);

      }else{
        $Query->setQueryUpdate($this->Manager);
      }

//    }

    $Viewer = new Viewer($this->pageS,$this->Manager);

    $Viewer->showPage();
  }


  // *PAGE* 削除/リストページ
  function pageDelete(){
    $this->setPage();
    $this->isDebug();
    $this->Manager->setSessionPageNum();
    $this->Manager->setSessionSeek($this->pageS);
    $this->Manager->setName();
    if(is_numeric($_GET['user_id'])){
      require_once(_PG_ROOT_._PG_FILE_QUERY_);
      $Query = new Query();
      $Query->setQueryDelete($_GET['user_id']);
    }
    require_once(_PG_ROOT_._PG_FILE_VIEWER_);
    $Viewer = new Viewer($this->pageS,$this->Manager);
    $Viewer->showPage();
  }



  // *PAGE* 許可･不許可/リストページ
  function pagePermission(){
    $this->setPage();
    $this->isDebug();
    $this->Manager->setSessionPageNum();
    $this->Manager->setSessionSeek($this->pageS);
    $this->Manager->setName();
    if(is_numeric($_GET['user_id']) && is_numeric($_GET['flag_permission'])){
      require_once(_PG_ROOT_._PG_FILE_QUERY_);
      $Query = new Query();
      $Query->setQueryPermission($_GET['user_id'],$_GET['flag_permission']);
    }
    require_once(_PG_ROOT_._PG_FILE_VIEWER_);
    $Viewer = new Viewer($this->pageS,$this->Manager);
    $Viewer->showPage();
  }



}

?>
