<?PHP
/*

  �ɲá���ĥ : �����Ѵ�


*/
  class ExpConvert extends Convert {


    function ExpConvert( $libUtil,$libCode ){

      $this->libUtil = $libUtil;
      $this->libCode = $libCode;
      if(isset($_POST['encoding'])){
        $this->libCode->setPost( mb_detect_encoding($_POST['encoding']) );
      }

      return ;
    }

    /*
     *
     *   ��������Ȥ���
     *   $convertS['�Ѵ�����']['Ϣ��'] = array('key'=>'�ե������̾');
     *  $cDataS['�ե������̾'] = '�Ѵ���������';
     *  �ξ嵭�ǡ������Ѱդ���
     *
     */

    function convert( $cDataS=False, $convertS=False ){


      if(!$cDataS ){
        return ;
      }

      if(!$convertS ){
        return ;
      }

      foreach($convertS as $mode=>$modeS ){

        foreach( $modeS as $mNum=>$mVal ){

          $key = $convertS[$mode][$mNum]['key'];


          if( isset($cDataS[$key]) ){

            $str  = $cDataS[$key];

            switch( $mode ){
              case     'text' : $cDataS[$key] = $this->libUtil->getTextfield($str); 
                                break;
              case 'textarea' : $cDataS[$key] = $this->libUtil->getTextarea($str); 
                                break;
/*
              case      'tag' : $cDataS[$key] = $this->libUtil->setTagAllow($str,"",True); 
                                break;
              case      'url' : if( !ereg("http://",$value) ) $value = "http://".$value;
                                $cDataS[$key] = $this->libUtil->setLinkTag($str);
                                break;
              case    'comma3': $cDataS[$key] = $this->libUtil->getHtml($str);
                                $cDataS[$key] = number_format($str); 
                                break;
*/
              case     'html' : $cDataS[$key] = $this->libUtil->getHtml($str); 
                                break;
              case    'input' : $cDataS[$key] = $str; 
                                break;
              case     'code' : $cDataS[$key] = $this->libCode->encodeBase( $str, $mVal['code'], $this->libCode->post);
                                break;
                      default : $cDataS[$key] = $this->getConvert($str,$mode);
            }

          }

        }

      }

      return $cDataS;
    }
  }






?>
