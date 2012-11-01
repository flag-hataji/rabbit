<?php
	/**
	 * 定数を設定
	 *
	 * @author fujita
	 * @package defaultPackage
	 */


	/**
	 * プログラム本体のパス
	 */

	// テスト時
//	if ( isset($_SERVER['argv'][2]) ){
//		// TEST
//		define("_TEST_", true);
//		define("_DOC_ROOT_", "/var/www/vhosts/test.itm-asp.com/html/");
//	} else {

		// 本番
		define("_TEST_", false);
		define("_DOC_ROOT_", "/var/www/vhosts/www.rabbit-mail.jp/html/");
		
//	}

    // ROOT
    define('_ROOT_',     _DOC_ROOT_);

	/**
	 * ライブラリのパス
	 */
	define("_ROOT_LIB_", _ROOT_."program/lib/");

	/**
	 * クラスのパス
	 */
	define("_ROOT_CLS_", _ROOT_."program/cls/");

	/**
	 * Logファイルの保存先
	 */
	define("_LOG_PATH_", _ROOT_."mailq/log/");

	/**
	 *  送信する件数
	 */
//	if ( _TEST_ ) {
//		// TEST
//		define("_READ_COUNT_", 2000);
//	}else {
//		// 本番
//		define("_READ_COUNT_", 2000);
//	}
//
//		Cronで設定すればOK
//	/**
//	 * 携帯宛に送信OKの開始時間
//	 */
//	define("_MOBILE_TIME_START_", 8);
//
//
//	/**
//	 * 携帯宛に送信OKの終了時間
//	 */
//	define("_MOBILE_TIME_END_", 20);

?>
