<?php
	/**
	 * ���������
	 *
	 * @author fujita
	 * @package defaultPackage
	 */


	/**
	 * �ץ�������ΤΥѥ�
	 */

	// �ƥ��Ȼ�
//	if ( isset($_SERVER['argv'][2]) ){
//		// TEST
//		define("_TEST_", true);
//		define("_DOC_ROOT_", "/var/www/vhosts/test.itm-asp.com/html/");
//	} else {

		// ����
		define("_TEST_", false);
		define("_DOC_ROOT_", "/var/www/vhosts/www.rabbit-mail.jp/html/");
		
//	}

    // ROOT
    define('_ROOT_',     _DOC_ROOT_);

	/**
	 * �饤�֥��Υѥ�
	 */
	define("_ROOT_LIB_", _ROOT_."program/lib/");

	/**
	 * ���饹�Υѥ�
	 */
	define("_ROOT_CLS_", _ROOT_."program/cls/");

	/**
	 * Log�ե��������¸��
	 */
	define("_LOG_PATH_", _ROOT_."mailq/log/");

	/**
	 *  ����������
	 */
//	if ( _TEST_ ) {
//		// TEST
//		define("_READ_COUNT_", 2000);
//	}else {
//		// ����
//		define("_READ_COUNT_", 2000);
//	}
//
//		Cron�����ꤹ���OK
//	/**
//	 * ���Ӱ�������OK�γ��ϻ���
//	 */
//	define("_MOBILE_TIME_START_", 8);
//
//
//	/**
//	 * ���Ӱ�������OK�ν�λ����
//	 */
//	define("_MOBILE_TIME_END_", 20);

?>
