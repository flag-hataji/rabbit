#!/usr/local/bin/php -q
<?PHP
  new Sender();

  class Sender{

    var $defineS    = "";
    var $valS       = "";
    var $queryS     = "";
    var $logS       = "";
    var $otherS       = "";
    var $ExPostgres = "";

    function Sender(){
//mail("hataji@itm.ne.jp","Sender","RUN");

      $this->defineS['Absolute']          = $this->setArgvDecode($_SERVER['argv'][1]);
      $this->defineS['DirProgram']        = $this->setArgvDecode($_SERVER['argv'][2]);
      $this->defineS['DirLib']            = $this->setArgvDecode($_SERVER['argv'][3]);
      $this->defineS['DirCommon']         = $this->setArgvDecode($_SERVER['argv'][4]);
      $this->defineS['DirClass']          = $this->setArgvDecode($_SERVER['argv'][5]);
      $this->defineS['DirClassDefine']    = $this->setArgvDecode($_SERVER['argv'][6]);
      $this->defineS['PgRoot']            = $this->setArgvDecode($_SERVER['argv'][7]);
      $this->defineS['PgRootCommon']      = $this->setArgvDecode($_SERVER['argv'][8]);
      $this->defineS['PgRootCsv']         = $this->setArgvDecode($_SERVER['argv'][9]);
      $this->defineS['PgRootMail']        = $this->setArgvDecode($_SERVER['argv'][10]);
      $this->defineS['pgRootMessage']     = $this->setArgvDecode($_SERVER['argv'][16]);
      $this->defineS['pgRootMessageHtml'] = $this->setArgvDecode($_SERVER['argv'][30]);

      $this->valS['file']           =  $this->setArgvDecode($_SERVER['argv'][11]);
      $this->valS['name_from']      =  $this->setArgvDecode($_SERVER['argv'][12]);
      $this->valS['mail_from']      =  $this->setArgvDecode($_SERVER['argv'][13]);
      $this->valS['mail_error']     =  $this->setArgvDecode($_SERVER['argv'][14]);
      $this->valS['subject']        =  $this->setArgvDecode($_SERVER['argv'][15]);
      $this->valS['message']        =  file_get_contents($this->defineS['pgRootMessage']);
      $this->valS['message_html']   =  file_get_contents($this->defineS['pgRootMessageHtml']);
      $this->valS['mail_confirm']   =  $this->setArgvDecode($_SERVER['argv'][21]);

      $this->queryS['td_log']       = $this->setArgvDecode($_SERVER['argv'][17]);
      $this->queryS['td_message']   = $this->setArgvDecode($_SERVER['argv'][18]);
      $this->queryS['td_mailq']     = $this->setArgvDecode($_SERVER['argv'][19]);
      $this->queryS['td_pictmail']  = $this->setArgvDecode($_SERVER['argv'][20]);

      $this->logS['mail_start_pc']  = $this->setArgvDecode($_SERVER['argv'][22]);
      $this->logS['mail_start_mo']  = $this->setArgvDecode($_SERVER['argv'][23]);
      $this->logS['mail_finish_pc'] = $this->setArgvDecode($_SERVER['argv'][24]);
      $this->logS['mail_finish_mo'] = $this->setArgvDecode($_SERVER['argv'][25]);
      $this->logS['type']           = $this->setArgvDecode($_SERVER['argv'][26]);

      $this->otherS['ok']           = $this->setArgvDecode($_SERVER['argv'][27]);
      $this->otherS['pc']           = $this->setArgvDecode($_SERVER['argv'][28]);
      $this->otherS['mobile']       = $this->setArgvDecode($_SERVER['argv'][29]);

      $this->queryS['td_message'] = str_replace("#message#",addslashes($this->valS['message']),$this->queryS['td_message']);
      $this->queryS['td_log']     = str_replace("#message#",addslashes($this->valS['message']),$this->queryS['td_log']);
      $this->queryS['td_message'] = str_replace("#message_html#",addslashes($this->valS['message_html']),$this->queryS['td_message']);
      $this->queryS['td_log']     = str_replace("#message_html#",addslashes($this->valS['message_html']),$this->queryS['td_log']);

      $this->ExPostgres = $this->dbConnect($this->defineS);
      $this->dbBegin();

      $this->registTdMailq();
      $this->registTdMeesage();
      $this->registTdLog();
      $this->registTdPictmail();

      $this->dbCommit();
      $this->ExPostgres->close();

      $this->sendMailFinish();

      chmod ($this->defineS['PgRootCsv'].$this->valS['file'], 0777); 
      unlink($this->defineS['PgRootCsv'].$this->valS['file']);
/*
      require_once($this->defineS['PgRoot']."Fileup.php");
      $Fileup = new Fileup();
      $Fileup->deleteFile($this->defineS['PgRootCsv'],$this->valS['file']);
*/
    }

    // DB��³
    function dbConnect(){
      require_once($this->defineS['DirClassDefine']."Db.php");
      require_once($this->defineS['DirLib']."db/Postgres.php");
      require_once($this->defineS['DirLib']."db/ExPostgres.php");
      $ExPostgres = new ExPostgres(_DB_NAME_,_DB_USER_,_DB_HOST_,_DB_PORT_);
      return $ExPostgres;
    }

    // * ����Хå�
    Function dbRollback(){
      pg_query($this->ExPostgres->connection, 'ROLLBACK');
    }

    // * �ӥ���
    Function dbBegin(){
      pg_query($this->ExPostgres->connection, 'BEGIN');
    }

    // * ���ߥå�
    Function dbCommit(){
      pg_query($this->ExPostgres->connection, 'COMMIT');
    }

    // * ��Ͽ
    Function dbRegist($query=False){
      $return = $this->ExPostgres->executeUpdate($query);

      return $return;
    }


    // �ǥ�����
    function setArgvDecode($str=False){
      if($str!=""){
        $str = urldecode($str);
        $str = unserialize($str) ;
      }
      return $str;
    }


    // �᡼�륭�塼��¸
    function registTdMailq(){

      require_once($this->defineS['DirLib'].'check/Check.php');
      $Check = new Check() ;

      $errorNum="";
      if( !file_exists($this->defineS['PgRootCsv'].$this->valS['file']) ){
        $this->sendMailError(1,$this->defineS['PgRootCsv'].$this->valS['file']);
      }else{





        // �������ȥ᡼�륻�å�
        // �᡼���ۿ������ס�1=PC�Τ� 2=���ӤΤ� 3=PC������
        $starterS="";
        switch( $this->logS['type'] ){
          case 1 :
            $starterS[1]['mail'] = $this->logS['mail_start_pc'];
            $starterS[1]['query'] = str_replace("#flag_pc#",'t',$this->queryS['td_mailq']);
            break;
          case 2 :
            $starterS[2]['mail'] = $this->logS['mail_start_mo'];
            $starterS[2]['query'] = str_replace("#flag_pc#",'f',$this->queryS['td_mailq']);
            break;
          case 3 :
            $starterS[1]['mail']  = $this->logS['mail_start_pc'];
            $starterS[1]['query'] = str_replace("#flag_pc#",'t',$this->queryS['td_mailq']);
            $starterS[2]['mail']  = $this->logS['mail_start_mo'];
            $starterS[2]['query'] = str_replace("#flag_pc#",'f',$this->queryS['td_mailq']);
            break;
        }
        if($starterS!=""){
          foreach($starterS as $num=>$starter ){
            $data = "";
            $registQuery = "";
            if($starter!=""){
              $data = "start,{$starter['mail']},1,2,3,4,5";
              $registQuery = $this->convertTdMailq($data,$starter['query']);
              if( !$this->dbRegist($registQuery) ){
                $this->sendMailError(2,$registQuery);
                $this->dbRollback();
                $this->ExPostgres->close();
              }
            }
          }
        }


        // �᡼��ꥹ�ȥ��å�
        $fp = fopen($this->defineS['PgRootCsv'].$this->valS['file'],'r') ;
        while( !feof($fp) ){
          $oneData = fgets($fp);
          if($oneData!=""){
            if (!$this->checkBlackList($oneData)) {
                $registQuery = $this->convertTdMailq($oneData);
                if( !$this->dbRegist($registQuery) ){
                  $this->sendMailError(2,$registQuery);
                  $this->dbRollback();
                  $this->ExPostgres->close();
                }
            }
          }
        }
        flock($fp, LOCK_UN);
        fclose($fp);


        // �ե��˥å���᡼�륻�å�
        // �᡼���ۿ������ס�1=PC�Τ� 2=���ӤΤ� 3=PC������
        $finisherS="";
        switch( $this->logS['type'] ){
          case 1 :
            $finisherS[1]['mail'] = $this->logS['mail_finish_pc'];
            $finisherS[1]['query'] = str_replace("#flag_pc#",'t',$this->queryS['td_mailq']);
            break;
          case 2 :
            $finisherS[2]['mail'] = $this->logS['mail_finish_mo'];
            $finisherS[2]['query'] = str_replace("#flag_pc#",'f',$this->queryS['td_mailq']);
            break;
          case 3 :
            $finisherS[1]['mail']  = $this->logS['mail_finish_pc'];
            $finisherS[1]['query'] = str_replace("#flag_pc#",'t',$this->queryS['td_mailq']);
            $finisherS[2]['mail']  = $this->logS['mail_finish_mo'];
            $finisherS[2]['query'] = str_replace("#flag_pc#",'f',$this->queryS['td_mailq']);
            break;
        }
        if($finisherS!=""){
          foreach($finisherS as $num=>$finisher ){
            $data = "";
            $registQuery = "";
            if($finisher!=""){
              $data = "finish,{$finisher['mail']},1,2,3,4,5";
              $registQuery = $this->convertTdMailq($data,$finisher['query']);
              if( !$this->dbRegist($registQuery) ){
                $this->sendMailError(2,$registQuery);
                $this->dbRollback();
                $this->ExPostgres->close();
              }
            }
          }
        }


      }
      return;
    }

    


    // mailq����С���
    function convertTdMailq($oneData=False,$baseQuery=False){

      if($baseQuery==False){
        $baseQuery = $this->queryS['td_mailq'];
      }
      list( $name, $email, $p1, $p2, $p3, $p4, $p5 ) = explode(",",$oneData);

      $name = str_replace(":", "��", $name);

      $registQuery="";
      if($baseQuery!=False){
        require_once($this->defineS['DirLib'].'check/Check.php');
        $Check = new Check() ;
        $registQuery = $baseQuery;
        $registQuery = str_replace("#name#", $name,$registQuery);
        $registQuery = str_replace("#email#",$email,$registQuery);
        $registQuery = str_replace("#p1#",$p1,$registQuery);
        $registQuery = str_replace("#p2#",$p2,$registQuery);
        $registQuery = str_replace("#p3#",$p3,$registQuery);
        $registQuery = str_replace("#p4#",$p4,$registQuery);
        $registQuery = str_replace("#p5#",$p5,$registQuery);
        if( $Check->isDocomo($email) || $Check->isVodafone($email) || $Check->isAu($email) ){
          $registQuery = str_replace("#flag_pc#",'f',$registQuery);
        }else{
          $registQuery = str_replace("#flag_pc#",'t',$registQuery);
        }
      }

      return $registQuery;
    }

    


    // td_log��¸
    function registTdLog(){
      if( !$this->dbRegist($this->queryS['td_log']) ){
        $this->sendMailError(2,$this->queryS['td_log']);
        $this->dbRollback();
        $this->ExPostgres->close();
      }
      return;
    }

    // td_message��¸
    function registTdMeesage(){
      if( !$this->dbRegist($this->queryS['td_message']) ){
        $this->sendMailError(2,$this->queryS['td_message']);
        $this->dbRollback();
        $this->ExPostgres->close();
      }
      return;
    }

    // td_pictmail��¸
    function registTdPictmail(){
      if( !$this->dbRegist($this->queryS['td_pictmail']) ){
        $this->sendMailError(2,$this->queryS['td_pictmail']);
        $this->dbRollback();
        $this->ExPostgres->close();
      }
      return;
    }



    // �᡼����������λ
    function sendMailFinish($subject=False,$message=False){

      $subjectUser   = "[rabbit-mail]�᡼���ۿ��Τ�ͽ��򾵤�ޤ���";
      $messageUser  = file_get_contents($this->defineS['PgRootMail']."userReserve.txt");

      $subjectMaster  = "[rabbit-mail]�᡼���ۿ��Τ�ͽ�󤬤���ޤ���\n";
      $messageMaster .= "�᡼��ꥹ�ȡ���������{$this->valS['file']}\n";
      $messageMaster .= "�ƣңϣͥ᡼�롡������{$this->valS['mail_from']}\n";
      $messageMaster .= "���顼�᡼�������衡��{$this->valS['mail_error']}\n";
      $messageMaster .= "��ǧ�᡼�������衡����{$this->valS['mail_confirm']}\n";
      $messageMaster .= "�ȡ������������������{$this->otherS['ok']}��\n";
      $messageMaster .= "�������������Уá�����{$this->otherS['pc']}��\n";
      $messageMaster .= "���������������ӡ�����{$this->otherS['mobile']}��\n\n";
      $messageMaster .= "�ʲ��Υ����꡼�¹�\n".htmlspecialchars($this->queryS['td_log']);

      $this->sendMailMaster($subjectMaster,$messageMaster);
      $this->sendMailUser($subjectUser,$messageUser);

      return;
    }


    // �᡼�����������顼���
    function sendMailError($num=False,$ex=False){

      $ex = htmlspecialchars($ex);

      $subjectMaster="";
      $messageMaster="";

      $subjectuser="";
      $messageuser="";

      switch($num){
        case 1: 
          $subjectMaster  = "�ڥ��顼��ȯ�����ޤ����ۥ��顼No.01\n"; 
          $messageMaster  = "�᡼��ꥹ�ȤΥե����뤬¸�ߤ��ޤ���\n"; 
          $messageMaster .= "�ե�����ѥ���{$ex}"; 
          break;
        case 2: 
          $subjectMaster  = "�ڥ��顼��ȯ�����ޤ����ۥ��顼No.02\n"; 
          $messageMaster  = "�����꡼�μ¹Ԥ�����ޤ���Ǥ�����\n"; 
          $messageMaster .= "�����꡼��{$ex}"; 
          break;
        case 3: 
          $subjectMaster  = "�ڥ��顼��ȯ�����ޤ����ۥ��顼No.03\n"; 
          $messageMaster  = "�����꡼�μ¹Ԥ������������ޤ��������᡼��ꥹ�Ȥκ��������ޤ���Ǥ�����\n"; 
          $messageMaster .= "�ե�����ѥ���{$ex}"; 
          break;
      }

      if($subjectMaster!="" && $messageMaster!=""){
        //$this->sendMailMaster($subjectMaster,$messageMaster);
        $Mail->normalMb_send_mail('info@rabbit-mail.jp', 'hataji@itm.ne.jp', $subject, $message );
      }


      $subjectuser="�ڶ۵ޡ�[rabbit-mail]�᡼��������ͽ��μ��դ�����ޤ���Ǥ���";
      $messageUser  = file_get_contents($this->defineS['PgRootMail']."userError.txt");
      if($subjectUser!="" && $messageUser!=""){
        $this->sendMailUser($subjectUser,$messageUser);
      }

      require_once($this->defineS['PgRoot']."Fileup.php");
      $Fileup = new Fileup();
      $Fileup->deleteFile($this->defineS['PgRootCsv'],$this->valS['file']);

      exit;
      return;
    }


    // �᡼��������������
    function sendMailMaster($subject=False,$message=False){

      require_once($this->defineS['DirLib']."mail/Mail.php");
      $Mail = new Mail();

      $Mail->normalMb_send_mail('info@rabbit-mail.jp', 'hataji@itm.ne.jp', $subject, $message );

      return;
    }

    // �᡼���������桼����
    function sendMailUser($subject=False,$message=False){

      require_once($this->defineS['DirLib']."mail/Mail.php");
      $Mail = new Mail();

      $Mail->normalMb_send_mail('info@rabbit-mail.jp', $this->valS['mail_confirm'], $subject, $message );

      return;
    }

    /*
     * �֥�å��ꥹ�ȥ����å�
     */
    function checkBlackList ($oneData="")
    {
        list( $name, $mail, $dust ) = explode(",",$oneData);

        if ($mail != "") {
            $blacklistCount = "SELECT count(mail) FROM td_mail_blacklist WHERE mail='" . $mail . "'";
            $isResult = pg_query($blacklistCount);
            $rows  = pg_fetch_row($isResult);
//mb_send_mail('hataji@itm.ne.jp', $mail, $rows[0].$blacklistCount);
        }

        if ($rows[0] > 0) {
            return true;
        }else{
            return false;
        }
        
    }

  }
