<?PHP
  /*
  *   DEBUG ���饹
  *   ����ǡ����򤽤�ʤ��ɽ��
  */
class clsDebug
{
 var $aData    = "";
 var $dataName = "";
 
  function printArrayData($aData,$dataName){
  	print "<br>----".$dataName."----<br>";
    	if(is_array($aData)){
    		$this->clsDebugforeach($aData,$count = 0);
    	}else{
    		print "[".$aData."] => ". $aData."<br>\n";
    	}
    	//print_r($aData);
    	print "<br>\n";
  return;
  }

  function clsDebugforeach($array,$count){
  	$count = $count+1;
  	foreach($array as $key => $value){
     		$i = 1; 
     		while($i<$count){
     			print "-";
     			$i++;
     		}
     		print "[".$key."] => ". $value."<br>\n";
     		if(is_array($value)) {
     			$this->clsDebugforeach($value,$count);
     		}
     }

  }
}
?>