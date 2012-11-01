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
     * 都道府県配列
     *
     * @var array
     * @access public
     */
    var $prefList;

    /**
     * 初期設定メソッド
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
     * 都道府県リスト取得用メソッド
     *
     * @param void
     * @access public
     * @return array $prefList
     */
    function getPrefList(){
        return $this->prefList;
    }

    /**
     * 受け取ったIDから都道府県名を返す
     *
     * @return
     * @param object $model
     * @param string $id
     */
    function getPrefName(&$model,$id){
        return $this->prefList[$id];
    }

    /**
     * 都道府県配列をセット
     *
     * @param void
     * @access praivate
     * @return void
     */
    function _setPrefList(){
        $prefList = array(
                      '1'=>'北海道',
                      '2'=>'青森県',
                      '3'=>'岩手県',
                      '4'=>'宮城県',
                      '5'=>'秋田県',
                      '6'=>'山形県',
                      '7'=>'福島県',
                      '8'=>'茨城県',
                      '9'=>'栃木県',
                      '10'=>'群馬県',
                      '11'=>'埼玉県',
                      '12'=>'千葉県',
                      '13'=>'東京都',
                      '14'=>'神奈川県',
                      '15'=>'新潟県',
                      '16'=>'富山県',
                      '17'=>'石川県',
                      '18'=>'福井県',
                      '19'=>'山梨県',
                      '20'=>'長野県',
                      '21'=>'岐阜県',
                      '22'=>'静岡県',
                      '23'=>'愛知県',
                      '24'=>'三重県',
                      '25'=>'滋賀県',
                      '26'=>'京都府',
                      '27'=>'大阪府',
                      '28'=>'兵庫県',
                      '29'=>'奈良県',
                      '30'=>'和歌山県',
                      '31'=>'鳥取県',
                      '32'=>'島根県',
                      '33'=>'岡山県',
                      '34'=>'広島県',
                      '35'=>'山口県',
                      '36'=>'徳島県',
                      '37'=>'香川県',
                      '38'=>'愛媛県',
                      '39'=>'高知県',
                      '40'=>'福岡県',
                      '41'=>'佐賀県',
                      '42'=>'長崎県',
                      '43'=>'熊本県',
                      '44'=>'大分県',
                      '45'=>'宮崎県',
                      '46'=>'鹿児島県',
                      '47'=>'沖縄県'
                      );

        $this->prefList = $prefList;
    }

    /**
     * 受け取った配列とCSVのパスにてCSV保存
     *
     * @return boolean 正常に保存すればtrue
     * @param object $model
     * @param array $arrData
     * @param object $csvPath
     * @param intger $date_flag ファイルに日付を入れて月ごとにファイルを分ける
     * @param string $out_enc 出力する文字コード。デフォルトはSJIS
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
                    $value=str_replace(",","，",$value);      //,削除
                    $value=str_replace('"','”',$value);      //"削除
                    $value=str_replace("'","’",$value);     //'削除
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