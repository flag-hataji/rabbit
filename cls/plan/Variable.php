<?PHP
/*

  �ѿ���Ϣ

*/

  class Variable {

    var $debug   = '';
    var $inputS  = '';
    var $viewS   = '';
    var $writeS  = '';
    var $hiddenS = '';
    var $errorS  = '';

    Function Variable($debug=False){

      if( $debug ) $this->debug = True;

      $this->format();

      return ;
    }


    /*
     * �����
     */
    Function format(){

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | format() <br>\n";

      $this->inputS  = '';
      $this->viewS    = '';
      $this->writeS  = '';
      $this->hiddenS = '';
      $this->errorS   = '';

      return ;
    }


    /*
     * �ǽ��
     */
    Function first(){

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | first() <br>\n";


      return ;
    }



    /*
     * �ꥹ��
     */
    Function listS(){

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | listS() <br>\n";


      return ;
    }


    /*
     * ����
     */
    Function write(){

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | write() <br>\n";

      $this->defaultToInput();
      $this->inputToWrite($this->inputS);
      $this->defaultToHidden($this->writeS);

      return ;
    }



    /*
     * ������Ͽ
     */
    Function renew($pId=False){

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | renew({$pId}) <br>\n";

      $this->dbToInput($pId);
      $this->inputToWrite($this->inputS);
      $this->defaultToHidden($this->writeS);

      return ;
    }


    /*
     * ������
     */
    Function rewrite($postS=False){

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | rewrite({$postS}) <br>\n";

      $this->postToInput($postS['inputS']);
      $this->inputToWrite($this->inputS);
      $this->defaultToHidden($this->writeS);

      return ;
    }


    /*
     * ��ǧ
     */
    Function confirm($postS=False){
      global $libTool;

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | confirm({$postS}) <br>\n";
      $this->postToInput($postS['inputS']);
      $this->inputToWrite($this->inputS);

      if( $this->errorToConfrim($this->inputS) ){
        $this->defaultToHidden($this->writeS);
        return True;
      }else{
        $this->inputToView($this->inputS);
        $this->dataToHidden($this->writeS,'inputS');
        return False;
      }


      return ;
    }


    /*
     * ��Ͽ
     */
    Function finish($postS=False,$mode=False){
      global $libBrowse,$pField,$pQuery;

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | finish({$postS},{$mode}) <br>\n";

      $this->postToInput($postS['inputS']);
      if( $mode=='new' ){
        $this->inputS['user_id']     = $this->getDbId('td_user_seq');
        $this->inputS['pictmail_id'] = $this->getDbId('td_pictmail_seq');
      }

      return ;
    }


// ----------------- �ʲ������� ----------------- //


    // * ���ꡧ��ǧ���顼
    Function errorToConfrim($iDataS=False){
      global $expCheck,$pField,$pCheckSp;

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | errorToConfrim({$iDataS}) <br>\n";

      $errorS = "";
      $errorS = $expCheck->errorAll( $iDataS, $pField->checkS, $pField->nameS );
      if( !$errorS ) $errorS = $pCheckSp->checkConfirm($iDataS);

      return $this->setError($errorS);
    }

    // * ���ꡧ���顼
    Function setError($errorS=False,$name='Error_name'){

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | setError({$errorS},{$name}) <br>\n";

      $return = False;

      if( $errorS && is_array($errorS) ){
        foreach($errorS as $key=>$value){
          $this->errorS[$key] = $value;
        }
        $return = True;
      }else if( $errorS ){
        $this->errorS[$name] = $errorS;
        $return = True;
      }

      return $return;
    }


    // * ���ꡧ�ǥե���Ȣ����ܥǡ���
    Function defaultToInput(){
      global $pField,$expConvert;

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | defaultToInput() <br>\n";

      foreach($pField->defaultS as $key=>$value){
        $iDataS[$key] = $value;
      }

      $this->inputS = $expConvert->convert( $iDataS, $pField->convertS );

      return ;
    }


    // * ���ꡧPOST�ǡ��������ܥǡ���
    Function postToInput($iDataS=False){
      global $pField,$expConvert;

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | postToInput({$iDataS}) <br>\n";

      $iDataS = $this->postToInputEx( $iDataS );

      $this->inputS = $expConvert->convert( $iDataS, $pField->convertS );
      foreach($this->inputS as $key=>$value){
        if( $value ){
          $this->inputS[$key] = $value;
        }else{
          $this->inputS[$key] = "";
        }
      }

      return ;
    }

    Function postToInputEx($iDataS=False){
      global $pField,$expConvert;
      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | postToInputEx({$iDataS}) <br>\n";

      return $iDataS;
    }



    // * ���ꡧDB�����ܥǡ���
    Function dbToInput($pId=False){
      global $pField,$expPostgres,$expConvert;


      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | dbToInput({$pId}) <br>\n";

      $query  = "SELECT * FROM td_pictmail ";
      $query .= " WHERE td_pictmail.flag_del!=1 AND td_pictmail.pictmail_id={$pId} ";
      if( $this->debug ) echo"<font size='1'> -  query =  {$query}</font> <br>\n";
      $qDataS = $this->dbToInputEx($expPostgres->getOne( $query,PGSQL_ASSOC ));

      foreach($pField->defaultS as $key=>$value){
        if( $qDataS[$key]!="" ){
          $iDataS[$key] = $qDataS[$key];
        }
      }

      $this->inputS = $expConvert->convert( $iDataS, $pField->convertS );

      return ;
    }
    Function dbToInputEx($qDataS=False){
      global $pField,$expConvert;
      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | dbToInputEx({$qDataS}) <br>\n";

      return $qDataS;
    }



    // * ���ꡧ���ܥǡ����������ѥǡ���
    Function inputToWrite($iDataS=False){
      global $expConvert, $pField;

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | inputToWrite( {$iDataS} ) <br>\n";

/*
      foreach($iDataS as $key=>$value){
        $wDataS[$key] = $value;
      }
*/
      $this->writeS = $expConvert->convert( $iDataS, $pField->writeS );

      return ;
    }


    // * ���ꡧ���ܥǡ�����ɽ���ѥǡ���
    Function inputToView($iDataS=False){
      global $expConvert, $pField;

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | inputToView({$iDataS}) <br>\n";

      $iDataS = $this->inputToViewEx( $iDataS );

      $this->viewS = $expConvert->convert( $iDataS, $pField->viewS );

      return ;
    }
    Function inputToViewEx($iDataS=False){
      global $expConvert, $mstAry, $pField;
      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | inputToViewEx({$iDataS}) <br>\n";


      $iDataS['price_month']      = "��".$iDataS['price_month'];
      $iDataS['price_month6']     = "��".$iDataS['price_month6'];
      $iDataS['price_year']       = "��".$iDataS['price_year'];
      $iDataS['account']          = $iDataS['account']."��";
      $iDataS['send_max']         = $iDataS['send_max']."��";
      $iDataS['send_now']         = $iDataS['send_now']."��";
      $iDataS['month_max']        = $iDataS['month_max']."��";
      $iDataS['month_now']        = $iDataS['month_now']."��";

      if( $iDataS['flag_dm']==1 ){
        $iDataS['flag_dm']="��";
      }else{
        $iDataS['flag_dm']="����";
      }


      if( $iDataS['flag_permission']==1 ){
        $iDataS['flag_permission']="����";
      }else{
        $iDataS['flag_permission']="�Ե���";
      }


      return $iDataS;
    }




    /*
     * ���ꡧ�ǥե�������ꢪ���ܥǡ���
     */
    Function defaultToHidden($wDataS=False){
      global $pField,$expConvert;

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | defaultToHidden( {$wDataS} ) <br>\n";

      foreach($pField->hiddenS as $num=>$value){
        $key  = $value['key'];
        $wKey = ereg_replace("inputS\[|\]","",$key );
        if( $wDataS[$wKey] ){
          $this->hiddenS[$key] = $wDataS[$wKey];
        }else{
          $this->hiddenS[$key] = $value['str'];
        }
      }

      return ;
    }


    /*
     * ���ꡧ����ǡ�����hidden�ǡ���
     */
    Function dataToHidden($wDataS=False,$mode='input'){
      global $pField,$expConvert;

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | dataToHidden({$wDataS},{$mode}) <br>\n";

      $hDataS = "";
      foreach( $wDataS as $key=>$value ){
        $hKey = "{$mode}[{$key}]";
        $hDataS[$hKey] = $value;
      }

      $this->hiddenS = $expConvert->convert( $hDataS, $pField->writeS );

      return ;
    }


    // * ���ꡧDB��hidden�ǡ���
    Function setDbToHidden($aData=False){
      global $pField,$expConvert;

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | setDbToHidden({$aData}) <br>\n";
      if( !isset($aData) || !$aData ) die(" - "._ROOT_PG_."Variable.php | setDbToHidden({$aData}) <b>Error</b><br>\n");

      $hData = "";
      foreach($pField->hiddenS as $value ){
        $key = ereg_replace("input\[|\]","", $value['key']);
        $hData[$value['key']] = $aData[$key];
      }

      $this->hiddenS = $expConvert->convert( $hData, $pField->writeS );

      return ;
    }


    // * ��ˡ���ID�μ���[DB]
    Function getDbId($seq=False){
      Global $expPostgres;

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | getDbId({$seq}) <br>\n ";

      return $expPostgres->getNextVal( $seq );
    }


    // * ��ˡ���ʸ����μ�����Ƚ��
    Function makeUnique($num=8){
      Global $cTool;

      if( _DEBUG_ ) echo" - "._ROOT_PG_PARTS_."partsVariable.php | getMakeId() <br>\n ";


      return $tmp_id;
    }



  }

?>
