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

  // *SET* �ڡ�����
  function setSessionPageNum($place=False){
    if( isset($_GET['page']) && is_numeric($_GET['page']) ){
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['page'] = $_GET['page'];
    }else if( isset($_POST['page']) && is_numeric($_POST['page']) ){
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['page'] = $_POST['page'];
    }else if( !isset($_SESSION[_SESSION_MODE_][_SESSION_NAME_]['page']) ){
      $_SESSION[_SESSION_MODE_][_SESSION_NAME_]['page'] =1;
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


    $this->nameS['log_id']       = '��������ID';
    $this->nameS['user_id']      = '�桼����ID';
    $this->nameS['subject']      = '������̾';
    $this->nameS['message']      = '������å��������ƥ����ȷ���';
    $this->nameS['message_html'] = '������å�������HTML����';
    $this->nameS['file_mail']    = '�᡼��ꥹ��';
    $this->nameS['name_from']    = '������̾';
    $this->nameS['mail_from']    = '������';
    $this->nameS['mail_confirm']   = '������ǧ�᡼��������';
    $this->nameS['mail_test']    = '�ƥ��ȥ᡼��������';
    $this->nameS['send_date']    = '����ͽ����';
    $this->nameS['flag_html']    = 'HTML�᡼������';
    $this->nameS['flag_omit']    = '�������ɥ쥹��ά';

    $this->nameS['check_mail_error'] = '���顼�᡼�����������å�';
    $this->nameS['mail_error']       = '�������顼�᡼�������';
    $this->nameS['mail_error1']      = '�������顼�᡼�����������ϡ�';
    $this->nameS['mail_error2']      = '�������顼�᡼�������ʼ�ư�����ѡ�';

    $this->showArrayDebug($this->nameS,'$this->nameS');

  }
  // *SET* CC���餭�����
  function setCcMessage(){

    $return = "";
    if( isset($_GET['cc_category_id'])  && $_GET['cc_category_id']!="" && is_numeric($_GET['cc_category_id']) ){
      $query = "SELECT comment1 from td_cc_category WHERE delete_flag='f' AND category_id={$_GET['cc_category_id']} AND user_id={$_SESSION['user']['user_id']};";
      $ExPostgres = $this->dbConnect();
      $ExPostgres->executeQuery($query);
      if( $ExPostgres->getRow($query)==1 ){
        $dataS = pg_fetch_assoc( $ExPostgres->getResult(),0 );
        $return = $dataS['comment1'];
      }
      pg_free_result( $ExPostgres->getResult() );
      $ExPostgres->close();
    }

    return $return;
  }

  // *SET* $this->defaultS => $this->inputS
  function setDefault(){


    $this->defaultS['log_id']     = '';
    $this->defaultS['user_id']      = $_SESSION['user']['user_id'];
    $this->defaultS['mail_from']    = $_SESSION['user']['mail'];
    $this->defaultS['mail_confirm']   = $_SESSION['user']['mail'];
    $this->defaultS['mail_test']    = $_SESSION['user']['mail'];
    $this->defaultS['send_date']    = '';
    $this->defaultS['send_date_y']  = date('y');
    $this->defaultS['send_date_m']  = date('m');
    $this->defaultS['send_date_d']  = date('d');
    $this->defaultS['send_date_h']  = date('H');
    $this->defaultS['send_date_i']  = date('i');
    $this->defaultS['file_mail']  = '';

    $this->defaultS['check_mail_error'] = 2;
    $this->defaultS['mail_error']       = "";
    $this->defaultS['mail_error1']      = $_SESSION['user']['mail'];
    $this->defaultS['mail_error2']      = str_replace("#user_id#",$_SESSION['user']['user_id'],_PG_MAIL_ERROR_);

    if( _TEST_ ){
      $this->defaultS['subject']    = '�����ƥ��� '.date('Ymd');
      $this->defaultS['message']    = '�����ƥ��ȥ�å����� '.date('Ymd')."\n\n%name%\n\n%param1%\n\n%param2%\n\n%param3%\n\n%param4%\n\n%param5%\n\n";
      $this->defaultS['message_html']    = "
        <html>
        <head>
        <title>itmMailService - TEST</title>
        </head>
        <body>
        <b>�����ƥ��ȥ�å����� ".date('Ymd')."</b><br>
        <font color='#FF0000'>�����ƥ��ȥ�å����� ".date('Ymd')."</font><br>
        <font size='4'>�����ƥ��ȥ�å����� ".date('Ymd')."</font><br>
        %name%<br><br>
        %param1%<br><br>
        %param2%<br><br>
        %param3%<br><br>
        %param4%<br><br>
        %param5%
        </body>
        </html>
      ";
      $this->defaultS['name_from']  = 'ITM�ƥ���������';
      $this->defaultS['flag_html']  = 1;
      $this->defaultS['flag_omit']  = 1;
    }else{
      $this->defaultS['subject']      = '';
      $this->defaultS['message']      = '';
      $this->defaultS['message_html'] = '';
      $this->defaultS['name_from']    = '';
      $this->defaultS['flag_html']    = 2;
      $this->defaultS['flag_omit']    = 2;
    }

    $ccMessage = $this->setCcMessage();
    if($ccMessage!=""){
      $this->defaultS['message'] = $ccMessage;
    }

    $this->showArrayDebug($this->defaultS,'$this->defaultS');

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

    $this->inputS['subject']      = $Convert->getConvert($this->inputS['subject'],'KV');
    $this->inputS['message']      = $Convert->getConvert($this->inputS['message'],'KV');
    $this->inputS['message']      = $this->nl2LF($this->inputS['message']);
    $this->inputS['message_html'] = $Convert->getConvert($this->inputS['message_html'],'KV');
    $this->inputS['message_html'] = $this->nl2LF($this->inputS['message_html']);
    $this->inputS['name_from']    = $Convert->getConvert($this->inputS['name_from'],'KVa2');
    $this->inputS['mail_from']    = $Convert->getConvert($this->inputS['mail_from'],'KVa2');
    $this->inputS['mail_confirm']   = $Convert->getConvert($this->inputS['mail_confirm'],'KVa2');
    $this->inputS['mail_test']    = $Convert->getConvert($this->inputS['mail_test'],'KVa2');
    $this->inputS['mail_error1'] = $Convert->getConvert($this->inputS['mail_error1'],'KVa2');

    if( $this->inputS['send_date']!="" ){
      list($this->inputS['send_date_y'],$this->inputS['send_date_m'],$this->inputS['send_date_d']) = explode("-",$this->inputS['send_date']);
    }else if($this->inputS['send_date_y']!="" && $this->inputS['send_date_m']!="" && $this->inputS['send_date_d']!=""){
      $this->inputS['send_date']  = sprintf("%04d-%02d-%02d",$this->inputS['send_date_y'],$this->inputS['send_date_m'],$this->inputS['send_date_d']);
      $this->inputS['send_date'] .= " ".sprintf("%02d:%02d",$this->inputS['send_date_h'],$this->inputS['send_date_i']);
    }

    if( $this->inputS['flag_html']=="" ){   $this->inputS['flag_html'] = 2; }
    if( $this->inputS['flag_omit']=="" ){   $this->inputS['flag_omit'] = 2; }

    switch($this->inputS['check_mail_error']){
      case 1:
        $this->inputS['mail_error'] = $this->inputS['mail_error1'];
        break;
      case 2:
        $this->inputS['mail_error'] = $this->inputS['mail_error2'];
        break;
    }

  }

  // *CONVERT* $this->writeS
  function convertWrite(){

    $this->writeS['subject']     = $this->getTextfield($this->writeS['subject']); 
    $this->writeS['name_from']   = $this->getTextfield($this->writeS['name_from']); 
    $this->writeS['mail_from']   = $this->getTextfield($this->writeS['mail_from']); 
    $this->writeS['mail_confirm']  = $this->getTextfield($this->writeS['mail_confirm']); 
    $this->writeS['mail_test']   = $this->getTextfield($this->writeS['mail_test']); 
    $this->writeS['send_date_y'] = $this->getTextfield($this->writeS['send_date_y']); 
    $this->writeS['send_date_m'] = $this->getTextfield($this->writeS['send_date_m']); 
    $this->writeS['send_date_d'] = $this->getTextfield($this->writeS['send_date_d']); 
    $this->writeS['flag_html']   = $this->getTextfield($this->writeS['flag_html']); 
    $this->writeS['flag_omit']   = $this->getTextfield($this->writeS['flag_omit']); 

    $this->writeS['check_mail_error']= $this->getTextfield($this->writeS['check_mail_error']); 
    $this->writeS['mail_error1']     = $this->getTextfield($this->writeS['mail_error1']); 

    $this->writeS['message']       = $this->getTextarea($this->writeS['message']); 
    $this->writeS['message_html']  = $this->getTextarea($this->writeS['message_html']); 

    foreach( $this->writeS as $key=>$value ){
      $this->writeS[$key] = mb_convert_encoding($value, $this->outputCode, $this->charaCode );
    }

  }


  // *CHECK* $this->inputS
  function checkInput(){

    require_once(_DIR_LIB_.'check/Check.php');
    $Check = new Check() ;

    if( !$Check->isInput($this->inputS['user_id']) )    $this->errorS['user_id']    = "��������֤��۾�Ǥ������٥����󤷤ʤ����Ƥ���������";
    if( !$Check->isInput($this->inputS['subject']) )    $this->errorS['subject']    = "{$this->nameS['subject']} ��̤���ϤǤ�";
    if( !$Check->isInput($this->inputS['message']) )    $this->errorS['message']    = "{$this->nameS['message']} ��̤���ϤǤ�";
    if( !$Check->isInput($this->inputS['name_from']) )  $this->errorS['name_from']  = "{$this->nameS['name_from']} ��̤���ϤǤ�";

    if( $Check->isInput($this->inputS['subject']) && !$Check->isMblen($this->inputS['subject'],500) )
      $this->errorS['subject'] = "{$this->nameS['subject']} ��500ʸ�������ʸ�Ϥ˼���Ƥ���������";

    if( $Check->isInput($this->inputS['message']) && !$Check->isMblen($this->inputS['message'],50000) )
      $this->errorS['message'] = "{$this->nameS['message']} ��50000ʸ�������ʸ�Ϥ˼���Ƥ���������";


    if( !$Check->isInput($this->inputS['mail_from']) ){
      $this->errorS['mail_from'] = "{$this->nameS['mail_from']} ��̤���ϤǤ�";
    }else if( !$Check->isMail($this->inputS['mail_from']) ){
      $this->errorS['mail_from'] = "{$this->nameS['mail_from']} �� {$this->writeS['mail_from']} ���������᡼�륢�ɥ쥹�ǤϤ���ޤ���";
    }else if( !$Check->isLen($this->inputS['mail_from'],100) ){
      $this->errorS['mail_from'] = "{$this->nameS['mail_from']} ��100ʸ�������ʸ�Ϥ˼���Ƥ���������";
    }

    if( !$Check->isInput($this->inputS['mail_confirm']) ){
      $this->errorS['mail_confirm'] = "{$this->nameS['mail_confirm']} ��̤���ϤǤ�";
    }else if( !$Check->isMail($this->inputS['mail_confirm']) ){
      $this->errorS['mail_confirm'] = "{$this->nameS['mail_confirm']} �� {$this->writeS['mail_confirm']} ���������᡼�륢�ɥ쥹�ǤϤ���ޤ���";
    }else if( !$Check->isLen($this->inputS['mail_confirm'],100) ){
      $this->errorS['mail_confirm'] = "{$this->nameS['mail_confirm']} ��100ʸ�������ʸ�Ϥ˼���Ƥ���������";
    }

    if( !$Check->isInput($this->inputS['mail_test']) ){
      $this->errorS['mail_test'] = "{$this->nameS['mail_test']} ��̤���ϤǤ�";
    }else if( !$Check->isMail($this->inputS['mail_test']) ){
      $this->errorS['mail_test'] = "{$this->nameS['mail_test']} �� {$this->writeS['mail_test']} ���������᡼�륢�ɥ쥹�ǤϤ���ޤ���";
    }else if( !$Check->isLen($this->inputS['mail_test'],100) ){
      $this->errorS['mail_test'] = "{$this->nameS['mail_test']} ��100ʸ�������ʸ�Ϥ˼���Ƥ���������";
    }

    if( !$Check->isInput($this->inputS['mail_error']) ){
      $this->errorS['mail_error'] = "{$this->nameS['mail_error']} ��̤���ϤǤ�";
    }else if( !$Check->isMail($this->inputS['mail_error']) ){
      $this->errorS['mail_error'] = "{$this->nameS['mail_error']} �� {$this->writeS['mail_error']} ���������᡼�륢�ɥ쥹�ǤϤ���ޤ���";
    }else if( !$Check->isLen($this->inputS['mail_error'],100) ){
      $this->errorS['mail_error'] = "{$this->nameS['mail_error']} ��100ʸ�������ʸ�Ϥ˼���Ƥ���������";
    }

    if( $this->inputS['flag_html']==1 && !$Check->isInput($this->inputS['message_html']) ){
      $this->errorS['message_html']    = "{$this->nameS['message_html']} ��̤���ϤǤ�";
    }

  }

  // *SET* ��λ��
  function setFinish(){
    $ExPostgres = $this->dbConnect();

    $this->inputS['log_id']     = $ExPostgres->getNextval('td_log_seq');
    $this->inputS['message_id'] = $ExPostgres->getNextval('td_message_message_id_seq');
    $this->inputS['mailq_id']   = $ExPostgres->getNextval('td_mailq_mailq_id_seq');

    $this->uploadS['file']             = $_POST['uploadS']['file'];
    $this->uploadS['numS']['fileLine'] = $_POST['uploadS']['numS']['fileLine'];
    $this->uploadS['numS']['ok']       = $_POST['uploadS']['numS']['ok'];
    $this->uploadS['numS']['pc']       = $_POST['uploadS']['numS']['pc'];
    $this->uploadS['numS']['mobile']   = $_POST['uploadS']['numS']['mobile'];
    $this->uploadS['flagS']['pc']      = $_POST['uploadS']['flagS']['pc'];
    $this->uploadS['flagS']['mobile']  = $_POST['uploadS']['flagS']['mobile'];
    $this->uploadS['flagS']['type']    = $_POST['uploadS']['flagS']['type'];

    $this->inputS['mail_start_pc']     = str_replace("#log_id#", $this->inputS['log_id'], _PG_MAIL_START_PC_);
    $this->inputS['mail_start_mo']     = str_replace("#log_id#", $this->inputS['log_id'], _PG_MAIL_START_MO_);
    $this->inputS['mail_finish_pc']    = str_replace("#log_id#", $this->inputS['log_id'], _PG_MAIL_FINISH_PC_);
    $this->inputS['mail_finish_mo']    = str_replace("#log_id#", $this->inputS['log_id'], _PG_MAIL_FINISH_MO_);

    $ExPostgres->close();
  }

  // *SET* ����¸�ե�����̾
  function setTempFileName(){
    $this->inputS['temp_file'] = "{$this->inputS['user_id']}_".date('YmdHis').".csv";
  }

}
?>
