<?PHP
/*
  マスタ周りライブラリ
*/

  class MstAry {

    /*
     *  変数の宣言
     */


    /*
     * コンストラクタ
     */
    Function MstAry(){


      return ;
    }


    /*
     * 性別
     */
    Function genderAry(){

      $array = "";

      $array[] = array( 'id'=>1, 'name'=>'男性', 'open'=>True );
      $array[] = array( 'id'=>2, 'name'=>'女性', 'open'=>True );
      $array[] = array( 'id'=>3, 'name'=>'秘密', 'open'=>True );

      return $array;
    }


    /*
     * mitisuji 
     
     */
    Function rootAry(){

      $array = "";

      $array[] = array( 'id'=>1, 'name'=>'ブログの紹介', 'open'=>True );
      $array[] = array( 'id'=>2, 'name'=>'メルマガ', 'open'=>True );
      $array[] = array( 'id'=>3, 'name'=>'チラシ', 'open'=>True );
      $array[] = array( 'id'=>4, 'name'=>'it1616.com', 'open'=>True );
      $array[] = array( 'id'=>5, 'name'=>'Google広告', 'open'=>True );
      $array[] = array( 'id'=>6, 'name'=>'Google検索', 'open'=>True );
      $array[] = array( 'id'=>7, 'name'=>'Yahoo広告', 'open'=>True );
      $array[] = array( 'id'=>8, 'name'=>'Yahoo検索', 'open'=>True );

      return $array;
    }




    /*
     * DM送信
     */
    Function dmAry(){

      $array = "";

      $array[] = array( 'id'=>0, 'name'=>'受け取らない',  'open'=>True );
      $array[] = array( 'id'=>1, 'name'=>'受け取る',      'open'=>True );

      return $array;
    }


    /*
     * 会員区分
     */
    Function userAry(){

      $array = "";

      $array[] = array( 'id'=>0, 'name'=>'仮会員',               'open'=>True );
      $array[] = array( 'id'=>1, 'name'=>'本会員',               'open'=>True );
      $array[] = array( 'id'=>2, 'name'=>'エンタープライズ会員', 'open'=>True );

      return $array;
    }

    /*
     * 使用許可
     */
    Function permissionAry(){

      $array = "";

      $array[] = array( 'id'=>0, 'name'=>'不可',  'open'=>True );
      $array[] = array( 'id'=>1, 'name'=>'許可',  'open'=>True );

      return $array;
    }

    /*
     * 削除
     */
    Function delAry(){

      $array = "";

      $array[] = array( 'id'=>0, 'name'=>'生存',  'open'=>True );
      $array[] = array( 'id'=>1, 'name'=>'削除',  'open'=>True );

      return $array;
    }


  }

?>
