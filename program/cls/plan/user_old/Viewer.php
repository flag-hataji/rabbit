<?PHP
/*
  物件管理：表示・出力
*/
class Viewer extends Html {

  var $pageS   = "";
  var $cDataS = "";

  function Viewer($pageS=False,$cDataS=False){
    $this->pageS   = $pageS;
    $this->cDataS = $cDataS;
    require_once( _DIR_LIB_."ex/ViewerLib.php" );
    require_once( _DIR_LIB_."ex/Library.php" );
    $this->ViewerLib = new ViewerLib();
    $this->Library   = new Library();
  }

  // DB接続
  function dbConnect(){
    require_once(_DIR_LIB_."db/Postgres.php");
    require_once(_DIR_LIB_."db/ExPostgres.php");
    $ExPostgres = new ExPostgres(_DB_NAME_,_DB_USER_,_DB_HOST_,_DB_PORT_);
    return $ExPostgres;
  }

  // *表示* ページ
  function showPage(){
    require_once($this->pageS['html']);
  }




  // 表示 - プランリスト
  function showListPlan(){

    require_once(_DIR_LIB_."daytime/Daytime.php");
    $Daytime  = new Daytime();

    $qS = $this->queryListPlan();

    $query = $qS['base'].$qS['join'].$qS['where'].$qS['groupby'].$qS['orderby'].$qS['limit'];

    $ExPostgres = $this->dbConnect();
    $ExPostgres->executeQuery($query);

    $count = $ExPostgres->getRow();
    if( $count!=0 ){
      $formatHtml = file_get_contents(_PG_ROOT_HTML_._PG_HTML_LIST_IN_);
      $i=0;
      while($ExPostgres->getRow()-1>=$i){
        $dataS = "";
        $dataS = pg_fetch_assoc( $ExPostgres->getResult(),$i );

        $dataS = $this->setViewDataS($dataS);

        if( isset($_POST['inputS']['plan_id']) && $_POST['inputS']['plan_id']==$dataS['plan_id']){ 
          $checked = "checked"; 
        }else{
          $checked = ""; 
        }

        $htmlList = $formatHtml;
        $htmlList = str_replace("#plan#",         $dataS['plan'],$htmlList);
        $htmlList = str_replace("#checked#",      $checked,$htmlList);
        $htmlList = str_replace("#plan_id#",      $dataS['plan_id'],$htmlList);
        $htmlList = str_replace("#send_max#",     $dataS['send_max'],$htmlList);
        $htmlList = str_replace("#price_first#",  $dataS['price_first'],$htmlList);
        $htmlList = str_replace("#price_month#",  $dataS['price_month'],$htmlList);
        $htmlList = str_replace("#price_month6#", $dataS['price_month6'],$htmlList);
        $htmlList = str_replace("#comment#",      $dataS['comment'],$htmlList);

        echo $htmlList;

        $i++;
      }
    }

    pg_free_result( $ExPostgres->getResult() );
    $ExPostgres->close();

    return $dataS;
  }



  // 表示 確認用
  function getViewDataSConfirm(){

    $qS = $this->queryDetailPlan();
    $query = $qS['base'].$qS['where'];
    $ExPostgres = $this->dbConnect();
    $ExPostgres->executeQuery($query);
    $dataS = pg_fetch_assoc( $ExPostgres->getResult(),0 );
    pg_free_result( $ExPostgres->getResult() );
    $ExPostgres->close();
    $dataS = $this->setViewDataS($dataS);
    return $dataS;
  }


  // 表示用データ
  function setViewDataS($dataS=False){

    foreach($dataS as $key=>$val ){
      $dataS[$key] = $this->getHtml($val);
    }

    $dataS['org']['price_first']  =floor($dataS['price_first']*1.05);

    $dataS['org']['price_total'] = (floor($dataS['price_first']*1.05)+floor($dataS['price_month6']*1.05));
    $dataS['org']['price_month']  =floor($dataS['price_month']*1.05);
    $dataS['org']['price_month6'] =floor($dataS['price_month6']*1.05);
    $dataS['org']['send_max']     =$dataS['send_max'];

    $dataS['price_total'] = number_format(floor($dataS['price_first']*1.05)+floor($dataS['price_month6']*1.05))."円";
    $dataS['price_first']  = number_format($dataS['org']['price_first'])."円";
    $dataS['price_month']  = number_format(floor($dataS['price_month']*1.05))."円";
    $dataS['price_month6'] = number_format(floor($dataS['price_month6']*1.05))."円";
    $dataS['send_max']     = number_format($dataS['send_max'])."件";

    if(isset($this->cDataS->inputS['auto_money']) && $this->cDataS->inputS['auto_money']==1){
      $dataS['auto_money']="する";
    }else if(isset($this->cDataS->inputS['auto_money']) && $this->cDataS->inputS['auto_money']==2){
      $dataS['auto_money']="しない";
    }

    if(isset($this->cDataS->inputS['pay']) && $this->cDataS->inputS['pay']==1){
      $dataS['pay']="クレジットカード";
    }else if(isset($this->cDataS->inputS['pay']) && $this->cDataS->inputS['pay']==2){
      $dataS['pay']="銀行振り込み";
    }

    return $dataS;
  }



  // クエリー プランリスト
  function queryDetailPlan(){

    $column  = "";
    $qS = "";

    $qS['base']    = "";
    $qS['where']   = "";

    $column .= "tmain.plan_id,";
    $column .= "tmain.plan,";
    if($_SESSION['user']['plan_pictmail_id']!=1 && $_SESSION['user']['plan_pictmail_id']!=7 ){
      $column .= "price_first=0,";
    }else{
      $column .= "tmain.price_first,";
    }
    $column .= "tmain.price_month,";
    $column .= "tmain.price_month6,";
    $column .= "tmain.send_max,";
    $column .= "tmain.comment,";
    $column  = substr($column,0,-1);

    $qS['base']    .= "SELECT {$column} FROM tm_plan AS tmain ";
    $qS['where']   .= " WHERE tmain.plan_id={$this->cDataS->inputS['plan_id']} ";

    return $qS;
  }


  // クエリー プランリスト
  function queryListPlan(){

    $column  = "";
    $qS = "";

    $qS['base']    = "";
    $qS['join']    = "";
    $qS['where']   = "";
    $qS['orderby'] = "";
    $qS['groupby'] = "";
    $qS['limit']   = "";

    $column .= "tmain.plan_id,";
    $column .= "tmain.plan,";
    if($_SESSION['user']['plan_pictmail_id']!=1 && $_SESSION['user']['plan_pictmail_id']!=7 ){
      $column .= "price_first=0,";
    }else{
      $column .= "tmain.price_first,";
    }
    $column .= "tmain.price_month,";
    $column .= "tmain.price_month6,";
    $column .= "tmain.send_max,";
    $column .= "tmain.comment,";
    $column .= "tmain.sort,";
    $column = substr($column,0,-1);


    $qS['base']    .= "SELECT {$column} FROM tm_plan AS tmain ";

    $qS['where']   .= " WHERE tmain.flag_open=1 ";
    $qS['where']   .= " AND (tmain.plan_id!=1)";
//    $qS['where']   .= " AND (tmain.plan_id!={$_SESSION['user']['plan_pictmail_id']} OR tmain.plan_id=7)";
    $qS['orderby'] .= "ORDER BY tmain.sort ";
    $qS['groupby'] .= "GROUP BY {$column} ";



    return $qS;
  }




}
?>
