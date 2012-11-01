<?PHP
/*
  強制変換関係クラス
  getConvert(変換したい文字列,オプション);
  オプションはデフォルトでKV3です。
  オプション : 以下のオプションを変換時に指定します。デフォルトは"KV"です。
  "r" :  「全角」英字を「半角」に変換
  "R" :  「半角」英字を「全角」に変換
  "n" :  「全角」数字を「半角」に変換
  "N" :  「半角」数字を「全角」に変換
  "a" :  「全角」英数字を「半角」に変換
  "A" :  「半角」英数字を「全角」に変換
  "s" :  「全角」スペースを「半角」に変換 (U+3000 -> U+0020)
  "S" :  「半角」スペースを「全角」に変換 (U+0020 -> U+3000)
  "k" :  「全角片仮名」を「半角片仮名」に変換
  "K" :  「半角片仮名」を「全角片仮名」に変換
  "h" :  「全角ひら仮名」を「半角片仮名」に変換
  "H" :  「半角片仮名」を「全角ひら仮名」に変換
  "c" :  「全角かた仮名」を「全角ひら仮名」に変換
  "C" :  「全角ひら仮名」を「全角かた仮名」に変換
  "V" :  濁点付きの文字を一文字に変換。"K","H"と共に使用します。

  "1" :  文字列をスラッシュでクォートする     addslashes
  "2" :  文字列の最初の文字を大文字にする   ucfirst
  "3" :  文字列の先頭および末尾にあるホワイトスペースを取り除く   trim
  "4" :  文字列を大文字にする   strtoupper
  "5" :  文字列を小文字にする   strtolower
  "6" :  特殊文字をHTMLエンティティに変換する htmlspecialchars
  "7" :  mb_trim
  "8" :  addslashesでクォートされた文字列のクォート部分を取り除く
  "9" :  連続する半角空白を削除

  ex.
  $str = "  　　ﾊﾝｶｸ　１２３　　　　";
  $str = $cConvert->getConvert($str,'KV3');
  echo"$str";// "　　ハンカク　１２３　　　　" と出力されます。
________________________________________________________________*/


/**
 * コンバートクラス
 */
class Convert
{

  var $str      = "";
  var $option   = "KV3";
  var $mbOption = "";

  /**
   * コンストラクタ
   * mb関係のモジュールが使えるかチェック
   * 内部文字コードを指定がない限りEUCに設定
   */
  function Convert( $code = null ){
    if( substr(phpversion(),0,1) == 3){
      die("PHP VERSION False = ".phpversion() );
    }
    if( $code ){
        mb_internal_encoding($code);
    } else {
      if( mb_internal_encoding() != "UTF8"){
        mb_internal_encoding("UTF8");
      }
    }
  }

  /**
   * 変換する
   * $str を $option にしたがって変換
   * $option 一覧はヘッダー部分のコメントを参照
   * param mixed $str
   * param str $option
   * return $str 変換された文字列
   */
  function getConvert($str, $option=""){

    $this->str = $str ;
    if($option!=""){
      $this->option = $option ;
    }
    if($str==""){
      return ;
    }

    // optionの解体
    $length = strlen($this->option) ;
    $this->mbOption = "";
    $tmp  = "";
    $num  = "";
    $i = 0 ;
    while( $i < $length ){
      $tmp = substr($this->option,$i,1);
      if( ereg("^[0-9]",$tmp) ){
        $num[$i] = $tmp ;
      }else{
        $this->mbOption .= $tmp ;
      }
      ++$i ;
    }

    if($this->mbOption!=""){
      $this->str = mb_convert_kana($this->str, $this->mbOption);
    }

    if( count($num) ){
      foreach( $num as $key => $val ){
        $this->getConvertData( $val );
      }
    }

    return $this->str ;
  }


  /**
   * 指定引数に対応する変換を行う。
   * param int $num
   */
  function getConvertData( $num ){

    switch ($num){
      case "1" :  $this->str = addslashes($this->str); break ;
      case "2" :  $this->str = ucfirst($this->str); break ;
      case "3" :  $this->str = trim($this->str); break ;
      case "4" :  $this->str = strtoupper($this->str); break ;
      case "5" :  $this->str = strtolower($this->str); break ;
      case "6" :  $this->str = htmlspecialchars($this->str); break ;
      case "7" :  $this->str = mb_trim($this->str); break ;
      case "8" :  $this->str = stripslashes($this->str); break ;
      case "9" :  $this->str = ereg_replace("[ ]{2,}",' ',$this->str);
    }
    return ;
  }

  /**
   * マルチバイトの全角も含むtrimを行う
   * 文字列の先頭および末尾にあるホワイトスペースを取り除く
   * param string $str 変換する文字列
   * return string $str 変換された文字列
   */
  function mb_trim($str){

    $str = mb_ereg_replace("^[　 ]+","",$str);
    $str = mb_ereg_replace("[　 ]+$","",$str);

    return $str ;
  }


}
