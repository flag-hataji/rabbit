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
     * �������᥽�å�
     * 
     * @access public
     * @return void
     * @param object $model
     */
    function setup(&$model){
        $this->model = $model;

    }
    
    /**
     *  ������ ���������Υᥢ�ɤ��ɤ���
     * @param $str mixed �����å�����ʸ����
     * @return boolean �ᥢ�ɤξ�� true ����ʳ� false ���֤���
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
    * ������ ���������Υɥ���Υᥢ�ɤ��ɤ���
    * @param $str mixed �����å�����ʸ����
    * @return boolean �ᥢ�ɤξ�� true ����ʳ� false ���֤���
    */
    function isDocomo($str){
        return ereg( "^@docomo.ne.jp",substr($str,-13) ) ;
    }
    
    
    /**
    * ������ ���������Υܡ����ե���Υᥢ�ɤ��ɤ���
    * @param $str mixed �����å�����ʸ����
    * @return boolean �ᥢ�ɤξ�� true ����ʳ� false ���֤���
    */
    function isVodafone($str){
        return ereg( "^@[dqnchtrks]{1}.vodafone.ne.jp",substr($str,-17) )  ;
    }
    
    
    /**
    * ������ ����������AU�Υᥢ�ɤ��ɤ���
    * @param $str mixed �����å�����ʸ����
    * @return boolean �ᥢ�ɤξ�� true ����ʳ� false ���֤���
    */
    function isAu($str){
        return ereg( "^ezweb.ne.jp",substr($str,-11) )  ;
    }
    
    
    /**
    * ������ ���������Υ��եȥХ󥯤Υᥢ�ɤ��ɤ���
    * @param $str mixed �����å�����ʸ����
    * @return boolean �ᥢ�ɤξ�� true ����ʳ� false ���֤���
    */
    function isSoftBank($str){
        return ereg( "^@softbank.ne.jp",substr($str,-15) )  ;
    }
    
    
    /**
    * ���ꤵ�줿ʸ�����Ĺ���������å�
    * 3��(�Х���)�ʾ塢10��(�Х���)�����ʤ� isLen('hoge', 3, 10);�Ȥ���
    * @param $str mixed �����å�����ʸ����
    * @param $max integer ����ʸ����(����ʸ������ޤ�)
    * @param $min integer �Ǿ�ʸ����(����ʸ������ޤ�)
    * @return boolean $max �� $min �δ֤�ʸ�����ʤ� true ����ʳ� false ���֤���
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
    * ���ꤵ�줿ʸ�����Ĺ����$len�ʾ夫�����å�
    * 10��(�Х���)�ʾ�ʤ� isLenMin('hoge', 10);�Ȥ���
    * @param $str mixed �����å�����ʸ����
    * @param $len integer ����ʸ����(����ʸ������ޤ�)
    * @return boolean $len ���Ĺ����� true ����ʳ� false ���֤���
    */
    function isLenMin($str, $len){
        return strlen($str) >= $len ? true : false ;
    }
    
    /**
    * ���ꤵ�줿ʸ�����Ĺ����$len�ʲ��������å�
    * 10��(�Х���)�ʲ��ʤ� isLenMax('hoge', 10);�Ȥ���
    * @param $str mixed �����å�����ʸ����
    * @param $len integer ����ʸ����(����ʸ������ޤ�)
    * @return boolean $len ���û����� true ����ʳ� false ���֤���
    */
    function isLenMax($str, $len){
        return strlen($str) <= $len ? true : false ;
    }
    
    /**
    * isLen �Υޥ���Х�����
    * @param $str mixed �����å�����ʸ����
    * @param $max integer ����ʸ����(����ʸ������ޤ�)
    * @param $min integer �Ǿ�ʸ����(����ʸ������ޤ�)
    * @return boolean $max �� $min �δ֤�ʸ�����ʤ� true ����ʳ� false ���֤���
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
    * isLenMin �Υޥ���Х�����
    * @param $str mixed �����å�����ʸ����
    * @param $len integer ����ʸ����(����ʸ������ޤ�)
    * @return boolean $len ���Ĺ����� true ����ʳ� false ���֤���
    */
    function isMbLenMin($str, $len){
        return mb_strlen($str) >= $len ? true : false ;
    }
    
    /**
    * isLenMax �Υޥ���Х�����
    * @param $str mixed �����å�����ʸ����
    * @param $len integer ����ʸ����(����ʸ������ޤ�)
    * @return boolean $len ���û����� true ����ʳ� false ���֤���
    */
    function isMbLenMax($str, $len){
        return mb_strlen($str) <= $len ? true : false ;
    }
    
    
    /**
    * ���ͤ��ɤ���������ɽ�������å�
    * @param $str integer �����å��������
    * @return boolean ���ͤʤ�� true ����ʳ��ʤ� false ���֤���
    */
    function isNumber(&$model,$str){
        return ereg("^[0-9]+$", $str);
    }
    
    /**
    * ���͵ڤӡ���������å�
    * @param $str integer �����å��������
    * @param $len integer �����å�������
    * @return boolean ���ͤǷ����礨�� true ����ʳ��ʤ� false ���֤���
    */
    function isNumberLen($str, $len){
        return ereg("^[0-9]{{$len}}$", $str);
    }
    
    /**
    * ���͵ڤӡ��ϰϤǷ�������å�
    * @param $str integer �����å��������
    * @param $start integer �����å����볫�Ϸ��
    * @param $end integer �����å����뽪λ���
    * @return boolean ���ͤǷ�����ϰ���ʤ� true ����ʳ��ʤ� false ���֤���
    */
    function isNumberRange(&$model,$str, $start,$end){

        return ereg("^[0-9]{{$start},{$end}}$", current($str));
    }
    
    /**
    * ��ʸ���ѻ��������å�
    * ���Υ᥽�åȤϡ���ʸ���Τߤ�����դ��ޤ�����ʸ����ʸ������̤��ʤ����� isA2Zi()�����Ѥ��Ƥ���������
    * @param $str integer �����å��������
    * @return boolean ��ʸ����ʸ���ʤ� true ����ʳ��ʤ� false ���֤���
    */
    function isA2Z($str){
        return ereg("^[A-Z]+$", $str);
    }
    
    /**
    * ��ʸ���ѻ��������å�
    * ���Υ᥽�åȤϡ���ʸ���Τߤ�����դ��ޤ�����ʸ����ʸ������̤��ʤ����� isA2Zi()�����Ѥ��Ƥ���������
    * @param $str integer �����å��������
    * @return boolean ��ʸ����ʸ���ʤ� true ����ʳ��ʤ� false ���֤���
    */
    function isA2Zs($str){
        return ereg("^[a-z]+$", $str);
    }
    
    /**
    * �ѻ��������å�
    * ���Υ᥽�åȤϡ���ʸ����ʸ���ζ��̤򤷤ޤ��󡣶��̤������ ���줾�졢 isA2Z() isA2Zs()�����Ѥ��Ƥ���������
    * @param $str integer �����å��������
    * @return boolean ��ʸ���ʤ� true ����ʳ��ʤ� false ���֤���
    */
    function isA2Zi($str){
        return eregi("^[A-Za-z]+$", $str);
    }
    
    /**
    * �ѿ����������å�
    * ���Υ᥽�åȤϡ��ѻ��˴ؤ�����ʸ���Τߤ�����դ��ޤ�����ʸ����ʸ������̤��ʤ����� isEisui()�����Ѥ��Ƥ���������
    * @param $str string �����å��������
    * @return boolean ��ʸ���ѻ����ڤӿ����ʤ� true ����ʳ��ʤ� false ���֤���
    */
    function isEisu($str){
        return ereg("^[0-9A-Z]+$", $str);
    }
    
    /**
    * �ѿ�����������ϰϥ����å�
    * ���Υ᥽�åȤϡ��ѻ��˴ؤ�����ʸ����ʸ���ζ��̤򤷤ޤ���
    * @param $str string �����å��������
    * @param $start integer �����å����볫�Ϸ��
    * @param $end integer �����å����뽪λ���
    * @return boolean �ѿ����Ƿ�����ϰ���ʤ� true ����ʳ��ʤ� false ���֤���
    */
    function isEisuiRange($str, $start,$end){
        return ereg("^[0-9A-Za-z]{{$start},{$end}}$", $str);
    }
    /**
    * �ѿ����������å�
    * ���Υ᥽�åȤϡ��ѻ��˴ؤ��ƾ�ʸ���Τߤ�����դ��ޤ�����ʸ����ʸ������̤��ʤ����� isEisui()�����Ѥ��Ƥ���������
    * @param $str string �����å��������
    * @return boolean ��ʸ���ѻ����ڤӿ����ʤ� true ����ʳ��ʤ� false ���֤���
    */
    function isEisus($str){
        return ereg("^[0-9a-z]+$", $str);
    }
    
    /**
    * �ѿ����������å�
    * ���Υ᥽�åȤϡ��ѻ��˴ؤ�����ʸ����ʸ���ζ��̤򤷤ޤ��󡣶��̤������ ���줾�졢 isEisu() isEisus()�����Ѥ��Ƥ���������
    * @param $str string �����å��������
    * @return boolean �羮�ѻ����ڤӿ����ʤ� true ����ʳ��ʤ� false ���֤���
    */
    function isEisui($str){
        return eregi("^[0-9A-Za-z]+$", $str);
    }
    
    // ���եե��٥åȡ����͡����ڡ���������
    function isEisuKigou($str){
        return ereg("^[]0-9A-Za-z\\!\"#$%&'\(\)*+,./:;<=>?@[\^_`{|}~]+$", $str);
    }
    
    /**
    * �������ʤ������å�(���ϼ��դޤ���)
    * @param $str string �����å��������
    * @return boolean �������ʤʤ� true ����ʳ��ʤ� false ���֤���
    */
    function isKataKana($str){
        return mb_ereg_match("^[��-����]+$",$str) ;
    }
    
    /**
    * �Ҥ餬�ʤ������å�(���ϼ��դޤ���)
    * @param $str string �����å��������
    * @return boolean �Ҥ餬�ʤʤ� true ����ʳ��ʤ� false ���֤���
    */
    function isHiragana(&$model,$str){
        return mb_ereg_match("^[��-�󡼡�]+$",current($str)) ;
    }
    
    /**
    * URL�������å�
    * @param $str string �����å�����ʸ����
    * @return boolean URL�ʤ� true ����ʳ��ʤ� false ���֤���
    */
    function isUrl($str){
        return preg_match("/s?https?:\/\/[-_.!~*'()a-zA-Z0-9;\/?:@&=+$,%#]+/",$str) ;
    }
    /**
     * �����ֹ���������å�(000-0000-0000�η�)
     * 
     * @return boolean 
     * @param object $val
     */
    function isTelLine(&$model,$str){
        return ereg( "(^[0-9\-]{12,13}$)",current($str)) ;
    }
    
    /**
     * �ɤ��餫���������Ϥ����뤫�ɤ���������å�
     * 
     * @return boolean
     * @param object $model
     * @param string $str �����å�����ʸ����
     * @param string $str2 ��Ӥ����ͤ�key
     */
    function validEitherEnter(&$model,$str,$str2){
        $arr = $model->data[$model->name];
        return (!(current($str)==""&&$arr[$str2]==""))? true:false;
    }
    
    /**
     * �����å��ܥå�������������å�
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