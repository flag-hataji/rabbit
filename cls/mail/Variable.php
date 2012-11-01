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
    Function first($aData=False){
      global $cWeb;

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | first() <br>\n";


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
    /*
     * 入力テスト
     */
    Function test($postS=False){

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | rewrite({$postS}) <br>\n";

      $this->postToInput($postS['inputS']);
      $this->inputToWrite($this->inputS);
      $this->defaultToHidden($this->writeS);

      if( $this->errorToConfrim($this->inputS) ){
        return True;
      }else{
        return False;
      }

      return ;
    }


    /*
     * 確認
     */
    Function confirm($postS=False,$filsS=False){
      global $libTool;

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | confirm({$postS},{$filsS}) <br>\n";

      $this->postToInput($postS['inputS']);
      $this->inputS['file_mail'] = date('YmdHis')."_id".$this->inputS['user_id']."_".$libTool->randamWord(8).".dat";
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
     * メールリスト仮アップエラー
     */
    Function tempMailError($errorS=False,$name='Error_name'){

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | tempMailError({$errorS},{$name}) <br>\n";

      $this->setError($errorS,$name);
      $this->hiddenS = '';
      $this->defaultToHidden($this->writeS);

      return ;
    }


    /*
     * 登録
     */
    Function finish($postS=False,$mode=False){
      global $libBrowse,$pField,$pQuery;

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | finish({$postS},{$mode}) <br>\n";

      $this->postToInput($postS['inputS']);
      $this->inputS['log_id'] = $this->getDbId('td_log_seq');
      $this->inputS['ip']     = $libBrowse->remote_address;
      $this->inputS['host']   = $libBrowse->remote_host;

      $this->inputS['message_id'] = $this->getDbId('td_message_message_id_seq');

      return ;
    }


// ----------------- 以下処理列 ----------------- //


    // * 設定：確認エラー
    Function errorToConfrim($iDataS=False){
      global $expCheck,$pField;

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | errorToConfrim({$iDataS}) <br>\n";

      $return = False;
      $errorS = "";
      $errorS = $expCheck->errorAll( $iDataS, $pField->checkS, $pField->nameS );

      
      if( !checkdate ( $this->writeS['send_date_m'], $this->writeS['send_date_d'], $this->writeS['send_date_y']) ){
        $errorS['date'] = "ご予約日は存在しない日付となっとります。";
      }

      if( $this->writeS['flag_html']==1 && $this->writeS['message_html']=="" ){
        $errorS['flag_html'] = "HTMLメール本文をご入力ください。";
      }

      if( $errorS ){
        $this->setError($errorS);
        $return = True;
      }

      return $return;
    }

    // * 設定：エラー
    Function setError($errorS=False,$name='Error_name'){

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | setError({$errorS},{$name}) <br>\n";

      if( $errorS && is_array($errorS) ){
        foreach($errorS as $key=>$value){
          $this->errorS[$key] = $value;
        }
        $return = True;
      }else if( $errorS ){
        $this->errorS[$name] = $errorS;
      }

      return ;
    }


    // * 設定：デフォルト→基本データ
    Function defaultToInput(){
      global $pField,$expPostgres,$expConvert;

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | defaultToInput() <br>\n";

      foreach($pField->defaultS as $key=>$value){
        $iDataS[$key] = $value;
      }


      $query = "SELECT user_id FROM td_user WHERE id='{$_SESSION['user']['id']}' AND password='{$_SESSION['user']['password']}'";
      $qDataS = $expPostgres->getOne( $query );
      $iDataS['user_id'] = $qDataS['user_id'];

      $this->inputS = $expConvert->convert( $iDataS, $pField->convertS );

      return ;
    }


    // * 設定：POSTデータ→基本データ
    Function postToInput($iDataS=False){
      global $pField,$expConvert;

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | postToInput({$iDataS}) <br>\n";

      $this->inputS = $expConvert->convert( $iDataS, $pField->convertS );

      $this->inputS['message'] = str_replace("\r\n","\n",$this->inputS['message']);
      $this->inputS['message'] = str_replace("\r","\n",$this->inputS['message']);

      return ;
    }


    // * 設定：DB→基本データ
    Function setDbToInput($promotion_id=False){
      global $pField,$expConvert,$adPostgres;

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | setDbToInput({$promotion_id}) <br>\n";
      if( !$promotion_id ) die(" - "._ROOT_PG_."Variable.php | setDbToInput({$promotion_id}) <b>Error</b><br>\n");

      $query  = "SELECT * FROM td_promotion WHERE del_flag!=1 AND promotion_id={$promotion_id} ";
      $qData = $adPostgres->getOne( $query,PGSQL_ASSOC );

      $this->inputS = $expConvert->convert( $qData, $pField->aConvert );

      if( $this->inputS['item_id'] ){
        $item_id = str_replace("{","",$this->inputS['item_id']);
        $item_id = str_replace("}","",$item_id);

        if( $item_id=='all' ){
            $this->inputS['item_use_all'] = 't';
        }else{
          $item_id = explode(",",$item_id);

          $i = 1;
          foreach($item_id as $num=>$id ){
            $id_key  = "item_id_{$i}";
            $use_key = "item_use_{$i}";
            $this->inputS[$id_key] = $id;
            $this->inputS[$use_key] = 't';
            $i++;
          }
        }
      }

      $start_date = explode("-",$this->inputS['start_date']);
      $this->inputS['start_date_y'] = $start_date[0];
      $this->inputS['start_date_m'] = $start_date[1];
      $this->inputS['start_date_d'] = $start_date[2];

      return ;
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

      $iDataS['send_date'] = "";
      if( $iDataS['send_date_y']!="" && $iDataS['send_date_m']!="" && $iDataS['send_date_d']!="" ){
        $iDataS['send_date_m'] = sprintf("%02d",$iDataS['send_date_m']) ;
        $iDataS['send_date_d'] = sprintf("%02d",$iDataS['send_date_d']) ;
        $iDataS['send_date_i'] = sprintf("%02d",$iDataS['send_date_i']) ;
        $iDataS['send_date_h'] = sprintf("%02d",$iDataS['send_date_h']) ;
        $iDataS['send_date'] = "{$iDataS['send_date_y']}-{$iDataS['send_date_m']}-{$iDataS['send_date_d']} {$iDataS['send_date_h']}:{$iDataS['send_date_i']}";
      }

      $this->writeS = $expConvert->convert( $iDataS, $pField->writeS );

      return ;
    }


    // * 設定：基本データ→表示用データ
    Function inputToView($iDataS=False){
      global $expConvert, $pField;

      if( $this->debug ) echo" - "._ROOT_PG_."Variable.php | inputToView({$iDataS}) <br>\n";

/*
      foreach($iDataS as $key=>$value){
        $vDataS[$key] = $value;
      }
*/

      if( $iDataS['send_date_y']!="" && $iDataS['send_date_m']!="" && $iDataS['send_date_d']!="" ){
        $iDataS['send_date_m'] = sprintf("%02d",$iDataS['send_date_m']) ;
        $iDataS['send_date_d'] = sprintf("%02d",$iDataS['send_date_d']) ;
        $iDataS['send_date_i'] = sprintf("%02d",$iDataS['send_date_i']) ;
        $iDataS['send_date_h'] = sprintf("%02d",$iDataS['send_date_h']) ;
        $iDataS['send_date'] = "{$iDataS['send_date_y']}/{$iDataS['send_date_m']}/{$iDataS['send_date_d']} {$iDataS['send_date_h']}:{$iDataS['send_date_i']}";
      }

      $this->viewS = $expConvert->convert( $iDataS, $pField->viewS );

      return ;
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
        if( $wDataS[$wKey] ){
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
