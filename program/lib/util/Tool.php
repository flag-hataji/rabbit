<?PHP
/*

  各種ツールクラス集

*/

class Tool {

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

      $words[]=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'); 
      $words[]=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'); 
      $words[]=array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 0); 

      if( $output ){
        echo $words[$key][$num];
      }else{
        $makeWord .= $words[$key][$num];
      }
    }

    return $makeWord;
  }


    /*
     * 擬似暗号化
     */
   function fake_encode($str=False){

      $str = base64_encode($str);
      $str = substr($str,$num-($num*2)).substr($str,$num,$num-($num*2)).substr($str,0,$num);

      return $str;
    }

    /*
     * 擬似複合化
     */
   function fake_decode($str=False){

      $str = substr($str,$num-($num*2)).substr($str,$num,$num-($num*2)).substr($str,0,$num);
      $str = base64_decode($str);

      return $str;
    }

}
?>
