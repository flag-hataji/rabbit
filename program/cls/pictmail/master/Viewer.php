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

  // ɽ�� ��ǧ��
  function getViewDataSConfirm(){

    $dataS = $this->setViewDataS($this->Manager->inputS);

    return $dataS;
  }


  // ɽ���ѥǡ���
  function setViewDataS($dataS=False){

    if (isset($dataS['plan_pictmail_id']) && $dataS['plan_pictmail_id'] != "") {

        require_once(_DIR_LIB_."db/Postgres.php");
        require_once(_DIR_LIB_."db/ExPostgres.php");
        $ExPostgres = new ExPostgres(_DB_NAME_,_DB_USER_,_DB_HOST_,_DB_PORT_);

        $isQuery = "SELECT plan from tm_plan WHERE plan_id=" . $dataS['plan_pictmail_id'] . ";";

        $ExPostgres->executeQuery($isQuery);
        $isDataS = pg_fetch_assoc( $ExPostgres->getResult(),0 );
        pg_free_result( $ExPostgres->getResult() );
        $ExPostgres->close();


        $dataS['plan_pictmail_id'] = $isDataS['plan'];

    }

    foreach($dataS as $key=>$val ){
      $dataS[$key] = $this->getHtml($val);
    }

    $dataS['price_month']  = number_format($dataS['price_month'])." ��";
    $dataS['price_month6'] = number_format($dataS['price_month6'])." ��";
    $dataS['price_year']   = number_format($dataS['price_year'])." ��";
    $dataS['send_max']     = number_format($dataS['send_max'])." ��";
    $dataS['send_now']     = number_format($dataS['send_now'])." ��";



    return $dataS;
  }





}
?>
