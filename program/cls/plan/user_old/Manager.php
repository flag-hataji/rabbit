<?PHP

class Manager extends Html {

  var $charaCode   = "EUC-JP";
  var $outputCode  = "EUC-JP";
  var $modeS       = "";
  var $defaultS    = "";
  var $inputS      = "";
  var $writeS      = "";
  var $errorS      = "";

  function Manager(){
    if( _DEBUG_ ){
      require_once(_DIR_LIB_.'debug/Debug.php');
      $this->Debug = new Debug();
    }
    require_once(_DIR_LIB_."ex/ViewerLib.php");
    $this->ViewerLib = new ViewerLib();
  }

  // DB��³
  function dbConnect(){
    require_once(_DIR_LIB_."db/Postgres.php");
    require_once(_DIR_LIB_."db/ExPostgres.php");
    $ExPostgres = new ExPostgres(_DB_NAME_,_DB_USER_,_DB_HOST_,_DB_PORT_);
    return $ExPostgres;
  }

  // *����* �ǥХå�
  function showArrayDebug( $val=False,$name='Deubg' ){
    if( _DEBUG_ ){
      $this->Debug->arrayView($val, $name, _DEBUG_);
    }
  }


  // *SET* SESSION �ڡ�������
  function setSessionPlace($place=False){
    $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['place'] = $place;
  }

  // *GET* SESSION �ڡ�������
  function getSessionPlace(){
    return $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['place'];
  }


  // *SET* Name
  function setName(){

    $this->nameS['pictmail_id']      = "�桼�����ץ��ID";
    $this->nameS['user_id']          = "�桼����ID";
    $this->nameS['plan_pictmail_id'] = "�ץ��ID";
    $this->nameS['price_month']      = "�������ȴ����1�����";
    $this->nameS['price_month6']     = "�������ȴ����6�����";
    $this->nameS['price_year']       = "�������ȴ����12�����";
    $this->nameS['send_max']         = "�᡼���������ʺ����";
    $this->nameS['send_now']         = "�᡼���������ʸ�����";
    $this->nameS['flag_dm']          = "���Τ餻�᡼��μ������";

    $this->showArrayDebug($this->nameS,'$this->nameS');

  }

  // *SET* $this->defaultS => $this->inputS
  function setDefault(){

    $this->defaultS['pictmail_id']     = "";
    $this->defaultS['user_id']         = "";
    $this->defaultS['plan_pictmail_id']= "";
    $this->defaultS['price_month']     = "";
    $this->defaultS['price_month6']    = "";
    $this->defaultS['price_year']      = "";
    $this->defaultS['send_max']        = "";
    $this->defaultS['send_now']        = "";
    $this->defaultS['flag_dm']         = "";

    $this->showArrayDebug($this->inputS,'$this->inputS');

    return;
  }


  // *SET* $this->defaultS => $this->inputS
  function setDefaultToInput(){
    foreach( $this->defaultS as $key=>$val ){
      if( !isset($this->inputS[$key]) ){
        $this->inputS[$key] = $val;
      }
    }
  }


  // *SET* $_POST => $this->inputS
  function setPostToInput(){

    if(isset($_POST['inputS'])){
      $this->inputS = $_POST['inputS'] ;
    }else{
      $this->inputS = "" ;
    }
    $this->setDefaultToInput();
    $this->convertInput();

    $this->showArrayDebug($this->inputS,'$this->inputS');
  }

  // *SET* DB => $this->inputS
  function setDbToInput(){

    $column  = "";
    $query   = "";

    $column .= "tmain.pictmail_id,";
    $column .= "tmain.user_id,";
    $column .= "tmain.plan_pictmail_id,";
    $column .= "tmain.price_month,";
    $column .= "tmain.price_month6,";
    $column .= "tmain.price_year,";
    $column .= "tmain.send_max,";
    $column .= "tmain.send_now,";
    $column .= "tmain.flag_dm,";

    $column = substr($column,0,-1);

    $query .= "SELECT {$column} FROM td_pictmail AS tmain ";
    $query .= " WHERE tmain.user_id={$_SESSION['user']['user_id']} ";

    $ExPostgres = $this->dbConnect();
    $ExPostgres->executeQuery($query);
    $dataS = pg_fetch_assoc( $ExPostgres->getResult(),0 );
    pg_free_result( $ExPostgres->getResult() );
    $ExPostgres->close();

    $this->inputS = $dataS ;
    $this->setDefaultToInput();

    $this->convertInput();
    $this->showArrayDebug($this->inputS,'$this->inputS');

    return ;
  }


  // *SET* PlanDB => $this->inputS
  function setPlanToInput(){

    $column  = "";
    $query   = "";
    $query .= "SELECT * FROM tm_plan WHERE plan_id={$this->inputS['plan_pictmail_id']} ";

    $ExPostgres = $this->dbConnect();
    $ExPostgres->executeQuery($query);
    $dataS = pg_fetch_assoc( $ExPostgres->getResult(),0 );
    pg_free_result( $ExPostgres->getResult() );
    $ExPostgres->close();

    $this->inputS['plan_pictmail_id']  = $dataS['plan_id'];
    $this->inputS['price_month']  = $dataS['price_month'];
    $this->inputS['price_month6'] = $dataS['price_month6'];
    $this->inputS['price_year']   = $dataS['price_year'];
    $this->inputS['send_max']     = $dataS['send_max'];
    $this->inputS['send_now']     = $dataS['send_max'];

    $this->setDefaultToInput();

    $this->convertInput();
    $this->showArrayDebug($this->inputS,'$this->inputS');

    return ;
  }



  // *SET* $this->inputS => $this->writeS
  function setInputToWrite(){
    $this->writeS = $this->inputS;
    $this->convertWrite();
    $this->showArrayDebug($this->writeS,'$this->writeS');
  }


  // *CONVERT* $this->inputS
  function convertInput(){

    require_once(_DIR_LIB_.'convert/Convert.php');
    $Convert = new Convert() ;

    if( isset($_POST['charaCode']) ){
      $postCode = mb_detect_encoding($_POST['charaCode']);
      if( $this->charaCode!=$postCode ){
        foreach( $this->inputS as $key=>$value ){
          $this->inputS[$key] = mb_convert_encoding($value, $this->charaCode, $postCode );
        }
      }
    }

    $this->inputS['price_month']  = $Convert->getConvert($this->inputS['price_month'],'KVa2');
    $this->inputS['price_month6'] = $Convert->getConvert($this->inputS['price_month6'],'KVa2');
    $this->inputS['price_year']   = $Convert->getConvert($this->inputS['price_year'],'KVa2');
    $this->inputS['send_max']     = $Convert->getConvert($this->inputS['send_max'],'KVa2');
    $this->inputS['send_now']     = $Convert->getConvert($this->inputS['send_now'],'KVa2');

    if( $this->inputS['flag_dm']=="" ){   $this->inputS['flag_dm'] = 1; }

  }

  // *CONVERT* $this->writeS
  function convertWrite(){

    $this->writeS['price_month']  = $this->getTextfield($this->writeS['price_month']); 
    $this->writeS['price_month6'] = $this->getTextfield($this->writeS['price_month6']); 
    $this->writeS['price_year']   = $this->getTextfield($this->writeS['price_year']); 
    $this->writeS['send_max']     = $this->getTextfield($this->writeS['send_max']); 
    $this->writeS['send_now']     = $this->getTextfield($this->writeS['send_now']); 

    foreach( $this->writeS as $key=>$value ){
      $this->writeS[$key] = mb_convert_encoding($value, $this->outputCode, $this->charaCode );
    }

  }


  // *CHECK* $this->inputS
  function checkInput(){

    require_once(_DIR_LIB_.'check/Check.php');
    $Check = new Check() ;
/*
    if( !$Check->isInput($this->inputS['company_id']) )        $this->errorS[company_id]        = "{$this->nameS['company_id']} ��̤���ϤǤ�";
    if( !$Check->isInput($this->inputS['branch_id']) )         $this->errorS[branch_id]         = "{$this->nameS['branch_id']} ��̤���ϤǤ�";
    if( !$Check->isInput($this->inputS['user_job_2_id']) ) $this->errorS[user_job_2_id] = "{$this->nameS['user_job_2_id']} ��̤���ϤǤ�";
    if( !$Check->isInput($this->inputS['area_id']) )           $this->errorS[area_id]           = "{$this->nameS['area_id']} ��̤���ϤǤ�";
    if( !$Check->isInput($this->inputS['wage']) )              $this->errorS[wage]              = "{$this->nameS['wage']} ��̤���ϤǤ�";
    if( !$Check->isInput($this->inputS['comment1']) )          $this->errorS[comment1]          = "{$this->nameS['comment1']} ��̤���ϤǤ�";
    if( !$Check->isInput($this->inputS['comment5']) )          $this->errorS[comment5]          = "{$this->nameS['comment5']} ��̤���ϤǤ�";
    if( !$Check->isInput($this->inputS['flag_exp']) )          $this->errorS[flag_exp]          = "{$this->nameS['flag_exp']} ��̤���ϤǤ�";
    if( !$Check->isInput($this->inputS['flag_term']) )         $this->errorS[flag_term]         = "{$this->nameS['flag_term']} ��̤���ϤǤ�";
    if( !$Check->isInput($this->inputS['user_wage_code_s']) ) $this->errorS[user_wage_code_s] = "{$this->nameS['user_wage_code_s']} ��̤���ϤǤ�";

    if( $Check->isInput($this->inputS['sort']) && !$Check->isNumber($this->inputS['sort']) )
      $this->errorS[wage]      = "{$this->nameS['sort']} ��Ⱦ�ѱѿ��Ǥ����Ϥ�������";

    if( $Check->isInput($this->inputS['wage']) && !$Check->isNumber($this->inputS['wage']) )
      $this->errorS[wage]      = "{$this->nameS['wage']} ��Ⱦ�ѱѿ��Ǥ����Ϥ�������";

    if( $Check->isInput($this->inputS['age_min']) && !$Check->isNumber($this->inputS['age_min']) )
      $this->errorS[age_min]   = "{$this->nameS['age_min']} ��Ⱦ�ѱѿ��Ǥ����Ϥ�������";

    if( $Check->isInput($this->inputS['age_max']) && !$Check->isNumber($this->inputS['age_max']) )
      $this->errorS[age_max]   = "{$this->nameS['age_max']} ��Ⱦ�ѱѿ��Ǥ����Ϥ�������";

    if( $Check->isInput($this->inputS['year_exp']) && !$Check->isNumber($this->inputS['year_exp']) )
      $this->errorS[year_exp]      = "{$this->nameS['year_exp']} ��Ⱦ�ѱѿ��Ǥ����Ϥ�������";
*/
  }

  // *SET* ID
  function setSequenceId(){
    $ExPostgres = $this->dbConnect();
    $this->inputS['user_id']     = $ExPostgres->getNextval('td_user_seq');
    $ExPostgres->close();
  }

}
?>
