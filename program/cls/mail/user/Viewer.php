<?PHP
/*
  物件管理：表示・出力
*/
class Viewer extends Html {

  var $pageS   = "";
  var $Manager = "";

  function Viewer($pageS=False,$Manager=False,$Fileup=False){
    $this->pageS   = $pageS;
    $this->Manager = $Manager;
    $this->Fileup  = $Fileup;
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


  // 表示 - エラー背景色
  function showErrorBgcolor($error=False,$errorS=False){

    if(isset($errorS[$error]) && $errorS[$error]!=""){  
      echo " bgcolor='#FF7777' ";
    }else{
      echo " bgcolor='#FFFFFF' ";
    }
  }


  // 表示 - エラー
  function showErrorList($errorS=False){
    if(isset($errorS) && $errorS!=""){  
      foreach($errorS as $key=>$val){
        echo "　<b><a href='#{$key}'><span class='white12'>※ {$val}</a></span></b><br>";
      }
    }
  }

  // 表示 - エラー
  function showErrorWord($error=False,$errorS=False){
    if(isset($errorS[$error]) && $errorS[$error]!=""){  
      echo "<br><b><span class='white12'>※ {$errorS[$error]}</span></b><br>";
    }
  }

  // 表示 - ファイルアップエラー
  function showErrorFileup($errorS=False){
    if( $errorS!="" ){  
      echo "
                <tr> 
                  <td align='left' bgcolor='#FFFFFF' class='gold12'>
      ";
      foreach($errorS as $val){
        echo "
                    ・{$val}<br>
        ";
      }
      echo "
                  </td>
                </tr>
      ";
    }
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

    $dataS['send_date'] = str_replace('-','/',$dataS['send_date']);
    $dataS['flag_omit'] = $this->ViewerLib->getNameLibrary('inputS[flag_omit]', $this->Library->arySend(), $dataS['flag_omit']);
    $dataS['flag_html'] = $this->ViewerLib->getNameLibrary('inputS[flag_html]', $this->Library->arySend(), $dataS['flag_html']);

    return $dataS;
  }





}
?>
