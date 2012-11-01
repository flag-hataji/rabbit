<?PHP
/**
 * ���ʥꥪ ���饹
 *
 * @author fujita
 * @package defaultPackage
 */

class Schedule {

	var $dbdo  = "";	// td_schedule��DB���֥�������

	var $view  = "";   // ɽ���Ѥ��ѿ�

	var $error = "";

	/**
	 * @return void
	 * @desc   �������
	 */
	function Schedule()
	{
	    // �����
	    $this->dbdo->reg_send = 0;
	}

	/**
	* @return boid
	* @param  user_id �桼����ID
	* @param  mode    ��Ͽmode
	* @desc   ��Ͽ����
	*/
	function isRegist($scenario_id, $mode){

		switch ($mode){
			case "insert":
		  	// �ǡ����μ���
				$flag = $this->isInsert($scenario_id);
				break;
			case "update":
		  	// �ǡ����μ���
				$flag = $this->isUpdate($scenario_id);
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
	* @return boid
	* @param  user_id �桼����ID
	* @desc   ��Ͽ����
	*/
	function isUpdate($scenario_id){

		// PEAR DB���֥������Ȥμ���
		$db = $this->dbdo->getDatabaseConnection();

		// ����򥫥�޶��ڤ��
		if ( $this->dbdo->flag_delivery==1 ){
			// �����ǻ���
			ksort($this->dbdo->delivery_week);
			$delivery_week = implode(',', $this->dbdo->delivery_week );
			$delivery_day  = "";
		}else {
			// ���դǻ���
			ksort($this->dbdo->delivery_day);
			$delivery_week = "";
			$delivery_day  = implode(',', $this->dbdo->delivery_day );
		}

		// SQLʸ
		$sql  = "UPDATE td_schedule SET ";
		$sql .= " flag_delivery   = {$this->dbdo->flag_delivery} , ";
		$sql .= " delivery_week   = '{$delivery_week}' , ";
		$sql .= " delivery_day    = '{$delivery_day}', ";
		$sql .= " delivery_time   = '{$this->dbdo->delivery_time}', ";
		$sql .= " up_date     	  =  now(), ";
		$sql .= " reg_send        = {$this->dbdo->reg_send} ";
		$sql .= "WHERE schedule_id = {$this->dbdo->schedule_id} ";

		// ��Ͽ����
		$rs = $db->query($sql);
		if ( DB::isError($rs) ){
			// Errorȯ��
			$this->error  = "���ʥꥪ���������ǥ��顼��ȯ�����ޤ�����<br>\n";
			$this->error .= $rs->message."<br>\n";
			$this->error .= $rs->userinfo."<br>\n";
			return false;
		}

		return true;

	}

	/**
	* @return boid
	* @param  user_id �桼����ID
	* @desc   ������Ͽ
	*/
	function isInsert($scenario_id){

		// sequence�ͤμ���
		$db = $this->dbdo->getDatabaseConnection();
		$db->autoCommit(false);	// ��ư���ߥå� off

		$next_id = $db->nextId('td_schedule_schedule_id_seq');

		// ����򥫥�޶��ڤ��
		if ( $this->dbdo->flag_delivery==1 ){
			// �����ǻ���
			ksort($this->dbdo->delivery_week);
			$delivery_week = implode(',', $this->dbdo->delivery_week );
			$delivery_day  = "";
		}else {
			// ���դǻ���
			ksort($this->dbdo->delivery_day);
			$delivery_week = "";
			$delivery_day  = implode(',', $this->dbdo->delivery_day );
		}

		// �ͤ�����
		$sql  = "INSERT INTO td_schedule(schedule_id, scenario_id, flag_delivery, delivery_week, delivery_day, delivery_time, ins_date, up_date, reg_send) ";
		$sql .= " VALUES ( {$next_id}, {$this->dbdo->scenario_id}, {$this->dbdo->flag_delivery}, '{$delivery_week}', '{$delivery_day}', '{$this->dbdo->delivery_time}', now(), now(), {$this->dbdo->reg_send} ); ";

		// td_schedule ��Ͽ����
		$rs = $db->query($sql);
		if ( DB::isError($rs) ){
			// Errorȯ��
			$db->rollback();
			$this->error  = "�������塼����Ͽ�����ǥ��顼��ȯ�����ޤ�����<br>\n";
			$this->error .= $rs->message."<br>\n";
			$this->error .= $rs->userinfo."<br>\n";
			return false;
		}

		$sql  = "UPDATE td_scenario SET schedule_id={$next_id} WHERE scenario_id={$scenario_id}";

		// td_scenario ��Ͽ����
		$rs = $db->query($sql);
		if ( DB::isError($rs) ){
			// Errorȯ��
			$db->rollback();
			$this->error  = "�������塼����Ͽ�����ǥ��顼��ȯ�����ޤ�����<br>\n";
			$this->error .= $rs->message."<br>\n";
			$this->error .= $rs->userinfo."<br>\n";
			return false;
		}

		$db->commit();	// ���ߥå�

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

		// �ۿ�����
		if ( $this->dbdo->delivery_time=="" ){
			$error.= "���ۿ����֤����򤷤Ƥ���������<br>\n";
		}

		// �ۿ��������������ˤ���
		if ( $this->dbdo->flag_delivery == "" ){
			$error .= "���ۿ��������򤷤Ƥ���������<br>\n";

		}else{

			// �ۿ���������Check
			if ( $this->dbdo->flag_delivery==1 ){
				// ����
				$week_flag = false;
				foreach ( $this->dbdo->delivery_week as $val ){
					if ( $val== 1 )	{ $week_flag=true; }
				}

				if ( $week_flag==false ){
					$error .= "���ۿ��������������򤷤Ƥ���������<br>\n";
				}

			}else {

				// ����

				// �������� & ��Ͽ���ۿ� & ���ƥåפ����Ĥξ����ü�ʾ��
				if ( isset($this->dbdo->delivery_day)==false ) {
					//
				}else{

    				// ̤���ϤΥ����å�
    				$blank_flag = false;
    				$max = count($this->dbdo->delivery_day);
    				for ( $i=0; $i<$max; $i++ )
    				{
    				    if ( $this->dbdo->delivery_day[$i]==="" )
    				    {
    				        $num = $i + 1;
                            $error .= "��{$num}���ܤ��ۿ�����̤���ϤǤ���<BR>\n";
                            $blank_flag = true;
                        }
                    }

                    if ( $blank_flag == false ) {

    					// ���Ϥ����ͤ�Check
    					if ( $this->dbdo->delivery_day[0]==="0" and $this->dbdo->reg_send == 0 ){
    						$error .= "���ۿ����ϣ����夫����ꤷ�Ƥ���������<br>\n";
    					}else{

    						$delivery  = $this->dbdo->delivery_day;
    						$flag      = true;
    						$deli_flag = true;
    						$old_deli  = $delivery[0] - 1 ;
    						foreach ( $delivery AS $key => $val ) {
    							// ���ͤ�Check
    							if ( $Check->isNumber($val)==false ){
    								$flag = false;
    							}
    							// ���դδֳ�
    							if ( ! ($old_deli < $val) ) {
    								$deli_flag = false;
    							}
    							$old_deli = $val;
    						}

    						if ( $flag==false ){
    							$error .= "���ۿ��������դϿ��ͤ����Ϥ��Ƥ���������<br>\n";
    						}
    						if ( $deli_flag==false ){
    							$error .= "���ۿ��������դϺ���1���ֳ֤����Ϥ��Ƥ���������<br>\n";
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
	* @desc   �ǡ������Ѵ�����
	*/
	function setDataConvert(){

		// delivery_num ������������ѹ�
		for( $i=0; $i<=6; $i++ ) {
			if ( isset($this->dbdo->delivery_week[$i])==false ) {
				$this->dbdo->delivery_week[$i] = -1;
			}
		}

		// �ۿ��������դǻ���
		if ( $this->dbdo->reg_send == 1 )
        {
            $this->dbdo->delivery_day[0] = "0";
        }

		ksort($this->dbdo->delivery_week);
		ksort($this->dbdo->delivery_day);

		// �������֤�����
		$this->dbdo->delivery_time = $this->dbdo->delivery_h.":".$this->dbdo->delivery_m;

		// ɽ���ѥǡ����Ѵ�
		$this->view['reg_send'] = ( $this->dbdo->reg_send == "1") ? "�Ϥ�" : "������";

	}

	/**
	* @return void
	* @desc   DB��Υǡ������Ѵ�
	*/
	function setDBConvert(){
		// ,�ʥ���ޡ˶��ڤ�����������
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
	* @desc   �ǡ������ѿ��˳�Ǽ
	*/
	function setPostToData(&$data, $flag=false){

		$ary = array();

		// �ץ�ѥƥ�̾��¸�ߤ����ΤΤ��ͤ򥻥å�
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
//			print "_delivery_week = �������Ƥͤ� <br>\n";
//		}
//
//		print_a ($ary, "_POST_ARY_DATA");
//
		// DBDO���ͤ��Ϥ�
//		$this->dbdo->setFrom($ary);

		// �����λ���
		//

//		print_a ( $this->dbdo , "_after_dbdo");

//		unset($ary);

	}

	/**
	* @return void
	* @desc   td_schedule��DBDO�����
	*/
	function setDBDO($lv=0){

    $this->dbdo = DB_DataObject::factory("Public_td_schedule");

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
				<table width="530" border="0" cellpadding="5" cellspacing="5">
					<tr>
						<td class="black12">
							<font color="#FF0000">
							�ʲ������ϥ��顼��ȯ�����ޤ�����<br>
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