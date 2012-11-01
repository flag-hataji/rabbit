<?PHP
/**
 * シナリオ クラス
 *
 * @author fujita
 * @package defaultPackage
 */

class Schedule {

	var $dbdo  = "";	// td_scheduleのDBオブジェクト

	var $view  = "";   // 表示用の変数

	var $error = "";

	/**
	 * @return void
	 * @desc   初期設定
	 */
	function Schedule()
	{
	    // 初期化
	    $this->dbdo->reg_send = 0;
	}

	/**
	* @return boid
	* @param  user_id ユーザーID
	* @param  mode    登録mode
	* @desc   登録処理
	*/
	function isRegist($scenario_id, $mode){

		switch ($mode){
			case "insert":
		  	// データの取得
				$flag = $this->isInsert($scenario_id);
				break;
			case "update":
		  	// データの取得
				$flag = $this->isUpdate($scenario_id);
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
	* @return boid
	* @param  user_id ユーザーID
	* @desc   登録処理
	*/
	function isUpdate($scenario_id){

		// PEAR DBオブジェクトの取得
		$db = $this->dbdo->getDatabaseConnection();

		// 配列をカンマ区切りに
		if ( $this->dbdo->flag_delivery==1 ){
			// 曜日で指定
			ksort($this->dbdo->delivery_week);
			$delivery_week = implode(',', $this->dbdo->delivery_week );
			$delivery_day  = "";
		}else {
			// 日付で指定
			ksort($this->dbdo->delivery_day);
			$delivery_week = "";
			$delivery_day  = implode(',', $this->dbdo->delivery_day );
		}

		// SQL文
		$sql  = "UPDATE td_schedule SET ";
		$sql .= " flag_delivery   = {$this->dbdo->flag_delivery} , ";
		$sql .= " delivery_week   = '{$delivery_week}' , ";
		$sql .= " delivery_day    = '{$delivery_day}', ";
		$sql .= " delivery_time   = '{$this->dbdo->delivery_time}', ";
		$sql .= " up_date     	  =  now(), ";
		$sql .= " reg_send        = {$this->dbdo->reg_send} ";
		$sql .= "WHERE schedule_id = {$this->dbdo->schedule_id} ";

		// 登録処理
		$rs = $db->query($sql);
		if ( DB::isError($rs) ){
			// Error発生
			$this->error  = "シナリオ修正処理でエラーが発生しました。<br>\n";
			$this->error .= $rs->message."<br>\n";
			$this->error .= $rs->userinfo."<br>\n";
			return false;
		}

		return true;

	}

	/**
	* @return boid
	* @param  user_id ユーザーID
	* @desc   新規登録
	*/
	function isInsert($scenario_id){

		// sequence値の取得
		$db = $this->dbdo->getDatabaseConnection();
		$db->autoCommit(false);	// 自動コミット off

		$next_id = $db->nextId('td_schedule_schedule_id_seq');

		// 配列をカンマ区切りに
		if ( $this->dbdo->flag_delivery==1 ){
			// 曜日で指定
			ksort($this->dbdo->delivery_week);
			$delivery_week = implode(',', $this->dbdo->delivery_week );
			$delivery_day  = "";
		}else {
			// 日付で指定
			ksort($this->dbdo->delivery_day);
			$delivery_week = "";
			$delivery_day  = implode(',', $this->dbdo->delivery_day );
		}

		// 値の設定
		$sql  = "INSERT INTO td_schedule(schedule_id, scenario_id, flag_delivery, delivery_week, delivery_day, delivery_time, ins_date, up_date, reg_send) ";
		$sql .= " VALUES ( {$next_id}, {$this->dbdo->scenario_id}, {$this->dbdo->flag_delivery}, '{$delivery_week}', '{$delivery_day}', '{$this->dbdo->delivery_time}', now(), now(), {$this->dbdo->reg_send} ); ";

		// td_schedule 登録処理
		$rs = $db->query($sql);
		if ( DB::isError($rs) ){
			// Error発生
			$db->rollback();
			$this->error  = "スケジュール登録処理でエラーが発生しました。<br>\n";
			$this->error .= $rs->message."<br>\n";
			$this->error .= $rs->userinfo."<br>\n";
			return false;
		}

		$sql  = "UPDATE td_scenario SET schedule_id={$next_id} WHERE scenario_id={$scenario_id}";

		// td_scenario 登録処理
		$rs = $db->query($sql);
		if ( DB::isError($rs) ){
			// Error発生
			$db->rollback();
			$this->error  = "スケジュール登録処理でエラーが発生しました。<br>\n";
			$this->error .= $rs->message."<br>\n";
			$this->error .= $rs->userinfo."<br>\n";
			return false;
		}

		$db->commit();	// コミット

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

		// 配信時間
		if ( $this->dbdo->delivery_time=="" ){
			$error.= "・配信時間を選択してください。<br>\n";
		}

		// 配信条件（曜日・日にち）
		if ( $this->dbdo->flag_delivery == "" ){
			$error .= "・配信条件を選択してください。<br>\n";

		}else{

			// 配信条件の内容Check
			if ( $this->dbdo->flag_delivery==1 ){
				// 曜日
				$week_flag = false;
				foreach ( $this->dbdo->delivery_week as $val ){
					if ( $val== 1 )	{ $week_flag=true; }
				}

				if ( $week_flag==false ){
					$error .= "・配信条件の曜日を選択してください。<br>\n";
				}

			}else {

				// 日時

				// 日時設定 & 登録日配信 & ステップが１つの場合と特殊な場合
				if ( isset($this->dbdo->delivery_day)==false ) {
					//
				}else{

    				// 未入力のチェック
    				$blank_flag = false;
    				$max = count($this->dbdo->delivery_day);
    				for ( $i=0; $i<$max; $i++ )
    				{
    				    if ( $this->dbdo->delivery_day[$i]==="" )
    				    {
    				        $num = $i + 1;
                            $error .= "・{$num}通目の配信日が未入力です。<BR>\n";
                            $blank_flag = true;
                        }
                    }

                    if ( $blank_flag == false ) {

    					// 入力した値のCheck
    					if ( $this->dbdo->delivery_day[0]==="0" and $this->dbdo->reg_send == 0 ){
    						$error .= "・配信日は１日後から指定してください。<br>\n";
    					}else{

    						$delivery  = $this->dbdo->delivery_day;
    						$flag      = true;
    						$deli_flag = true;
    						$old_deli  = $delivery[0] - 1 ;
    						foreach ( $delivery AS $key => $val ) {
    							// 数値のCheck
    							if ( $Check->isNumber($val)==false ){
    								$flag = false;
    							}
    							// 日付の間隔
    							if ( ! ($old_deli < $val) ) {
    								$deli_flag = false;
    							}
    							$old_deli = $val;
    						}

    						if ( $flag==false ){
    							$error .= "・配信条件の日付は数値で入力してください。<br>\n";
    						}
    						if ( $deli_flag==false ){
    							$error .= "・配信条件の日付は最低1日間隔で入力してください。<br>\n";
    						}
    					}
    				}

				}

			} // else

		}

		$this->error = $error;

		return ( $error=="" );

	}

	/**
	* @return void
	* @desc   データを変換する
	*/
	function setDataConvert(){

		// delivery_num を配列形式に変更
		for( $i=0; $i<=6; $i++ ) {
			if ( isset($this->dbdo->delivery_week[$i])==false ) {
				$this->dbdo->delivery_week[$i] = -1;
			}
		}

		// 配信条件の日付で指定
		if ( $this->dbdo->reg_send == 1 )
        {
            $this->dbdo->delivery_day[0] = "0";
        }

		ksort($this->dbdo->delivery_week);
		ksort($this->dbdo->delivery_day);

		// 配送時間の設定
		$this->dbdo->delivery_time = $this->dbdo->delivery_h.":".$this->dbdo->delivery_m;

		// 表示用データ変換
		$this->view['reg_send'] = ( $this->dbdo->reg_send == "1") ? "はい" : "いいえ";

	}

	/**
	* @return void
	* @desc   DB上のデータの変換
	*/
	function setDBConvert(){
		// ,（カンマ）区切りを配列形式へ
		if ( $this->dbdo->delivery_week != ""){
			$this->dbdo->delivery_week = explode(",", $this->dbdo->delivery_week);
		}
		if ( $this->dbdo->delivery_day  != ""){
			$this->dbdo->delivery_day  = explode(",", $this->dbdo->delivery_day);
		}

		list($this->dbdo->delivery_h,$this->dbdo->delivery_m,) = explode(":", $this->dbdo->delivery_time);

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
					$this->dbdo->{$key}[$k2] = ( $flag ) ? htmlspecialchars( trim($v2), ENT_QUOTES ) : trim($v2);
				}
			}else{
				$this->dbdo->{$key} = ($flag) ? htmlspecialchars( trim($val), ENT_QUOTES) : trim($val);
			}

		}

//		print_a ( $this->dbdo , "_before_dbdo");
//
//		$this->dbdo->delivery_week = "";
//
//		if ( isset($this->dbdo->delivery_week) ) {
//			print "_delivery_week = ". $this->dbdo->delivery_week ppppppppppppppppp."<br>\n";
//		}else {
//			print "_delivery_week = 宣言されてねぇ <br>\n";
//		}
//
//		print_a ($ary, "_POST_ARY_DATA");
//
		// DBDOに値を渡す
//		$this->dbdo->setFrom($ary);

		// 曜日の指定
		//

//		print_a ( $this->dbdo , "_after_dbdo");

//		unset($ary);

	}

	/**
	* @return void
	* @desc   td_scheduleのDBDOの宣言
	*/
	function setDBDO($lv=0){

    $this->dbdo = DB_DataObject::factory("Public_td_schedule");

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
				<table width="530" border="0" cellpadding="5" cellspacing="5">
					<tr>
						<td class="black12">
							<font color="#FF0000">
							以下の入力エラーが発生しました。<br>
							{$this->error}<BR>

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