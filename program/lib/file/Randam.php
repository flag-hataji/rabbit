<?php

class Randam
{

  var $words = "";

  function Randam(){
    $this->words[]=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'); 
    $this->words[]=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'); 
    $this->words[]=array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 0); 
  }

  /*
   * ランダム英数字生成
   */
  function randamWord($length=10, $output=False ){

    $makeWord = "";
    for($i=0 ;$i<$length; $i++) { 

      mt_srand( (double)microtime()*1000000 );

      $key =mt_rand(0,2);

      if ($key==2) {
        $num = mt_rand(0,10);
      }else{
        $num = mt_rand(0,25);
      }

      if( $output ){
        echo $this->words[$key][$num];
      }else{
        $makeWord .= $this->words[$key][$num];
      }
    }

    return $makeWord;
  }
}
?>