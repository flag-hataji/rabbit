<?PHP
/*

  出力関連


*/

  class Output {

    var $debug = "";
    var $base = "";
    var $html = "";
    var $page_max    = 20;
    var $code_output = "EUC-JP";

    // * コンストラクタ
    Function Output($base=False,$code_output=False,$page_max=False,$debug=False){

      if( $debug )       $this->debug       = True;
      if( $base )        $this->base        = $base;
      if( $page_max )    $this->page_max    = $page_max;
      if( $code_output ) $this->code_output = $code_output;

      return ;
    }


    /*
     * html出力
     */
    function html($mode=False,$place=False){
      global $libUtil, $libCode, $expUtil, $pField, $pVariable;

      if( $this->debug ) echo" - "._ROOT_PG_."Output.php | html({$mode},{$place}) <br>\n";

      $html = "";
      switch( $mode ){

        // 送信
        case 'send':
          switch( $place ){
            case   'error': $html = _HTML_PG_WRITE_;   break;
            case   'write': $html = _HTML_PG_WRITE_;   break;
            case 'confirm': $html = _HTML_PG_CONFIRM_; break;
            case 'rewrite': $html = _HTML_PG_WRITE_;   break;
            case    'over': $html = _HTML_PG_ERROR_;   break;
            case  'finish': $html = _HTML_PG_FINISH_;  break;
          }
          break;

      }

      if( !$html ) die('NOT HTML');

      // 表示・出力用文字変換
      $pField->nameS     = $libCode->encodeBase( $pField->nameS,    $this->code_output, 'EUC-JP');
      $pVariable->viewS  = $libCode->encodeBase( $pVariable->viewS, $this->code_output, 'EUC-JP');
      $pVariable->writeS = $libCode->encodeBase( $pVariable->writeS,$this->code_output, 'EUC-JP');


      require_once _HTML_PG_BASE_ ;

      return;
    }


    /*
     * エラー文 出力
     */
    Function error(){
      global $libUtil, $libCode, $expUtil, $pField, $pVariable;

      if( $this->debug ) echo"<font size='1'> - "._ROOT_PG_."Output.php | error()</font> <br>\n";

      $error = "<div align='left'><font color='#FF0000'>";

      if( $pVariable->errorS ){
        if( isset($pVariable->errorS) && $pVariable->errorS ){
          foreach($pVariable->errorS as $key=>$word){
            $error .= "　　{$word}<br>\n";
          }
        }
        $error .= "</font></div><br>";

      }
      echo $libCode->encodeBase( $error, $this->code_output, 'EUC-JP');

      return ;
    }


    /*
     * hidden出力
     */
    Function hidden($next=False ){
      global $libUtil, $libCode, $expUtil, $pField, $pVariable;

      if( $this->debug ) echo"<font size='1'> - "._ROOT_PG_."Output.php | hidden({$next})</font> <br>\n";

      $hidden = "";
      $hidden .= "<input type='hidden' name='".session_name()."' value='".session_id()."'>\n";
      $hidden .= "<input type='hidden' name='encoding'           value='もじこーどはんていようていすう'>\n";

      if( $next ) $hidden .= "<input type='hidden' name='hidden' value='{$next}'>\n";

      if( isset($pVariable->hiddenS) && is_array($pVariable->hiddenS) ){
        foreach($pVariable->hiddenS as $name=>$value ){
          $hidden .= "<input type='hidden' name='{$name}' value='{$value}'>\n";
          if( $this->debug ) echo"<font size='2'>＜input type='hidden' name='{$name}' value='{$value}'＞</font><br>\n";
        }
      }

      echo $libCode->encodeBase( $hidden, $this->code_output, 'EUC-JP');

      return;
    }

  }
?>
