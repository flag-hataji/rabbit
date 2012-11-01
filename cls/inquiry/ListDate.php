<?PHP
//年月日自動表示

class ListDate
{

	var $defaultYear  = "";
	var $defaultMonth = "";
	var $defaultDay   = "";

	function ListDate(){
		$this->defaultYear  = date('Y');
		$this->defaultMonth = date('m');
		$this->defaultDay   = date('d');
	return;
	}


	function Listyear($year){
		if(!$year){ $year = $this->defaultYear; }
		$i= $this->defaultYear - 80;
			for ($i ; $i <= $this->defaultYear ; $i++){
				if($i == $year ){
					print "<option selected>$i</option>\n";
				}else{
					print "<option >$i</option>\n";
				}
			}

	return;
	}

	function Listmonth($month){
		if(!$month){ $month = $this->defaultMonth; }
		$i = 1;
			for($i ; $i <= 12 ; $i++){
				if($i == $month ){
					print "<option selected>$i</option>\n";
				}else{
					print "<option >$i</option>\n";
				}
			}
	return;
	}


	function Listday($day){
		if(!$day){ $day = $this->defaultDay; }
		$i = 1;
			for($i ; $i <= 31 ; $i++ ){
				if($i == $day ){
					print "<option selected>$i</option>\n";
				}else{
					print "<option >$i</option>\n";
				}
			}
	return;
	}

}
?>