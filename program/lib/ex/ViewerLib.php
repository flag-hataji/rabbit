<?PHP
/*

*/
class ViewerLib {

  function ViewerLib(){

  }

  // DB��³
  function dbConnect(){
    require_once(_DIR_LIB_."db/Postgres.php");
    require_once(_DIR_LIB_."db/ExPostgres.php");
    $ExPostgres = new ExPostgres(_DB_NAME_,_DB_USER_,_DB_HOST_,_DB_PORT_);
    return $ExPostgres;
  }


  // ���쥯�ȥܥå�������ϩ
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


  // ��������ϩ
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


  // ���쥯�ȥܥå�������ƻ�ܸ�(̾��ɳ�դ�)
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

  // ���쥯�ȥܥå������᡼�������ץ��
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


  // �������᡼�������ץ��̾
  function getPlanPictmailName( $plan_id=False){

    $query = "SELECT * FROM tm_plan WHERE plan_id={$plan_id}";

    $ExPostgres = $this->dbConnect();
    $ExPostgres->executeQuery($query);
    $dataS = pg_fetch_assoc( $ExPostgres->getResult(),0 );
    pg_free_result( $ExPostgres->getResult() );
    $ExPostgres->close();

    return $dataS['plan'];
  }







  // �������饤�֥��̾��
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

  // ���쥯�ȥܥå������饤�֥��ǡ���
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
