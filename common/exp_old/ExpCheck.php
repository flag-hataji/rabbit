<?PHP
/*

  �ɲá���ĥ : WEB����


*/
/*

  �ɲá���ĥ : ���ϥ����å�

*/

  class ExpCheck extends Check {


    /*
     *  ��������Ȥ���
     *  $checkS['�����å���']['Ϣ��'] = array('key'=>'�ե������̾');
     *  ���� $checkS['�����å���']['Ϣ��'] = array('key'=>'�ե������̾','limit'=>����);
     *  ���� $checkS['�����å���']['Ϣ��'] = array('key'=>'�ե������̾','ex'=>��ĥ�����å�);
     *  $nameS['�ե������̾'] = '̾��';
     *  $dataS['�ե������̾'] = '�����å���������';
     *  �ξ嵭�ǡ������Ѱդ���
     */
    function errorAll( $dataS=False, $checkS=False, $nameS=False ){

      if(!$dataS ){
        return ;
      }

      if(!$checkS ){
        return ;
      }

      if(!$nameS ){
        return ;
      }

      $type  = "";
      $error = "";
      foreach($checkS as $type=>$typeS ){

        foreach( $typeS as $tNum=>$tVal ){

          $key = $checkS[$type][$tNum]['key'];

          $name = $nameS[$key];

          $str  = "";
          if( isset($dataS[$key]) ){
            $str  = $dataS[$key];
          }

          $limit = "";
          if( isset($checkS[$type][$tNum]['limit']) ) $limit = $checkS[$type][$tNum]['limit'];

          $ex = "";
          if( isset($checkS[$type][$tNum]['ex']) ) $ex = $checkS[$type][$tNum]['ex'];

          $errorKey = $type."_".$key;

          switch($type){

            case     'Input' : $error[$errorKey] = $this->errorInput( $str, $name );    break;
            case      'Mail' : $error[$errorKey] = $this->errorMail( $str, $name );     break;
            case    'Docomo' : $error[$errorKey] = $this->errorDocomo( $str, $name );   break;
            case  'Vodafone' : $error[$errorKey] = $this->errorVodafone( $str, $name ); break;
            case        'Au' : $error[$errorKey] = $this->errorAu( $str, $name );       break;
            case       'Zip' : $error[$errorKey] = $this->errorZip( $str, $name );      break;
            case       'Tel' : $error[$errorKey] = $this->errorTel( $str, $name );      break;
            case       'Url' : $error[$errorKey] = $this->errorUrl( $str, $name );      break;
            case      'Date' : $error[$errorKey] = $this->errorDate( $str, $name );     break;
            case        'Ei' : $error[$errorKey] = $this->errorEi( $str, $name );       break;
            case      'Eisu' : $error[$errorKey] = $this->errorEisu( $str, $name );     break;
            case 'EisuSpace' : $error[$errorKey] = $this->errorEisuSpace( $str, $name );break;
            case   'EiSpace' : $error[$errorKey] = $this->errorEiSpace( $str, $name );  break;
            case 'EisuKigou' : $error[$errorKey] = $this->errorEisuKigou( $str, $name );break;
            case  'KataKana' : $error[$errorKey] = $this->errorKataKana( $str, $name ); break;
            case        '16' : $error[$errorKey] = $this->error16( $str, $name );       break;
            case       'Len' : $error[$errorKey] = $this->errorLen( $str, $name, $limit );   break;
            case    'Mblen'  : $error[$errorKey] = $this->errorMblen( $str, $name, $limit ); break;
            case    'Number' : $error[$errorKey] = $this->errorNumber( $str, $name, $limit ); break; 
            case 'WideCheck' : $error[$errorKey] = $this->errorWideCheck( $str, $name, $limit ); break;
          }
          if( !$error[$errorKey] ) unset($error[$errorKey]);


        }

      }

      return $error;
    }



    // ����
    function errorInput($str=False,$name=False){
      $error = "";
      if(!$this->isInput($str)) $error = "{$name}��̤���ϤǤ�";
      return $error;
    }

    // �ᥢ��
    function errorMail($str=False,$name=False){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->isMail($str)) $error = "{$name}������������ޤ���";
      return $error;
    }

    // Docomo�ᥢ��
    function errorDocomo($str=False,$name=False){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->isDocomo($str)) $error = "{$name}������������ޤ���";
      return $error;
    }

    // Vodafone�ᥢ��
    function errorVodafone($str=False,$name=False){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->isVodafone($str)) $error = "{$name}������������ޤ���";
      return $error;
    }

    // au�ᥢ��
    function errorAu($str=False,$name=False){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->isAu($str)) $error = "{$name}������������ޤ���";
      return $error;
    }

    // ͹���ֹ�
    function errorZip($str=False,$name=False){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->isZip($str)) $error = "{$name}������������ޤ���";
      return $error;
    }


    // �����ֹ�
    function errorTel($str=False,$name=False){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->isTel($str)) $error = "{$name}������������ޤ���";
      return $error;
    }

    // URL
    function errorUrl($str=False,$name=False){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->isUrl($str)) $error = "{$name}������������ޤ���";
      return $error;
    }

    // ����
    function errorDate($str=False,$name=False){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->isDate($str)) $error = "{$name}������������ޤ���";
      return $error;
    }

    // Ⱦ�ѱѻ�
    function errorEi($str=False,$name=False){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->isEi($str)) $error = "{$name}��Ⱦ�ѱѻ��ǤϤ���ޤ���";
      return $error;
    }

    // Ⱦ�ѱѻ�(���򥳥�)
    function errorEiSpace($str=False,$name=False){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->isEiSpace($str)) $error = "{$name}��Ⱦ�ѱѻ��ǤϤ���ޤ���";
      return $error;
    }

    // Ⱦ�ѱѿ���
    function errorEisu($str=False,$name=False){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->isEisu($str)) $error = "{$name}��Ⱦ�ѱѿ����ǤϤ���ޤ���";
      return $error;
    }

    // Ⱦ�ѱѿ���(���򥳥�)
    function errorEisuSpace($str=False,$name=False){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->isEisuSpace($str)) $error = "{$name}��Ⱦ�ѱѿ����ǤϤ���ޤ���";
      return $error;
    }

    // �ѿ����� ������椫�ɤ����Υ����å�
    function errorEisuKigou($str=False,$name=False){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->isEisuKigou($str)) $error = "{$name}������������ޤ���";
      return $error;
    }

    // ��������
    function errorKataKana($str=False,$name=False){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->isKataKana($str)) $error = "{$name}���������ʤǤϤ���ޤ���";
      return $error;
    }

    // 16�ʿ������å�
    function error16($str=False,$name=False){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->is16($str)) $error = "{$name}������������ޤ���";
      return $error;
    }



    // ʸ����
    function errorLen( $str=False,$name=False,$limit=0 ){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->isLen($str,$limit)) $error = "{$name}��{$limit}ʸ���ʾ�����ϤǤ�";
      return $error;
    }

    // ʸ����(�ޥ���Х���)
    function errorMblen( $str=False,$name=False,$limit=0 ){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->isMbLen($str,$limit)) $error = "{$name}��{$limit}ʸ���ʾ�����ϤǤ�";
      return $error;
    }

    // Ⱦ�ѿ���
    function errorNumber($str=False, $name=False, $ex=False){
      $error = "";
      if(!$str || !$name) return ;
      if( $ex ){
        if(!$this->isNumber($str,$ex)) $error = "{$name}��Ⱦ�ѿ���{$ex}������Ϥ��Ƥ�������";
      }else{
        if(!$this->isNumber($str,$ex)) $error = "{$name}��Ⱦ�ѿ����ǤϤ���ޤ���";
      }
      return $error;
    }

    // ���ѥ����å�
    function errorWideCheck($str=False,$name=False,$ex=False){
      $error = "";
      if(!$str || !$name) return ;
      if(!$this->isWideCheck($str,$ex)) $error = "{$name}������������ޤ���";
      return $error;
    }

  }

?>
