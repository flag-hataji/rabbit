<?PHP
/**
 * DB_DataObjectのクラス
 *
 * @author fujita
 * @package defaultPackage
 */

class Dbdo {

//	var $dbdo;
//	var $debug = false;

	/**
	* @return void
	* @param $table テーブルの作成
	* @param $key 検索するフィールド名
	* @param $val 検索値
	* @param $column 取得するフィールドの値
	* @desc DB_DataObjectのインスタンス作成
	*/
//	function getOne($table, $key, $val, $col){
//
//		$dbdo = DB_DataObject::factory("Public_{$table}");
//		if ( $dbdo->message !="" ) {
//			echo "DB_DataObjectの宣言に失敗しました。<br>\n";
//			echo "Error-Message。<br>\n";
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
	* @param $table テーブルの作成
	* @param $where 検索条件の連想配列
	* @desc 検索結果の１レコードの取得
	*/
//	function getData($table, $where){
//		
//		$dbdo = DB_DataObject::factory("Public_{$table}");
//		if ( $dbdo->message !="" ) {
//			echo "DB_DataObjectの宣言に失敗しました。<br>\n";
//			echo "Error-Message。<br>\n";
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
//			die("該当件数が１件ではありません。");
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
	* @desc DB_DataObject接続
	*/
	function getDBDO($table){

		$dbdo = DB_DataObject::factory("Public_{$table}");

		if ( get_class($dbdo) == "db_dataobject_error" ) {
//		if ( DB::isError($dbdo->_lastError) ) {	// Error判定がよくわからん
			$str  = "DB_DataObjectの宣言に失敗しました。<br>\n";
			$str .= $dbdo->message."<br>\n";
			die($str);
		}
		
		return $dbdo;

	}

}
?>