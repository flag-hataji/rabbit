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
  }

  // DB接続
  function dbConnect(){
    require_once(_DIR_LIB_."db/Postgres.php");
    require_once(_DIR_LIB_."db/ExPostgres.php");
    $ExPostgres = new ExPostgres(_DB_NAME_,_DB_USER_,_DB_HOST_,_DB_PORT_);
    return $ExPostgres;
  }


  // *Debug*
  function setDebug(){
    if(_DEBUG_){
      require_once(_DIR_LIB_.'debug/Debug.php');
      $this->Debug = new Debug();
      echo "Now Mode = {$this->pageS['place']}<br>\n";
      echo "RegistMode = {$this->pageS['mode']}<br>\n";
    }
    return;
  }


  // *CHECK* 存在
  function isRequire($path){
    return file_exists($path) ? True : False ;
  }


  // *SET* ページモード
  function setPageMode($mode=False){
    if( isset($_POST['mode']) ){
      $mode = $_POST['mode'];
    }else if( isset($_GET['mode']) ){
      $mode = $_GET['mode'];
    }else{
      $mode = "renew";
    }
    $this->pageS['mode'] = $mode;
    return ;
  }


  // *SET* ページ現在地
  function setPagePlace($place=False){
    if( isset($_POST['post']) ){
      $place = @key($_POST['post']);
    }else if( isset($_GET['get']) ){
      $place = $_GET['get'];
    }else if( isset($_POST['hidden']) ){
      $place = $_POST['hidden'];
    }else{
      $place = "list";
    }
    $this->pageS['place'] = $place;
    return ;
  }


  // *SET* ページデータ
  function setPageData(){

    switch( $this->pageS['mode'] ){
      // 新規登録
      case "new": 
        $this->pageS['html']  = _PG_ROOT_HTML_NEW_;
        $this->pageS['title'] = _PG_TITLE_NEW_;
        break;
      // 修正・削除
      case "renew": 
        $this->pageS['html']  = _PG_ROOT_HTML_RENEW_;
        $this->pageS['title'] = _PG_TITLE_RENEW_;
        break;
    }

    switch( $this->pageS['place'] ){
      case "seek": 
        $this->pageS['html']  .= _PG_HTML_SEEK_;
        $this->pageS['title'] .= _PG_TITLE_SEEK_;
        break;
      case   "list":
      case   "delete":
      case   "cancel_pc":
      case   "cancel_mobile":
        $this->pageS['html']  .= _PG_HTML_LIST_;
        $this->pageS['title'] .= _PG_TITLE_LIST_;
        break;
      case   "detail":
        $this->pageS['html']  .= _PG_HTML_DETAIL_;
        $this->pageS['title'] .= _PG_TITLE_DETAIL_;
        break;
      case   "write":
      case "rewrite": 
        $this->pageS['html']  .= _PG_HTML_WRITE_;
        $this->pageS['title'] .= _PG_TITLE_WRITE_;
        break;
      case "confirm": 
        $this->pageS['html']  .= _PG_HTML_CONFIRM_;
        $this->pageS['title'] .= _PG_TITLE_CONFIRM_;
        break;
      case "finish": 
        $this->pageS['html']  .= _PG_HTML_FINISH_;
        $this->pageS['title'] .= _PG_TITLE_FINISH_;
        break;
    }

    return ;
  }


  // *Control*
  function setControl(){
    $this->setPagePlace();
    $this->setPageMode();
    switch( $this->pageS['place'] ){
      case "seek":
        $this->pageSeek();
        break;
      case "list":
        $this->pageList();
        break;
      case "cancel_pc":
        $this->pageCancelPc();
        break;
      case "cancel_mobile":
        $this->pageCancelMobile();
        break;
      case "detail":
        $this->pageDetail();
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
      case "delete":
        $this->pageDelete();
        break;
      default:
        die("Error :"._PG_ROOT_._PG_FILE_CONTOROLLER_." on line ".__LINE__." Place is [{$this->pageS['place']}] UNKNOWN ");
    }
    return;
  }


  // *PAGE* 検索ページ
  function pageSeek(){
    $this->setPageData();
    $this->setDebug();
    $this->Manager->setSessionPageNum();
    $this->Manager->setSessionSeekFormat();
    $this->Manager->setName();
    require_once(_PG_ROOT_._PG_FILE_VIEWER_);
    $Viewer = new Viewer($this->pageS,$this->Manager);
    $Viewer->showPage();
    return;
  }


  // *PAGE* リストページ
  function pageList(){
    $this->setPageData();
    $this->setDebug();
    $this->Manager->setSessionPageNum();
    $this->Manager->setSessionSeek($this->pageS);
    $this->Manager->setName();
    require_once(_PG_ROOT_._PG_FILE_VIEWER_);
    $Viewer = new Viewer($this->pageS,$this->Manager);
    $Viewer->showPage();
    return;
  }


  // *PAGE* PCキャンセル/リストページ
  function pageCancelPc(){
    $this->setPageData();
    $this->setDebug();

    $ExPostgres = $this->dbConnect();
    $query  = "DELETE FROM td_mailq WHERE message_id={$_GET['message_id']} AND flag_pc='t' ";
    $ExPostgres->registQuery($query);
    $query  = "UPDATE td_log SET flag_pc=3 WHERE log_id={$_GET['log_id']} ";
    $ExPostgres->registQuery($query);
    $query  = "UPDATE td_pictmail SET send_now=send_now+{$_GET['send_count_pc']} WHERE user_id={$_SESSION['user']['user_id']} ";
    $ExPostgres->registQuery($query);
    $ExPostgres->close();

    $this->Manager->setSessionPageNum();
    $this->Manager->setSessionSeek($this->pageS);
    $this->Manager->setName();
    require_once(_PG_ROOT_._PG_FILE_VIEWER_);
    $Viewer = new Viewer($this->pageS,$this->Manager);
    $Viewer->showPage();
    return;
  }


  // *PAGE* 携帯キャンセル/リストページ
  function pageCancelMobile(){
    $this->setPageData();
    $this->setDebug();

    $ExPostgres = $this->dbConnect();
    $query  = "DELETE FROM td_mailq WHERE message_id={$_GET['message_id']} AND flag_pc='f' ";
    $ExPostgres->registQuery($query);
    $query  = "UPDATE td_log SET flag_mobile=3 WHERE log_id={$_GET['log_id']} ";
    $ExPostgres->registQuery($query);
    $query  = "UPDATE td_pictmail SET send_now=send_now+{$_GET['send_count_mobile']} WHERE user_id={$_SESSION['user']['user_id']} ";
    $ExPostgres->registQuery($query);

    $ExPostgres->close();

    $this->Manager->setSessionPageNum();
    $this->Manager->setSessionSeek($this->pageS);
    $this->Manager->setName();
    require_once(_PG_ROOT_._PG_FILE_VIEWER_);
    $Viewer = new Viewer($this->pageS,$this->Manager);
    $Viewer->showPage();
    return;
  }



  // *PAGE* 詳細ページ
  function pageDetail(){
    $this->setPageData();
    $this->setDebug();
    $this->Manager->setSessionPageNum();
    $this->Manager->setSessionSeek($this->pageS);
    $this->Manager->setName();
    require_once(_PG_ROOT_._PG_FILE_VIEWER_);
    $Viewer = new Viewer($this->pageS,$this->Manager);
    $Viewer->showPage();
    return;
  }


  // *PAGE* 削除/リストページ
  function pageDelete(){
    $this->setPageData();
    $this->setDebug();
    $this->Manager->setSessionPageNum();
    $this->Manager->setSessionSeek($this->pageS);
    $this->Manager->setName();
    if(is_numeric($_GET['log_id'])){
      require_once(_PG_ROOT_._PG_FILE_QUERY_);
      $Query = new Query();
      $Query->setQueryDelete($_GET['log_id']);
    }
    require_once(_PG_ROOT_._PG_FILE_VIEWER_);
    $Viewer = new Viewer($this->pageS,$this->Manager);
    $Viewer->showPage();
    return;
  }



  // *PAGE* 入力ページ
  function pageWrite(){
    $this->setPageData();
    $this->setDebug();
    $this->Manager->setName();
    $this->Manager->setDefault();
    switch( $this->pageS['place'] ){
      case "rewrite": 
        $this->Manager->setPostToInput(); 
        break;
      case "write":
        switch( $this->pageS['mode'] ){
          case "new":   
            $this->Manager->setDefaultToInput(); 
            break;
          case "renew": 
            $this->Manager->setDbToInput(); 
            break;
        }
        break;
    }
    $this->Manager->setInputToWrite();
    $this->Manager->setSessionPlace($this->pageS['place']);
    require_once(_PG_ROOT_._PG_FILE_VIEWER_);
    $Viewer = new Viewer($this->pageS,$this->Manager);
    $Viewer->showPage();
    return;
  }

  // *PAGE* 確認/エラー入力ページ
  function pageConfirm(){

    $this->Manager->setName();
    $this->Manager->setDefault();
    $this->Manager->setPostToInput();
    $this->Manager->setInputToWrite();
    $this->Manager->checkInput();

    if( $this->Manager->errorS!="" ){
      $this->pageS['place'] = "write";
    }
    $this->setPageData();


    $this->setDebug();
    $this->Manager->setSessionPlace($this->pageS['place']);

    require_once(_PG_ROOT_._PG_FILE_VIEWER_);
    $Viewer = new Viewer($this->pageS,$this->Manager);
    $Viewer->showPage();
    return;
  }


  // *PAGE* 完了ページ
  function pageFinish(){

    $this->setPageData();
    $this->setDebug();
//    if( $this->Manager->getSessionPlace()!='finish' ){
      $this->Manager->setSessionPlace($this->pageS['place']);
      $this->Manager->setName();
      $this->Manager->setDefault();
      $this->Manager->setPostToInput();

      require_once(_PG_ROOT_._PG_FILE_QUERY_);
      $Query = new Query();

      if($this->pageS['mode']=='new'){
        $this->Manager->setSequenceId();
        $Query->setQueryInsert($this->Manager);
      }else{
        $Query->setQueryUpdate($this->Manager,$this->pageS['place']);
      }
//    }

    require_once(_PG_ROOT_._PG_FILE_VIEWER_);
    $Viewer = new Viewer($this->pageS,$this->Manager);
    $Viewer->showPage();
    return;
  }

}

?>
