<?php
/* SVN FILE: $Id: acl.php 7945 2008-12-19 02:16:01Z gwoo $ */
/**
 * ex_validate behavior class.
 *
 * Enables objects to easily tie into an ACL system
 *
 * PHP versions 4 and 5
 *
 * CakePHP :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2006-2008, Cake Software Foundation, Inc.
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2006-2008, Cake Software Foundation, Inc.
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP Project
 * @package       cake
 * @subpackage    cake.cake.libs.model.behaviors
 * @since         CakePHP v 1.2.0.4487
 * @version       $Revision: 7945 $
 * @modifiedby    $LastChangedBy: gwoo $
 * @lastmodified  $Date: 2008-12-18 18:16:01 -0800 (Thu, 18 Dec 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Short description for file
 *
 * Long description for file
 *
 * @package       cake
 * @subpackage    cake.cake.libs.model.behaviors
 */
class ExValidateBehavior extends ModelBehavior {
    

    /**
     * 初期設定メソッド
     * 
     * @access public
     * @return void
     * @param object $model
     */
    function setup(&$model){
        $this->model = $model;

    }
    
    /**
     *  引数が ケータイのメアドかどうか
     * @param $str mixed チェックする文字列
     * @return boolean メアドの場合 true それ以外 false を返す。
     */
    function isMobileMail(&$model,$str){

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
        return false ;
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
        return ereg( "^@softbank.ne.jp",substr($str,-15) )  ;
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
    function isNumber(&$model,$str){
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
    function isNumberRange(&$model,$str, $start,$end){

        return ereg("^[0-9]{{$start},{$end}}$", current($str));
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
    * 英数字、および範囲チェック
    * このメソットは、英字に関して大文字小文字の区別をしません。
    * @param $str string チェックする数値
    * @param $start integer チェックする開始桁数
    * @param $end integer チェックする終了桁数
    * @return boolean 英数字で桁数が範囲内なら true それ以外なら false を返す。
    */
    function isEisuiRange($str, $start,$end){
        return ereg("^[0-9A-Za-z]{{$start},{$end}}$", $str);
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
    * ひらがなかチェック(ーは受付ます。)
    * @param $str string チェックする数値
    * @return boolean ひらがななら true それ以外なら false を返す。
    */
    function isHiragana(&$model,$str){
        return mb_ereg_match("^[あ-んー　]+$",current($str)) ;
    }
    
    /**
    * URLかチェック
    * @param $str string チェックする文字列
    * @return boolean URLなら true それ以外なら false を返す。
    */
    function isUrl($str){
        return preg_match("/s?https?:\/\/[-_.!~*'()a-zA-Z0-9;\/?:@&=+$,%#]+/",$str) ;
    }
    /**
     * 電話番号形式チェック(000-0000-0000の形)
     * 
     * @return boolean 
     * @param object $val
     */
    function isTelLine(&$model,$str){
        return ereg( "(^[0-9\-]{12,13}$)",current($str)) ;
    }
    
    /**
     * どちらか片方の入力があるかどうかをチェック
     * 
     * @return boolean
     * @param object $model
     * @param string $str チェックする文字列
     * @param string $str2 比較する値のkey
     */
    function validEitherEnter(&$model,$str,$str2){
        $arr = $model->data[$model->name];
        return (!(current($str)==""&&$arr[$str2]==""))? true:false;
    }
    
    /**
     * チェックボックスの選択チェック
     * 
     * @return boolean 
     * @param object $val
     */
    function isCheckbox(&$model, $str){
        if ((!current($str)) == 0) {
            return true;
        } else {
            return false;
        }
    }
}
?>