<?PHP


new Main();


class Main {


    function Main(){

        define('_HTTPS_COERCION_', false);
        define('_DEBUG_',  false );
        define('_TEST_',   false );
        define('_MASTER_', false );


        define('_SESSION_MODE_', 'user' );
        define('_SESSION_NAME_', 'plan' );

        // - Load & Setup[Common]
        require_once('../../../program/cls/define/Setup.php');

        // - SetUp[Local]
        define('_PG_ROOT_',        _DIR_CLS_."plan/user/");
        define('_PG_ROOT_COMMON_', _DIR_CLS_."plan/common/");
        define('_PG_ROOT_THIS_',   _ABSOLUTE_."member/pictmail/plan/");
        define('_PG_ROOT_HTML_',   _PG_ROOT_);
        define('_PG_ROOT_MAIL_',   _PG_ROOT_."mail/");
        define('_PG_URL_',         _URL_."member/pictmail/plan/");
        define('_PG_URL_TOP_',     _PG_URL_."change.php");

        define('_PG_URL_CHANGE_', _PG_URL_."change.php");


        define('_PG_FILE_MAIN_',        "Main.php");
        define('_PG_FILE_CONTOROLLER_', "Controller.php");
        define('_PG_FILE_MANAGER_',     "Manager.php");
        define('_PG_FILE_VIEWER_',      "Viewer.php");
        define('_PG_FILE_LIBRARY_',     "Library.php");
        define('_PG_FILE_QUERY_',       "Query.php");
        define('_PG_FILE_MAILER_',      "Mailer.php");

       
        define('_PG_HTML_WRITE_',    "pg_write.html");
        define('_PG_HTML_LIST_IN_',  "pg_list_in.html");
        define('_PG_HTML_CONFIRM_',  "pg_confirm.html");
        define('_PG_HTML_FINISH_',   "pg_finish.html");
        define('_PG_HTML_DETAIL_',   "pg_detail.html");

        define('_PG_TITLE_',          "プラン変更：");
        define('_PG_TITLE_WRITE_',    _PG_TITLE_." 入力");
        define('_PG_TITLE_CONFIRM_',  _PG_TITLE_." 入力確認");
        define('_PG_TITLE_FINISH_',   _PG_TITLE_." 入力完了");

        define('_PG_FILE_MAIL_USER_NEW1_',   "userNew1.txt");
        define('_PG_FILE_MAIL_USER_NEW2_',   "userNew2.txt");
        define('_PG_FILE_MAIL_USER_NEW3_',   "userNew3.txt");
        define('_PG_FILE_MAIL_USER_RENEW_',  "userRenew.txt");
        define('_PG_FILE_MAIL_MASTER_NEW_',  "masterNew.txt");


        $this->run();


    }


    function run(){

        require_once(_DIR_LIB_."db/Postgres.php");
        require_once(_DIR_LIB_."db/ExPostgres.php");
        $ExPostgres = new ExPostgres(_DB_NAME_,_DB_USER_,_DB_HOST_,_DB_PORT_);

        $this->setPosition();
        $this->setPageData();
        $this->showPage();

        if( _DEBUG_ ){
            require_once(_DIR_LIB_.'debug/Debug.php');
            $libDebug = new Debug();
            $libDebug->arrayView($_SESSION[_SESSION_MODE_][_SESSION_NAME_],'$_SESSION[\''._SESSION_MODE_.'\'][\''._SESSION_NAME_.'\']',_DEBUG_);
            $libDebug->arrayView($_POST,'$_POST',_DEBUG_);
            $libDebug->arrayView($_GET, '$_GET',_DEBUG_);
            $libDebug->defineView(_DEBUG_);
        }

        return ;
    }


    function setController(){

        $isPosition = $this->_pageS['position'];
        $isHtml     = $this->_pageS['html'];
        $isTitle    = $this->_pageS['title'];

        require_once(_PG_ROOT_HTML_.$isHtml);

        return ;
    }


    function showPage(){

        require_once(_DIR_LIB_.'util/Util.php') ;
        require_once(_DIR_LIB_.'util/Html.php') ;
        require_once(_DIR_LIB_.'util/ExHtml.php') ;

        $isDataS    = $this->dataS;
        $isViewS    = $this->viewS;
        $isPlanS    = $this->planS;
        $isCardS    = $this->cardS;
        $isA8S      = $this->A8S;

        $isPosition = $this->_pageS['position'];
        $isHtml     = $this->_pageS['html'];
        $isTitle    = $this->_pageS['title'];

        require_once(_PG_ROOT_HTML_.$isHtml);

        return ;
    }



    function showPlan($format=""){


        $isPlanDataS = $this->planS;

        $isFormatBase = $format;

        $isPlanDataS['price_month6'] = number_format(floor($isPlanDataS['price_month6']*1.05));
        $isPlanDataS['price_month']  = number_format(floor($isPlanDataS['price_month']*1.05));


        if($isPlanDataS['flag_type']==1 && $_SESSION['user']['flag_type']==1){
            $isPlanDataS['price_first']  = 0;
        }else{
            $isPlanDataS['price_first']  = number_format(floor($isPlanDataS['price_first']*1.05));
        }


        $str1 = $isPlanDataS['plan'];
        $str2 = $isPlanDataS['send_max']."件";
        $str3 = $isPlanDataS['price_month6']."円（月：".$isPlanDataS['price_month']."円）";
        $str4 = $isPlanDataS['price_first']."円";


        $isFormatBase = str_replace("#str1#",$str1,$isFormatBase);
        $isFormatBase = str_replace("#str2#",$str2,$isFormatBase);
        $isFormatBase = str_replace("#str3#",$str3,$isFormatBase);
        $isFormatBase = str_replace("#str4#",$str4,$isFormatBase);


        echo $isFormatBase;

        return ;
    }


    function setPosition(){

        if(isset($_POST['position']) && $_POST['position']!=""){
            $position = key($_POST['position']);
        }else{
            $position = "write";
        }

        $this->_pageS['position'] = $position;

        return ;
    }


    function setPageData(){

        $isPosition = $this->_pageS['position'];

        switch($isPosition){
            case "write":
                $isHtml  = _PG_HTML_WRITE_;
                $isTitle = _PG_TITLE_WRITE_;
                $this->setPageWrite();
                break;
            case "rewrite":
                $isHtml  = _PG_HTML_WRITE_;
                $isTitle = _PG_TITLE_WRITE_;
                $this->setPageRewrite();
                break;
            case "confirm":
                $isHtml  = _PG_HTML_CONFIRM_;
                $isTitle = _PG_TITLE_CONFIRM_;
                $this->setPageConfirm();
                break;
            case "finish":
                $isHtml  = _PG_HTML_FINISH_;
                $isTitle = _PG_TITLE_FINISH_;
                $this->setPageFinish();
                break;
        }

        $this->_pageS['position'] = $isPosition;
        $this->_pageS['html']     = $isHtml;
        $this->_pageS['title']    = $isTitle;

        return ;
    }


    function setPageWrite(){

        $this->setDataWrite();
        $this->setDataPlan();

        return ;
    }


    function setPageRewrite(){

        $this->setDataConfirm();
        $this->setDataPlan();

        return ;
    }


    function setPageConfirm(){

        $this->setDataConfirm();
        $this->setDataPlan();
        $this->setDataView();
        $this->setDataCard();
        

        return ;
    }


    function setPageFinish(){

        $this->setDataConfirm();
        $this->setDataPlan();
        $this->setDataView();
        $this->setDataA8();

        $this->setDataA8();


        require_once(_PG_ROOT_._PG_FILE_MAILER_);

        $__Mailer = new Mailer();

        $__Mailer->sendMailFinish($this);

        return ;
    }


    function setDataWrite(){

        $isDataS = "";

        $isDataS['user_id'] = $_SESSION['user']['user_id'];
        $isDataS['plan_id'] = "";
        if(isset($_GET['plan_id']) && $_GET['plan_id']!=""){
           $isDataS['plan_id'] = $_GET['plan_id'];
        }
        $isDataS['flag_pay']        = 2;
        $isDataS['flag_automoney']  = 2;

        $this->dataS = $isDataS;

        return;
    }


    function setDataConfirm(){

        $isDataS = "";
        if(isset($_POST['inputS']) && $_POST['inputS']!=""){
            $isDataS = $_POST['inputS'];
        }

        $this->dataS = $isDataS;

        return;
    }


    function setDataView(){

        $isDataS = $this->dataS;


        switch($isDataS['flag_pay']){
            case 1:
                $isViewDataS['flag_pay'] = "クレジットカード決済";
                break;
            case 2:
                $isViewDataS['flag_pay'] = "銀行振り込み";
                break;
        }


        switch($isDataS['flag_automoney']){
            case 1:
                $isViewDataS['flag_automoney'] = "希望する";
                break;
            case 2:
                $isViewDataS['flag_automoney'] = "希望しない";
                break;
        }

        $this->viewS = $isViewDataS;

        return;
    }


    function setDataCard(){

        $isDataS = $this->dataS;
        $isPlanDataS = $this->planS;

        if( date('d')<=10 ){
          $year  = date('Y');
          $month = date('m');
        }else{
          if( date('m')==12 ){
            $year  = date('Y')+1;
            $month = 1;
          }else{
            $year  = date('Y');
            $month = sprintf("%02d",date('m')+1);
          }
        }
        $time = strtotime( $year."-".$month."-01" );


        $day_service_end = date( "Y年m月", mktime(0,0,0,date("m",$time)+5,date("d",$time),date("Y",$time)) );

        switch ($isPlanDataS['flag_type']) {

            case 2:
                $day_service_end = "無期限（配信メール件数がゼロになるまで）";
                break;

        }

        $isCardS['_SGPid'] = "itmasp";
        $isCardS['_price'] = $isPlanDataS['price_total'];
        $isCardS['_mail']  = $_SESSION['user']['mail'];
        $isCardS['_opt1']  = $isPlanDataS['plan'];
        $isCardS['_opt2']  = $isDataS['user_id'];
        $isCardS['_opt3']  = $_SESSION['user']['name_family']." ".$_SESSION['user']['name_first'];
        $isCardS['_opt4']  = $isDataS['plan_id'];
        $isCardS['_opt5']  = "/member/pictmail/plan/finish.php";
        $isCardS['_opt6']  = $day_service_end;

        $this->cardS = $isCardS;

        return;
    }


    function setDataPlan(){



        $isDataS = $this->dataS;

        $isQuery = "SELECT * FROM tm_plan WHERE plan_id=".$isDataS['plan_id'];


        $isResult = pg_query($isQuery);

        $isPlanDataS = pg_fetch_assoc($isResult,0);

        if($isPlanDataS['flag_type']==1 && $_SESSION['user']['flag_type']==1){
            $isPlanDataS['price_total'] = (floor($isPlanDataS['price_month6']*1.05));
        }else{
            $isPlanDataS['price_total'] = (floor($isPlanDataS['price_first']*1.05)+floor($isPlanDataS['price_month6']*1.05));
        }


/*
        if($isPlanDataS['flag_type']==2){
            $isPlanDataS['price_total'] = (floor($isPlanDataS['price_first']*1.05));

        }elseif($_SESSION['user']['flag_type']==1 && $_SESSION['user']['plan_pictmail_id']==1){
            $isPlanDataS['price_total'] = (floor($isPlanDataS['price_first']*1.05)+floor($isPlanDataS['price_month6']*1.05));

        }elseif($_SESSION['user']['flag_type']==1){
            $isPlanDataS['price_total'] = (floor($isPlanDataS['price_month6']*1.05));

        }elseif($_SESSION['user']['flag_type']==2){
            $isPlanDataS['price_total'] = (floor($isPlanDataS['price_first']*1.05)+floor($isPlanDataS['price_month6']*1.05));

        }else{
            $isPlanDataS['price_total'] = floor($isPlanDataS['price_first']*1.05);

        }
*/

        $this->planS = $isPlanDataS;

        return ;
    }


    function setDataA8(){



        $isDataS = $this->dataS;
        $isPlanS = $this->planS;



        $a8Margin = (($isPlanS['price_month6']+$isPlanS['price_first'])*0.1);
        $a8Date   = date('YmdHis');

        $a8so     = $isDataS['user_id'];
        $a8Url    =  "https://px.a8.net/cgi-bin/a8fly/sales?pid=s00000001947003&so=".$a8so."&si=".$a8Margin.".1.".$a8Margin.".".$dataS['plan_id']."&ts=".$a8Date;
        $a8Tag = "IMG SRC=\"".$a8Url."\" width=\"1\" height=\"1\"";

        $this->A8S['tag'] = $a8Tag;

        return ;
    }

/*
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
*/


}
?>
