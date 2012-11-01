<?PHP
/*

  追加・拡張 : WEB使用


*/
/*

  追加・拡張 : 入力チェック

*/

  class ExpCheck extends Check {


    /*
     *  使用前提として
     *  $checkS['チェック型']['連番'] = array('key'=>'フォールド名');
     *  又は $checkS['チェック型']['連番'] = array('key'=>'フォールド名','limit'=>数値);
     *  又は $checkS['チェック型']['連番'] = array('key'=>'フォールド名','ex'=>拡張チェック);
     *  $nameS['フォールド名'] = '名称';
     *  $dataS['フォールド名'] = 'チェック該当の値';
     *  の上記データを用意する
     */
    function errorAll( $dataS=False, $checkS=False, $nameS=False ){

      if(!$dataS ){
        return ;
      }

      if(!$checkS ){
        return ;
      }

      if(!$nameS ){
        return ;
      }

      $type  = "";
      $error = "";
      foreach($checkS as $type=>$typeS ){

        foreach( $typeS as $tNum=>$tVal ){

          $key = $checkS[$type][$tNum]['key'];

          $name = $nameS[$key];

          $str  = "";
          if( isset($dataS[$key]) ){
            $str  = $dataS[$key];
          }

          $limit = "";
          if( isset($checkS[$type][$tNum]['limit']) ) $limit = $checkS[$type][$tNum]['limit'];

          $ex = "";
          if( isset($checkS[$type][$tNum]['ex']) ) $ex = $checkS[$type][$tNum]['ex'];

          $errorKey = $type."_".$key;

          switch($type){

            case     'Input' : $error[$errorKey] = $this->errorInput( $str, $name );    break;
            case      'Mail' : $error[$errorKey] = $this->errorMail( $str, $name );     break;
            case    'Docomo' : $error[$errorKey] = $this->errorDocomo( $str, $name );   break;
            case  'Vodafone' : $error[$errorKey] = $this->errorVodafone( $str, $name ); break;
            case        'Au' : $error[$errorKey] = $this->errorAu( $str, $name );       break;
            case       'Zip' : $error[$errorKey] = $this->errorZip( $str, $name );      break;
            case       'Tel' : $error[$errorKey] = $this->errorTel( $str, $name );      break;
            case       'Url' : $error[$errorKey] = $this->errorUrl( $str, $name );      break;
            case      'Date' : $error[$errorKey] = $this->errorDate( $str, $name );     break;
            case        'Ei' : $error[$errorKey] = $this->errorEi( $str, $name );       break;
            case      'Eisu' : $error[$errorKey] = $this->errorEisu( $str, $name );     break;
            case 'EisuSpace' : $error[$errorKey] = $this->errorEisuSpace( $str, $name );break;
            case   'EiSpace' : $error[$errorKey] = $this->errorEiSpace( $str, $name );  break;
            case 'EisuKigou' : $error[$errorKey] = $this->errorEisuKigou( $str, $name );break;
            case  'KataKana' : $error[$errorKey] = $this->errorKataKana( $str, $name ); break;
            case        '16' : $error[$errorKey] = $this->error16( $str, $name );       break;
            case       'Len' : $error[$errorKey] = $this->errorLen( $str, $name, $limit );   break;
            case    'Mblen'  : $error[$errorKey] = $this->errorMblen( $str, $name, $limit ); break;
            case    'Number' : $error[$errorKey] = $this->errorNumber( $str, $name, $limit ); break; 
            case 'WideCheck' : $error[$errorKey] = $this->errorWideCheck( $str, $name, $limit ); break;
          }
          if( !$error[$errorKey] ) unset($error[$errorKey]);


        }

      }

      return $error;
    }



    // 入力
    function errorInput($str=False,$name=False){
      $error = "";
      if(!$this->isInput($str)) $error = "{$name}が未入力です";
      return $error;
    }

    // メアド
    function errorMail($str=False,$name=False){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->isMail($str)) $error = "{$name}が正しくありません";
      return $error;
    }

    // Docomoメアド
    function errorDocomo($str=False,$name=False){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->isDocomo($str)) $error = "{$name}が正しくありません";
      return $error;
    }

    // Vodafoneメアド
    function errorVodafone($str=False,$name=False){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->isVodafone($str)) $error = "{$name}が正しくありません";
      return $error;
    }

    // auメアド
    function errorAu($str=False,$name=False){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->isAu($str)) $error = "{$name}が正しくありません";
      return $error;
    }

    // 郵便番号
    function errorZip($str=False,$name=False){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->isZip($str)) $error = "{$name}が正しくありません";
      return $error;
    }


    // 電話番号
    function errorTel($str=False,$name=False){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->isTel($str)) $error = "{$name}が正しくありません";
      return $error;
    }

    // URL
    function errorUrl($str=False,$name=False){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->isUrl($str)) $error = "{$name}が正しくありません";
      return $error;
    }

    // 日付
    function errorDate($str=False,$name=False){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->isDate($str)) $error = "{$name}が正しくありません";
      return $error;
    }

    // 半角英字
    function errorEi($str=False,$name=False){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->isEi($str)) $error = "{$name}が半角英字ではありません";
      return $error;
    }

    // 半角英字(空白コミ)
    function errorEiSpace($str=False,$name=False){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->isEiSpace($str)) $error = "{$name}が半角英字ではありません";
      return $error;
    }

    // 半角英数字
    function errorEisu($str=False,$name=False){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->isEisu($str)) $error = "{$name}が半角英数字ではありません";
      return $error;
    }

    // 半角英数字(空白コミ)
    function errorEisuSpace($str=False,$name=False){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->isEisuSpace($str)) $error = "{$name}が半角英数字ではありません";
      return $error;
    }

    // 英数字と もろもろ記号かどうかのチェック
    function errorEisuKigou($str=False,$name=False){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->isEisuKigou($str)) $error = "{$name}が正しくありません";
      return $error;
    }

    // カタカナ
    function errorKataKana($str=False,$name=False){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->isKataKana($str)) $error = "{$name}がカタカナではありません";
      return $error;
    }

    // 16進数チェック
    function error16($str=False,$name=False){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->is16($str)) $error = "{$name}が正しくありません";
      return $error;
    }



    // 文字数
    function errorLen( $str=False,$name=False,$limit=0 ){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->isLen($str,$limit)) $error = "{$name}が{$limit}文字以上の入力です";
      return $error;
    }

    // 文字数(マルチバイト)
    function errorMblen( $str=False,$name=False,$limit=0 ){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->isMbLen($str,$limit)) $error = "{$name}が{$limit}文字以上の入力です";
      return $error;
    }

    // 半角数字
    function errorNumber($str=False, $name=False, $ex=False){
      $error = "";
      if(!$str || !$name) return ;
      if( $ex ){
        if(!$this->isNumber($str,$ex)) $error = "{$name}は半角数字{$ex}桁で入力してください";
      }else{
        if(!$this->isNumber($str,$ex)) $error = "{$name}が半角数字ではありません";
      }
      return $error;
    }

    // 汎用チェック
    function errorWideCheck($str=False,$name=False,$ex=False){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->isWideCheck($str,$ex)) $error = "{$name}が正しくありません";
      return $error;
    }

  }

?>
