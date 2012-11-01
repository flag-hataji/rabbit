<?PHP

class Cookie {

  var $timeNum  = 604800;
  var $timeSet  = "";
  var $timeDrop = "";

  function Cookie(){

    $this->timeNum  = 604800;
    $this->timeSet  = time()+$this->timeNum;
    $this->timeDrop = time()-$this->timeNum+3600;

  }

  // *SET* COOOKIEÆâÊÝÂ¸
  function setCookie($name=False,$dataS=False){
    if( isset($dataS) ){
      if(is_array($dataS)){
        foreach($dataS as $key=>$value ){
          setcookie("{$name}[{$key}]", $value, $this->timeSet);
        }
      }else{
        setcookie("{$name}", $dataS, $this->timeSet);
      }
    }
    return ;
  }

  // *SET* CookieÆâÇË´þ
  function dropCookie($name=False,$dataS=False){

    if(isset($name) && $name!="" ){
      if( isset($dataS) && is_array($dataS)){
        foreach($dataS as $key=>$value ){
          setcookie("{$name}[{$key}]", "", $this->timeDrop);
        }
      }else{
        setcookie("{$name}", "", $this->timeDrop);
      }
    }

    return ;
  }



}
?>
