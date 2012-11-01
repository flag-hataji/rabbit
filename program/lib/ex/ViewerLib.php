<?PHP
/*

*/
class ViewerLib {

  function ViewerLib(){

  }

  // DB接続
  function dbConnect(){
    require_once(_DIR_LIB_."db/Postgres.php");
    require_once(_DIR_LIB_."db/ExPostgres.php");
    $ExPostgres = new ExPostgres(_DB_NAME_,_DB_USER_,_DB_HOST_,_DB_PORT_);
    return $ExPostgres;
  }


  // セレクトボックス：経路
  function showSelectRoot( $setName=False, $setVal=False){

    $query = "SELECT * FROM tm_root ORDER BY sort";

    $ExPostgres = $this->dbConnect();
    $ExPostgres->executeQuery($query);

    echo"<select name='{$setName}'>\n";
    $count = $ExPostgres->getRow();
    if( $count!=0 ){
      $i=0;
      while($ExPostgres->getRow()-1>=$i){
        $dataS = pg_fetch_assoc( $ExPostgres->getResult(),$i );
        $selected = "";
        if($setVal==$dataS['root_id']){
          $selected = "selected";
        }
        echo "  <option value='{$dataS['root_id']}' {$selected}>{$dataS['root']}</option>\n";
        $i++;
      }
    }
    echo"</select>\n";

    pg_free_result( $ExPostgres->getResult() );
    $ExPostgres->close();

    return ;
  }


  // 取得：経路
  function getNameRoot( $setName=False, $setVal=False){

    $query = "SELECT * FROM tm_root WHERE root_id={$setVal}";

    $ExPostgres = $this->dbConnect();
    $ExPostgres->executeQuery($query);
    $dataS = pg_fetch_assoc( $ExPostgres->getResult(),0 );
    $name = $dataS['root'];
    pg_free_result( $ExPostgres->getResult() );
    $ExPostgres->close();

    return $name;
  }


  // セレクトボックス：都道府県(名前紐付け)
  function showSelectPrefName( $setName=False, $setVal=False){

    $query = "SELECT * FROM tm_pref ORDER BY sort";

    $ExPostgres = $this->dbConnect();
    $ExPostgres->executeQuery($query);

    echo"<select name='{$setName}'>\n";
    $count = $ExPostgres->getRow();
    if( $count!=0 ){
      $i=0;
      while($ExPostgres->getRow()-1>=$i){
        $dataS = pg_fetch_assoc( $ExPostgres->getResult(),$i );
        $selected = "";
        if($setVal==$dataS['pref']){
          $selected = "selected";
        }
        echo "  <option value='{$dataS['pref']}' {$selected}>{$dataS['pref']}</option>\n";
        $i++;
      }
    }
    echo"</select>\n";

    pg_free_result( $ExPostgres->getResult() );
    $ExPostgres->close();



    return ;
  }

  // セレクトボックス：メール送信プラン
  function showSelectPlanPictmail( $setName=False, $setVal=False){

    $query = "SELECT * FROM tm_plan ORDER BY plan_id";

    $ExPostgres = $this->dbConnect();
    $ExPostgres->executeQuery($query);

    echo"<select name='{$setName}'>\n";
    echo "  <option value=''>--------------</option>\n";
    $count = $ExPostgres->getRow();
    if( $count!=0 ){
      $i=0;
      while($ExPostgres->getRow()-1>=$i){
        $dataS = pg_fetch_assoc( $ExPostgres->getResult(),$i );
        $selected = "";
        if($setVal==$dataS['plan_id']){
          $selected = "selected";
        }
        echo "  <option value='{$dataS['plan_id']}' {$selected}>{$dataS['plan']}</option>\n";
        $i++;
      }
    }
    echo"</select>\n";

    pg_free_result( $ExPostgres->getResult() );
    $ExPostgres->close();



    return ;
  }


  // 取得：メール送信プラン名
  function getPlanPictmailName( $plan_id=False){

    $query = "SELECT * FROM tm_plan WHERE plan_id={$plan_id}";

    $ExPostgres = $this->dbConnect();
    $ExPostgres->executeQuery($query);
    $dataS = pg_fetch_assoc( $ExPostgres->getResult(),0 );
    pg_free_result( $ExPostgres->getResult() );
    $ExPostgres->close();

    return $dataS['plan'];
  }







  // 取得：ライブラリ名前
  function getNameLibrary( $setName=False, $dataS=False, $setVal=False){

    require_once(_DIR_LIB_."ex/Library.php");
    $Library = new Library();

    foreach($dataS as $num=>$strS){
      if($setVal==$strS['id']){
        $name = $strS['name'];
      }
    }

    return $name;
  }

  // セレクトボックス：ライブラリデータ
  function showSelectLibrary( $setName=False, $dataS=False, $setVal=False){

    require_once(_DIR_LIB_."ex/Library.php");
    $Library = new Library();

    echo"<select name='{$setName}'>\n";
    foreach($dataS as $num=>$strS){
      $selected = "";
      if($setVal==$strS['id']){
        $selected = "selected";
      }
      echo "  <option value='{$strS['id']}' {$selected}>{$strS['name']}</option>\n";
    }
    echo"</select>\n";

    return ;
  }

}
?>
