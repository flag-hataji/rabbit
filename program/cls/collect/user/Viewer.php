<?PHP
/*
  ɽ��������
*/
class Viewer extends Html {

  var $pageS   = "";
  var $Manager = "";

  function Viewer($pageS=False,$Manager=False){
    $this->pageS   = $pageS;
    $this->Manager = $Manager;
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
        if( $this->Manager->writeS['collect_id']!="" ){
          echo "<input type='hidden' name='inputS[collect_id]' value='{$this->Manager->writeS['collect_id']}'>\n";
          if(_DEBUG_){
            echo "&lt; input type='hidden' name='inputS[collect_id]' value='{$this->Manager->writeS['collect_id']}'&gt;<br>\n";
          }
        }
        break;
    }
    return;
  }


  // ɽ�� - ���顼�طʿ�
  function showErrorBgcolor($error=False,$errorS=False){

    if(isset($errorS[$error]) && $errorS[$error]!=""){  
      echo " bgcolor='#FFAA77' ";
    }else{
      echo " bgcolor='#FFFFFF' ";
    }
  }


  // ɽ�� - ���顼
  function showErrorWord($error=False,$errorS=False){
    if(isset($errorS[$error]) && $errorS[$error]!=""){  
      echo "<br><b><span class='white12'>�� {$errorS[$error]}</span></b><br>";
    }
  }


  // ɽ�� ��ǧ��
  function getViewDataSConfirm(){

    $dataS = $this->setViewDataS($this->Manager->inputS);


    return $dataS;
  }


  // ɽ���ѥǡ���
  function setViewDataS($dataS=False){

    foreach($dataS as $key=>$val ){
      $dataS[$key] = $this->getHtml($val);
    }

    $dataS['tool_id'];

    $query  = "SELECT * FROM tm_tool WHERE tool_id={$_POST['inputS']['tool_id']} ";
    $ExPostgres = $this->dbConnect();
    $ExPostgres->executeQuery($query);
    $dataS = pg_fetch_assoc( $ExPostgres->getResult(),0 );
    $dataS['tool_id']  = $dataS['tool'];
    $dataS['url']      = $dataS['url'];

    return $dataS;
  }


}
?>
