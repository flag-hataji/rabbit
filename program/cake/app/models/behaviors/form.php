<?php
/* SVN FILE: $Id: acl.php 7945 2008-12-19 02:16:01Z gwoo $ */
/**
 * form behavior class.
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
class FormBehavior extends ModelBehavior {

    /**
     * ��ƻ�ܸ�����
     *
     * @var array
     * @access public
     */
    var $prefList;

    /**
     * �������᥽�å�
     *
     * @access public
     * @return void
     * @param object $model
     */
    function setup(&$model){
        $this->model = $model;
        $this->_setPrefList();
    }

    /**
     * ��ƻ�ܸ��ꥹ�ȼ����ѥ᥽�å�
     *
     * @param void
     * @access public
     * @return array $prefList
     */
    function getPrefList(){
        return $this->prefList;
    }

    /**
     * ������ä�ID������ƻ�ܸ�̾���֤�
     *
     * @return
     * @param object $model
     * @param string $id
     */
    function getPrefName(&$model,$id){
        return $this->prefList[$id];
    }

    /**
     * ��ƻ�ܸ�����򥻥å�
     *
     * @param void
     * @access praivate
     * @return void
     */
    function _setPrefList(){
        $prefList = array(
                      '1'=>'�̳�ƻ',
                      '2'=>'�Ŀ���',
                      '3'=>'��긩',
                      '4'=>'�ܾ븩',
                      '5'=>'���ĸ�',
                      '6'=>'������',
                      '7'=>'ʡ�縩',
                      '8'=>'��븩',
                      '9'=>'���ڸ�',
                      '10'=>'���ϸ�',
                      '11'=>'��̸�',
                      '12'=>'���ո�',
                      '13'=>'�����',
                      '14'=>'�����',
                      '15'=>'���㸩',
                      '16'=>'�ٻ���',
                      '17'=>'���',
                      '18'=>'ʡ�温',
                      '19'=>'������',
                      '20'=>'Ĺ�',
                      '21'=>'���츩',
                      '22'=>'�Ų���',
                      '23'=>'���θ�',
                      '24'=>'���Ÿ�',
                      '25'=>'���츩',
                      '26'=>'������',
                      '27'=>'�����',
                      '28'=>'ʼ�˸�',
                      '29'=>'���ɸ�',
                      '30'=>'�²λ���',
                      '31'=>'Ļ�踩',
                      '32'=>'�纬��',
                      '33'=>'������',
                      '34'=>'���縩',
                      '35'=>'������',
                      '36'=>'���縩',
                      '37'=>'���',
                      '38'=>'��ɲ��',
                      '39'=>'���θ�',
                      '40'=>'ʡ����',
                      '41'=>'���츩',
                      '42'=>'Ĺ�긩',
                      '43'=>'���ܸ�',
                      '44'=>'��ʬ��',
                      '45'=>'�ܺ긩',
                      '46'=>'�����縩',
                      '47'=>'���츩'
                      );

        $this->prefList = $prefList;
    }

    /**
     * ������ä������CSV�Υѥ��ˤ�CSV��¸
     *
     * @return boolean �������¸�����true
     * @param object $model
     * @param array $arrData
     * @param object $csvPath
     * @param intger $date_flag �ե���������դ�����Ʒ�Ȥ˥ե������ʬ����
     * @param string $out_enc ���Ϥ���ʸ�������ɡ��ǥե���Ȥ�SJIS
     */
    function csvWriter(&$model,$arrData,$csvPath,$csvName="formdata",$date_flag="1",$out_enc="SJIS"){

        $writer = "";
        if($arrData!=""){

            if($date_flag=="1"){
                $csvPath = $csvPath."/".$csvName.date("ym").".csv";
            }else{
                $csvPath = $csvPath.$csvName.".csv";
            }

            if(@$fp = fopen($csvPath,"a")){

                flock($fp,LOCK_EX);
                $writer .= date("Y/m/d H:i:s").",";
                foreach ($arrData as $key=>$value) {
                    $value=str_replace(",","��",$value);      //,���
                    $value=str_replace('"','��',$value);      //"���
                    $value=str_replace("'","��",$value);     //'���
                    $writer .= '"'.$value.'",';
                }

                $len    = mb_strlen($writer);
                $writer = substr_replace($writer,'',-1,$len);
                $writer.= "\n";
                $writer = mb_convert_encoding($writer,$out_enc,Configure::read("App.encoding"));
                fwrite($fp,$writer);
                unset($writer);
                flock($fp,LOCK_UN);
                fclose($fp);
            }else{
                return false;
            }
        }

        return true;

    }
}
?>