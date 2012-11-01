#!/usr/bin/php

<?PHP

/*
  ����
  $this->mailS         : [ ���� ] �᡼��ǡ����ݤ���
  $this->headerS       : [ ���� ] �إå��ǡ���
  $this->bodyS         : [ ���� ] ��ʸ�ǡ���
  $this->bodyAll         : [ ʸ�� ] ��ʸ�ǡ���
  $this->error_mail    : [ ʸ�� ] ���顼�᡼�륢�ɥ쥹
  $this->numExplode    : [ ���� ] �إå�����ʸ�ζ��ڤ��
  $this->numLine       : [ ���� ] �᡼��ǡ�����Կ�
  $this->flagAppend    : [ ���� ] ź�դ�̵ͭ True=ͭ�� Fakse=̵��
  $this->numAppend     : [ ���� ] ź�եե������
  $this->appendS       : [ ���� ] ź�եե�����ǡ���
  $this->boundary      : [ ʸ�� ] ź�դ���ʸ�ζ��ڤ�ʸ��
  $this->lineBoundaryS : [ ���� ] ź�դ���ʸ�ζ��ڤ��
*/


class InportMail{

	  var $mailAll     = "";
	  var $mailAllS    = "";
	  var $mailS       = "";
	  var $headerS     = "";
	  var $bodyS       = "";
	  var $error_mail  = "";
	  var $to_mail  = "";
	  var $time_start = "";
	  var $time_stop  = "";

	  function InportMail(){
	    $this->setMail();
	    $this->setErrorMail();
	  }


  // * �᡼��ǡ�������
  function setMail(){
    $this->mailAll = file_get_contents("php://stdin");
    	   // mb_send_mail  ( "hataji@itm.ne.jp"  , "postfix "  , $message = "{$this->mailAll}" );
    //$this->mailS = file_get_contents("/usr/local/vpopmail/domains/itm-asp.com/hataji/Maildir/new/test");


    //�᡼�뤬�Ǥ����Τ���ʸ���
    //$array = explode('Content-Transfer-Encoding:',$this->mailAll,2);
    $array[0] = $this->mailAll;

    $this->mailAllS = $array[0];
    $this->mailS = explode("\n",$array[0]);

    //��ʸ�ȥإå�����ֲ����ǡפ�ʬ����
    $qmail_msg = "Hi. This is the qmail-send program";
    $post_msg  = "This is the mail system at host";
    $post_msg2 = "This is the Postfix program at host";
    $ms01_msg    = "The original message was received";
    $ms02_msg  = "This Message was ";

    if(ereg($qmail_msg,$array[0])){
	    $array2 = explode($qmail_msg,$array[0],2);
    }elseif(ereg($post_msg, $array[0])){
	    $array2 = explode($post_msg,$array[0],2);
	    //mb_send_mail  ( "hataji@itm.ne.jp"  , "postfix "  , $message = "postfix " );
    }elseif(ereg($post_msg2, $array[0])){
    	$array2 = explode($post_msg2,$array[0],2);
    }elseif(ereg($ms01_msg, $array[0])){
    	$array2 = explode($ms01_msg,$array[0],2);
    }elseif(ereg($ms02_msg, $array[0])){
    	$array2 = explode($ms02_msg,$array[0],2);
    }else{
    	//����ʾ���ʬ�䤷�ʤ�
		//$array2[0] = $array[0];
		//$array2[1] = $array[1];
		//̵�����ʬ��
		$array2 = explode("Subject:",$array[0],2);
    }

//	$array2 = explode("Subject::",$array[0],2);


    //mb_send_mail  ( "hataji@itm.ne.jp"  , "hedder "  , $message = "hedder = {$array2[0]}"   );

    $this->headerS    = explode("\n",$array2[0]);
    $this->bodyS      = explode("\n",$array2[1]);

    return ;
  }


  // * ��������
  function setNewLine($str=False){
    $str = ereg_replace("\r\n","\n",$str);
    $str = ereg_replace("\r",  "\n",$str);
    return $str;
  }

  // * �����˴�
  function unsetNewLine($str=False){
    $str = ereg_replace("\r\n","",$str);
    $str = ereg_replace("\r",  "",$str);
    $str = ereg_replace("\n",  "",$str);
    return $str;
  }

  // * ʸ������������
  function setEncode($str=False){
    $str = mb_convert_encoding( $str, "EUC-JP","JIS" );
    return $str;
  }





  // * ��ʸ����
  function setBody(){
    $bodyAll="";
    $numBoundary=0;
    $lineBoundaryS="";
    $line=0;
    $i=$this->numExplode;
    $key="";
    $val="";
    while ($i<=$this->numLine){
      if( isset($this->boundary) && $this->boundary!="" && ereg($this->boundary, $this->mailS[$i]) ){
        $numBoundary++;
        $lineBoundaryS[$numBoundary] = $line;
      }
      $bodyS[$line] = $this->unsetNewLine($this->mailS[$i]);
      $bodyAll .= $this->unsetNewLine($this->mailS[$i]);
      $line++;
      $i++;
    }
    $this->bodyS         = $bodyS;
    $this->lineBoundaryS = $lineBoundaryS;
    $this->bodyAll       = $bodyAll ;
    return ;
  }

  // * ��ʸ��ź��ʬΥ
  function setExplodeAppend(){

    // ��ʸ����
    if(isset($this->lineBoundaryS) && is_array($this->lineBoundaryS) ){
      $line=0;
      $i=$this->lineBoundaryS[1];
      while ($i<=$this->lineBoundaryS[2]-1){
        $bodyS[$line] = $this->bodyS[$i];
        $line++;
        $i++;
      }
      $numExplode = array_search("", $bodyS);

      $i=0;
      while ($i<=$numExplode){
        unset($bodyS[$i]);
        $i++;
      }

      // ź�ռ���
      $numTemp=1;
      while ($numTemp<=$this->numAppend){

        $line=0;
        $i=$this->lineBoundaryS[1+$numTemp]+1;
        while ($i<=$this->lineBoundaryS[2+$numTemp]-1){
          $appendS[$numTemp]['data'][$line] = $this->bodyS[$i];
          $line++;
          $i++;
        }

        $numExplode = array_search("", $appendS[$numTemp]['data']);

        $fileName ="";
        $i=0;
        while ($i<=$numExplode){

          if( ereg("filename=",$appendS[$numTemp]['data'][$i]) ){
            $fileType = strchr( $appendS[$numTemp]['data'][$i],"." );
            $fileType = str_replace("\"","",$fileType);
            $fileType = str_replace(".","",$fileType);
          }

          unset($appendS[$numTemp]['data'][$i]);
          $i++;
        }
        $appendS[$numTemp]['type'] = $fileType;

        $numTemp++;
      }

      $this->bodyS   = $bodyS;
      $this->appendS = $appendS;

    }

    return ;
  }

  // * ���顼�᡼�륢�ɥ쥹���� ���ɤ�;��ͭ��
  function setErrorMail(){




  	//TO����ʬ������erroro-55@itm-asp.com �إå��������������

  	foreach($this->headerS as $str ){
  		//	preg_match("error[-].[0-9]*@itm-asp.com", $str,$preg_mail);
  		//  mb_send_mail  ( "hataji@itm.ne.jp"  , "to mail_preg"  , $message = "tomail = {$preg_mail[0]}"   );
       	if(ereg("To: ",$str) && ereg("error-",$str)){
       		//$to_mail = str_replace(" ","",$error);
       		//$to_mail = explode(":",$str,2);
       		//$to_mail = $to_mail[1];
        	$to_mail = explode(" ",$str);
        	$to_mail = $to_mail[1];
        	if(ereg("error-",$to_mail)){
		    	break;
        	}
       	}elseif(ereg("error-",$str) && ereg("rabbit-mail.jp",$str)){
       		$to_mail = explode(">",$str,2);
			$to_mail = explode("<",$to_mail[0],2);
			$to_mail = $to_mail[1];
          //mb_send_mail  ( "hataji@itm.ne.jp"  , "to mail"  , $message = "tomail = {$this->to_mail}"   );
        	if(ereg("error-",$to_mail)){
		    	break;
        	}
       	}elseif(ereg("X-Env-Sender:",$str) && ereg("error-",$str)){
       		$to_mail = explode(" ",$str,2);
			$to_mail = $to_mail[1];
          //mb_send_mail  ( "hataji@itm.ne.jp"  , "to mail"  , $message = "tomail = {$this->to_mail}"   );
        	if(ereg("error-",$to_mail)){
		    	break;
        	}
       	}

  	}
    $to_mail = str_replace("<","",$to_mail);
    $to_mail = str_replace(">","",$to_mail);
    $to_mail = trim($to_mail);
    $this->to_mail ="";
    $this->to_mail = $to_mail;

  	//���顼���ɥ쥹��������ʸ����
  	foreach($this->bodyS as $str ){
       	if(ereg("To: ",$str) && !ereg("Reply-To:",$str) && !ereg("error-",$str)){
          $error_mail = explode(" ",$str);
          if(!empty($error_mail[2])){
	          $error = $error_mail[2];
       	  }elseif(!empty($error_mail[1])){
	          $error = $error_mail[1];
       	  }
	       	break;

       	}elseif(ereg("Final-Recipient:",$str) ){
          $error_mail = explode(";",$str,2);
          $error = $error_mail[1];
	       	break;

       	}elseif(ereg("X-Loop:",$str) ){
          $error_mail = explode(" ",$str,2);
          $error = $error_mail[1];
	       	break;

       	}


  	}
          $error = str_replace("<","",$error);
          $error = str_replace(">","",$error);
     /*
          $error = str_replace("rfc822;","",$error);
          $error = str_replace("RFC822;","",$error);
     */
          $error = trim($error);
          $this->error_mail ="";
          $this->error_mail = $error;
/*
        $message = "tomail = {$this->to_mail}\nerrormail[0] = {$error_mail[0]}\nerrormail[1] = {$error_mail[1]}\nerrormail[2] = {$error_mail[2]}\nerror = {$this->error_mail}\n";
		$message .= "\n{$this->mailAllS}";
        mb_send_mail  ( "hataji@itm.ne.jp"  , "error mail 1"  ,  $message  );
*/
  	return;
  }

}


/*
* ��������ģ´ط�
*/

//DB��Ͽ
function registDbMain($id){
global $InportMail;
  //require_once ('/var/www/vhosts/www.itm-asp2.com/html/lib/Postgres.php');
  require_once ('/var/www/vhosts/www.rabbit-mail.jp/html/program/lib/db/Postgres.php');
  $Postgres = new Postgres();

  $InportMail->bodyAll = pg_escape_string(implode("", $InportMail->mailS  )) ;

  $query = "INSERT INTO td_error_log_itm ";
  $query .= " ( user_id , mail , error_count , message ) ";
  $query .= " VALUES( ";
  $query .= " {$id},";
  $query .= " '{$InportMail->error_mail}',";
  $query .= " '1' ,";
  $query .= " '{$InportMail->bodyAll}'";
  $query .= " ) ";

  $Postgres->executeUpdate($query);
  $Postgres->close();
return;
}

//DB UPDATE
function updateDbMain($getData){
global $InportMail;
  //require_once ('/var/www/vhosts/www.itm-asp2.com/html/lib/Postgres.php');
  require_once ('/var/www/vhosts/www.rabbit-mail.jp/html/program/lib/db/Postgres.php');
  $Postgres = new Postgres();

  $InportMail->bodyAll = pg_escape_string(implode("", $InportMail->mailS  )) ;

  $error_count = $getData['error_count'];
  $error_count++;

  $query = "UPDATE td_error_log_itm SET ";
  $query .= " error_count = {$error_count} ,";
  $query .= " message = '{$InportMail->bodyAll}' ,";
  $query .= " date_update = NOW()";
  $query .= " WHERE error_log_id = '{$getData['error_log_id']}' ";

  $Postgres->executeUpdate($query);
  $Postgres->close();
return;
}

//DB���
function delDbMain($email,$id){
global $InportMail;
  //require_once ('/www/vhosts/test.itm-asp.com/html/lib/Postgres.php');
  require_once ('/var/www/vhosts/www.rabbit-mail.jp/html/program/lib/db/Postgres.php');
  $Postgres = new Postgres();

  $query = "DELETE FROM td_mmail_member ";
  $query .= " WHERE ";
  $query .= " email =  '{$InportMail->error_mail}' AND user_id =  '{$id}'";
  echo $query ;
  $Postgres->executeUpdate($query);
  $Postgres->close();
return;
}

//��Ͽ���줿�ǡ����ʥᥢ�ɡˤ����뤫��
function selectData($id){
global $InportMail;
  //require_once ('/www/vhosts/test.itm-asp.com/html/lib/Postgres.php');
  require_once ('/var/www/vhosts/www.rabbit-mail.jp/html/program/lib/db/Postgres.php');
  $Postgres = new Postgres();

  $query  = "SELECT * FROM  td_error_log_itm ";
  $query .= " WHERE user_id = {$id} AND mail = '{$InportMail->error_mail}' ";
//mb_send_mail  ( "hataji@itm.ne.jp"  , "2kaime"  , "query ={$query}"   );


  $result  = $Postgres->executeQuery($query);
    while ( $data = pg_fetch_array($result) ) {
      $getData = $data;
    }
  $Postgres->close();
return($getData);
}
















  //main
 $InportMail = new InportMail;

if(empty($InportMail->to_mail)  || empty($InportMail->error_mail)){
/*
	$message1 = "errormail = {$InportMail->error_mail}\ntomail = {$InportMail->to_mail}\n";
    $message1 .= $InportMail->mailAllS;
	mb_send_mail  ( "hataji@itm.ne.jp"  , "noget error mail "  , $message1   );
*/
}else{
/*
 	$message1 = "error address  = {$InportMail->error_mail}\n";
 	$message1 .= "to address     = {$InportMail->to_mail}\n";
 	mb_send_mail  ( "hataji@itm.ne.jp"  , "confirm errormail "  , $message1   );
*/
}

 $id_str = explode("@",$InportMail->to_mail,2);
 $id = explode("-",$id_str[0],2);

/*
 	if(!ereg("MAILER-DAEMON",$InportMail->mailS )){
    	mail("hataji@itm.ne.jp", "no get error address", $InportMail->mailS);
    	die;
    }
*/



 if($id[0]=="error"){


   if(ereg("^[0-9]+$", $id[1]) && strstr($InportMail->error_mail, '@') && strstr($InportMail->error_mail, '.') ){

       $getData =  selectData($id[1]);
//mb_send_mail  ( "hataji@itm.ne.jp"  , "ok01"  , "getdata ={$getData[error_log_id]}"   );
       if(!$getData){
        registDbMain($id[1]);
/*
        $message_ok .= "insert error address  = {$InportMail->error_mail}\n";
 		$message_ok .= "to address     = {$InportMail->to_mail}\n";
 		mb_send_mail  ( "hataji@itm.ne.jp"  , "regist errormail "  , $message_ok   );
*/
       }else{
        updateDbMain($getData);
/*
        $message_ok .= "update error address  = {$InportMail->error_mail}\n";
 		$message_ok .= "to address     = {$InportMail->to_mail}\n";
 		mb_send_mail  ( "hataji@itm.ne.jp"  , "update errormail "  , $message_ok   );
*/
       }
   }else{
   	//2010-08-31���ɲ�
 		  if (is_array ($InportMail->error_mail)){
			  foreach($InportMail->error_mail as $key => $str){
			    $message .= $key." => ".$str."\n";
			  }
 		  }else{

 		  	$message .= "error address  = {$InportMail->error_mail}\n";
         	$message .= "to address     = {$InportMail->to_mail}\n";
 		  }

		  $message .= "======error hedder ======\n";
 		  $message .= $InportMail->mailAll."\n\n" ;
/*
		   foreach($InportMail->mailS as $str ){
		    $message .= $str."\n";
		  }

 		  mb_send_mail  ( "hataji@itm.ne.jp"  , "errormail get error "  , $message   );
*/
//2010-08-31���ɲ� end
   }
 }else{
/*
 		$message .= "error address  = {$InportMail->error_mail}\n";
 		$message .= "to address     = {$InportMail->to_mail}\n";
 		$message .= "======error hedder ======\n";
 		$message .= $InportMail->mailAll."\n\n" ;
 		mb_send_mail  ( "hataji@itm.ne.jp"  , "errormail get error-2 "  , $message   );
*/
 }



 exit;
?>
