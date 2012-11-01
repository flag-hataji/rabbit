<?PHP
/*
  マスタ周り
*/

  class Library {

    /*
     * コンストラクタ
     */
    function Library(){


      return ;
    }

    function aryGender(){
      $array[] = array('id'=>'1', 'name'=>'男性', 'open'=>True );
      $array[] = array('id'=>'2', 'name'=>'女性', 'open'=>True );
      $array[] = array('id'=>'3', 'name'=>'不問', 'open'=>True );
      return $array;
    }

    function aryYesOrNo(){
      $array[] = array('id'=>'0', 'name'=>'×', 'open'=>True );
      $array[] = array('id'=>'1', 'name'=>'○',   'open'=>True );
      return $array;
    }

    function aryShow(){
      $array[] = array('id'=>'1', 'name'=>'公開する',   'open'=>True );
      $array[] = array('id'=>'2', 'name'=>'公開しない', 'open'=>True );
      $array[] = array('id'=>'3', 'name'=>'終了',       'open'=>True );
      return $array;
    }


    function aryPresence(){
      $array[] = array( 'id'=>1, 'name'=>'あり', 'open'=>True );
      $array[] = array( 'id'=>0, 'name'=>'なし', 'open'=>True );
      return $array;
    }

    function aryDm(){
      $array[] = array( 'id'=>1, 'name'=>'受信する', 'open'=>True );
      $array[] = array( 'id'=>2, 'name'=>'受信しない', 'open'=>True );
      return $array;
    }


    function arySend(){
      $array[] = array( 'id'=>1, 'name'=>'送信する', 'open'=>True );
      $array[] = array( 'id'=>2, 'name'=>'送信しない', 'open'=>True );
      return $array;
    }

    function arySend2(){
      $array[] = array( 'id'=>1, 'name'=>'不正アドレスを省いて送信する', 'open'=>True );
      $array[] = array( 'id'=>2, 'name'=>'送信せずに不正アドレスを確認する', 'open'=>True );
      return $array;
    }


  }

?>
