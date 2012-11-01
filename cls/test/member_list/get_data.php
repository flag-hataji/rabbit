<?PHP
//DBデータ取得

	function outPutIndustry($industry_3_id){
	global $cPostgres;
		$query = "SELECT *  FROM  tm_industry_3 WHERE flag_show = '1' ORDER BY sort";
		$dataS = $cPostgres->executeQuery($query);
		
		$i = 0;
		$opIndustry = "                      <option VALUE=''>選択してください</option>";
		while ($getData[] = pg_fetch_array($dataS)){
				if($industry_3_id == $getData[$i]['industry_3_id'] ){
					$opIndustry .= "                      <option selected VALUE='{$getData[$i]['industry_3_id']}'>{$getData[$i]['industry_3']}</option>\n";
				}else{
					$opIndustry .= "                      <option VALUE='{$getData[$i]['industry_3_id']}'>{$getData[$i]['industry_3']}</option>\n";
				}
		$i++;
		}
		
		echo"
                    <select name='aData[industry_3_id]'>
                      {$opIndustry}
                    </select>
        ";
//		/print_r($getData);
	return;
	}


	function outPutPref($pref_id){
	global $cPostgres;
		$query = "SELECT * FROM tm_pref ORDER BY sort ";
		$dataS = $cPostgres->executeQuery($query);
		
		$i = 0;
		while ($getData[] = pg_fetch_array($dataS)){
				if($pref_id == $getData[$i]['pref_id'] ){
					$opPref .= "                      <option selected VALUE='{$getData[$i]['pref_id']}'>{$getData[$i]['pref']}</option>\n";
				}else{
					$opPref .= "                      <option VALUE='{$getData[$i]['pref_id']}'>{$getData[$i]['pref']}</option>\n";
				}
		$i++;
		}
		
		echo"
                    <select name='aData[pref_id]'>
                      {$opPref}
                    </select>
        ";
//		/print_r($getData);
	return;
	}


	function outPutBranch($branch_id){
	global $cPostgres;
		$query = "SELECT branch_id,branch  FROM tm_branch WHERE flag_show = '1' ORDER BY sort";
		$dataS = $cPostgres->executeQuery($query);
		
		
		
		$i = 0;
		$opBranch = "                      <option VALUE=''>選択してください</option>";
		while ($getData[] = pg_fetch_array($dataS)){
				if($branch_id == $getData[$i]['branch_id'] ){
					$opBranch .= "                      <option selected VALUE='{$getData[$i]['branch_id']}'>{$getData[$i]['branch']}</option>\n";
				}else{
					$opBranch .= "                      <option VALUE='{$getData[$i]['branch_id']}'>{$getData[$i]['branch']}</option>\n";
				}
		$i++;
		}
		
		echo"
                    <select name='aData[branch_id]'>
                      {$opBranch}
                    </select>
        ";
//		/print_r($getData);
	return;
	}

	function outPutStaff($staff_id){
	global $cPostgres;
		$query = "SELECT staff_id, staff  FROM tm_staff WHERE flag_show = '1' ORDER BY sort";
		$dataS = $cPostgres->executeQuery($query);
		
		
		
		$i = 0;
		$opStaff = "                      <option VALUE=''>選択してください</option>";
		while ($getData[] = pg_fetch_array($dataS)){
				if($staff_id == $getData[$i]['staff_id'] ){
					$opStaff .= "                      <option selected VALUE='{$getData[$i]['staff_id']}'>{$getData[$i]['staff']}</option>\n";
				}else{
					$opStaff .= "                      <option VALUE='{$getData[$i]['staff_id']}'>{$getData[$i]['staff']}</option>\n";
				}
		$i++;
		}
		
		echo"
                    <select name='aData[staff_id]'>
                      {$opStaff}
                    </select>
        ";
//		/print_r($getData);
	return;
	}

	
	
	function outPutDay($year,$month,$day,$dataName){
		if(!$year || !$month || !$day){
		  date("Y/m/d");
		  $year  = date("Y");
		  $month = date("m");
		  $day   = date("d");
		}

			$y = date("Y")-100;
			while( $y <= date("Y") ){
				if($y == $year ){
					$opYear .= "                      <option selected>{$y}</option>\n";
				}else{
					$opYear .= "                      <option>{$y}</option>\n";
				}
			$y++;
			}

			$m = 1;
			while( $m <= 12 ){
				if($m == $month ){
					$opMonth .= "                      <option selected>{$m}</option>\n";
				}else{
					$opMonth .= "                      <option>{$m}</option>\n";
				}
			$m++;
			}

			$d = 1;
			while( $d <= 31 ){
				if($d == $day ){
					$opDay .= "                      <option selected>{$d}</option>\n";
				}else{
					$opDay .= "                      <option>{$d}</option>\n";
				}
			$d++;
			}

		echo"
                    <select name='aData[{$dataName}1]'>
                      {$opYear}
                    </select>
                    年 
                    <select name='aData[{$dataName}2]'>
                      {$opMonth}
                    </select>
                    月 
                    <select name='aData[{$dataName}3]'>
                      {$opDay}
                    </select>
                    日
        ";

	return;
	}

	
	
	
//confirm
	function outPutPrefConfirm($pref_id){
	global $cPostgres;
		$query = "SELECT pref FROM tm_pref WHERE pref_id ={$pref_id} ";
		$dataS = $cPostgres->executeQuery($query);

		$getData = pg_fetch_array($dataS);
		
		echo $getData['pref'];
//		/print_r($getData);
	return;
	}

	function outPutIndustryConfirm($industry_3_id){
	global $cPostgres;
		$query = "SELECT industry_3 FROM tm_industry_3 WHERE industry_3_id ={$industry_3_id} ";
		$dataS = $cPostgres->executeQuery($query);

		$getData = pg_fetch_array($dataS);
		
		echo $getData['industry_3'];
//		print_r($getData);
	return;
	}

	function outPutBranchConfirm($branch_id){
	global $cPostgres;
		$query = "SELECT branch FROM tm_branch WHERE branch_id ={$branch_id} ";
		$dataS = $cPostgres->executeQuery($query);

		$getData = pg_fetch_array($dataS);
		
		echo $getData['branch'];
//		print_r($getData);
	return;
	}
	
	function outPutStaffConfirm($staff_id){
	global $cPostgres;
		$query = "SELECT staff FROM tm_staff WHERE staff_id ={$staff_id} ";
		$dataS = $cPostgres->executeQuery($query);

		$getData = pg_fetch_array($dataS);
		
		echo $getData['staff'];
//		print_r($getData);
	return;
	}
?>