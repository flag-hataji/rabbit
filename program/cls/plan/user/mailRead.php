<?PHP

/*
 * メール読み込みクラス
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
   * 用途：メールデータのセット
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
   * 用途：メールデータのコンバート
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
   * 用途：メールデータの分割
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
   * 用途：メールヘッダのセット
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
   * 用途：メール件名のセット
   *
   */
  function setMailSubject()
  {

      $isSubjectBase = $this->_mailDataHeaderS['subject'];

      $isExplode = explode("\n",$isSubjectBase);

      $isSubject = "";
      foreach($isExplode as $isStr){
          if(eregi("(.*)=\?iso-2022-jp\?B\?([^\?]+)\?=(.*)",$isStr,$regs)) {//MIME Bﾃﾞｺｰﾄﾞ
              $isStr = base64_decode($regs[2]);
          }
          if (eregi("(.*)=\?iso-2022-jp\?Q\?([^\?]+)\?=(.*)",$isStr,$regs)) {//MIME Qﾃﾞｺｰﾄﾞ
              $isStr = quoted_printable_decode($regs[2]);
          }
          $isSubject .= $isStr;
      }

      $this->_mailDataHeaderS['subject'] = $isSubject;

      return ;
  }





  /*
   * 用途：改行コードの統一
   *
   */
  function setLineUnion($str=""){

      $str = str_replace("\r\n","\n",$str);
      $str = str_replace("\r","\n",$str);

      return $str;
  }


  /*
   * 用途：文字コードの変更
   *
   */
  function setConvertEncoding($str="",$after="",$before=""){

      $str = mb_convert_encoding($str,$after,$before);

      return $str;
  }


}


?>
