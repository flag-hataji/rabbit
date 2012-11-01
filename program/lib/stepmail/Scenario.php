<?PHP
/**
 * ���ʥꥪ ���饹
 *
 * @author fujita
 * @package defaultPackage
 */

class Scenario {

	var $dbdo 		= "";	// td_scenario��DBDO
	var $tmp_dbdo = "";	// td_scenario��DBDO tmp

	var $error = "";

	/**
	* @return boid
	* @param  user_id �桼����ID
	* @param  mode    ��Ͽmode
	* @desc   ��Ͽ����
	*/
	function isRegist($user_id, $scenario_id, $mode){

		switch ($mode){
			case "insert":
		  	// �ǡ����μ���
				$flag = $this->isInsert($user_id);
				break;
			case "update":
		  	// �ǡ����μ���
				$flag = $this->isUpdate($scenario_id);
				break;
			case "delete":
				$flag = $this->isDelete($scenario_id);
				break;
			default:
				die("ͽ������Error��ȯ�����ޤ��� Scenario ".__LINE__);
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
	* @param  scenario_id ���ʥꥪ�ֹ�
	* @desc   �ۿ���ߡ��Ƴ�����
	*/
	function isStop($scenario_id){

		// PEAR DB���֥������Ȥμ���
		$db = $this->dbdo->getDatabaseConnection();

		// SQLʸ
		$sql  = "UPDATE td_scenario SET ";
		$sql .= " flag_send = case when flag_send=0 then 1 else 0 end ";
		$sql .= "WHERE scenario_id = $scenario_id ";

		print "sql = {$sql} <br>\n";

		// ��Ͽ����
		$rs = $db->query($sql);
		if ( DB::isError($rs) ){
			// Errorȯ��
			$this->error  = "���ʥꥪ���������ǥ��顼��ȯ�����ޤ�����<br>\n";
			$this->error .= $rs->message."<br>\n";
			$this->error .= $rs->userinfo."<br>\n";

//			print_a($rs, "_Error_Obj");

			return false;
		}

		return true;

	}

	/**
	* @return boid
	* @param  scenario_id ���ʥꥪ�ֹ�
	* @desc   ��Ͽ����
	*/
	function isDelete($scenario_id){

		// PEAR DB���֥������Ȥμ���
		$db = $this->dbdo->getDatabaseConnection();

		// SQLʸ
		$sql  = "DELETE FROM td_scenario ";
		$sql .= "WHERE scenario_id = $scenario_id ";

		print "sql = {$sql} <br>\n";

		// �������
		$rs = $db->query($sql);
		if ( DB::isError($rs) ){
			// Errorȯ��
			$this->error  = "���ʥꥪ��������ǥ��顼��ȯ�����ޤ�����<br>\n";
			$this->error .= $rs->message."<br>\n";
			$this->error .= $rs->userinfo."<br>\n";

//			print_a($rs, "_Error_Obj");

			return false;
		}

		return true;

	}

	/**
	* @return boid
	* @param  user_id �桼����ID
	* @desc   ��Ͽ����
	*/
	function isUpdate($scenario_id){

		// PEAR DB���֥������Ȥμ���
		$db = $this->dbdo->getDatabaseConnection();

		// SQLʸ
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

		// ��Ͽ����
		$rs = $db->query($sql);
		if ( DB::isError($rs) ){
			// Errorȯ��
			$this->error  = "���ʥꥪ���������ǥ��顼��ȯ�����ޤ�����<br>\n";
			$this->error .= $rs->message."<br>\n";
			$this->error .= $rs->userinfo."<br>\n";

//			print_a($rs, "_Error_Obj");

			return false;
		}

		return true;

	}


	/**
	* @return boid
	* @param  user_id �桼����ID
	* @desc   ������Ͽ
	*/
	function isInsert($user_id){

		// sequence�ͤμ���
		$db = $this->dbdo->getDatabaseConnection();
		$next_id = $db->nextId('td_scenario_scenario_id_seq');

		// �ͤ�����
		$this->dbdo->scenario_id  = $next_id;
		$this->dbdo->schedule_id  = "null";
		$this->dbdo->user_id  		= $user_id;
		$this->dbdo->flag_send 		= 1;
		$this->dbdo->ins_date 		= "now()";
		$this->dbdo->up_date  		= "now()";

		// ��Ͽ����
		if ( ! $this->dbdo->insert() ){
			// Errorȯ��
			$this->error  = "���ʥꥪ��Ͽ�����ǥ��顼��ȯ�����ޤ�����<br>\n";
			$this->error .= $this->dbdo->_lastError->message;
			return false;
		}

		return true;

	}

	/**
	* @return bool
	* @desc   ���ʥꥪ������Check
	*/
	function isCheck(){

		include_once _DIR_LIB_."check/Check.php";
		$Check = new Check();

		$error = "";

		// ���ʥꥪ̾
		if ( $this->dbdo->scenario_name=="" ){
			$error .= "�����ʥꥪ̾��̤���ϤǤ�<br>\n";
		}

		// ������̾
		if ( $this->dbdo->email_from_name==""){
			$error .= "��������̾��̤���ϤǤ�<br>\n";
		}

		// �����ԥ᡼�륢�ɥ쥹
		if ( $this->dbdo->email_from != "" ){
			if ( $Check->isMail($this->dbdo->email_from)==false ) {
				$error .= "�������ԥ᡼�륢�ɥ쥹�������Ǥ�<br>\n";
			}
		}else{
			$error .= "�������ԥ᡼�륢�ɥ쥹��̤���ϤǤ�<br>\n";
		}

		// �������顼�������
		if ( $this->dbdo->email_error != "" ){
			if ( $Check->isMail($this->dbdo->email_error)==false ) {
				$error .= "���������顼���ͤ������Ǥ�<br>\n";
			}
		}else{
			$error .= "���������顼������褬̤���ϤǤ�<br>\n";
		}

		$this->error = $error;

		return ( $error=="" );

	}

	/**
	* @return void
	* @param  &$data
	* @param  $flag
	* @desc   �ǡ������ѿ��˳�Ǽ
	*/
	function setPostToData(&$data, $flag=false){

		$ary = array();

		// �ץ�ѥƥ�̾��¸�ߤ����ΤΤ��ͤ򥻥å�
		foreach ( $data as $key => $val ){

			if ( is_array($val) ) {
				foreach ( $val as $k2 => $v2) {
					$ary[$key][$k2] = ( $flag ) ? htmlspecialchars( trim($v2), ENT_QUOTES ) : trim($v2);
				}
			}else{
				$ary[$key] = ($flag) ? htmlspecialchars( trim($val), ENT_QUOTES) : trim($val);
			}

		}

		// DBDO���ͤ��Ϥ�
		$this->dbdo->setFrom($ary);

		unset($ary);

	}

	/**
	* @return bool
	* @desc   Demo�Ǥ�Check & ���ʥꥪ��Ͽ��Check
	*/
	function isDemoCheck(){

		// DEMO�ǤǤ��Ǥˣ��ĥ��ʥꥪ����Ͽ���Ƥ���� true ���֤�

		// DB��³
		if ( $this->dbdo == "" ) {
			$this->setDBDO();
		}

		// - ����Ѥߡ�
		if ( $_SESSION['user']['flag_stepmail']=='t' ) {
			return false;
		}

		// - ���ʥꥪ����Ͽ�������
		$cnt = $this->dbdo->get("user_id", $_SESSION['user']['user_id']);

		if ( 1 <= $cnt ){
			// ���ʥꥪ�������С�
			print "�����С� \n";
			return true;
		}else {
			// ���ʥꥪ��ϿOK
			print "OK \n";
			return false;
		}

	}

	/**
	* @return void
	* @desc   td_scenario��DBDO�����
	*/
	function setDBDO($lv=0){

    $this->dbdo = DB_DataObject::factory("Public_td_scenario");

		if ( get_class($this->dbdo) == "db_dataobject_error" ) {
			$str  = "DB_DataObject������˼��Ԥ��ޤ�����<br>\n";
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
							�ʲ������ϥ��顼��ȯ�����ޤ�����<br>
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