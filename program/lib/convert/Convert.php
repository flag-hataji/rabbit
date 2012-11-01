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

  "1" :  文字列の先頭および末尾にあるホワイトスペースを取り除く   trim
  "2" :  文字列の先頭および末尾にあるホワイトスペース全角を取り除く   mbTrim
  "3" :  連続する半角空白を一つにまとめる(４つの半角を１つに等)
  "4" :  連続する全角空白を一つにまとめる(５つの半角を一つに等)
  "5" :  半角空白除去
  "6" :  全角空白除去

  ex
  全角カタカナ で 全角スペースを半角に 前後のスペースタブ(全角も)等除去　名前など
  KV2
  これで数値を半角に統一した意場合
  KVn2
  だけど通常　数値及び英字を半角だと
  KVa2

  更新履歴
  2005/07/02 Sunao Kiyosue 
________________________________________________________________*/


class Convert{

  var $encoding = "" ;
  var $str      = "" ;
  var $option   = "" ;
  var $mbOption = "" ;
  var $num      = "" ;

  function Convert($encoding = "EUC_JP"){
    if( substr(phpversion(),0,1) == 3){
      die("PHP VERSION False");
    }
    mb_internal_encoding($encoding);
  }

  //public
  function setEncoding($encoding = "EUC_JP"){
    $this->encoding = $encoding ;
    mb_internal_encoding($this->encoding);
  }

  //  
   function makeOption(){
    $length = strlen($this->option) ;
    $this->mbOption = null ;
    $this->num      = null ;
    $tmp  = "";
    $i = 0 ;
    while( $i < $length ){
      $tmp = substr($this->option,$i,1);
      if( ereg("^[0-9]", $tmp) ){
        $this->num[$i] = $tmp ;
      }else{
        $this->mbOption .= $tmp ;
      }
      ++$i ;
    }
  }

  // public
  function getConvert($str,$option){

    $this->str    = $str    ;
    $this->option = $option ;


    $this->makeOption();
    if($this->mbOption!=""){
      $this->str = mb_convert_kana($this->str, $this->mbOption);
    }
    if( count($this->num) ){
      foreach( $this->num as $key => $val ){
        $this->setConvert( $val );
      }
    }
    return $this->str ;
  }


  // 
   function setConvert( $num ){

    switch ($num){
      case "1" :  $this->str = trim($this->str); break ;
      case "2" :  $this->str = $this->mbTrim($this->str); break ;
      case "3" :  $this->str = ereg_replace("[ ]{2,}",' ',$this->str); break ;
      case "4" :  $this->str = mb_ereg_replace("[　]{2,}",'　',$this->str); break ;
      case "5" :  $this->str = str_replace(" ","",$this->str); break ;//空白除去
      case "6" :  $this->str = mb_ereg_replace("　","",$this->str); break ;//空白除去
    }
    return ;
  }


  // mbTrim  
   function mbTrim($str){
    $str = mb_ereg_replace("^[　 \t\n\r\0\x0B]+","",$str);
    $str = mb_ereg_replace("[　 \t\n\r\0\x0B]+$","",$str);
    return $str ;
  }

}
?>