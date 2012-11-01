<?php
/* SVN FILE: $Id: acl.php 7945 2008-12-19 02:16:01Z gwoo $ */
/**
 * convert behavior class.
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
class ConvertBehavior extends ModelBehavior {
    
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
     * Ⱦ�ѿ��ͤ��Ѵ�����
     * 
     * @return strung $str
     * @param string $str
     */
    function getConvertHanNum(&$model,$str){
        
        if($str!=""){
            //;ʬ�ʶ�����������ѿ�����Ⱦ�ѿ�����
            switch(Configure::read("App.encoding")){
                case "UTF-8":
                    $str = preg_replace("/^[ ��]+/u","",$str);
                    $str = preg_replace("/[ ��]+$/u","",$str);
                    break;
                default :
                    $str = preg_replace("/^[ ��]+/","",$str);
                    $str = preg_replace("/[ ��]+$/","",$str);
            }
            $str = mb_convert_kana($str,"a");
            
            return $str;
        }
        
    }
    
    /**
     * Ⱦ�ѱѻ����Ѵ�����
     * 
     * @return strung $str
     * @param string $str
     */
    function getConvertHanEi(&$model,$str){
        
        if($str !== ""){
            //;ʬ�ʶ�����������ѿ�����Ⱦ�ѿ�����
            switch(Configure::read("App.encoding")){
                case "UTF-8":
                    $str = preg_replace("/^[ ��]+/u","",$str);
                    $str = preg_replace("/[ ��]+$/u","",$str);
                    break;
                default :
                    $str = preg_replace("/^[ ��]+/","",$str);
                    $str = preg_replace("/[ ��]+$/","",$str);
            }
            $str = mb_convert_kana($str,"r");
            return $str;
        }
        
    }
    
    /**
     * ���ѡ���Ⱦ��@���Ѵ�����
     * 
     * @return strung $str
     * @param string $str
     */
    function getConvertAttoMark(&$model,$str) {
        if ($str !== "") {
            //���ѡ���Ⱦ��@��
            $str = preg_replace("/��/u","@", $str);
            
            return $str;
        }
    }
    
    
    function getConvertHankaku(&$model,$str) {
        if ($str !== "") {
            switch(Configure::read("App.encoding")){
                case "UTF-8":
                    $str = trim($str);
                    $str = preg_replace("/^[ ��]+/u","",$str);
                    $str = preg_replace("/[ ��]+$/u","",$str);
                   // $str = preg_replace("/[ ]{2,}/u","��",$str);
                    break;
                default :
                    $str = trim($str);
                    $str = preg_replace("/^[ ��]+/","",$str);
                    $str = preg_replace("/[ ��]+$/","",$str);
                   // $str = preg_replace("/[ ]{2,}/","��",$str);
            }
            
            return $str;
        }
    }
}
?>