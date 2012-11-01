<?php
/*******************************
	Smarty設定用ファイル
*******************************/

require_once '../../../Smarty/libs/Smarty.class.php';

class MySmarty extends Smarty {
	function __construct() {
		$this->Smarty();
		$this->template_dir="./templates";
		$this->compile_dir="./templates_c/";
		$this->cache_dir="./cache/";
		$this->caching=FALSE;
	}
}
?>
