<?php
/*
*    ���顼�ǡ��������������
*/


new download();


class download{
    
    //download��mode
    var $mode = "";    
    //���Ϥ��줿POST�ǡ���
    var $data = array();
    
    //�ݥ��������³����
    var $cPostgres;
    
    /**
     * cunstruct
     * @return void
     */

    function __construct(){

        require_once '../../../../program/cls/define/Setup.php';
        require_once _DIR_CLS_.'pictmail/error/setup.php';
        $this->cPostgres = $cPostgres;
        $this->cCheck      = new Check();

        if(isset($_SESSION['user'])){
          $this->main();
          exit;
        }else{
            echo "SESSION ERROR";
            exit;
        }
    }
    
    /**
     * main
     * @return void
     */
    function main(){

        //POST�ǡ��������å�
        if(!(isset($_POST['mode'])&&isset($_POST['data']))){
            exit();
        }
        $this->mode = @key($_POST['mode']);
        $this->data = $_POST['data'];

        //������ϥ����å�
        try{
            $this->setCheck();
        }catch(exception $e){
            die($e->getMessage());
        }
        
        //CSV���ϥ⡼������
        switch($this->mode){
            case 'download':
                $this->setDownload();
                break;
            case 'download_light':
                $this->setDownloadLight();
                break;
            default :
        }
        exit();
    }
    
    /**
     * ���顼CSV���ǡ������������
     * @return header content-type CSV
     */
    function setDownload(){
        $where = "where user_id = {$_SESSION['user']['user_id']}";
        $start_flg = false;
        $end_flg = false;
        $start_date = "";
        $end_date = "";
        
        //�������դ��������ϻ�
        if(
           (isset($this->data['start_year'])&&$this->data['start_year']!="")&&
           (isset($this->data['start_month'])&&$this->data['start_month']!="")&&
           (isset($this->data['start_day'])&&$this->data['start_day']!="")
          ){
              $start_flg = true;
              $start_date = "{$this->data['start_year']}-{$this->data['start_month']}-{$this->data['start_day']}";
//               $where  .= " AND (date_insert >= '{$this->data['start_year']}-{$this->data['start_month']}-{$this->data['start_day']}' ";
//               $where  .= " OR date_update >= '{$this->data['start_year']}-{$this->data['start_month']}-{$this->data['start_day']}') ";
        }
        //��λ���դ��������ϻ�
        if(
           (isset($this->data['end_year'])&&$this->data['end_year']!="")&&
           (isset($this->data['end_month'])&&$this->data['end_month']!="")&&
           (isset($this->data['end_day'])&&$this->data['end_day']!="")
          ){
              $end_flg = true;
              $end_date = "{$this->data['end_year']}-{$this->data['end_month']}-{$this->data['end_day']}";
               //$where  .= " AND CASE WHEN date_update IS NULL THEN date_insert ELSE date_update END  <= '{$this->data['end_year']}-{$this->data['end_month']}-{$this->data['end_day']}' ";
//               $where  .= " AND (date_insert <= '{$this->data['end_year']}-{$this->data['end_month']}-{$this->data['end_day']}' ";
//               $where  .= " OR date_update <= '{$this->data['end_year']}-{$this->data['end_month']}-{$this->data['end_day']}') ";
        }
        
        //�������Τ�
        if($start_flg&&!$end_flg){
        
               $where  .= " AND (date_insert >= cast(to_char(to_timestamp('{$start_date}','YYYY-mm-dd 00:00:00'),'YYYY-MM-DD') as date) ";
               $where  .= " OR date_update >= cast(to_char(to_timestamp('{$start_date}','YYYY-mm-dd 00:00:00'),'YYYY-MM-DD') as date)) ";
        //��λ���Τ�
        }elseif(!$start_flg&&$end_flg){
               $where  .= " AND (date_insert <= cast(to_char(to_timestamp('{$end_date}','YYYY-mm-dd 00:00:00')+'+1days','YYYY-MM-DD') as date) ";
               $where  .= " OR date_update <= cast(to_char(to_timestamp('{$end_date}','YYYY-mm-dd 00:00:00')+'+1days','YYYY-MM-DD') as date)) ";
        //����������λ�����ϻ�
        }elseif($start_flg&&$end_flg){
               $where  .= " AND ((date_insert >= cast(to_char(to_timestamp('{$start_date}','YYYY-mm-dd 00:00:00'),'YYYY-MM-DD') as date) ";
               $where  .= " AND date_insert <= cast(to_char(to_timestamp('{$end_date}','YYYY-mm-dd 00:00:00')+'+1days','YYYY-MM-DD') as date)) ";
               $where  .= " OR (date_update >=  cast(to_char(to_timestamp('{$start_date}','YYYY-mm-dd 00:00:00'),'YYYY-MM-DD') as date) ";
               $where  .= " AND date_update <=  cast(to_char(to_timestamp('{$end_date}','YYYY-mm-dd 00:00:00')+'+1days','YYYY-MM-DD') as date))) ";
        }
        
        //���顼������ϻ�
        if(isset($this->data['err_count'])&&$this->data['err_count']!=""){
            $where .= " AND error_count >= {$this->data['err_count']} ";
        }
        //�᡼�륢�ɥ쥹���ϻ�
        if(isset($this->data['mail'])&&$this->data['mail']!=""){
            $where .= " AND mail LIKE '%" . pg_escape_string($this->data['mail']) . "%' ";
        }

        
        
        $query  = "SELECT mail
         , error_count
         , date_insert
         , date_update
         , message
         FROM td_error_log_itm {$where}
         ORDER BY error_count DESC , date_update DESC , date_insert DESC
         ";
        $data = $this->cPostgres->executeQuery($query);

        $CsvData  = "�᡼�륢�ɥ쥹,";
        $CsvData .= "���顼���,";
        $CsvData .= "��󥨥顼��,";
        $CsvData .= "�ǽ����顼������,";
        $CsvData .= "���顼����,";
        $CsvData .= "���顼��";
        $CsvData .= "\r\n";

        $CsvData = mb_convert_encoding($CsvData,"SJIS" ,"EUC-JP"); 

        $today = date('YmdHis');
        $filename = "error_log{$today}.csv";
        header ("Content-Disposition: attachment; filename=$filename");
        header ("Content-type: application/x-csv");
        echo $CsvData;

        while ( $DownData = pg_fetch_array($data) ) {

            unset ($insstr);
            unset ($upstr);
            unset ($CsvData);
            unset ($valus);
            unset ($key);

            $DownData['error_code'] ="";
            $insstr = explode(".",$DownData['date_insert'],2);
            $upstr  = explode(".",$DownData['date_update'],2);
            $DownData['date_insert'] = $insstr[0];
            $DownData['date_update'] = $upstr[0];
            $DownData['message'] = str_replace("\r","\n",$DownData['message']);
            $DownData['message'] = str_replace("\rn","\n",$DownData['message']);
            $DownData['message'] = str_replace("\n","<BR>",$DownData['message']);
            $DownData['message'] = str_replace(",","��",$DownData['message']);
            $DownData['mail'] = str_replace(",","",$DownData['mail']);
            //���顼����
            $DownData['error_code'] = $this->getError($DownData['message']);

            $CsvData = $DownData['mail'].",".$DownData['error_count'].",".$DownData['date_insert'];
            $CsvData .= ",".$DownData['date_update'].",".$DownData['error_code'].",".$DownData['message']."\r\n";

            $CsvData = mb_convert_encoding($CsvData,"SJIS" ,"EUC-JP");
            echo $CsvData;
        }
        unset ($DownData);
    }
    
    /**
     * ���顼CSV�᡼�륢�ɥ쥹�Τߥ��������
     * @return header content-type CSV
     */
    function setDownloadLight(){
        
        $where = "where user_id = {$_SESSION['user']['user_id']}";
        $start_flg = false;
        $end_flg = false;
        $start_date = "";
        $end_date = "";
        
        //�������դ��������ϻ�
        if(
           (isset($this->data['start_year'])&&$this->data['start_year']!="")&&
           (isset($this->data['start_month'])&&$this->data['start_month']!="")&&
           (isset($this->data['start_day'])&&$this->data['start_day']!="")
          ){
              $start_flg = true;
              $start_date = "{$this->data['start_year']}-{$this->data['start_month']}-{$this->data['start_day']}";
//               $where  .= " AND (date_insert >= '{$this->data['start_year']}-{$this->data['start_month']}-{$this->data['start_day']}' ";
//               $where  .= " OR date_update >= '{$this->data['start_year']}-{$this->data['start_month']}-{$this->data['start_day']}') ";
        }
        //��λ���դ��������ϻ�
        if(
           (isset($this->data['end_year'])&&$this->data['end_year']!="")&&
           (isset($this->data['end_month'])&&$this->data['end_month']!="")&&
           (isset($this->data['end_day'])&&$this->data['end_day']!="")
          ){
              $end_flg = true;
              $end_date = "{$this->data['end_year']}-{$this->data['end_month']}-{$this->data['end_day']}";
               //$where  .= " AND CASE WHEN date_update IS NULL THEN date_insert ELSE date_update END  <= '{$this->data['end_year']}-{$this->data['end_month']}-{$this->data['end_day']}' ";
//               $where  .= " AND (date_insert <= '{$this->data['end_year']}-{$this->data['end_month']}-{$this->data['end_day']}' ";
//               $where  .= " OR date_update <= '{$this->data['end_year']}-{$this->data['end_month']}-{$this->data['end_day']}') ";
        }
        
        //�������Τ�
        if($start_flg&&!$end_flg){
        
               $where  .= " AND (date_insert >= cast(to_char(to_timestamp('{$start_date}','YYYY-mm-dd 00:00:00'),'YYYY-MM-DD') as date) ";
               $where  .= " OR date_update >= cast(to_char(to_timestamp('{$start_date}','YYYY-mm-dd 00:00:00'),'YYYY-MM-DD') as date)) ";
        //��λ���Τ�
        }elseif(!$start_flg&&$end_flg){
               $where  .= " AND (date_insert <= cast(to_char(to_timestamp('{$end_date}','YYYY-mm-dd 00:00:00')+'+1days','YYYY-MM-DD') as date) ";
               $where  .= " OR date_update <= cast(to_char(to_timestamp('{$end_date}','YYYY-mm-dd 00:00:00')+'+1days','YYYY-MM-DD') as date)) ";
        //����������λ�����ϻ�
        }elseif($start_flg&&$end_flg){
               $where  .= " AND ((date_insert >= cast(to_char(to_timestamp('{$start_date}','YYYY-mm-dd 00:00:00'),'YYYY-MM-DD') as date) ";
               $where  .= " AND date_insert <= cast(to_char(to_timestamp('{$end_date}','YYYY-mm-dd 00:00:00')+'+1days','YYYY-MM-DD') as date)) ";
               $where  .= " OR (date_update >=  cast(to_char(to_timestamp('{$start_date}','YYYY-mm-dd 00:00:00'),'YYYY-MM-DD') as date) ";
               $where  .= " AND date_update <=  cast(to_char(to_timestamp('{$end_date}','YYYY-mm-dd 00:00:00')+'+1days','YYYY-MM-DD') as date))) ";
        }
        
        //���顼������ϻ�
        if(isset($this->data['err_count'])&&$this->data['err_count']!=""){
            $where .= " AND error_count >= {$this->data['err_count']} ";
        }
        //�᡼�륢�ɥ쥹���ϻ�
        if(isset($this->data['mail'])&&$this->data['mail']!=""){
            $where .= " AND mail LIKE '%" . pg_escape_string($this->data['mail']) . "%' ";
        }
        $query  = "SELECT mail
         , error_count
         , date_insert
         , date_update
         , message
         FROM td_error_log_itm {$where}
         ORDER BY error_count DESC , date_update DESC , date_insert DESC
         ";
        $data = $this->cPostgres->executeQuery($query);

        $CsvData  = "�᡼�륢�ɥ쥹,";
        $CsvData .= "���顼���,";
        $CsvData .= "��󥨥顼��,";
        $CsvData .= "�ǽ����顼������,";
        $CsvData .= "���顼����";
        $CsvData .= "\r\n";
        $CsvData = mb_convert_encoding($CsvData,"SJIS" ,"EUC-JP");

        $today = date('YmdHis');
        $filename = "error_log_light{$today}.csv";
        header ("Content-Disposition: attachment; filename=$filename");
        header ("Content-type: application/x-csv");
        echo $CsvData;
        
        while ( $DownData = pg_fetch_array($data) ) {

            unset ($insstr);
            unset ($upstr);
            unset ($CsvData);
            unset ($valus);
            unset ($key);

            $DownData['error_code'] ="";
            $insstr = explode(".",$DownData['date_insert'],2);
            $upstr  = explode(".",$DownData['date_update'],2);
            $DownData['date_insert'] = $insstr[0];
            $DownData['date_update'] = $upstr[0];
            //���顼����
            $DownData['error_code'] = $this->getError($DownData['message']);


            $CsvData .= $DownData['mail'].",".$DownData['error_count'].",".$DownData['date_insert'].",".$DownData['date_update'].",".$DownData['error_code']."\r\n";

            $CsvData = mb_convert_encoding($CsvData,"SJIS" ,"EUC-JP");
            echo $CsvData;

        }
        unset ($DownData);

    }
    
    /**
     * ��ñ��POST�ǡ��������å�
     * @return boolean
     */
    function setCheck(){
    
        $data = $this->data;
    
        //�ǡ��������å�
        if(!(is_array($data)&&isset($data))){
            throw new Exception("POST error");
        }
        //���ͥ����å�
        unset($data['mail']);
        $flg=true;
        foreach($data as $key=>$value){
            if(!empty($value)){
                if(!is_numeric($value)){
                    $flg = false;
                }
            }
        }
        //���ͤ���ʤ���Х��顼
        if(!$flg){
            throw new Exception("POST number error");
        }
        
        //TODO ���ϥ����å������Ĥ��
        return true;
    }



    /*
    *  ���顼����
    */
    function getError($message){
            $error_code ="";
            //��ޤ���ʬ����
            if( stristr($message, 'said: 550') ){ $error_code = "�����С���������";  }
            if( stristr($message, 'said: 554')){ $error_code = "���ɥ쥹��¸�ߤ��ʤ�";  }

            if( stristr($message, 'Host not found') ){ $error_code = "�����С������Ĥ���ʤ��ʥɥᥤ��¸�ߤ��ʤ���ǽ��ͭ��";  }
            if( stristr($message, 'Host found but no data record')){ $error_code = "�����С������Ĥ���ʤ�";  }
            if( stristr($message, 'Unknown') && stristr($message, 'user')){ $error_code = "���ɥ쥹��¸�ߤ��ʤ�";  }
            if( stristr($message, 'no mailbox here'  ) ){ $error_code = "���ɥ쥹��¸�ߤ��ʤ�";  }
            if( stristr($message, 'does not like recipient') ){ $error_code = "���ɥ쥹��¸�ߤ��ʤ�";  }
            if( stristr($message, '550 Mailbox unavailable') ){ $error_code = "���ɥ쥹��¸�ߤ��ʤ�";  }
            if( stristr($message, '5.1.1')){ $error_code = "���ɥ쥹��¸�ߤ��ʤ�";  }
            if( stristr($message, '5.4.0')){ $error_code = "���ɥ쥹��¸�ߤ��ʤ�";  }
            if( stristr($message, 'No such mailbox')){ $error_code = "���ɥ쥹��¸�ߤ��ʤ�";  }
            if( stristr($message, 'Invalid recipient') ){ $error_code = "��������褬̵���ʥɥᥤ�������ݤβ�ǽ��ͭ��";  }
            if( stristr($message, 'failed after I sent the message')){ $error_code = "��������褬̵���ʥɥᥤ�������ݤβ�ǽ��ͭ��";  }
            if( stristr($message, '554 5.7.1 This message has been blocked')){ $error_code = "��������褬̵���ʥɥᥤ�������ݤβ�ǽ��ͭ��";  }
            if( stristr($message, 'Status: 5.7.1')){ $error_code = "��������褬̵���ʥɥᥤ�������ݤβ�ǽ��ͭ��";  }
            if( stristr($message, 'mailbox is full')){ $error_code = "�᡼��ܥå���������";  }
            if( stristr($message, 'over') && stristr($message, 'quota')){ $error_code = "�᡼��ܥå���������";  }
            if( stristr($message, '552 Too much mail data')){ $error_code = "�᡼��ܥå���������";  }
            if( stristr($message, '554 delivery error')){ $error_code = "���ɥ쥹�����餫����ͳ��������߾���";  }
            if( stristr($message, 'mailbox unavailable (#5.5.0) ')){ $error_code = "���ɥ쥹�����餫����ͳ��������߾���";  }
            if( stristr($message, 'This user doesn\'t have a')){ $error_code = "���ɥ쥹��¸�ߤ��ʤ�";  }
            //�����С�����
            if( stristr($message, 'Remote host said: 421')){ $error_code = "Ĺ���֡������С���������������";  }
            if( stristr($message, 'Connection') && stristr($message, 'timed out')){ $error_code = "������֥��ͥ��������褺�����ॢ����";  }
            if( stristr($message, 'No route to host')){ $error_code = "���Υ����С�����³�Ǥ��ʤ�"; }
            if( stristr($message, '421 4.3.2')){ $error_code = "�����С���������������";  }
            if( stristr($message, 'Line Too Long')){ $error_code = "��ʸ��˲��Ԥ�̵��Ĺʸ������";  }
            if( stristr($message, 'http://www.google.com/mail/help/bulk_mail.html')){ $error_code = "Gmail�ե��륿���ˤ��֥�å�";  }

    return($error_code);
    }

}
