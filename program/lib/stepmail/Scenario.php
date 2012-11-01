<?PHP
/**
 * シナリオ クラス
 *
 * @author fujita
 * @package defaultPackage
 */

class Scenario {

	var $dbdo 		= "";	// td_scenarioのDBDO
	var $tmp_dbdo = "";	// td_scenarioのDBDO tmp

	var $error = "";

	/**
	* @return boid
	* @param  user_id ユーザーID
	* @param  mode    登録mode
	* @desc   登録処理
	*/
	function isRegist($user_id, $scenario_id, $mode){

		switch ($mode){
			case "insert":
		  	// データの取得
				$flag = $this->isInsert($user_id);
				break;
			case "update":
		  	// データの取得
				$flag = $this->isUpdate($scenario_id);
				break;
			case "delete":
				$flag = $this->isDelete($scenario_id);
				break;
			default:
				die("予期せぬErrorが発生しました Scenario ".__LINE__);
		}

		if ( ! $flag ){
			print "ERROR <Br>\n";
		}else {
			print "OK <Br>\n";
		}

		return $flag;

	}

	/**
	* @return void
	* @param  scenario_id シナリオ番号
	* @desc   配信停止、再開処理
	*/
	function isStop($scenario_id){

		// PEAR DBオブジェクトの取得
		$db = $this->dbdo->getDatabaseConnection();

		// SQL文
		$sql  = "UPDATE td_scenario SET ";
		$sql .= " flag_send = case when flag_send=0 then 1 else 0 end ";
		$sql .= "WHERE scenario_id = $scenario_id ";

		print "sql = {$sql} <br>\n";

		// 登録処理
		$rs = $db->query($sql);
		if ( DB::isError($rs) ){
			// Error発生
			$this->error  = "シナリオ修正処理でエラーが発生しました。<br>\n";
			$this->error .= $rs->message."<br>\n";
			$this->error .= $rs->userinfo."<br>\n";

//			print_a($rs, "_Error_Obj");

			return false;
		}

		return true;

	}

	/**
	* @return boid
	* @param  scenario_id シナリオ番号
	* @desc   登録処理
	*/
	function isDelete($scenario_id){

		// PEAR DBオブジェクトの取得
		$db = $this->dbdo->getDatabaseConnection();

		// SQL文
		$sql  = "DELETE FROM td_scenario ";
		$sql .= "WHERE scenario_id = $scenario_id ";

		print "sql = {$sql} <br>\n";

		// 削除処理
		$rs = $db->query($sql);
		if ( DB::isError($rs) ){
			// Error発生
			$this->error  = "シナリオ削除処理でエラーが発生しました。<br>\n";
			$this->error .= $rs->message."<br>\n";
			$this->error .= $rs->userinfo."<br>\n";

//			print_a($rs, "_Error_Obj");

			return false;
		}

		return true;

	}

	/**
	* @return boid
	* @param  user_id ユーザーID
	* @desc   登録処理
	*/
	function isUpdate($scenario_id){

		// PEAR DBオブジェクトの取得
		$db = $this->dbdo->getDatabaseConnection();

		// SQL文
		$sql  = "UPDATE td_scenario SET ";
		$sql .= " scenario_name   = '{$this->dbdo->scenario_name}' , ";
		$sql .= " email_from      = '{$this->dbdo->email_from}', ";
		$sql .= " email_from_name = '{$this->dbdo->email_from_name}', ";
		$sql .= " email_error 		= '{$this->dbdo->email_error}', ";
		$sql .= " text_header 		= '{$this->dbdo->text_header}', ";
		$sql .= " text_footer 		= '{$this->dbdo->text_footer}', ";
		$sql .= " html_header 		= '{$this->dbdo->html_header}', ";
		$sql .= " html_footer 		= '{$this->dbdo->html_footer}', ";
		$sql .= " up_date 					= now() ";
		$sql .= "WHERE scenario_id = $scenario_id ";

		print "sql = {$sql} <br>\n";

		// 登録処理
		$rs = $db->query($sql);
		if ( DB::isError($rs) ){
			// Error発生
			$this->error  = "シナリオ修正処理でエラーが発生しました。<br>\n";
			$this->error .= $rs->message."<br>\n";
			$this->error .= $rs->userinfo."<br>\n";

//			print_a($rs, "_Error_Obj");

			return false;
		}

		return true;

	}


	/**
	* @return boid
	* @param  user_id ユーザーID
	* @desc   新規登録
	*/
	function isInsert($user_id){

		// sequence値の取得
		$db = $this->dbdo->getDatabaseConnection();
		$next_id = $db->nextId('td_scenario_scenario_id_seq');

		// 値の設定
		$this->dbdo->scenario_id  = $next_id;
		$this->dbdo->schedule_id  = "null";
		$this->dbdo->user_id  		= $user_id;
		$this->dbdo->flag_send 		= 1;
		$this->dbdo->ins_date 		= "now()";
		$this->dbdo->up_date  		= "now()";

		// 登録処理
		if ( ! $this->dbdo->insert() ){
			// Error発生
			$this->error  = "シナリオ登録処理でエラーが発生しました。<br>\n";
			$this->error .= $this->dbdo->_lastError->message;
			return false;
		}

		return true;

	}

	/**
	* @return bool
	* @desc   シナリオの入力Check
	*/
	function isCheck(){

		include_once _DIR_LIB_."check/Check.php";
		$Check = new Check();

		$error = "";

		// シナリオ名
		if ( $this->dbdo->scenario_name=="" ){
			$error .= "・シナリオ名が未入力です<br>\n";
		}

		// 送信者名
		if ( $this->dbdo->email_from_name==""){
			$error .= "・送信者名が未入力です<br>\n";
		}

		// 送信者メールアドレス
		if ( $this->dbdo->email_from != "" ){
			if ( $Check->isMail($this->dbdo->email_from)==false ) {
				$error .= "・送信者メールアドレスが不正です<br>\n";
			}
		}else{
			$error .= "・送信者メールアドレスが未入力です<br>\n";
		}

		// 送信エラーの戻り先
		if ( $this->dbdo->email_error != "" ){
			if ( $Check->isMail($this->dbdo->email_error)==false ) {
				$error .= "・送信エラーの値が不正です<br>\n";
			}
		}else{
			$error .= "・送信エラーの戻り先が未入力です<br>\n";
		}

		$this->error = $error;

		return ( $error=="" );

	}

	/**
	* @return void
	* @param  &$data
	* @param  $flag
	* @desc   データを変数に格納
	*/
	function setPostToData(&$data, $flag=false){

		$ary = array();

		// プロパティ名で存在するもののみ値をセット
		foreach ( $data as $key => $val ){

			if ( is_array($val) ) {
				foreach ( $val as $k2 => $v2) {
					$ary[$key][$k2] = ( $flag ) ? htmlspecialchars( trim($v2), ENT_QUOTES ) : trim($v2);
				}
			}else{
				$ary[$key] = ($flag) ? htmlspecialchars( trim($val), ENT_QUOTES) : trim($val);
			}

		}

		// DBDOに値を渡す
		$this->dbdo->setFrom($ary);

		unset($ary);

	}

	/**
	* @return bool
	* @desc   Demo版のCheck & シナリオ登録数Check
	*/
	function isDemoCheck(){

		// DEMO版ですでに１つシナリオを登録していれば true を返す

		// DB接続
		if ( $this->dbdo == "" ) {
			$this->setDBDO();
		}

		// - 契約済み？
		if ( $_SESSION['user']['flag_stepmail']=='t' ) {
			return false;
		}

		// - シナリオの登録数を取得
		$cnt = $this->dbdo->get("user_id", $_SESSION['user']['user_id']);

		if ( 1 <= $cnt ){
			// シナリオ数オーバー
			print "オーバー \n";
			return true;
		}else {
			// シナリオ登録OK
			print "OK \n";
			return false;
		}

	}

	/**
	* @return void
	* @desc   td_scenarioのDBDOの宣言
	*/
	function setDBDO($lv=0){

    $this->dbdo = DB_DataObject::factory("Public_td_scenario");

		if ( get_class($this->dbdo) == "db_dataobject_error" ) {
			$str  = "DB_DataObjectの宣言に失敗しました。<br>\n";
			$str .= $this->dbdo->message."<br>\n";
			die($str);
		}

		$this->dbdo->debugLevel($lv);

	}


	/**
	* @return
	* @param
	* @desc
	*/
	function showError(){

		if ( $this->error != "" ) {
			echo <<<END_HTML
				<div align="center">
				<table width="530" border="0" cellpadding="0" cellspacing="0">
					<tr class="black12">
						<td>
							<BR>
							<font color="#FF0000">
							以下の入力エラーが発生しました。<br>
							{$this->error}
							</font>
						</td>
					</tr>
				</TABLE>

				</div>
END_HTML;

		}

	}

}
?>