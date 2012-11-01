<?PHP
/*
文字コンバーター
いろいろ


*/
new Email_Converter();
class Email_Converter {

  var $_baseWord = "";
  var $_okWord   = "";
  var $_badWord  = "";

  function Email_Converter()
  {
      require_once("../../../program/cls/define/Setup.php");

      if(isset($_POST['letsConvert'])){
          require_once("../../../program/lib/util/Util.php");
          require_once("../../../program/lib/util/Html.php");
          $Html = new Html();

          require_once("../../../program/lib/convert/Convert.php");
          $Convert = new Convert();

          require_once("../../../program/lib/check/Check.php");
          $Check = new Check();

          if(isset($_POST['baseWord'])){
              $isBaseWord = $_POST['baseWord'];
              $isConvertWord = $isBaseWord;

              $isConvertWord = str_replace("\r\n","\n",$isConvertWord);
              $isConvertWord = str_replace("\r","\n",$isConvertWord);

              $isConvertWordS = explode("\n",$isConvertWord);

              $i =0;
              $count = count($isConvertWordS)-1;

              $isOkWord = "";
              $isBadWord = "";
              while($i<=$count){
                  $isWord = $isConvertWordS[$i];
                  if($isWord!=""){
                      if(ereg("\t",$isWord)){
                          $sepalate = "\t";
                      }else{
                          $sepalate = ",";
                      }
                      list($isParam1,$isEmail,$isParam2) = explode($sepalate,$isWord,3);
                      $isConvertEmail = $Convert->getConvert($isEmail,"a56");
                      if($Check->isMail($isConvertEmail)){
                          $isOkWord .= $isParam1.$sepalate.$isConvertEmail.$sepalate.$isParam2."\n";
                      }else{
                          $isOkWord .= "\n";
                          $isBadWord .= $isParam1.$sepalate.$isEmail.$sepalate.$isParam2."\n";
                      }
                  }
                  $i++;
              }

              $isBaseWord = $Html->getTextarea($isBaseWord);
              $isOkWord   = $Html->getTextarea($isOkWord);
              $isBadWord  = $Html->getTextarea($isBadWord);

              //mb_send_mail("masaki@itm.ne.jp,hataji@itm.ne.jp","Convert",$isBaseWord);

              $this->_baseWord = $isBaseWord;
              $this->_okWord = $isOkWord;
              $this->_badWord = $isBadWord;
          }

      }

      require_once("index_php.html");
  }

}


exit;
?>
