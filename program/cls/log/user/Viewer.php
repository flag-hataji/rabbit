<?PHP
/*
  ʪ�������ɽ��������
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

  // DB��³
  function dbConnect(){
    require_once(_DIR_LIB_."db/Postgres.php");
    require_once(_DIR_LIB_."db/ExPostgres.php");
    $ExPostgres = new ExPostgres(_DB_NAME_,_DB_USER_,_DB_HOST_,_DB_PORT_);
    return $ExPostgres;
  }


  // *ɽ��* �ڡ���
  function showPage(){
    require_once($this->pageS['html']);
  }


  // *����* ���ߤΥڡ�����
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


  // ɽ�� - Hidden
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
        if( $this->Manager->writeS['log_id']!="" ){
          echo "<input type='hidden' name='inputS[log_id]' value='{$this->Manager->writeS['log_id']}'>\n";
          if(_DEBUG_){
            echo "&lt; input type='hidden' name='inputS[log_id]' value='{$this->Manager->writeS['log_id']}'&gt;<br>\n";
          }
        }
        break;
    }
    return;
  }


  // ɽ�� - error
  function showError(){
    if($this->Manager->errorS!=""){
      echo"
        <table width='600'>
          <tr>
            <td align='left'>
              <font size='2' color='#FF0000'>
      ";

      foreach($this->Manager->errorS as $key=>$value){
        echo"��{$value}<br>";
      }
      echo"
              </font>
            </td>
          </tr>
        </table>
      ";

    }
  }

  // ɽ�� - �ڡ������
  function showPageLink(){

    $qS = $this->queryListLog();
    $query = $qS['page'].$qS['join'].$qS['where'];

    $this->setNowPage($query);

    $htmlIn = file_get_contents(_PG_ROOT_HTML_RENEW_._PG_HTML_LIST_PAGE_);
    $before = "��";
    if( $this->page!=1 ){
      $before = "<a href='"._PG_URL_."index.php?get=list&mode={$this->pageS['mode']}&page=".($this->page-1)."'>��</a>";
    }

    $i=1;
    $page = "";
    while($i<=$this->pageTotal){
      if($this->page==$i){
        $page .=  "| <b>{$i}</b>\n";
      }else{
        $page .=  "| <a href='"._PG_URL_."index.php?get=list&mode={$this->pageS['mode']}&page={$i}'>{$i}</a>\n";
      }
//echo $i%15;
      if($i!=0 && ($i%25)==0){
        $page .=  "<br>\n";
      }
      $i++; 
    }
    $page .= "|";

    $after = "��";
    if( $this->page<$this->pageTotal ){
      $after = "<a href='"._PG_URL_."index.php?get=list&mode={$this->pageS['mode']}&page=".($this->page+1)."'>��</a>";
    }

    $htmlPage = $htmlIn;
    $htmlPage = str_replace("#totalCount#", $this->totalCount, $htmlPage);
    $htmlPage = str_replace("#nowMin#", $this->nowMin, $htmlPage);
    $htmlPage = str_replace("#nowMax#", $this->nowMax, $htmlPage);
    $htmlPage = str_replace("#before#", "", $htmlPage);
    $htmlPage = str_replace("#after#",  "", $htmlPage);
//    $htmlPage = str_replace("#before#", $before, $htmlPage);
//    $htmlPage = str_replace("#after#",  $after, $htmlPage);
    $htmlPage = str_replace("#page#",   $page, $htmlPage);

    echo $htmlPage;

  }


  // ɽ�� - �桼�����ꥹ��
  function showSeekCondition(){


    $condition="";
    if( $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['log_id']!="" ){
      $condition .=  "{$this->Manager->nameS['log_id']}��<b> �� {$_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['log_id']} �� </b>��ޤ�<br>\n";
    }

    if( $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert1']!="" && $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert2']!="" ){
      $condition .=  "{$this->Manager->nameS['date_insert']}��<b>";
      $condition .=  "�� {$_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert1']} �� ";
      $condition .=  " {$_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert2']} �� </b><br>\n";
    }

    if( $condition=="" ){
      $condition= "�ʤ�";
    }

    echo $condition;

  }


  

  // ɽ�� - ���ꥹ��
  function showListLog(){

    require_once(_DIR_LIB_."daytime/Daytime.php");
    $Daytime  = new Daytime();

    $qS = $this->queryListLog();

    $query = $qS['base'].$qS['join'].$qS['where'].$qS['groupby'].$qS['orderby'].$qS['limit'];

    $ExPostgres = $this->dbConnect();
    $ExPostgres->executeQuery($query);

    $count = $ExPostgres->getRow();
    if( $count!=0 ){
      $formatHtml = file_get_contents(_PG_ROOT_HTML_RENEW_._PG_HTML_LIST_IN_);
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

        $dataS = $this->setViewDataS($dataS);

        $htmlList = $formatHtml;
        $htmlList = str_replace("#bgcolor#",      $dataS['bgcolor'],$htmlList);
        $htmlList = str_replace("#fontcolor#",    $dataS['fontcolor'],$htmlList);
        $htmlList = str_replace("#log_id#",       $dataS['log_id'],$htmlList);
        $htmlList = str_replace("#send_date#",    $dataS['send_date'],$htmlList);
        $htmlList = str_replace("#user_id#",      $dataS['user_id'],$htmlList);
        $htmlList = str_replace("#name_from#",    $dataS['name_from'],$htmlList);
        $htmlList = str_replace("#mail_from#",    $dataS['mail_from'],$htmlList);
        $htmlList = str_replace("#month_count#",  $dataS['month_count'],$htmlList);
        $htmlList = str_replace("#send_count#",   $dataS['send_count'],$htmlList);
        $htmlList = str_replace("#send_count_pc#",     $dataS['send_count_pc'],$htmlList);
        $htmlList = str_replace("#send_count_mobile#", $dataS['send_count_mobile'],$htmlList);
        $htmlList = str_replace("#subject#",           $dataS['subject'],$htmlList);
        $htmlList = str_replace("#date_insert#",       $dataS['date_insert'],$htmlList);
        $htmlList = str_replace("#date_insert_ym#",    $dataS['date_insert_ym'],$htmlList);

        $htmlList = str_replace("#flag_pc#",     $dataS['flag_pc'],$htmlList);
        $htmlList = str_replace("#flag_mobile#", $dataS['flag_mobile'],$htmlList);

        $htmlList = str_replace("#n_log_id#",       $this->Manager->nameS['log_id'],$htmlList);
        $htmlList = str_replace("#n_send_date#",    $this->Manager->nameS['send_date'],$htmlList);
        $htmlList = str_replace("#n_user_id#",      $this->Manager->nameS['user_id'],$htmlList);
        $htmlList = str_replace("#n_name_from#",    $this->Manager->nameS['name_from'],$htmlList);
        $htmlList = str_replace("#n_mail_from#",    $this->Manager->nameS['mail_from'],$htmlList);
        $htmlList = str_replace("#n_month_count#",  $this->Manager->nameS['month_count'],$htmlList);
        $htmlList = str_replace("#n_send_count#",   $this->Manager->nameS['send_count'],$htmlList);
        $htmlList = str_replace("#n_send_count_pc#",     $this->Manager->nameS['send_count_pc'],$htmlList);
        $htmlList = str_replace("#n_send_count_mobile#", $this->Manager->nameS['send_count_mobile'],$htmlList);
        $htmlList = str_replace("#n_subject#",           $this->Manager->nameS['subject'],$htmlList);
        $htmlList = str_replace("#n_date_insert#",       $this->Manager->nameS['date_insert'],$htmlList);
        $htmlList = str_replace("#n_flag_pc#",           $this->Manager->nameS['flag_pc'],$htmlList);
        $htmlList = str_replace("#n_flag_mobile#",       $this->Manager->nameS['flag_mobile'],$htmlList);

        $htmlList = str_replace("#url_detail#",  $dataS['url_detail'], $htmlList);
        $htmlList = str_replace("#url_cancel_pc#",  $dataS['url_cancel_pc'], $htmlList);
        $htmlList = str_replace("#url_cancel_mobile#",  $dataS['url_cancel_mobile'], $htmlList);

        $htmlList = str_replace("#button_cancel_pc#",  $dataS['button_cancel_pc'], $htmlList);
        $htmlList = str_replace("#button_cancel_mobile#",  $dataS['button_cancel_mobile'], $htmlList);

        echo $htmlList;

        $i++;
      }
    }else{

      echo "2006ǯ2��21���˼»ܤ��줿����ǽ�ɲåС�����󥢥åװʹߤ��ۿ��Ϥ���ޤ���";

    }

    pg_free_result( $ExPostgres->getResult() );
    $ExPostgres->close();

  }


  // ɽ�� ��ǧ��
  function getViewDataSDetail(){

    $qS = $this->queryDetailLog();
    $query = $qS['base'].$qS['join'].$qS['where'].$qS['groupby'].$qS['orderby'].$qS['limit'];
    $ExPostgres = $this->dbConnect();
    $ExPostgres->executeQuery($query);
    $dataS = pg_fetch_assoc( $ExPostgres->getResult(),0 );
    pg_free_result( $ExPostgres->getResult() );
    $ExPostgres->close();

    $dataS = $this->setViewDataS($dataS);

    return $dataS;
  }


  // ɽ���ѥǡ���
  function setViewDataS($dataS=False){

    foreach($dataS as $key=>$val ){
      $dataS[$key] = $this->getHtml($val);
    }

    require_once(_DIR_LIB_."daytime/Daytime.php");
    $Daytime  = new Daytime();

    $dataS['flag_mobile_org'] = $dataS['flag_mobile'];
    $dataS['flag_pc_org']     = $dataS['flag_pc'];

    $dataS['url_detail']        = str_replace("#log_id#",$dataS['log_id'],_PG_URL_DETAIL_);
    $dataS['url_cancel_pc']     = _PG_URL_CANCEL_PC_;
    $dataS['url_cancel_mobile'] = _PG_URL_CANCEL_MOBILE_;
    $dataS['url_cancel_pc']     = str_replace("#message_id#",$dataS['message_id'],$dataS['url_cancel_pc']);
    $dataS['url_cancel_pc']     = str_replace("#log_id#",$dataS['log_id'],$dataS['url_cancel_pc']);
    $dataS['url_cancel_pc']     = str_replace("#send_count_pc#",$dataS['send_count_pc'],$dataS['url_cancel_pc']);
    $dataS['url_cancel_mobile'] = str_replace("#message_id#",$dataS['message_id'],$dataS['url_cancel_mobile']);
    $dataS['url_cancel_mobile'] = str_replace("#log_id#",$dataS['log_id'],$dataS['url_cancel_mobile']);
    $dataS['url_cancel_mobile'] = str_replace("#send_count_mobile#",$dataS['send_count_mobile'],$dataS['url_cancel_mobile']);

    $dataS['button_cancel_pc'] = "";
    if($dataS['flag_pc']==1){
      $dataS['button_cancel_pc']     = "<input type='button' name='link' value='�Уå���󥻥�' onClick=\"location.href='"._PG_URL_CANCEL_PC_."'\">";
      $dataS['button_cancel_pc']     = str_replace("#message_id#",$dataS['message_id'],$dataS['button_cancel_pc']);
      $dataS['button_cancel_pc']     = str_replace("#log_id#",$dataS['log_id'],$dataS['button_cancel_pc']);
      $dataS['button_cancel_pc']     = str_replace("#send_count_pc#",$dataS['send_count_pc'],$dataS['button_cancel_pc']);
    }

    $dataS['button_cancel_mobile'] = "";
    if($dataS['flag_mobile']==1){
      $dataS['button_cancel_mobile'] = "<input type='button' name='link' value='���ӥ���󥻥�' onClick=\"location.href='"._PG_URL_CANCEL_MOBILE_."'\">";
      $dataS['button_cancel_mobile'] = str_replace("#message_id#",$dataS['message_id'],$dataS['button_cancel_mobile']);
      $dataS['button_cancel_mobile'] = str_replace("#log_id#",$dataS['log_id'],$dataS['button_cancel_mobile']);
       $dataS['button_cancel_mobile'] = str_replace("#send_count_mobile#",$dataS['send_count_mobile'],$dataS['button_cancel_mobile']);
   }

    $dataS['mail_from'] = "<a href='mailto:{$dataS['mail_from']}'>{$dataS['mail_from']}</a>";

    $date_insert    = $Daytime->getDateFromTimestamp($dataS['date_insert'],'ǯ','��','�� ');
    $date_insert   .= substr($Daytime->getTimeFromTimestamp($dataS['date_insert'],'��','ʬ','��'),0,-4);
    $dataS['date_insert'] = $date_insert;
    $dataS['date_insert_ym'] = substr($dataS['date_insert'],0,10);

    $send_date    = $Daytime->getDateFromTimestamp($dataS['send_date'],'ǯ','��','�� ');
    $send_date   .= substr($Daytime->getTimeFromTimestamp($dataS['send_date'],'��','ʬ','��'),0,-4);
    $dataS['send_date'] = $send_date;

    $date_pc    = $Daytime->getDateFromTimestamp($dataS['date_pc'],'ǯ','��','�� ');
    $date_pc   .= substr($Daytime->getTimeFromTimestamp($dataS['date_pc'],'��','ʬ','��'),0,-4);
    $dataS['date_pc'] = $date_pc;

    $date_mobile    = $Daytime->getDateFromTimestamp($dataS['date_mobile'],'ǯ','��','�� ');
    $date_mobile   .= substr($Daytime->getTimeFromTimestamp($dataS['date_mobile'],'��','ʬ','��'),0,-4);
    $dataS['date_mobile'] = $date_mobile;

    $dataS['month_count'] = "{$dataS['month_count']}���ܤ��ۿ�";
    $dataS['send_count'] = "{$dataS['send_count']}��";
    $dataS['send_count_mobile'] = "{$dataS['send_count_mobile']}��";
    $dataS['send_count_pc'] = "{$dataS['send_count_pc']}��";

    $dataS['delete_alart']  = "onclick=\"return confirm('";
    $dataS['delete_alart'] .= "�ʲ��Υ��������ޤ����������Ǥ��礦����\\n\\n";
    $dataS['delete_alart'] .= "ID     �� {$dataS['log_id']}\\n";
    $dataS['delete_alart'] .= "������ �� {$dataS['date_insert']}\\n";
    $dataS['delete_alart'] .= "��̾   �� {$dataS['subject']}\\n";
    $dataS['delete_alart'] .= "');\"";

    $dataS['url_list']   = _PG_URL_RENEW_LIST_;
    $dataS['bgcolor']    = "#FFFFFF";
    $dataS['fontcolor']  = "#000000";
/*
    if($dataS['flag_pc_org']==2 || $dataS['flag_mobile_org']==2){
      $dataS['bgcolor'] = "#DDDDFF";

    }else if($dataS['flag_pc_org']==3 && $dataS['flag_mobile_org']==3){
      $dataS['bgcolor'] = "#FFDDDD";

    }else if($dataS['flag_pc_org']==99 && $dataS['flag_mobile_org']==99){
      $dataS['bgcolor'] = "#DDDDDD";
    }*/

    switch($dataS['flag_pc']){
      case 1: 
        $dataS['flag_pc'] = "�ۿ�����"; 
        break;
      case 2: 
        $dataS['flag_pc'] = "<b><span class='blue12'>�ۿ���</span></b>"; 
        break;
      case 3: 
        $dataS['flag_pc'] = "<b><span class='red12'>����󥻥��</span></b>"; 
        break;
      case 99: 
        $dataS['flag_pc'] = "<b><span class='gold12'>��λ</span><br><span class='black10'>{$dataS['date_pc']}</span></b>"; 
        break;
      default: 
        $dataS['flag_pc'] = "�ۿ����ʤ�"; 
    }

    switch($dataS['flag_mobile']){
      case 1: 
        $dataS['flag_mobile'] = "�ۿ�����"; 
        break;
      case 2: 
        $dataS['flag_mobile'] = "<b><span class='blue12'>�ۿ���</span></b>"; 
        break;
      case 3: 
        $dataS['flag_mobile'] = "<b><span class='red12'>����󥻥��</span></b>"; 
        break;
      case 99: 
        $dataS['flag_mobile'] = "<b><span class='gold12'>��λ</span><br><span class='black10'>{$dataS['date_mobile']}</span></b>"; 
        break;
      default: 
        $dataS['flag_mobile'] = "�ۿ����ʤ�"; 
    }





    return $dataS;
  }




  // �����꡼ - ���ܺ�
  function queryDetailLog(){



    $column  = "";
    $qS = "";

    $qS['page']    = "";
    $qS['base']    = "";
    $qS['join']    = "";
    $qS['where']   = "";
    $qS['orderby'] = "";
    $qS['groupby'] = "";
    $qS['limit']   = "";

    $column .= "tmain.log_id,";
    $column .= "tmain.user_id,";
    $column .= "tmain.message_id,";
    $column .= "tmain.name_from,";
    $column .= "tmain.mail_from,";
    $column .= "tmain.mail_error,";
    $column .= "tmain.month_count,";
    $column .= "tmain.send_count,";
    $column .= "tmain.send_count_pc,";
    $column .= "tmain.send_count_mobile,";
    $column .= "tmain.ip,";
    $column .= "tmain.host,";
    $column .= "tmain.subject,";
    $column .= "tmain.message,";
    $column .= "tmain.message_html,";
    $column .= "tmain.send_date,";
    $column .= "tmain.date_pc,";
    $column .= "tmain.date_mobile,";
    $column .= "tmain.date_insert,";

    $column .= "tmain.flag_pc,";
    $column .= "tmain.flag_mobile,";
    $column .= "tmain.flag_type,";

    $column = substr($column,0,-1);

    $qS['base']    .= "SELECT {$column} FROM td_log AS tmain ";
    $qS['where'] = " WHERE tmain.user_id={$_SESSION['user']['user_id']} AND log_id='{$_GET['log_id']}'";
    $qS['orderby'] .= "ORDER BY tmain.log_id DESC ";
    $qS['groupby'] .= "GROUP BY {$column} ";
    $qS['limit']   .= "LIMIT {$this->pageMax} OFFSET ".(($this->page-1)*$this->pageMax)." ";



    return $qS;
  }




  // �����꡼ - ���ꥹ��
  function queryListLog(){

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

    $column .= "tmain.log_id,";
    $column .= "tmain.user_id,";
    $column .= "tmain.message_id,";
    $column .= "tmain.name_from,";
    $column .= "tmain.mail_from,";
    $column .= "tmain.mail_error,";
    $column .= "tmain.month_count,";
    $column .= "tmain.send_count,";
    $column .= "tmain.send_count_pc,";
    $column .= "tmain.send_count_mobile,";
    $column .= "tmain.ip,";
    $column .= "tmain.host,";
    $column .= "tmain.subject,";
    $column .= "tmain.message,";
    $column .= "tmain.message_html,";
    $column .= "tmain.send_date,";
    $column .= "tmain.date_pc,";
    $column .= "tmain.date_mobile,";
    $column .= "tmain.date_insert,";

    $column .= "tmain.flag_pc,";
    $column .= "tmain.flag_mobile,";
    $column .= "tmain.flag_type,";




    $column = substr($column,0,-1);

    $qS['page']    .= "SELECT count(*)  FROM td_log AS tmain ";
    $qS['base']    .= "SELECT {$column} FROM td_log AS tmain ";
    $qS['where']   .= "";
    $qS['orderby'] .= "ORDER BY tmain.log_id DESC ";
    $qS['groupby'] .= "GROUP BY {$column} ";
    $qS['limit']   .= "LIMIT {$this->pageMax} OFFSET ".(($this->page-1)*$this->pageMax)." ";


    if( $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['log_id']!="" ){
      $qS['where'] .= " tmain.log_id LIKE '%{$_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['log_id']}%' AND ";
    }

    if( $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert1']!="" && $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert2']!="" ){
      $qS['where'] .= " (tmain.date_insert>='{$_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert1']} 00:00:00' AND ";
      $qS['where'] .= " tmain.date_insert<='{$_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['date_insert2']} 23:59:59') AND ";
    }

    if( $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['send_date1']!="" && $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['send_date2']!="" ){
      $qS['where'] .= " (tmain.send_date>='{$_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['send_date1']} 00:00:00' AND ";
      $qS['where'] .= " tmain.send_date<='{$_SESSION[_SESSION_MODE_][_SESSION_NAME_]['seekS']['send_date2']} 23:59:59') AND ";
    }

    if( $qS['where']!="" ){
      $qS['where'] = " AND (".substr($qS['where'],0,-4).") ";
    }
    $qS['where'] = " WHERE tmain.user_id={$_SESSION['user']['user_id']}";


    return $qS;
  }



}
?>
