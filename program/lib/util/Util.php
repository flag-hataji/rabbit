<?PHP
/* 2005/02/08 Sunao Kiyosue ITM */

class Util
{
  function Util(){

  }

  function mbTrim($str){
    $str = mb_ereg_replace("^[¡¡ ]+","",$str);
    $str = mb_ereg_replace("[¡¡ ]+$","",$str);
    return $str ;
  }

  function br2LF( $str ){
    $str = str_replace("<br>","\n",$str);
    $str = str_replace("<br />","\n",$str);
    return $str;
  }

  function nl2LF( $str ){
    $str = str_replace("\r\n","\n",$str);
    $str = str_replace("\r","\n",$str);
    return $str;
  }

  function nl2Del( $str ){
    $str = str_replace("\r\n","",$str);
    $str = str_replace("\r",  "",$str);
    $str = str_replace("\n",  "",$str);
    return $str ;
  }

  function decodeTag( $str ){
    $str = str_replace("&#039;", "'",  $str);
    $str = str_replace("&amp;","&",$str);
    $str = str_replace("&quot;","\"",$str);
    $str = str_replace("&lt;","<",$str);
    $str = str_replace("&gt;",">",$str);
    return $str;
  }

  function sjisChange($str){
    $str = rawurlencode($str);
    $str = ereg_replace("%5C%5C","%5C",$str);
    $str = rawurldecode($str);
    return $str;
  }

}
?>