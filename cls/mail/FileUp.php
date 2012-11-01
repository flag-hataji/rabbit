<?PHP
/*

  メールリストファイル関連

*/

  class fileUp{

    var $debug     = "";
    var $sendMax   = 20;
    var $delimit   = ",";
    var $errorWord = "";
    var $fieldNum  = 5;
    var $wFile     = "";

    Function fileUp($sendMax=False, $delimit=False,$debug=False){

      if( $debug )   $this->debug = True;
      if( $sendMax ) $this->sendMax = $sendMax;
      if( $delimit ) $this->delimit = $delimit;

      if( $debug ){
        echo "sendMax = {$this->sendMax}<br>\n";
      }

      return ;
    }


    /*
     * メールリスト 仮アップ
     */
    Function tempMail($fileS=False, $wFile=False){
      global $pVariable;

      if( $this->debug ) echo " - "._ROOT_PG_."fileUp.php | upTemp({$fileS},{$wFile}) <br>\n";

      $this->format($this->debug);

      $this->wFile = $wFile;

      $error    = False;
      $errorNum = 0;
      $count    = 0;

      if( !$fileS || $fileS['error']==4 ){
        $errorNum = 1;

      }else if(!$wFile){
        $errorNum = 90;

      }else{




        $dataS=file($fileS['tmp_name']);
        $i=1;
        foreach( $dataS as $val ){
          $val = mb_convert_encoding( $val, "EUC-JP","SJIS" );
          $val = str_replace("\r\n", "\n", $val);
          $val = str_replace("\r",   "\n", $val);
          $val = str_replace("\n",   "#br#", $val);
          $val = str_replace("",   "・", $val);
          $val = str_replace('\\',   '\\\\', $val);
          $val = str_replace("'",   "’", $val);
          $val = str_replace('"',  '”', $val);
          $val = htmlspecialchars($val,ENT_QUOTES);

          $exData = explode("#br#",$val);
          if( count($exData)>2 ){
            foreach($exData as $exVal){
              $enDataS[$i] = $exVal;
              $i++;
            }
          }else{
            $val = str_replace("#br#", "", $val);
            $enDataS[$i] = $val;
          }
          $i++;
        }


        foreach( $enDataS as $oneData ){

          if( $oneData ){

            $count++;
            if( $count==($this->sendMax+1) ){
              $errorNum = 2;
              break;
            }

            // チェック
            $errorNum = $this->check( $oneData );

            if( $errorNum ){
              break;
            }else{
              // 書き込み
              $this->write( $wFile, $oneData );
            }

          }

        }
        $this->write( $wFile, "送信者様（送信完了確認用）,_#MASTER#_{$pVariable->inputS['mail_from']}" );




/*
        $handle = fopen( $fileS['tmp_name'], 'r' );

        while ( !feof($handle) ) {

          $oneData = fgets($handle);

          // エンコード
          $oneData = $this->encode( $oneData);

          if( $oneData ){

            $count++;
            if( $count==($this->sendMax+1) ){
              $errorNum = 2;
              break;
            }

            // チェック
            $errorNum = $this->check( $oneData );

            if( $errorNum ){
              break;
            }else{
              // 書き込み
              $this->write( $wFile, $oneData );
            }

          }

        }

        fclose ($handle);
*/


        @chmod ($wFile, 0777); 

      }

      if( $errorNum!=0 ){
        $error = $this->error($errorNum);
        $this->delete($wFile,$this->debug);
      }

      return $error;
    }


    // * 初期化
    Function format(){
      if( $this->debug ) echo " - "._ROOT_PG_."fileUp.php | format() <br>\n";

      $this->errorWord = "";

      return ;
    }

    // * エンコード
    Function encode( $str=False ){
      if( $this->debug ) echo " - "._ROOT_PG_."fileUp.php | encode({$str}) <br>\n";

      $str = str_replace("\r\n", "", $str);
      $str = str_replace("\r",   "", $str);
      $str = str_replace("\n",   "", $str);
      $str = htmlspecialchars($str,ENT_QUOTES);


/*
echo mb_http_output().$str." = ";
echo mb_detect_encoding( $str );
echo " -> ";
*/
/*
      if( mb_detect_encoding($str, "SJIS,JIS")!="EUC-JP" ){
//echo " =Convert= ";

//        $str = mb_convert_encoding( $str, "EUC-JP" );
//        $str = mb_convert_encoding( $str, "EUC-JP","auto" );
        $str = mb_convert_encoding( $str, "EUC-JP","SJIS" );
      }
*/
/*
echo $str." = ";
echo mb_detect_encoding( $str );
echo "<br>";
*/
      $str = mb_convert_encoding( $str, "EUC-JP","SJIS" );





      return $str;
    }


    // * チェック
    Function check( $str=False ){
      if( $this->debug ) echo " - "._ROOT_PG_."fileUp.php | check({$str}) <br>\n";

      if( isset($_SESSION['mailError']) ){
        unset($_SESSION['mailError']);
      }

      $errorNum = 0;
      $explodeS = explode($this->delimit,$str);

      if( !isset($explodeS[1]) || 
          !$explodeS[1] || 
          !preg_match("/^[\/\.!#%&\-_0-9a-z]+\@[!#%&\-_0-9a-z]+(\.[!#%&\-_0-9a-z]+)+$/i",$explodeS[1])
      ){
        $_SESSION['mailError'] = $explodeS[1];
        $errorNum = 3;
      }
/*
      if( 
        preg_match( "/([\x87][\x40-\x9F]|[\xED-\xEE][\x40-\xFC]|[\xFA-\xFC][\x40-\x4B]|[\xF0-\xF9][\x40-\xFC]|[\x85-\x88][\x40-\x9E]|[\xEA-\xFC][\xA5-\xFC])/",$str)
      ){
        $_SESSION['mailError'] = $explodeS[1];
        $errorNum = 4;
      }
*/
      return $errorNum;
    }


    // * 書き込み
    Function write( $wFile, $str=False ){

      $errorNum = 0;

      // 新規
      if( !file_exists($wFile) ){ 
        $mode = 'w';
      // 追加
      }else{
        $mode = 'a';
      }

      // パラメータ追加   
      $explodeS = explode(",",$str);
      $exStr = "{$explodeS[0]},$explodeS[1],";
      $i=2;
      while ( $i<=$this->fieldNum+1 ){
        if( isset($explodeS[$i]) && $explodeS[$i]!="" ){
          //$explodeS[$i] = htmlspecialchars($explodeS[$i]);
          $exStr .= "{$explodeS[$i]}";
        }
        $exStr .= ",";

        $i++;
      }
      $str = substr($exStr,0,-1)."\n";

      if( $this->debug ) echo " - "._ROOT_PG_."fileUp.php | write({$wFile},{$str}) - mode = {$mode} <br>\n";

      if( !$fp = fopen($wFile,$mode) ){
        $errorNum = 91;
      }

      if( !fwrite($fp, $str) ){
        $errorNum = 92;
      }

      flock($fp, LOCK_UN);
      fclose($fp);

      return $errorNum;
    }



    // * 削除
    Function delete( $wFile ){

      if( $this->debug ) echo " - "._ROOT_PG_."fileUp.php | delete({$wFile}) <br>\n";

      if( $wFile && file_exists($wFile) ){ 
        chmod ($wFile, 0777); 
        unlink($wFile);
      }

      return ;
    }


    // * エラー
    Function error($error=False){

      if( $this->debug ) echo " - "._ROOT_PG_."fileUp.php | error({$error}) <br>\n";

      switch( $error ){
        // 想定エラー
        case 1: $this->errorWord = "メールリストがアップされていません";   break;
        case 2: $this->errorWord = "送信件数は{$this->sendMax}件までです"; break;
        case 3: $this->errorWord = "不正なメールアドレスが存在します：「 ".$_SESSION['mailError']." 」" ;     break;
        case 4: $this->errorWord = "外字もしくは機種依存文字が存在します：「 ".$_SESSION['mailError']." 」" ;     break;

        // 想定外エラー
        case 90: $this->errorWord = "予期せぬシステムエラーが発生いたしました[ case:{$error} ]"; break;
        case 91: $this->errorWord = "予期せぬシステムエラーが発生いたしました[ case:{$error} ]"; break;
        case 92: $this->errorWord = "予期せぬシステムエラーが発生いたしました[ case:{$error} ]"; break;
      }

      return $this->errorWord;
    }



  }

?>
