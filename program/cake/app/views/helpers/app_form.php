<?php
/* SVN FILE: $Id: form.php 8166 2009-05-04 21:17:19Z gwoo $ */
/**
 * Automatic generation of HTML FORMs from given data.
 *
 * Used for scaffolding.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.view.helpers
 * @since         CakePHP(tm) v 0.10.0.1076
 * @version       $Revision: 8166 $
 * @modifiedby    $LastChangedBy: gwoo $
 * @lastmodified  $Date: 2009-05-04 14:17:19 -0700 (Mon, 04 May 2009) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Form helper library.
 *
 * Automatic generation of HTML FORMs from given data.
 *
 * @package       cake
 * @subpackage    cake.cake.libs.view.helpers
 */
class AppFormHelper extends FormHelper {
    
    /**
     * Postで受け渡すhiddenを生成
     * 
     * @params string Model名
     * @return $string $hidens
     */
    function postHiddens($modelName){
        
        $posts = $this->data[$modelName];
        $hiddens = "\n";
        foreach ($posts as $key=>$value){
            $hiddens .= $this->hidden($modelName.'.'.$key,array("value"=>$value))."\n";
        }
        return $hiddens;
    }
    /**
     * エラーを出力させる
     * 
     * @params string Model名
     * @return $string $errs
     */
    function errMsgs($errorMsgs){
        $errs = "\n";
        foreach($errorMsgs as $key=>$value){
           $errs .= $value."\n";
           
        }
        return $errs;
    }

    
    /**
     * checkbox生成
     * 
     * @params string Model名
     * @return $string $checkboxs
     */
     function viewCheckboxs($materialLists) {
         $checkboxs = "\n";
        foreach($materialLists as $key => $value){
            $checkboxs .= $this->checkbox("Request.material".$key, array('id'=> $key, 'value' => $value, 'div'=> false)).$value."\n";
        }
        
        return $checkboxs;
     }
}
?>