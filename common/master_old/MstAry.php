<?PHP
/*
  �ޥ�������饤�֥��
*/

  class MstAry {

    /*
     *  �ѿ������
     */


    /*
     * ���󥹥ȥ饯��
     */
    Function MstAry(){


      return ;
    }


    /*
     * ����
     */
    Function genderAry(){

      $array = "";

      $array[] = array( 'id'=>1, 'name'=>'����', 'open'=>True );
      $array[] = array( 'id'=>2, 'name'=>'����', 'open'=>True );
      $array[] = array( 'id'=>3, 'name'=>'��̩', 'open'=>True );

      return $array;
    }


    /*
     * mitisuji 
     
     */
    Function rootAry(){

      $array = "";

      $array[] = array( 'id'=>1, 'name'=>'�֥��ξҲ�', 'open'=>True );
      $array[] = array( 'id'=>2, 'name'=>'���ޥ�', 'open'=>True );
      $array[] = array( 'id'=>3, 'name'=>'���饷', 'open'=>True );
      $array[] = array( 'id'=>4, 'name'=>'it1616.com', 'open'=>True );
      $array[] = array( 'id'=>5, 'name'=>'Google����', 'open'=>True );
      $array[] = array( 'id'=>6, 'name'=>'Google����', 'open'=>True );
      $array[] = array( 'id'=>7, 'name'=>'Yahoo����', 'open'=>True );
      $array[] = array( 'id'=>8, 'name'=>'Yahoo����', 'open'=>True );

      return $array;
    }




    /*
     * DM����
     */
    Function dmAry(){

      $array = "";

      $array[] = array( 'id'=>0, 'name'=>'�������ʤ�',  'open'=>True );
      $array[] = array( 'id'=>1, 'name'=>'�������',      'open'=>True );

      return $array;
    }


    /*
     * �����ʬ
     */
    Function userAry(){

      $array = "";

      $array[] = array( 'id'=>0, 'name'=>'�����',               'open'=>True );
      $array[] = array( 'id'=>1, 'name'=>'�ܲ��',               'open'=>True );
      $array[] = array( 'id'=>2, 'name'=>'���󥿡��ץ饤�����', 'open'=>True );

      return $array;
    }

    /*
     * ���ѵ���
     */
    Function permissionAry(){

      $array = "";

      $array[] = array( 'id'=>0, 'name'=>'�Բ�',  'open'=>True );
      $array[] = array( 'id'=>1, 'name'=>'����',  'open'=>True );

      return $array;
    }

    /*
     * ���
     */
    Function delAry(){

      $array = "";

      $array[] = array( 'id'=>0, 'name'=>'��¸',  'open'=>True );
      $array[] = array( 'id'=>1, 'name'=>'���',  'open'=>True );

      return $array;
    }


  }

?>
