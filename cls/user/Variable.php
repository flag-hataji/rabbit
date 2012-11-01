<?PHP
/*

  変数関連

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
     * 初期化
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
     * 最初期
     */
    Function first(){

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | first() <br>\n";


      return ;
    }



    /*
     * リスト
     */
    Function listS(){

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | listS() <br>\n";


      return ;
    }


    /*
     * 入力
     */
    Function write(){

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | write() <br>\n";

      $this->defaultToInput();
      $this->inputToWrite($this->inputS);
      $this->defaultToHidden($this->writeS);

      return ;
    }



    /*
     * 修正登録
     */
    Function renew($pId=False){

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | renew({$pId}) <br>\n";

      $this->dbToInput($pId);
      $this->inputToWrite($this->inputS);
      $this->defaultToHidden($this->writeS);

      return ;
    }


    /*
     * 再入力
     */
    Function rewrite($postS=False){

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | rewrite({$postS}) <br>\n";

      $this->postToInput($postS['inputS']);
      $this->inputToWrite($this->inputS);
      $this->defaultToHidden($this->writeS);

      return ;
    }


    /*
     * 確認
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
     * 登録
     */
    Function finish($postS=False,$mode=False){
      global $libBrowse,$pField,$pQuery;

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | finish({$postS},{$mode}) <br>\n";

      if( $mode!='replan' ){

        $this->postToInput($postS['inputS']);
        if( $mode=='new' ){
          $this->inputS['user_id']     = $this->getDbId('td_user_seq');
          $this->inputS['pictmail_id'] = $this->getDbId('td_pictmail_seq');
        }

      }

      return ;
    }


// ----------------- 以下処理列 ----------------- //


    // * 設定：確認エラー
    Function errorToConfrim($iDataS=False){
      global $expCheck,$pField,$pCheckSp;

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | errorToConfrim({$iDataS}) <br>\n";

      $errorS = "";
      $errorS = $expCheck->errorAll( $iDataS, $pField->checkS, $pField->nameS );
      if( !$errorS ) $errorS = $pCheckSp->checkConfirm($iDataS);

      return $this->setError($errorS);
    }

    // * 設定：エラー
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


    // * 設定：デフォルト→基本データ
    Function defaultToInput(){
      global $pField,$expConvert;

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | defaultToInput() <br>\n";

      foreach($pField->defaultS as $key=>$value){
        $iDataS[$key] = $value;
      }

      $this->inputS = $expConvert->convert( $iDataS, $pField->convertS );

      return ;
    }


    // * 設定：POSTデータ→基本データ
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

      $iDataS['name'] = "";
      if( $iDataS['name_first'] && $iDataS['name_family'] ){
        $iDataS['name'] = "{$iDataS['name_family']} {$iDataS['name_first']}";
      }

      $iDataS['kana'] = "";
      if( $iDataS['kana_first'] && $iDataS['kana_family'] ){
        $iDataS['kana'] = "{$iDataS['kana_family']} {$iDataS['kana_first']}";
      }

      $iDataS['birthday'] = "";
      if( $iDataS['birthday_y']!="" && $iDataS['birthday_m']!="" && $iDataS['birthday_d']!="" ){
        $iDataS['birthday_m'] = sprintf("%02d",$iDataS['birthday_m']) ;
        $iDataS['birthday_d'] = sprintf("%02d",$iDataS['birthday_d']) ;
        $iDataS['birthday'] = "{$iDataS['birthday_y']}-{$iDataS['birthday_m']}-{$iDataS['birthday_d']}";
      }

      $iDataS['zip'] = "";
      if( $iDataS['zip_1']!="" && $iDataS['zip_2']!="" ){
        $iDataS['zip'] = "{$iDataS['zip_1']}{$iDataS['zip_2']}";
      }

      $iDataS['tel'] = "";
      if( $iDataS['tel_1']!="" && $iDataS['tel_2']!="" && $iDataS['tel_3']!="" ){
        $iDataS['tel'] = "{$iDataS['tel_1']}-{$iDataS['tel_2']}-{$iDataS['tel_3']}";
      }

      $iDataS['mobile'] = "";
      if( $iDataS['mobile_1']!="" && $iDataS['mobile_2']!="" && $iDataS['mobile_3']!="" ){
        $iDataS['mobile'] = "{$iDataS['mobile_1']}-{$iDataS['mobile_2']}-{$iDataS['mobile_3']}";
      }

      $iDataS['fax'] = "";
      if( $iDataS['fax_1']!="" && $iDataS['fax_2']!="" && $iDataS['fax_3']!="" ){
        $iDataS['fax'] = "{$iDataS['fax_1']}-{$iDataS['fax_2']}-{$iDataS['fax_3']}";
      }

      return $iDataS;
    }



    // * 設定：DB→基本データ
    Function dbToInput($pId=False){
      global $pField,$expPostgres,$expConvert;


      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | dbToInput({$pId}) <br>\n";

      $query  = "SELECT * FROM td_user WHERE flag_del!=1 ";


      $column  = "td_user.user_id,";
      $column .= "td_user.job_id,";
      $column .= "td_user.id,";
      $column .= "td_user.password,";
      $column .= "td_user.name_family,";
      $column .= "td_user.name_first,";
      $column .= "td_user.kana_family,";
      $column .= "td_user.kana_first,";
      $column .= "td_user.birthday,";
      $column .= "td_user.mail,";
      $column .= "td_user.tel,";
      $column .= "td_user.mobile,";
      $column .= "td_user.fax,";
      $column .= "td_user.zip,";
      $column .= "td_user.area,";
      $column .= "td_user.address1,";
      $column .= "td_user.address2,";
      $column .= "td_user.comment,";
      $column .= "td_user.flag_gender,";
      $column .= "td_user.flag_pictmail,";
      $column .= "td_user.flag_stepmail,";

      $column .= "td_pictmail.plan_pictmail_id,";
      $column .= "td_pictmail.account,";
      $column .= "td_pictmail.send_max,";
      $column .= "td_pictmail.month_max,";
      $column .= "td_pictmail.flag_permission,";
      $column .= "td_pictmail.flag_dm,";
      $column .= "td_pictmail.flag_permission";

exit;
      $query  = "SELECT {$column} FROM td_user ";
      $query .= " JOIN td_pictmail ON td_pictmail.user_id=td_user.user_id ";
      $query .= " WHERE td_pictmail.flag_del!=1 AND td_user.user_id={$pId} ";
      $query .= " ORDER BY td_user.user_id ";
      if( $this->debug ) echo"<font size='1'> -  query =  {$query}</font> <br>\n";
      $qDataS = $this->dbToInputEx($expPostgres->getOne( $query,PGSQL_ASSOC ));

      foreach($pField->defaultS as $key=>$value){
        if( isset($qDataS[$key]) ){
          $iDataS[$key] = $qDataS[$key];
        }
      }

      $this->inputS = $expConvert->convert( $iDataS, $pField->convertS );

      return ;
    }
    Function dbToInputEx($qDataS=False){
      global $pField,$expConvert;
      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | dbToInputEx({$qDataS}) <br>\n";

      if( $qDataS['birthday'] ){
        $birthdayEx = explode("-",$qDataS['birthday']);
        $qDataS['birthday_y'] = $birthdayEx[0];
        $qDataS['birthday_m'] = $birthdayEx[1];
        $qDataS['birthday_d'] = $birthdayEx[2];
      }


      $qDataS['zip_1'] = "";
      $qDataS['zip_2'] = "";
      if( $qDataS['zip'] ){
        $qDataS['zip_1'] = substr($qDataS['zip'],0,3);
        $qDataS['zip_2'] = substr($qDataS['zip'],3,4);
      }


      $qDataS['tel_1'] = "";
      $qDataS['tel_2'] = "";
      $qDataS['tel_3'] = "";
      if( $qDataS['tel'] ){
        $telEx = explode("-",$qDataS['tel']);
        $qDataS['tel_1'] = $telEx[0];
        $qDataS['tel_2'] = $telEx[1];
        $qDataS['tel_3'] = $telEx[2];
      }


      $qDataS['mobile_1'] = "";
      $qDataS['mobile_2'] = "";
      $qDataS['mobile_3'] = "";
      if( $qDataS['mobile'] ){
        $mobileEx = explode("-",$qDataS['mobile']);
        $qDataS['mobile_1'] = $mobileEx[0];
        $qDataS['mobile_2'] = $mobileEx[1];
        $qDataS['mobile_3'] = $mobileEx[2];
      }


      $qDataS['fax_1'] = "";
      $qDataS['fax_2'] = "";
      $qDataS['fax_3'] = "";
      if( $qDataS['fax'] ){
        $faxEx = explode("-",$qDataS['fax']);
        $qDataS['fax_1'] = $faxEx[0];
        $qDataS['fax_2'] = $faxEx[1];
        $qDataS['fax_3'] = $faxEx[2];
      }

      return $qDataS;
    }



    // * 設定：基本データ→入力用データ
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


    // * 設定：基本データ→表示用データ
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

      if( $iDataS['birthday_y']!="" && $iDataS['birthday_m']!="" && $iDataS['birthday_d']!="" ){
        $iDataS['birthday'] = "{$iDataS['birthday_y']}年{$iDataS['birthday_m']}月{$iDataS['birthday_d']}日";
      }

      if( $iDataS['zip_1']!="" && $iDataS['zip_2']!=""){
        $iDataS['zip'] = "{$iDataS['zip_1']}-{$iDataS['zip_2']}";
      }

      $genderS = $mstAry->genderAry();
      foreach( $genderS as $num=>$value ){
        if( $iDataS['flag_gender'] == $value['id'] ){
          $iDataS['flag_gender'] = $value['name'];
        }
      }

      $permissionS = $mstAry->permissionAry();
      foreach( $permissionS as $num=>$value ){
        if( isset($iDataS['flag_permission']) && ($iDataS['flag_permission'] == $value['id']) ){
          $iDataS['flag_permission'] = $value['name'];
        }
      }

      $userS = $mstAry->userAry();
      foreach( $userS as $num=>$value ){
        if( isset($iDataS['plan_id']) && ($iDataS['plan_id'] == $value['id']) ){
          $iDataS['plan_id'] = $value['name'];
        }
      }

      $dmS = $mstAry->dmAry();
      foreach( $dmS as $num=>$value ){
        if( isset($iDataS['flag_dm']) && ($iDataS['flag_dm'] == $value['id']) ){
          $iDataS['flag_dm'] = $value['name'];
        }
      }

      return $iDataS;
    }




    /*
     * 設定：デフォルト設定→基本データ
     */
    Function defaultToHidden($wDataS=False){
      global $pField,$expConvert;

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | defaultToHidden( {$wDataS} ) <br>\n";

      foreach($pField->hiddenS as $num=>$value){
        $key  = $value['key'];
        $wKey = ereg_replace("inputS\[|\]","",$key );
        if( isset($wDataS[$wKey]) ){
          $this->hiddenS[$key] = $wDataS[$wKey];
        }else{
          $this->hiddenS[$key] = $value['str'];
        }
      }

      return ;
    }


    /*
     * 設定：指定データ→hiddenデータ
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


    // * 設定：DB→hiddenデータ
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


    // * ユニークIDの取得[DB]
    Function getDbId($seq=False){
      Global $expPostgres;

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | getDbId({$seq}) <br>\n ";

      return $expPostgres->getNextVal( $seq );
    }


    // * ユニーク文字列の取得と判定
    Function makeUnique($num=8){
      Global $cTool;

      if( _DEBUG_ ) echo" - "._ROOT_PG_PARTS_."partsVariable.php | getMakeId() <br>\n ";


      return $tmp_id;
    }



  }

?>
