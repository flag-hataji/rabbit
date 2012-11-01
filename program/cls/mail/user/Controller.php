<?PHP
/*
  物件管理：コントロール
*/
class Controller extends Html {

  var $pageS = "";

  function Controller(){

    if($this->isRequire(_PG_ROOT_._PG_FILE_MANAGER_)){
      require_once(_PG_ROOT_._PG_FILE_MANAGER_);
      require_once(_PG_ROOT_._PG_FILE_FILEUP_);
      $this->Manager = new Manager();
      $this->Fileup = new Fileup();
    }else{
      die("Error :"._PG_ROOT_._PG_FILE_CONTOROLLER_." on line ".__LINE__." "._PG_ROOT_._PG_FILE_MANAGER_." Require Error");
    }

    $this->pageS['place'] = $this->setPlace();
    $this->pageS['mode']  = $this->setMode();

    switch( $this->pageS['place'] ){

      case "write":
      case "rewrite":
        $this->pageWrite();
        break;

      case "test1":
      case "test2":
        $this->pageTest();
        break;

      case "confirm":
        $this->pageConfirm();
        break;

      case "finish":
      case "finish_renew":
        $this->pageFinish();
        break;

      case "delete":
        $this->pageDelete();
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
      case   "test1": 
      case   "test2": 
        $this->pageS['html']  = _PG_ROOT_HTML_._PG_HTML_WRITE_;
        $this->pageS['title'] = _PG_TITLE_WRITE_;
        break;
      case "confirm": 
        $this->pageS['html']  = _PG_ROOT_HTML_._PG_HTML_CONFIRM_;
        $this->pageS['title'] = _PG_TITLE_CONFIRM_;
        break;
      case "finish": 
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

    if($_SESSION['user']['flag_permission']==2){
      require_once(_PG_ROOT_HTML_._PG_HTML_STOP_);
    }

    $this->Manager->setName();
    $this->Manager->setDefault();
    switch( $this->pageS['place'] ){
      case "rewrite": 
        $this->Manager->setPostToInput(); 
        $this->Fileup->deleteFile(_PG_ROOT_CSV_,$_POST['uploadS']['file']);
        break;
      case   "write": $this->Manager->setDefaultToInput(); break;
    }

    $this->Manager->setInputToWrite();
    $this->Manager->setSessionPlace($this->pageS['place']);
    require_once(_PG_ROOT_._PG_FILE_VIEWER_);
    $Viewer = new Viewer($this->pageS,$this->Manager,$this->Fileup);
    $Viewer->showPage();
  }


  // *PAGE* 送信テスト/入力ページ
  function pageTest(){

    $this->pageS['place'] = "write";
    $this->setPage();
    $this->isDebug();

    $this->Manager->setSessionPlace($this->pageS['place']);
    $this->Manager->setName();
    $this->Manager->setDefault();
    $this->Manager->setPostToInput();
    $this->Manager->setInputToWrite();
    $this->Manager->checkInput();

    if( $this->Manager->errorS=="" ){
      require_once(_PG_ROOT_._PG_FILE_TESTER_);
      $Tester = new Tester($this->Manager);
    }

    require_once(_PG_ROOT_._PG_FILE_VIEWER_);
    $Viewer = new Viewer($this->pageS,$this->Manager,$this->Fileup);
    $Viewer->showPage();

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
    }else{
      $this->Manager->setTempFileName();
      $this->Fileup->upTemp($_FILES['file_mail'],_PG_ROOT_CSV_,$this->Manager->inputS['temp_file'],$this->Manager->inputS['mail_confirm']);
      if($this->Fileup->errorS!=""  || ($this->Fileup->dataErrorS!="" && $this->Manager->inputS['flag_omit']==2)  || ($this->Fileup->dataErrorS!="" && $this->Manager->inputS['flag_omit']==2)){
        $this->Manager->errorS = $this->Fileup->errorS;
        if($this->Fileup->dataErrorS!=""){
          $this->Manager->errorS = $this->Fileup->dataErrorS;
        }
        $this->pageS['place'] = "write";
      }
    }

    $this->setPage();
    $this->isDebug();
    $this->Manager->setSessionPlace($this->pageS['place']);

    require_once(_PG_ROOT_._PG_FILE_VIEWER_);
    $Viewer = new Viewer($this->pageS,$this->Manager,$this->Fileup);
    $Viewer->showPage();

  }


  // *PAGE* 完了ページ
  function pageFinish(){
    $this->setPage();
    $this->isDebug();

    require_once(_DIR_LIB_."db/Postgres.php");
    require_once(_DIR_LIB_."db/ExPostgres.php");
    $ExPostgres = new ExPostgres(_DB_NAME_,_DB_USER_,_DB_HOST_,_DB_PORT_);

    if( $this->Manager->getSessionPlace()!='finish' ){

      $this->Manager->setSessionPlace($this->pageS['place']);

      $this->Manager->setName();
      $this->Manager->setDefault();
      $this->Manager->setPostToInput();

/*ざっくりとメッセージ別ファイル化============================*/
      $rootMessageHtml = _PG_ROOT_DAT_._PG_DAT_MESSAGE_HTML_;
      $rootMessageHtml = str_replace("#date#",date('YmdHis'), $rootMessageHtml);
      $rootMessageHtml = str_replace("#user_id#",$this->Manager->inputS['user_id'], $rootMessageHtml);
      $mode = 'w';
      $fp=fopen($rootMessageHtml,$mode);
      fwrite($fp, $this->Manager->inputS['message_html']);
      flock($fp, LOCK_UN);
      fclose($fp);
      chmod ($rootMessageHtml, 0777); 

      $rootMessage = _PG_ROOT_DAT_._PG_DAT_MESSAGE_;
      $rootMessage = str_replace("#date#",date('YmdHis'), $rootMessage);
      $rootMessage = str_replace("#user_id#",$this->Manager->inputS['user_id'], $rootMessage);
      $mode = 'w';
      $fp=fopen($rootMessage,$mode);
      fwrite($fp, $this->Manager->inputS['message']);
      flock($fp, LOCK_UN);
      fclose($fp);
      chmod ($rootMessage, 0777); 
/*==========================================================*/

      require_once(_PG_ROOT_._PG_FILE_QUERY_);
      $Query = new Query();

      $this->Manager->setFinish();
      $query =  $Query->setQuery($this->Manager);

      $argv1  = urlencode( serialize( _ABSOLUTE_ ) );
      $argv2  = urlencode( serialize( _DIR_PROGRAM_ ) );
      $argv3  = urlencode( serialize( _DIR_LIB_ ) );
      $argv4  = urlencode( serialize( _DIR_COMMON_ ) );
      $argv5  = urlencode( serialize( _DIR_CLS_ ) );
      $argv6  = urlencode( serialize( _DIR_CLS_DEFINE_ ) );
      $argv7  = urlencode( serialize( _PG_ROOT_ ) );
      $argv8  = urlencode( serialize( _PG_ROOT_COMMON_ ) );
      $argv9  = urlencode( serialize( _PG_ROOT_CSV_ ) );
      $argv10 = urlencode( serialize( _PG_ROOT_MAIL_ ) );
      $argv11 = urlencode( serialize( $this->Manager->uploadS['file'] ) );
      $argv12 = urlencode( serialize( $this->Manager->inputS['name_from'] ) );
      $argv13 = urlencode( serialize( $this->Manager->inputS['mail_from'] ) );
      $argv14 = urlencode( serialize( $this->Manager->inputS['mail_error'] ) );
      $argv15 = urlencode( serialize( $this->Manager->inputS['subject'] ) );
      $argv17 = urlencode( serialize( $query['td_log'] ) );
      $argv18 = urlencode( serialize( $query['td_message'] ) );
      $argv19 = urlencode( serialize( $query['td_mailq'] ) );
      $argv20 = urlencode( serialize( $query['td_pictmail'] ) );
      $argv21 = urlencode( serialize( $this->Manager->inputS['mail_confirm'] ) );

      $argv22 = urlencode( serialize( $this->Manager->inputS['mail_start_pc'] ) );
      $argv23 = urlencode( serialize( $this->Manager->inputS['mail_start_mo'] ) );
      $argv24 = urlencode( serialize( $this->Manager->inputS['mail_finish_pc'] ) );
      $argv25 = urlencode( serialize( $this->Manager->inputS['mail_finish_mo'] ) );
      $argv26 = urlencode( serialize( $this->Manager->uploadS['flagS']['type'] ) );


      $argv27 = urlencode( serialize( $this->Manager->uploadS['numS']['ok'] ) );
      $argv28 = urlencode( serialize( $this->Manager->uploadS['numS']['pc'] ) );
      $argv29 = urlencode( serialize( $this->Manager->uploadS['numS']['mobile'] ) );

      $argv16 = urlencode( serialize( $rootMessage ) );
      $argv30 = urlencode( serialize( $rootMessageHtml ) );


//      echo exec( _PG_ROOT_._PG_FILE_SENDER_." $argv1 $argv2 $argv3 $argv4 $argv5 $argv6 $argv7 $argv8 $argv9 $argv10 $argv11 $argv12 $argv13 $argv14 $argv15 $argv16 $argv17 $argv18 $argv19 $argv20 $argv21 $argv22 $argv23 $argv24 $argv25 $argv26 $argv27 $argv28 $argv29 $argv30 > /dev/null &");
      $isCommand = "/usr/bin/php /var/www/vhosts/www.rabbit-mail.jp/html/program/cls/mail/user/Sender.php $argv1 $argv2 $argv3 $argv4 $argv5 $argv6 $argv7 $argv8 $argv9 $argv10 $argv11 $argv12 $argv13 $argv14 $argv15 $argv16 $argv17 $argv18 $argv19 $argv20 $argv21 $argv22 $argv23 $argv24 $argv25 $argv26 $argv27 $argv28 $argv29 $argv30";

     `$isCommand`;

    }

    require_once(_PG_ROOT_._PG_FILE_VIEWER_);
    $Viewer = new Viewer($this->pageS,$this->Manager,$this->Fileup);
    $Viewer->showPage();


  }


}

?>
