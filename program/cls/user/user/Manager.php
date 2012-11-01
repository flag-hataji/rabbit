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

  // *SET* SESSION ���������
  function setSessionLogin($place=False){
    $_SESSION['user']['user_id']  = $this->inputS['user_id'];
    $_SESSION['user']['id']       = $this->inputS['id'];
    $_SESSION['user']['password'] = $this->inputS['password'];
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

    $this->nameS['user_id']     = "�桼����ID";
    $this->nameS['job_id']      = "����ID";
    $this->nameS['id']          = "������ID";
    $this->nameS['password']    = "�ѥ����";
    $this->nameS['name']        = "̾��";
    $this->nameS['name_family'] = "̾������";
    $this->nameS['name_first']  = "̾����̾";
    $this->nameS['kana']        = "̾���ʥեꥬ�ʡ�";
    $this->nameS['kana_family'] = "̾�������ʥեꥬ�ʡ�";
    $this->nameS['kana_first']  = "̾����̾�ʥեꥬ�ʡ�";
    $this->nameS['birthday']    = "��ǯ����";
    $this->nameS['birthday_y']  = "��������ǯ";
    $this->nameS['birthday_m']  = "����������";
    $this->nameS['birthday_d']  = "����������";
    $this->nameS['mail']        = "�᡼�륢�ɥ쥹";
    $this->nameS['tel']         = "�����ֹ�";
    $this->nameS['tel_1']       = "�����ֹ�ʾ�����";
    $this->nameS['tel_2']       = "�����ֹ��������";
    $this->nameS['tel_3']       = "�����ֹ�ʲ�����";
    $this->nameS['mobile']      = "��������";
    $this->nameS['mobile_1']    = "�������áʾ�����";
    $this->nameS['mobile_2']    = "�������á�������";
    $this->nameS['mobile_3']    = "�������áʲ�����";
    $this->nameS['fax']         = "FAX�ֹ�";
    $this->nameS['fax_1']       = "FAX�ֹ�ʾ�����";
    $this->nameS['fax_2']       = "FAX�ֹ��������";
    $this->nameS['fax_3']       = "FAX�ֹ�ʲ�����";
    $this->nameS['zip']         = "͹���ֹ�";
    $this->nameS['area']        = "��ƻ�ܸ�";
    $this->nameS['address1']    = "�Զ�Į¼��������";
    $this->nameS['address2']    = "�ӥ�̾";
    $this->nameS['comment']     = "����";
    $this->nameS['flag_gender'] = "����";
    $this->nameS['flag_pictmail'] = "�᡼�����ۿ�����";
    $this->nameS['flag_stepmail'] = "���ƥåץ᡼�����";
    $this->nameS['name_company']  = "���̾";
    $this->nameS['kana_company']  = "���̾�ʥեꥬ�ʡ�";

    $this->nameS['user_ex1_id']  = "";
    $this->nameS['medium_id']    = "";
    $this->nameS['text_medium']  = "";
    $this->nameS['ip']           = "";
    $this->nameS['host']         = "";
    $this->nameS['referrer']     = "";



    $this->showArrayDebug($this->nameS,'$this->nameS');

  }

  // *SET* $this->defaultS => $this->inputS
  function setDefault(){

    $this->defaultS['user_id']      = "";
    $this->defaultS['job_id']       = "";
    $this->defaultS['id']           = "";
    $this->defaultS['password']     = "";
    $this->defaultS['name']         = "";
    $this->defaultS['name_family']  = "";
    $this->defaultS['name_first']   = "";
    $this->defaultS['kana']         = "";
    $this->defaultS['kana_family']  = "";
    $this->defaultS['kana_first']   = "";
    $this->defaultS['birthday']     = "";
    $this->defaultS['birthday_y']   = "";
    $this->defaultS['birthday_m']   = "";
    $this->defaultS['birthday_d']   = "";
    $this->defaultS['mail']         = "";
    $this->defaultS['tel']          = "";
    $this->defaultS['tel_1']        = "";
    $this->defaultS['tel_2']        = "";
    $this->defaultS['tel_3']        = "";
    $this->defaultS['mobile']       = "";
    $this->defaultS['mobile_1']     = "";
    $this->defaultS['mobile_2']     = "";
    $this->defaultS['mobile_3']     = "";
    $this->defaultS['fax']          = "";
    $this->defaultS['fax_1']        = "";
    $this->defaultS['fax_2']        = "";
    $this->defaultS['fax_3']        = "";
    $this->defaultS['zip']          = "";
    $this->defaultS['area']         = "";
    $this->defaultS['address1']     = "";
    $this->defaultS['address2']     = "";
    $this->defaultS['comment']      = "";
    $this->defaultS['flag_gender']  = "";
    $this->defaultS['flag_pictmail']    = "t";
    $this->defaultS['flag_stepmail']    = "f";
    $this->defaultS['name_company']     = "";
    $this->defaultS['kana_company']     = "";

    $this->defaultS['user_ex1_id']  = "";
    $this->defaultS['medium_id']    = "";
    $this->defaultS['text_medium']  = "";
    $this->defaultS['ip']           = "";
    $this->defaultS['host']         = "";
    $this->defaultS['referrer']     = "";

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

    $column .= "tmain.user_id,";
    $column .= "tmain.id,";
    $column .= "tmain.password,";
    $column .= "tmain.name_family,";
    $column .= "tmain.name_first,";
    $column .= "tmain.kana_family,";
    $column .= "tmain.kana_first,";
    $column .= "tmain.name_company,";
    $column .= "tmain.kana_company,";
    $column .= "tmain.mail,";
    $column .= "tmain.tel,";
    $column .= "tmain.mobile,";
    $column .= "tmain.zip,";
    $column .= "tmain.area,";
    $column .= "tmain.address1,";
    $column .= "tmain.address2,";
    $column .= "tmain.comment,";
    $column .= "tmain.flag_pictmail,";
    $column .= "tmain.flag_stepmail,";

    $column = substr($column,0,-1);

    $query .= "SELECT {$column} FROM td_user AS tmain ";
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
          if($value!="" && $postCode!=""){
            $this->inputS[$key] = mb_convert_encoding($value, $this->charaCode, $postCode );
          }
        }
      }
    }

    $this->inputS['name_company']= $Convert->getConvert($this->inputS['name_company'],'KVa2');
    $this->inputS['kana_company']= $Convert->getConvert($this->inputS['kana_company'],'KCVa2');
    $this->inputS['comment']     = $Convert->getConvert($this->inputS['comment'],'KVa2');
    $this->inputS['area']        = $Convert->getConvert($this->inputS['area'],'KVa2');
    $this->inputS['address1']    = $Convert->getConvert($this->inputS['address1'],'KVa2');
    $this->inputS['address2']    = $Convert->getConvert($this->inputS['address2'],'KVa2');
    $this->inputS['id']          = $Convert->getConvert($this->inputS['id'],'KVa2');
    $this->inputS['password']    = $Convert->getConvert($this->inputS['password'],'KVa2');
    $this->inputS['name_family'] = $Convert->getConvert($this->inputS['name_family'],'KVa2');
    $this->inputS['name_first']  = $Convert->getConvert($this->inputS['name_first'],'KVa2');
    $this->inputS['kana_family'] = $Convert->getConvert($this->inputS['kana_family'],'KCVa2');
    $this->inputS['kana_first']  = $Convert->getConvert($this->inputS['kana_first'],'KCVa2');
    $this->inputS['mail']        = $Convert->getConvert($this->inputS['mail'],'KVa2');
    $this->inputS['fax_1']       = $Convert->getConvert($this->inputS['fax_1'],'KVa2');
    $this->inputS['fax_2']       = $Convert->getConvert($this->inputS['fax_2'],'KVa2');
    $this->inputS['fax_3']       = $Convert->getConvert($this->inputS['fax_3'],'KVa2');
    $this->inputS['tel_1']       = $Convert->getConvert($this->inputS['tel_1'],'KVa2');
    $this->inputS['tel_2']       = $Convert->getConvert($this->inputS['tel_2'],'KVa2');
    $this->inputS['tel_3']       = $Convert->getConvert($this->inputS['tel_3'],'KVa2');
    $this->inputS['mobile_1']    = $Convert->getConvert($this->inputS['mobile_1'],'KVa2');
    $this->inputS['mobile_2']    = $Convert->getConvert($this->inputS['mobile_2'],'KVa2');
    $this->inputS['mobile_3']    = $Convert->getConvert($this->inputS['mobile_3'],'KVa2');


    if( $this->inputS['flag_gender']=="" ){   $this->inputS['flag_gender'] = 3; }
    if( $this->inputS['flag_pictmail']=="" ){   $this->inputS['flag_pictmail'] = 'f'; }
    if( $this->inputS['flag_stepmail']=="" ){   $this->inputS['flag_stepmail'] = 'f'; }

    if( $this->inputS['birthday']!="" ){
      list($this->inputS['birthday_y'],$this->inputS['birthday_m'],$this->inputS['birthday_d']) = explode("-",$this->inputS['birthday']);
    }else if($this->inputS['birthday_y']!="" && $this->inputS['birthday_m']!="" && $this->inputS['birthday_d']!=""){
      $this->inputS['birthday'] = sprintf("%04d-%02d-%02d",$this->inputS['birthday_y'],$this->inputS['birthday_m'],$this->inputS['birthday_d']);
    }

    if( $this->inputS['zip']!="" ){
      $this->inputS['zip'] = str_replace('-','',$this->inputS['zip']);
    }

    if( $this->inputS['tel']!="" ){
      list($this->inputS['tel_1'],$this->inputS['tel_2'],$this->inputS['tel_3']) = explode("-",$this->inputS['tel']);
    }else if($this->inputS['tel_1']!="" && $this->inputS['tel_2']!="" && $this->inputS['tel_3']!=""){
      $this->inputS['tel'] = "{$this->inputS['tel_1']}-{$this->inputS['tel_2']}-{$this->inputS['tel_3']}";
    }

    if( $this->inputS['mobile']!="" ){
      list($this->inputS['mobile_1'],$this->inputS['mobile_2'],$this->inputS['mobile_3']) = explode("-",$this->inputS['mobile']);
    }else if($this->inputS['mobile_1']!="" && $this->inputS['mobile_2']!="" && $this->inputS['mobile_3']!=""){
      $this->inputS['mobile'] = "{$this->inputS['mobile_1']}-{$this->inputS['mobile_2']}-{$this->inputS['mobile_3']}";
    }

    if( $this->inputS['fax']!="" ){
      list($this->inputS['fax_1'],$this->inputS['fax_2'],$this->inputS['fax_3']) = explode("-",$this->inputS['fax']);
    }else if($this->inputS['fax_1']!="" && $this->inputS['fax_2']!="" && $this->inputS['fax_3']!=""){
      $this->inputS['fax'] = "{$this->inputS['fax_1']}-{$this->inputS['fax_2']}-{$this->inputS['fax_3']}";
    }

    return;
  }

  // *CONVERT* $this->writeS
  function convertWrite(){

    $this->writeS['name_company'] = $this->getTextfield($this->writeS['name_company']); 
    $this->writeS['kana_company'] = $this->getTextfield($this->writeS['kana_company']); 
    $this->writeS['area']         = $this->getTextfield($this->writeS['area']); 
    $this->writeS['address1']     = $this->getTextfield($this->writeS['address1']); 
    $this->writeS['address2']     = $this->getTextfield($this->writeS['address2']); 
    $this->writeS['id']           = $this->getTextfield($this->writeS['id']); 
    $this->writeS['password']     = $this->getTextfield($this->writeS['password']); 
    $this->writeS['name_family']  = $this->getTextfield($this->writeS['name_family']); 
    $this->writeS['name_first']   = $this->getTextfield($this->writeS['name_first']); 
    $this->writeS['kana_family']  = $this->getTextfield($this->writeS['kana_family']); 
    $this->writeS['kana_first']   = $this->getTextfield($this->writeS['kana_first']); 
    $this->writeS['mail']         = $this->getTextfield($this->writeS['mail']); 
    $this->writeS['fax_1']        = $this->getTextfield($this->writeS['fax_1']); 
    $this->writeS['fax_2']        = $this->getTextfield($this->writeS['fax_2']); 
    $this->writeS['fax_3']        = $this->getTextfield($this->writeS['fax_3']); 
    $this->writeS['tel_1']        = $this->getTextfield($this->writeS['tel_1']); 
    $this->writeS['tel_2']        = $this->getTextfield($this->writeS['tel_2']); 
    $this->writeS['tel_3']        = $this->getTextfield($this->writeS['tel_3']); 

    $this->writeS['mobile_1']     = $this->getTextfield($this->writeS['mobile_1']); 
    $this->writeS['mobile_2']     = $this->getTextfield($this->writeS['mobile_2']); 
    $this->writeS['mobile_3']     = $this->getTextfield($this->writeS['mobile_3']); 

    $this->writeS['id']           = $this->getTextfield($this->writeS['id']); 
    $this->writeS['password']     = $this->getTextfield($this->writeS['password']); 

    $this->writeS['comment']      = $this->getTextarea($this->writeS['comment']); 

    foreach( $this->writeS as $key=>$value ){
      $this->writeS[$key] = mb_convert_encoding($value, $this->outputCode, $this->charaCode );
    }

  }


  // *CHECK* $this->inputS
  function checkInput($mode=False){
    $ExPostgres = $this->dbConnect();

    require_once(_DIR_LIB_.'check/Check.php');
    $Check = new Check() ;

    if( !$Check->isInput($this->inputS['name_first']) )  $this->errorS['name']     = "{$this->nameS['name_first']} ��̤���ϤǤ�";
    if( !$Check->isInput($this->inputS['name_family']) ) $this->errorS['name'] = "{$this->nameS['name_family']} ��̤���ϤǤ�";
    if( !$Check->isInput($this->inputS['mail']) )        $this->errorS['mail'] = "{$this->nameS['mail']} ��̤���ϤǤ�";

    if( !$Check->isInput($this->inputS['zip']) )         $this->errorS['zip'] = "{$this->nameS['zip']} ��̤���ϤǤ�";
    if( !$Check->isInput($this->inputS['area']) )        $this->errorS['area'] = "{$this->nameS['area']} ��̤���ϤǤ�";
    if( !$Check->isInput($this->inputS['address1']) )    $this->errorS['address1'] = "{$this->nameS['address1']} ��̤���ϤǤ�";


    if( !$Check->isInput($this->inputS['kana_first']) ){
      $this->errorS['kana'] = "{$this->nameS['kana_first']} ��̤���ϤǤ�";
    }else if( !$Check->isKataKana($this->inputS['kana_first']) ){
      $this->errorS['kana'] = "{$this->nameS['kana_first']} �ϥ������ʤǤ����Ϥ���������";
    }

    if( !$Check->isInput($this->inputS['kana_family']) ){
      $this->errorS['kana'] = "{$this->nameS['kana_family']} ��̤���ϤǤ�";
    }else if( !$Check->isKataKana($this->inputS['kana_family']) ){
      $this->errorS['kana'] = "{$this->nameS['kana_family']} �ϥ������ʤǤ����Ϥ���������";
    }

    if( !$Check->isInput($this->inputS['tel']) && !$Check->isInput($this->inputS['mobile']) ){
        $this->errorS['tel'] = "{$this->nameS['tel']}��{$this->nameS['mobile']} �Ϥɤ��餫ɬ�������Ϥ���������";
        $this->errorS['mobile'] = "{$this->nameS['tel']}��{$this->nameS['mobile']} �Ϥɤ��餫ɬ�������Ϥ���������";
    }

    if( $Check->isInput($this->inputS['tel_3']) ){
      if( $Check->isInput($this->inputS['tel_3']) && !$Check->isNumber($this->inputS['tel_3']) ){
        $this->errorS['tel'] = "{$this->nameS['tel_3']} ��Ⱦ�ѱѿ��Ǥ����Ϥ�������";
      }else if( !$Check->isLen($this->inputS['tel_3'],7) ){
        $this->errorS['tel'] = "{$this->nameS['tel_3']} ��7������˼���Ƥ���������";
      }
    }

    if( $Check->isInput($this->inputS['tel_2']) ){
      if( $Check->isInput($this->inputS['tel_2']) && !$Check->isNumber($this->inputS['tel_2']) ){
        $this->errorS['tel'] = "{$this->nameS['tel_2']} ��Ⱦ�ѱѿ��Ǥ����Ϥ�������";
      }else if( !$Check->isLen($this->inputS['tel_2'],7) ){
        $this->errorS['tel'] = "{$this->nameS['tel_2']} ��7������˼���Ƥ���������";
      }
    }

    if( $Check->isInput($this->inputS['tel_1']) ){
      if( $Check->isInput($this->inputS['tel_1']) && !$Check->isNumber($this->inputS['tel_1']) ){
        $this->errorS['tel'] = "{$this->nameS['tel_1']} ��Ⱦ�ѱѿ��Ǥ����Ϥ�������";
      }else if( !$Check->isLen($this->inputS['tel_1'],7) ){
        $this->errorS['tel'] = "{$this->nameS['tel_1']} ��7������˼���Ƥ���������";
      }
    }

    if( $Check->isInput($this->inputS['mobile_3']) ){
      if( $Check->isInput($this->inputS['mobile_3']) && !$Check->isNumber($this->inputS['mobile_3']) ){
        $this->errorS['mobile'] = "{$this->nameS['mobile_3']} ��Ⱦ�ѱѿ��Ǥ����Ϥ�������";
      }else if( !$Check->isLen($this->inputS['mobile_3'],7) ){
        $this->errorS['mobile'] = "{$this->nameS['mobile_3']} ��7������˼���Ƥ���������";
      }
    }

    if( $Check->isInput($this->inputS['mobile_2']) ){
      if( $Check->isInput($this->inputS['mobile_2']) && !$Check->isNumber($this->inputS['mobile_2']) ){
        $this->errorS['mobile'] = "{$this->nameS['mobile_2']} ��Ⱦ�ѱѿ��Ǥ����Ϥ�������";
      }else if( !$Check->isLen($this->inputS['mobile_2'],7) ){
        $this->errorS['mobile'] = "{$this->nameS['mobile_2']} ��7������˼���Ƥ���������";
      }
    }

    if( $Check->isInput($this->inputS['mobile_1']) ){
      if( $Check->isInput($this->inputS['mobile_1']) && !$Check->isNumber($this->inputS['mobile_1']) ){
        $this->errorS['mobile'] = "{$this->nameS['mobile_1']} ��Ⱦ�ѱѿ��Ǥ����Ϥ�������";
      }else if( !$Check->isLen($this->inputS['mobile_1'],7) ){
        $this->errorS['mobile'] = "{$this->nameS['mobile_1']} ��7������˼���Ƥ���������";
      }
    }

    if( $Check->isInput($this->inputS['fax_3']) ){
      if( $Check->isInput($this->inputS['fax_3']) && !$Check->isNumber($this->inputS['fax_3']) ){
        $this->errorS['fax'] = "{$this->nameS['fax_3']} ��Ⱦ�ѱѿ��Ǥ����Ϥ�������";
      }else if( !$Check->isLen($this->inputS['fax_3'],7) ){
        $this->errorS['fax'] = "{$this->nameS['fax_3']} ��7������˼���Ƥ���������";
      }
    }

    if( $Check->isInput($this->inputS['fax_2']) ){
      if( $Check->isInput($this->inputS['fax_2']) && !$Check->isNumber($this->inputS['fax_2']) ){
        $this->errorS['fax'] = "{$this->nameS['fax_2']} ��Ⱦ�ѱѿ��Ǥ����Ϥ�������";
      }else if( !$Check->isLen($this->inputS['fax_2'],7) ){
        $this->errorS['fax'] = "{$this->nameS['fax_2']} ��7������˼���Ƥ���������";
      }
    }

    if( $Check->isInput($this->inputS['fax_1']) ){
      if( $Check->isInput($this->inputS['fax_1']) && !$Check->isNumber($this->inputS['fax_1']) ){
        $this->errorS['fax'] = "{$this->nameS['fax_1']} ��Ⱦ�ѱѿ��Ǥ����Ϥ�������";
      }else if( !$Check->isLen($this->inputS['fax_1'],7) ){
        $this->errorS['fax'] = "{$this->nameS['fax_1']} ��7������˼���Ƥ���������";
      }
    }


    if( $Check->isInput($this->inputS['zip']) ){
      if( $Check->isInput($this->inputS['zip']) && !$Check->isNumber($this->inputS['zip']) ){
        $this->errorS['zip'] = "{$this->nameS['zip']} ��Ⱦ�ѱѿ��Ǥ����Ϥ�������";
      }else if( !$Check->isLen($this->inputS['zip'],7) ){
        $this->errorS['zip'] = "{$this->nameS['zip']} ��3������˼���Ƥ���������";
      }
    }


    if( !$Check->isInput($this->inputS['mail']) ){
      $this->errorS['mail'] = "{$this->nameS['mail']} ��̤���ϤǤ�";
    }else if( !$Check->isMail($this->inputS['mail']) ){
      $this->errorS['mail'] = "{$this->nameS['mail']} �� {$this->writeS['mail']} ���������᡼�륢�ɥ쥹�ǤϤ���ޤ���";
    }else if( !$Check->isLen($this->inputS['mail'],100) ){
      $this->errorS['mail'] = "{$this->nameS['mail']} ��100������˼���Ƥ���������";
/*
    }else if( $mode=='new' ){
      $query  = "SELECT count(*) FROM td_user AS tmain ";
      $query .= " JOIN td_pictmail AS td01 ON td01.user_id=tmain.user_id ";
      $query .= " WHERE tmain.mail='{$this->inputS['mail']}' AND td01.flag_del!=1";
      $ExPostgres->executeQuery($query);
      $mCountS = pg_fetch_assoc( $ExPostgres->getResult(),0 );
      pg_free_result( $ExPostgres->getResult() );
      if( $mCountS['count']!=0 ){
        $this->errorS['mail']  = "���Ϥ��줿�᡼�륢�ɥ쥹�ϴ��˻��Ѥ���Ƥ���ޤ���";
      }
*/
    }

    if( !$Check->isInput($this->inputS['id']) ){
      $this->errorS['id'] = "{$this->nameS['id']} ��̤���ϤǤ�";
    }else if( !$Check->isEisui($this->inputS['id']) ){
      $this->errorS['id'] = "{$this->nameS['id']} ��Ⱦ�ѱѿ��Ǥ����Ϥ���������";
    }else{
      $iCount = mb_strlen($this->inputS['id']);
      if($iCount>16 || $iCount<4){
        $this->errorS['id']  = "{$this->nameS['id']}��4��16ʸ����Ⱦ�ѱѿ��Ǥ����Ϥ���������";
      }
      $query  = "SELECT count(*) FROM td_user AS tmain ";
      $query .= " WHERE tmain.id='{$this->inputS['id']}'";

      if(_SESSION_MODE_ == "user"  &&  $_POST['mode'] == "renew"){
        $query .= " AND tmain.user_id!='{$_SESSION['user']['user_id']}'";
      }
      if(_SESSION_MODE_ == "admin"  &&  $_POST['mode']=="renew"){
        $query .= " AND tmain.user_id!={$this->inputS['user_id']}";
      }

      $ExPostgres->executeQuery($query);
      $iCountS = pg_fetch_assoc( $ExPostgres->getResult(),0 );
      pg_free_result( $ExPostgres->getResult() );
      if( $iCountS['count']!=0 ){
        $this->errorS['id']  = "���Ϥ��줿ID�ϴ��˻��Ѥ���Ƥ���ޤ���";
      }
    }

    if( !$Check->isInput($this->inputS['password']) ){
      $this->errorS['password'] = "{$this->nameS['password']} ��̤���ϤǤ�";
    }else if( !$Check->isEisui($this->inputS['password']) ){
      $this->errorS['password'] = "{$this->nameS['password']} ��Ⱦ�ѱѿ��Ǥ����Ϥ���������";
    }else{
      $pCount = mb_strlen($this->inputS['password']);
      if($pCount>16 || $pCount<6){
        $this->errorS['password']  = "{$this->nameS['password']}��6��16ʸ����Ⱦ�ѱѿ��Ǥ����Ϥ���������";
      }
    }


    if( $Check->isInput($this->inputS['id']) && $Check->isInput($this->inputS['password']) ){

      if( $this->inputS['id']==$this->inputS['password'] ){
        $this->errorS['id'] = "{$this->nameS['id']}��{$this->nameS['password']}�Ͻ�ʣ���ʤ��ѿ��������Ϥ���������";
        $this->errorS['password'] = "{$this->nameS['id']}��{$this->nameS['password']}�Ͻ�ʣ���ʤ��ѿ��������Ϥ���������";
      }
    }


    if($_POST['mode'] == "new") {

        if( !$Check->isInput($this->inputS['flag_kiyaku']) ){

            $this->errorS['flag_kiyaku'] = "����Τ�Ʊ�դ򤤤������ʤ������Ͽ������ޤ���";

        }

    }

    $ExPostgres->close();
  }


  // *SET* ������Ͽ
  function setNewRegist(){


    require_once(_DIR_LIB_."util/Browse.php");
    $Browse = new Browse();

    $ExPostgres = $this->dbConnect();

    $this->inputS['user_id']     = $ExPostgres->getNextval('td_user_seq');

    $this->inputS['pictmail_id'] = $ExPostgres->getNextval('td_pictmail_seq');
    $this->inputS['send_max'] = 60;

    $this->inputS['user_ex1_id']     = $ExPostgres->getNextval('td_user_ex1_seq');
    $this->inputS['ip']   = $Browse->remote_address;
    $this->inputS['host'] = $Browse->remote_host;

    $this->inputS['referrer']   = "";
    $this->inputS['medium_id'] = "";

    if(isset($_COOKIE['sign_up']['referrer'])){
      $this->inputS['referrer']   = $_COOKIE['sign_up']['referrer'];
    }
    if(isset($_COOKIE['sign_up']['medium_id'])){
      $this->inputS['medium_id'] = $_COOKIE['sign_up']['medium_id'];
    }

    $ExPostgres->close();
  }

}
?>
