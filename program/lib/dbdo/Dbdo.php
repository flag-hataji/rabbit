<?PHP
/**
 * DB_DataObject�Υ��饹
 *
 * @author fujita
 * @package defaultPackage
 */

class Dbdo {

//	var $dbdo;
//	var $debug = false;

	/**
	* @return void
	* @param $table �ơ��֥�κ���
	* @param $key ��������ե������̾
	* @param $val ������
	* @param $column ��������ե�����ɤ���
	* @desc DB_DataObject�Υ��󥹥��󥹺���
	*/
//	function getOne($table, $key, $val, $col){
//
//		$dbdo = DB_DataObject::factory("Public_{$table}");
//		if ( $dbdo->message !="" ) {
//			echo "DB_DataObject������˼��Ԥ��ޤ�����<br>\n";
//			echo "Error-Message��<br>\n";
//			echo "{$dbdo->message}<br>\n";
//		}
//		
//		$dbdo->get($key, $val);
//
//		return $dbdo->{$col};
//
//	}

	/**
	* @return object
	* @param $table �ơ��֥�κ���
	* @param $where ��������Ϣ������
	* @desc ������̤Σ��쥳���ɤμ���
	*/
//	function getData($table, $where){
//		
//		$dbdo = DB_DataObject::factory("Public_{$table}");
//		if ( $dbdo->message !="" ) {
//			echo "DB_DataObject������˼��Ԥ��ޤ�����<br>\n";
//			echo "Error-Message��<br>\n";
//			echo "{$dbdo->message}<br>\n";
//		}
//
//		foreach ( $where as $key => $val ) {
//			$dbdo->whereAdd("{$key}={$val}");
//		}
//
//		$dbdo->keys("*");
//		if ( $dbdo->count() != 1 ) {
//	    print_a( get_object_vars($dbdo) , "_DBDO_");
//			die("�������������ǤϤ���ޤ���");
//		}
//
//		$dbdo->find();
//
//		$dbdo->fetch();
//
//		return $dbdo;
//		
//	}

	/**
	* @return void
	* @desc DB_DataObject��³
	*/
	function getDBDO($table){

		$dbdo = DB_DataObject::factory("Public_{$table}");

		if ( get_class($dbdo) == "db_dataobject_error" ) {
//		if ( DB::isError($dbdo->_lastError) ) {	// ErrorȽ�꤬�褯�狼���
			$str  = "DB_DataObject������˼��Ԥ��ޤ�����<br>\n";
			$str .= $dbdo->message."<br>\n";
			die($str);
		}
		
		return $dbdo;

	}

}
?>