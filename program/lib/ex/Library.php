<?PHP
/*
  �ޥ�������
*/

  class Library {

    /*
     * ���󥹥ȥ饯��
     */
    function Library(){


      return ;
    }

    function aryGender(){
      $array[] = array('id'=>'1', 'name'=>'����', 'open'=>True );
      $array[] = array('id'=>'2', 'name'=>'����', 'open'=>True );
      $array[] = array('id'=>'3', 'name'=>'����', 'open'=>True );
      return $array;
    }

    function aryYesOrNo(){
      $array[] = array('id'=>'0', 'name'=>'��', 'open'=>True );
      $array[] = array('id'=>'1', 'name'=>'��',   'open'=>True );
      return $array;
    }

    function aryShow(){
      $array[] = array('id'=>'1', 'name'=>'��������',   'open'=>True );
      $array[] = array('id'=>'2', 'name'=>'�������ʤ�', 'open'=>True );
      $array[] = array('id'=>'3', 'name'=>'��λ',       'open'=>True );
      return $array;
    }


    function aryPresence(){
      $array[] = array( 'id'=>1, 'name'=>'����', 'open'=>True );
      $array[] = array( 'id'=>0, 'name'=>'�ʤ�', 'open'=>True );
      return $array;
    }

    function aryDm(){
      $array[] = array( 'id'=>1, 'name'=>'��������', 'open'=>True );
      $array[] = array( 'id'=>2, 'name'=>'�������ʤ�', 'open'=>True );
      return $array;
    }


    function arySend(){
      $array[] = array( 'id'=>1, 'name'=>'��������', 'open'=>True );
      $array[] = array( 'id'=>2, 'name'=>'�������ʤ�', 'open'=>True );
      return $array;
    }

    function arySend2(){
      $array[] = array( 'id'=>1, 'name'=>'�������ɥ쥹��ʤ�����������', 'open'=>True );
      $array[] = array( 'id'=>2, 'name'=>'�����������������ɥ쥹���ǧ����', 'open'=>True );
      return $array;
    }


  }

?>
