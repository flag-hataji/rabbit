<?PHP

/*
 * �᡼���ɤ߹��ߥ��饹
 *
 */

class mailRead {

  var $_mailData        = "";
  var $_mailDataHeader  = "";
  var $_mailDataHeaderS = "";
  var $_mailDataBody    = "";


  var $_encodeBefore   = "JIS,SJIS";
  var $_encodeAfter    = "EUC-JP";


  /*
   * ���ӡ��᡼��ǡ����Υ��å�
   *
   */
  function setMailData()
  {

      $isMailData  = "";

      $isMailData = file_get_contents("php://stdin");

      $this->_mailData = $isMailData;

      return ;
  }


  /*
   * ���ӡ��᡼��ǡ����Υ���С���
   *
   */
  function setConvertMailData()
  {

      $isEncodeBefore = $this->_encodeBefore;
      $isEncodeAfter  = $this->_encodeAfter;

      $isMailData = $this->_mailData;

      $isMailData = $this->setConvertEncoding($isMailData,$isEncodeAfter,$isEncodeBefore);
      $isMailData = $this->setLineUnion($isMailData);

      $this->_mailData = $isMailData;

      return ;
  }


  /*
   * ���ӡ��᡼��ǡ�����ʬ��
   *
   */
  function setSepalateMailData()
  {

      $isMailDataHeader = "";
      $isMailDataFooter = "";

      $isMailData = $this->_mailData;
      if($isMailData!=""){
          $isMailDataS = explode("\n\n",$isMailData,2);
          $isMailDataHeader = $isMailDataS[0];
          $isMailDataBody   = $isMailDataS[1];
      }

      $this->_mailDataHeader = $isMailDataHeader;
      $this->_mailDataBody   = $isMailDataBody;

      return ;
  }


  /*
   * ���ӡ��᡼��إå��Υ��å�
   *
   */
  function setMailHeader()
  {
      $isMailDataHeaderS = "";

      $isMailDataHeader = $this->_mailDataHeader;

      $isExplodeS = explode("\n",$isMailDataHeader);

      foreach($isExplodeS as $isData){

          $isKey = "";
          $isVal = "";
          $regS = "";
          if(eregi("(.*):(.*)",$isData,$regS)){
              $isKey = $regS[1];
              $isKey = strtolower($isKey);
              $isKey = trim($isKey);
              $isVal = $regS[2];
              $isMailDataHeaderS[$isKey] = $isVal;
              $isKeyBefore = $isKey;
          }else if($isKeyBefore!=""){
              $isKey = $isKeyBefore;
              $isVal = $isData;
              $isMailDataHeaderS[$isKey] .= "\n".$isVal;
          }
      }

      $this->_mailDataHeaderS = $isMailDataHeaderS;


      return ;
  }




  /*
   * ���ӡ��᡼���̾�Υ��å�
   *
   */
  function setMailSubject()
  {

      $isSubjectBase = $this->_mailDataHeaderS['subject'];

      $isExplode = explode("\n",$isSubjectBase);

      $isSubject = "";
      foreach($isExplode as $isStr){
          if(eregi("(.*)=\?iso-2022-jp\?B\?([^\?]+)\?=(.*)",$isStr,$regs)) {//MIME B�Îގ����Ď�
              $isStr = base64_decode($regs[2]);
          }
          if (eregi("(.*)=\?iso-2022-jp\?Q\?([^\?]+)\?=(.*)",$isStr,$regs)) {//MIME Q�Îގ����Ď�
              $isStr = quoted_printable_decode($regs[2]);
          }
          $isSubject .= $isStr;
      }

      $this->_mailDataHeaderS['subject'] = $isSubject;

      return ;
  }





  /*
   * ���ӡ����ԥ����ɤ�����
   *
   */
  function setLineUnion($str=""){

      $str = str_replace("\r\n","\n",$str);
      $str = str_replace("\r","\n",$str);

      return $str;
  }


  /*
   * ���ӡ�ʸ�������ɤ��ѹ�
   *
   */
  function setConvertEncoding($str="",$after="",$before=""){

      $str = mb_convert_encoding($str,$after,$before);

      return $str;
  }


}


?>
