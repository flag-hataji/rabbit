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
     * ͽ�����̥��顼ȯ������errror.ctpɽ��
     *
     * @param array $params ���顼��å�������
     * �����Ԥ˥᡼����������array("mail_flag"=>"1")
     * @access public
     * @return void
     */
     function error($params=""){

        extract($params);

        if(empty($view_err_msg)){
            $view_err_msg ="ͽ�����̥��顼��ȯ�����ޤ�����������Ǥ����������Ԥ��䤤��碌�Ƥ���������\n";
        }

        //�᡼��������̵ͭ
        if(!empty($mail_flag)){
            if($mail_flag=="1"){

                if(empty($err_msg)){
                    $err_msg = "ͽ�����̥��顼ȯ����ȯ�����ޤ�����\n";
                }
                //PHP5.2�ʾ�
                if(function_exists('error_get_last')){
                    $err_arr = error_get_last();
                    foreach($err_arr as $key=>$value){
                        $err_msg .= $key.":".$value."\n";
                    }
                //5.2�ʲ�
                }else{

                }

                //�Ķ��ѿ��μ���
                foreach($_SERVER as $key2=>$value2){
                    $err_msg .= $key2.":".$value2."\n";
                }
                mb_send_mail(ERROR_EMAIL, $_SERVER['HTTP_HOST']."�ץ���२�顼",$err_msg);
            }
        }

        //�֥饦����ɽ�����륨�顼��å�����������
        $this->controller->set('view_err_msg', $view_err_msg);
        $this->_outputMessage('error');
    }

 }
 ?>