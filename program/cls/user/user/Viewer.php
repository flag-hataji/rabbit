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

    $dataS['name']     = "{$dataS['name_family']} {$dataS['name_first']}";
    $dataS['kana']     = "{$dataS['kana_family']} {$dataS['kana_first']}";
    $dataS['birthday'] = str_replace('-',' / ',$dataS['birthday']);
    $dataS['zip']      = "��{$dataS['zip']}";

    $dataS['flag_gender'] = $this->ViewerLib->getNameLibrary('inputS[flag_gender]', $this->Library->aryGender(), $dataS['flag_gender']);

    if($this->pageS['mode']=='new'){
      $dataS['root_id'] = $this->ViewerLib->getNameRoot('',$dataS['root_id']);
      if($dataS['text_root']!=""){
        $dataS['text_root'] = "��{$dataS['text_root']}";
      }
    }

    return $dataS;
  }


}
?>
