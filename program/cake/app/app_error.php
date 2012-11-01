<?php
/* SVN FILE: $Id: error.php 8120 2009-03-19 20:25:10Z gwoo $ */
/**
 * app_error CakeError
 *
 * Provides Error Capturing for Framework errors.
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
 * @subpackage    cake.cake.libs
 * @since         CakePHP(tm) v 0.10.5.1732
 * @version       $Revision: 8120 $
 * @modifiedby    $LastChangedBy: gwoo $
 * @lastmodified  $Date: 2009-03-19 13:25:10 -0700 (Thu, 19 Mar 2009) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
 class AppError extends ErrorHandler{

    /**
     * 予期せぬエラー発生時、errror.ctp表示
     *
     * @param array $params エラーメッセージ。
     * 管理者にメール送信時、array("mail_flag"=>"1")
     * @access public
     * @return void
     */
     function error($params=""){

        extract($params);

        if(empty($view_err_msg)){
            $view_err_msg ="予期せぬエラーが発生しました。お手数ですが、管理者に問い合わせてください。\n";
        }

        //メール送信の有無
        if(!empty($mail_flag)){
            if($mail_flag=="1"){

                if(empty($err_msg)){
                    $err_msg = "予期せぬエラー発生が発生しました。\n";
                }
                //PHP5.2以上
                if(function_exists('error_get_last')){
                    $err_arr = error_get_last();
                    foreach($err_arr as $key=>$value){
                        $err_msg .= $key.":".$value."\n";
                    }
                //5.2以下
                }else{

                }

                //環境変数の取得
                foreach($_SERVER as $key2=>$value2){
                    $err_msg .= $key2.":".$value2."\n";
                }
                mb_send_mail(ERROR_EMAIL, $_SERVER['HTTP_HOST']."プログラムエラー",$err_msg);
            }
        }

        //ブラウザに表示するエラーメッセージを設定
        $this->controller->set('view_err_msg', $view_err_msg);
        $this->_outputMessage('error');
    }

 }
 ?>