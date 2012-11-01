<?PHP
/**
*  チェッククラス
*
*  文字コード：EUC-JP
*
* @package /lib/org/
* @author  Kiyosue
* @since   PHP5
* @version 2006.12.01
*/
class Check
{
  /**
   * 引数が 空 及び null でないか === でなく == で比較している。
   * @param $str mixed チェックする文字列
   * @return boolean 空の場合 false 空でない場合 true を返す。
   */
  function isInput($str){
    return trim( $str )=="" ? false : true ;
  }

  /**
   * 引数が メアドかどうか、正規表現チェック
   * @param $str mixed チェックする文字列
   * @return boolean メアドの場合 true それ以外 false を返す。
   */
  function isMail($str){
    return  preg_match("/^[\.!#%&\-_0-9a-z]+\@[!#%&\-_0-9a-z]+(\.[!#%&\-_0-9a-z]+)+$/i",$str) ;
  }

  /**
   * 引数が ケータイのメアドかどうか
   * @param $str mixed チェックする文字列
   * @return boolean メアドの場合 true それ以外 false を返す。
   */
  function isMobileMail($str){
    if($this->isDocomo($str)){
      return true ;
    }
    if($this->isVodafone($str)){
      return true ;
    }
    if($this->isAu($str)){
      return true ;
    }
    if($this->isSoftBank($str)){
      return true ;
    }
    return fales ;
  }

  /**
   * 引数が ケータイのドコモのメアドかどうか
   * @param $str mixed チェックする文字列
   * @return boolean メアドの場合 true それ以外 false を返す。
   */
  function isDocomo($str){
    return ereg( "^@docomo.ne.jp",substr($str,-13) ) ;
  }

  /**
   * 引数が ケータイのボーダフォンのメアドかどうか
   * @param $str mixed チェックする文字列
   * @return boolean メアドの場合 true それ以外 false を返す。
   */
  function isVodafone($str){
    return ereg( "^@[dqnchtrks]{1}.vodafone.ne.jp",substr($str,-17) )  ;
  }

  /**
   * 引数が ケータイのAUのメアドかどうか
   * @param $str mixed チェックする文字列
   * @return boolean メアドの場合 true それ以外 false を返す。
   */
  function isAu($str){
    return ereg( "^ezweb.ne.jp",substr($str,-11) )  ;
  }

  /**
   * 引数が ケータイのソフトバンクのメアドかどうか
   * @param $str mixed チェックする文字列
   * @return boolean メアドの場合 true それ以外 false を返す。
   */
  function isSoftBank($str){
    return ereg( "^@[dqnchtrks]{1}.softbank.ne.jp",substr($str,-17) )  ;
  }


  /**
   * 指定された文字列の長さかチェック
   * 3字(バイト)以上、10字(バイト)いかなら isLen('hoge', 3, 10);とする
   * @param $str mixed チェックする文字列
   * @param $max integer 最大文字数(この文字数を含む)
   * @param $min integer 最小文字数(この文字数を含む)
   * @return boolean $max と $min の間の文字数なら true それ以外 false を返す。
   */
  function isLen( $str, $min, $max = 0){
    if(! $this->isLenMin($str, $min) ){
      return false ;
    }
    if(! $this->isLenMax($str, $max) ){
      return false ;
    }
    return true ;
  }

  /**
   * 指定された文字列の長さが$len以上かチェック
   * 10字(バイト)以上なら isLenMin('hoge', 10);とする
   * @param $str mixed チェックする文字列
   * @param $len integer 最大文字数(この文字数を含む)
   * @return boolean $len より長ければ true それ以外 false を返す。
   */
  function isLenMin($str, $len){
    return strlen($str) >= $len ? true : false ;
  }

  /**
   * 指定された文字列の長さが$len以下かチェック
   * 10字(バイト)以下なら isLenMax('hoge', 10);とする
   * @param $str mixed チェックする文字列
   * @param $len integer 最大文字数(この文字数を含む)
   * @return boolean $len より短ければ true それ以外 false を返す。
   */
  function isLenMax($str, $len){
    return strlen($str) <= $len ? true : false ;
  }

  /**
   * isLen のマルチバイト版
   * @param $str mixed チェックする文字列
   * @param $max integer 最大文字数(この文字数を含む)
   * @param $min integer 最小文字数(この文字数を含む)
   * @return boolean $max と $min の間の文字数なら true それ以外 false を返す。
   */
  function isMbLen( $str, $max, $min = 0){
    if(! $this->isMbLenMin($str, $min) ){
      return false ;
    }
    if(! $this->isMbLenMax($str, $max) ){
      return false ;
    }
    return true ;
  }

  /**
   * isLenMin のマルチバイト版
   * @param $str mixed チェックする文字列
   * @param $len integer 最大文字数(この文字数を含む)
   * @return boolean $len より長ければ true それ以外 false を返す。
   */
  function isMbLenMin($str, $len){
    return mb_strlen($str) >= $len ? true : false ;
  }

  /**
   * isLenMax のマルチバイト版
   * @param $str mixed チェックする文字列
   * @param $len integer 最大文字数(この文字数を含む)
   * @return boolean $len より短ければ true それ以外 false を返す。
   */
  function isMbLenMax($str, $len){
    return mb_strlen($str) <= $len ? true : false ;
  }


  /**
   * 数値かどうか、正規表現チェック
   * @param $str integer チェックする数値
   * @return boolean 数値ならば true それ以外なら false を返す。
   */
  function isNumber($str){
    return ereg("^[0-9]+$", $str);
  }

  /**
   * 数値及び、桁数チェック
   * @param $str integer チェックする数値
   * @param $len integer チェックする桁数
   * @return boolean 数値で桁数も合えば true それ以外なら false を返す。
   */
  function isNumberLen($str, $len){
    return ereg("^[0-9]{{$len}}$", $str);
  }

  /**
   * 数値及び、範囲で桁数チェック
   * @param $str integer チェックする数値
   * @param $start integer チェックする開始桁数
   * @param $end integer チェックする終了桁数
   * @return boolean 数値で桁数が範囲内なら true それ以外なら false を返す。
   */
  function isNumberRange($str, $start,$end){
    return ereg("^[0-9]{{$start},{$end}}$", $str);
  }

  /**
   * 大文字英字かチェック
   * このメソットは、大文字のみを受け付けます、大文字小文字を区別しない場合は isA2Zi()を利用してください。
   * @param $str integer チェックする数値
   * @return boolean 大文字英文字なら true それ以外なら false を返す。
   */
  function isA2Z($str){
   return ereg("^[A-Z]+$", $str);
  }

  /**
   * 小文字英字かチェック
   * このメソットは、小文字のみを受け付けます、大文字小文字を区別しない場合は isA2Zi()を利用してください。
   * @param $str integer チェックする数値
   * @return boolean 小文字英文字なら true それ以外なら false を返す。
   */
  function isA2Zs($str){
   return ereg("^[a-z]+$", $str);
  }

  /**
   * 英字かチェック
   * このメソットは、大文字小文字の区別をしません。区別する場合は それぞれ、 isA2Z() isA2Zs()を利用してください。
   * @param $str integer チェックする数値
   * @return boolean 英文字なら true それ以外なら false を返す。
   */
  function isA2Zi($str){
   return eregi("^[A-Za-z]+$", $str);
  }

  /**
   * 英数字かチェック
   * このメソットは、英字に関して大文字のみを受け付けます、大文字小文字を区別しない場合は isEisui()を利用してください。
   * @param $str string チェックする数値
   * @return boolean 大文字英字、及び数字なら true それ以外なら false を返す。
   */
  function isEisu($str){
   return ereg("^[0-9A-Z]+$", $str);
  }

  /**
   * 英数字かチェック
   * このメソットは、英字に関して小文字のみを受け付けます、大文字小文字を区別しない場合は isEisui()を利用してください。
   * @param $str string チェックする数値
   * @return boolean 小文字英字、及び数字なら true それ以外なら false を返す。
   */
  function isEisus($str){
   return ereg("^[0-9a-z]+$", $str);
  }

  /**
   * 英数字かチェック
   * このメソットは、英字に関して大文字小文字の区別をしません。区別する場合は それぞれ、 isEisu() isEisus()を利用してください。
   * @param $str string チェックする数値
   * @return boolean 大小英字、及び数字なら true それ以外なら false を返す。
   */
  function isEisui($str){
    return eregi("^[0-9A-Za-z]+$", $str);
  }

  // アフファベット　数値　スペース
  function isEisuSpace($str){
     return ereg("^[0-9A-Z ]+$", $str);
  }
  function isEisuSpaces($str){
     return ereg("^[0-9a-z ]+$", $str);
  }
  function isEisuSpacei($str){
     return eregi("^[0-9A-Za-z ]+$", $str);
  }

  // アフファベット　数値　スペース　記号
  function isEisuKigou($str){
     return ereg("^[]0-9A-Za-z\\!\"#$%&'\(\)*+,./:;<=>?@[\^_`{|}~]+$", $str);
  }

  /**
   * カタカナかチェック(ーは受付ます。)
   * @param $str string チェックする数値
   * @return boolean カタカナなら true それ以外なら false を返す。
   */
  function isKataKana($str){
    return mb_ereg_match("^[ァ-ヶー]+$",$str) ;
  }

  /**
   * URLかチェック
   * @param $str string チェックする文字列
   * @return boolean URLなら true それ以外なら false を返す。
   */
  function isUrl($str){
    return preg_match("/s?https?:\/\/[-_.!~*'()a-zA-Z0-9;\/?:@&=+$,%#]+/",$str) ;
  }


  // utill 便利
  function isZip($str){
    return ereg("^[0-9]{7}$",$str);
  }
  function isZipLine($str){
    return ereg("^[0-9]{3}-[0-9]{4}$",$str);
  }
  function isTel($str){
    return ereg("^[0-9]{10,11}$",$str);
  }
  function isTelLine($str){
    return ereg( "(^[0-9\-]{12,13}$)",$str ) ;
  }

  function isDate($str){
    return ereg("(^[1-9]{1})([0-9]{3})([:/]{1})([0-9]{2})([:/]{1})([0-9]{2})",$str) ;
  }

}
