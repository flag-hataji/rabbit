<?PHP
/*
  物件管理：表示・出力
*/
class Viewer extends Html {

  var $pageS   = "";
  var $Manager = "";

  function Viewer($pageS=False,$Manager=False){
    $this->pageS   = $pageS;
    $this->Manager = $Manager;
    $this->page    = $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['page'];
    $this->pageMax = _LIST_NUM1_;
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



  // *設定* 現在のページ数
  function setNowPage($query=False){

    $ExPostgres = $this->dbConnect();
    $ExPostgres->executeQuery($query);
    $countS = pg_fetch_assoc( $ExPostgres->getResult(),0 );
    pg_free_result( $ExPostgres->getResult() );
    $ExPostgres->close();

    $this->totalCount = $countS['count'];
    $this->pageTotal  = floor($this->totalCount/$this->pageMax);
    $this->remainder  = $this->totalCount-($this->pageTotal*$this->pageMax);
    if( $this->remainder!=0 ){
      ++$this->pageTotal;
    }
    $this->nowMin = ((($this->page-1)*$this->pageMax)+1);
    $this->nowMax = $this->pageMax;

    if( $this->page!=$this->pageTotal  ){
      $this->nowMax = $this->page*$this->pageMax;
    }else if( $this->page==$this->pageTotal  ){
      $this->nowMax = $this->totalCount;
    }

    return;
  }


  // 表示 - Hidden
  function showHidden(){

    switch($this->pageS['place']){
      case 'confirm' : 
        if( $this->Manager->writeS!="" ){
          foreach($this->Manager->writeS as $key=>$value){
            echo "<input type='hidden' name='inputS[{$key}]' value='{$value}'>\n";
            if(_DEBUG_){
              echo "&lt; input type='hidden' name='inputS[{$key}]' value='{$value}'&gt;<br>\n";
            }
          }
        }
        break;
      case 'rewrite' : 
      case 'write' : 
        if( $this->Manager->writeS['user_id']!="" ){
          echo "<input type='hidden' name='inputS[user_id]' value='{$this->Manager->writeS['user_id']}'>\n";
          if(_DEBUG_){
            echo "&lt; input type='hidden' name='inputS[user_id]' value='{$this->Manager->writeS['user_id']}'&gt;<br>\n";
          }
        }
        break;
    }
    return;
  }


  // 表示 - error
  function showError(){
    if($this->Manager->errorS!=""){
      echo"
        <table width='600'>
          <tr>
            <td align='left'>
              <font size='2' color='#FF0000'>
      ";

      foreach($this->Manager->errorS as $key=>$value){
        echo"・{$value}<br>";
      }
      echo"
              </font>
            </td>
          </tr>
        </table>
      ";

    }
  }

  // 表示 - ページリンク
  function showPageLink(){

    $qS = $this->queryList();
    $query = $qS['page'].$qS['join'].$qS['where'];

    $this->setNowPage($query);

    $htmlIn = file_get_contents(_PG_ROOT_HTML_._PG_HTML_LIST_PAGE_);
    $before = "前";
    if( $this->page!=1 ){
      $before = "<a href='"._PG_URL_."index.php?get=list&mode={$this->pageS['mode']}&page=".($this->page-1)."'>前</a>";
    }

    $i=1;
    $page = "";
    while($i<=$this->pageTotal){
      if($this->page==$i){
        $page .=  "| <b>{$i}</b>\n";
      }else{
        $page .=  "| <a href='"._PG_URL_."index.php?get=list&mode={$this->pageS['mode']}&page={$i}'>{$i}</a>\n";
      }
      $i++; 
    }
    $page .= "|";

    $after = "次";
    if( $this->page<$this->pageTotal ){
      $after = "<a href='"._PG_URL_."index.php?get=list&mode={$this->pageS['mode']}&page=".($this->page+1)."'>次</a>";
    }

    $htmlPage = $htmlIn;
    $htmlPage = str_replace("#totalCount#", $this->totalCount, $htmlPage);
    $htmlPage = str_replace("#nowMin#", $this->nowMin, $htmlPage);
    $htmlPage = str_replace("#nowMax#", $this->nowMax, $htmlPage);
    $htmlPage = str_replace("#before#", $before, $htmlPage);
    $htmlPage = str_replace("#after#",  $after, $htmlPage);
    $htmlPage = str_replace("#page#",   $page, $htmlPage);

    echo $htmlPage;

  }


  // 表示 - ユーザーリスト
  function showSeekCondition(){


    $condition="";
    if( $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['user_id']!="" ){
      $condition .=  "{$this->Manager->nameS['user_id']}に<b> 「 {$_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['user_id']} 」 </b>を含む<br>\n";
    }
    if( $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['comment']!="" ){
      $condition .=  "{$this->Manager->nameS['comment']}に<b> 「 {$_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['comment']} 」 </b>を含む<br>\n";
    }
    if( $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['name_family']!="" ){
      $condition .=  "{$this->Manager->nameS['name_family']}に<b> 「 {$_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['name_family']} 」 </b>を含む<br>\n";
    }
    if( $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['name_first']!="" ){
      $condition .=  "{$this->Manager->nameS['name_first']}に<b> 「 {$_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['name_first']} 」 </b>を含む<br>\n";
    }
    if( $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['kana_family']!="" ){
      $condition .=  "{$this->Manager->nameS['kana_family']}に<b> 「 {$_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['kana_family']} 」 </b>を含む<br>\n";
    }
    if( $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['kana_first']!="" ){
      $condition .=  "{$this->Manager->nameS['kana_first']}に<b> 「 {$_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['kana_first']} 」 </b>を含む<br>\n";
    }
    if( $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['name_company']!="" ){
      $condition .=  "{$this->Manager->nameS['name_company']}に<b> 「 {$_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['name_company']} 」 </b>を含む<br>\n";
    }
    if( $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['kana_company']!="" ){
      $condition .=  "{$this->Manager->nameS['kana_company']}に<b> 「 {$_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['kana_company']} 」 </b>を含む<br>\n";
    }
    if( $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['birthday']!="" ){
      $condition .=  "{$this->Manager->nameS['birthday']}が<b> 「 {$_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['birthday']} 」 </b><br>\n";
    }
    if( $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert1']!="" && $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert2']!="" ){
      $condition .=  "{$this->Manager->nameS['date_insert']}が<b>";
      $condition .=  "「 {$_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert1']} 〜 ";
      $condition .=  " {$_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert2']} 」 </b><br>\n";
    }
    if( $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['tel']!="" ){
      $condition .=  "{$this->Manager->nameS['tel']}が<b> 「 {$_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['tel']} 」 </b><br>\n";
    }
    if( $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['mail']!="" ){
      $condition .=  "{$this->Manager->nameS['mail']}に<b> 「 {$_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['mail']} 」 </b>を含む<br>\n";
    }

    if( $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['plan_pictmail_id']!="" ){
      $condition .= "プラン：".$this->ViewerLib->getPlanPictmailName($_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['plan_pictmail_id'] )."<br>\n";
    }

    if( $condition=="" ){
      $condition= "なし";
    }

    echo $condition;

  }


  

  // 表示 - ユーザーリスト
  function showListUser(){

    require_once(_DIR_LIB_."daytime/Daytime.php");
    $Daytime  = new Daytime();

    $qS = $this->queryList();

    $query = $qS['base'].$qS['join'].$qS['where'].$qS['groupby'].$qS['orderby'].$qS['limit'];

    $ExPostgres = $this->dbConnect();
    $ExPostgres->executeQuery($query);

    $count = $ExPostgres->getRow();
    if( $count!=0 ){
      $formatHtml = file_get_contents(_PG_ROOT_HTML_._PG_HTML_RENEW_LIST_IN_);
      $i=0;
      while($ExPostgres->getRow()-1>=$i){
        $dataS = "";
        $dataS = pg_fetch_assoc( $ExPostgres->getResult(),$i );

        foreach( $dataS as $dataKey=>$dataVal){
          if($dataVal!=""){
            $dataS[$dataKey] = $this->getHtml($dataVal);
          }else{
            $dataS[$dataKey] = "-----";
          }
        }

        $bgcolor = "#FFFFFF";
        $fontcolor= "#000000";
        $flag_permission = "<b><font color='#1111CC'>使用可</font></b>";
        if($dataS['flag_permission']==2){
          $fontcolor = "#FF0000";
          $bgcolor   = "#CCCCCC";
          $flag_permission = "<b><font color='#FF0000'>使用不可</font></b>";
        }

        $dataS['mail'] = "<a href='mailto:{$dataS['mail']}'>{$dataS['mail']}</a>";

        $date_update  = $Daytime->getDateFromTimestamp($dataS['date_update'])." ".$Daytime->getTimeFromTimestamp($dataS['date_update']);
        $date_insert  = $Daytime->getDateFromTimestamp($dataS['date_insert'])." ".$Daytime->getTimeFromTimestamp($dataS['date_insert']);

        $url_renew_user      = str_replace("#user_id#",$dataS['user_id'],_PG_URL_RENEW_USER_WRITE_);
        $url_renew_plan      = str_replace("#user_id#",$dataS['user_id'],_PG_URL_RENEW_PLAN_WRITE_);
        $url_select_plan     = str_replace("#user_id#",$dataS['user_id'],_PG_URL_SELECT_PLAN_);
        $url_permission_user = str_replace("#user_id#",$dataS['user_id'],_PG_URL_PERMISSION_USER_);
        $url_delete_user     = str_replace("#user_id#",$dataS['user_id'],_PG_URL_DELETE_USER_);

        $delete_alart  = "onclick=\"return confirm('";
        $delete_alart .= "以下のユーザーを削除します。宜しいでしょうか？\\n\\n";
        $delete_alart .= "user ID  ： {$dataS['user_id']}\\n";
        $delete_alart .= "名       ： {$dataS['name_family']} {$dataS['kana_family']}\\n";
        $delete_alart .= "');\"";

        $permission1_alart  = "onclick=\"return confirm('";
        $permission1_alart .= "以下のユーザーの使用を許可いたします。宜しいでしょうか？\\n\\n";
        $permission1_alart .= "user ID  ： {$dataS['user_id']}\\n";
        $permission1_alart .= "名       ： {$dataS['name_family']} {$dataS['kana_family']}\\n";
        $permission1_alart .= "');\"";

        $permission2_alart  = "onclick=\"return confirm('";
        $permission2_alart .= "以下のユーザーの使用を不可といたします。宜しいでしょうか？\\n\\n";
        $permission2_alart .= "user ID  ： {$dataS['user_id']}\\n";
        $permission2_alart .= "名       ： {$dataS['name_family']} {$dataS['kana_family']}\\n";
        $permission2_alart .= "');\"";

        $htmlList = $formatHtml;
        $htmlList = str_replace("#bgcolor#",      $bgcolor,$htmlList);
        $htmlList = str_replace("#fontcolor#",    $fontcolor,$htmlList);
        $htmlList = str_replace("#user_id#",      $dataS['user_id'],$htmlList);
        $htmlList = str_replace("#name_first#",   $dataS['name_first'],$htmlList);
        $htmlList = str_replace("#name_family#",  $dataS['name_family'],$htmlList);
        $htmlList = str_replace("#kana_family#",  $dataS['kana_family'],$htmlList);
        $htmlList = str_replace("#kana_first#",   $dataS['kana_first'],$htmlList);
        $htmlList = str_replace("#name_company#", $dataS['name_company'],$htmlList);
        $htmlList = str_replace("#kana_company#", $dataS['kana_company'],$htmlList);
        $htmlList = str_replace("#tel#",          $dataS['tel'],$htmlList);
        $htmlList = str_replace("#mail#", $dataS['mail'],$htmlList);
        $htmlList = str_replace("#plan#", $dataS['plan'],$htmlList);
        $htmlList = str_replace("#send_now#", $dataS['send_now'],$htmlList);
        $htmlList = str_replace("#send_max#", $dataS['send_max'],$htmlList);
        $htmlList = str_replace("#flag_permission#", $flag_permission,$htmlList);
        $htmlList = str_replace("#date_insert#", $date_insert,$htmlList);
        $htmlList = str_replace("#date_update_plan#", $date_update,$htmlList);

        $htmlList = str_replace("#delete_alart#", $delete_alart, $htmlList);
        $htmlList = str_replace("#permission1_alart#", $permission1_alart, $htmlList);
        $htmlList = str_replace("#permission2_alart#", $permission2_alart, $htmlList);

        $htmlList = str_replace("#url_renew_user#", $url_renew_user, $htmlList);
        $htmlList = str_replace("#url_renew_plan#", $url_renew_plan, $htmlList);
        $htmlList = str_replace("#url_select_plan#", $url_select_plan, $htmlList);
        $htmlList = str_replace("#url_permission_user#", $url_permission_user, $htmlList);
        $htmlList = str_replace("#url_delete_user#", $url_delete_user, $htmlList);

        echo $htmlList;

        $i++;
      }
    }

    pg_free_result( $ExPostgres->getResult() );
    $ExPostgres->close();

    return;
  }

  // 表示 確認用
  function getViewDataSConfirm(){

    $dataS = $this->setViewDataS($this->Manager->inputS);

    return $dataS;
  }


  // 表示用データ
  function setViewDataS($dataS=False){

    foreach($dataS as $key=>$val ){
      $dataS[$key] = $this->getHtml($val);
    }

    $dataS['name']     = "{$dataS['name_family']} {$dataS['name_first']}";
    $dataS['kana']     = "{$dataS['kana_family']} {$dataS['kana_first']}";
    $dataS['birthday'] = str_replace('-',' / ',$dataS['birthday']);

    return $dataS;
  }




  // クエリー - 企業/求人リスト
  function queryList(){

    $column  = "";
    $qS = "";

    $qS['page']    = "";
    $qS['base']    = "";
    $qS['join']    = "";
    $qS['where']   = "";
    $qS['orderby'] = "";
    $qS['groupby'] = "";
    $qS['limit']   = "";

    switch($this->pageS['mode']){
      case 'new':
        break;
      case 'renew':
        break;
    }

    $column .= "tmain.user_id,";
    $column .= "tmain.name_family,";
    $column .= "tmain.name_first,";
    $column .= "tmain.kana_family,";
    $column .= "tmain.kana_first,";
    $column .= "tmain.name_company,";
    $column .= "tmain.kana_company,";
    $column .= "tmain.mail,";
    $column .= "tmain.tel,";
    $column .= "tmain.date_insert,";

    $column .= "td01.pictmail_id,";
    $column .= "td01.plan_pictmail_id,";
    $column .= "td01.send_now,";
    $column .= "td01.send_max,";
    $column .= "td01.flag_permission,";
    $column .= "td01.date_update,";

    $column .= "tm01.plan_id,";
    $column .= "tm01.plan,";

    $column = substr($column,0,-1);


    $qS['page']    .= "SELECT count(*)  FROM td_user AS tmain ";
    $qS['base']    .= "SELECT {$column} FROM td_user AS tmain ";

    $qS['join']    .= "JOIN td_pictmail AS td01 ON tmain.user_id         = td01.user_id ";
    $qS['join']    .= "JOIN tm_plan     AS tm01 ON td01.plan_pictmail_id = tm01.plan_id ";

    $qS['where']   .= "";
    $qS['orderby'] .= "ORDER BY tm01.plan_id DESC, tmain.user_id DESC ";
    $qS['groupby'] .= "GROUP BY {$column} ";
    $qS['limit']   .= "LIMIT {$this->pageMax} OFFSET ".(($this->page-1)*$this->pageMax)." ";


    if( $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['user_id']!="" ){
      $qS['where'] .= " tmain.user_id LIKE '%{$_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['user_id']}%' AND ";
    }

    if( $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['comment']!="" ){
      $qS['where'] .= " tmain.comment LIKE '%{$_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['comment']}%' AND ";
    }

    if( $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['name_family']!="" ){
      $qS['where'] .= " tmain.name_family LIKE '%{$_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['name_family']}%' AND ";
    }

    if( $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['name_first']!="" ){
      $qS['where'] .= " tmain.name_first LIKE '%{$_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['name_first']}%' AND ";
    }

    if( $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['kana_family']!="" ){
      $qS['where'] .= " tmain.kana_family LIKE '%{$_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['kana_family']}%' AND ";
    }

    if( $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['kana_first']!="" ){
      $qS['where'] .= " tmain.kana_first LIKE '%{$_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['kana_first']}%' AND ";
    }

    if( $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['name_company']!="" ){
      $qS['where'] .= " tmain.name_company LIKE '%{$_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['name_company']}%' AND ";
    }

    if( $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['kana_company']!="" ){
      $qS['where'] .= " tmain.kana_company LIKE '%{$_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['kana_company']}%' AND ";
    }

    if( $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert1']!="" && $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert2']!="" ){
      $qS['where'] .= " (tmain.date_insert>='{$_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert1']} 00:00:00' AND ";
      $qS['where'] .= " tmain.date_insert<='{$_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert2']} 23:59:59') AND ";
    }



    if( $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['birthday']!="" ){
      $qS['where'] .= " tmain.birthday='{$_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['birthday']}' AND ";
    }

    if( $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['tel']!="" ){
      $qS['where'] .= " tmain.tel='{$_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['tel']}' AND ";
    }
    if( $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['mail']!="" ){
      $qS['where'] .= " tmain.mail LIKE '%{$_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['mail']}%' AND ";
    }

    if( $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['plan_pictmail_id']!="" ){
      $qS['where'] .= " td01.plan_pictmail_id={$_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['plan_pictmail_id']} AND ";
    }

    if( $qS['where']!="" ){
      $qS['where'] = " AND (".substr($qS['where'],0,-4).") ";
    }
    $qS['where'] = " WHERE tmain.flag_pictmail='t' AND td01.flag_del!=1 {$qS['where']}";


    return $qS;
  }



}
?>
