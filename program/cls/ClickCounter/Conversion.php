<?php
class Conversion
{
    var $connection   = "host=localhost port=5432 dbname=itm-asp user=pgsql";// ���ߥƥ�����Ͽ
    var $db           = null ;
    var $inputs       = null;

    var $image = 'R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==';
    var $datas = null ;

    // __construct
    function Conversion()
    {

        // cookie �ǡ�����������
        if(! $this->setInputsData()){
            $this->setImage();
        }

        // DB���ͥ���
        if(! $this->setConnect()){
            $this->setImage();
        }

        // �����Υ����󥿡���cookie�ˤ��뤫�����å�
        if(! $this->isConversion()){
            $this->setImage();
        }else{
            // ID��¸�ߤ�����ģ���Ͽ
            $this->setAccessDb();
            $this->setAccessText();
            // �������å�������(test�Ѥ�̵�� ���֤�ͭ���ˤ���褦��)
            setcookie ("ITM_{$this->datas['clickcounter_id']}", "", time() - 3600, "/conv/{$this->datas['user_id']}", ".itm-asp.com");//���λ���
        }

        // ������쥯��
        $this->setImage();
    }


    /**
     * URL�����ѿ���ȴ���Ф���
     * 
     */
    function setInputsData()
    {
        $inputs = explode("/", $_SERVER["REQUEST_URI"]);
        array_shift($inputs);// 2���ؤ��餹
        array_shift($inputs);
        $this->inputs['user_id']       = array_shift($inputs);
        $this->inputs['conversion_id'] = array_shift($inputs);

        $this->inputs['cookie'] = $_COOKIE ;

        return true ;
    }

    function isConversion()
    {
        // cookie �ǡ�����ʬ��
        if(! is_array($this->inputs['cookie']) ){
            return false ;
        }

        $old_access_time = 0 ;
        $this->datas = null ;
        // �����Υ���С������ɣĤΤߤΥǡ����Τߤ򡢥�����
        foreach( $this->inputs['cookie'] as $key => $val ){
            if(! ereg("^ITM_[0-9]+$",$key) ){
                continue ;
            }
            $clickcounter_id = str_replace("ITM_","",$key) ;
            list($conversion_id, $user_id, $url_cd, $access_time) = explode("_", $val );
            // ������ conversion_id ����
            if( $conversion_id != $this->inputs['conversion_id'] ){
                continue ;
            }
            // �ǿ��λ��狼?
            if( $old_access_time < $access_time ){
                $this->datas['conversion_id']   = $conversion_id ;
                $this->datas['clickcounter_id'] = $clickcounter_id ;
                $this->datas['user_id']         = $user_id ;
                $this->datas['url_cd']          = $url_cd ;
                $this->datas['access_time']     = $access_time ;
                $old_access_time = $access_time ;
            }
        }
        if(! is_array($this->datas) ){
            return false ;
        }
        return ture ;
    }



    function setAccessDb()
    {
        $query = "INSERT INTO td_cc_conversion_result ( "
               . "conv_result_id, "
               . "delete_flag, "
               . "insert_date, "
               . "update_date, "
//               . "insert_user, "
               . "conversion_id, "
               . "clickcounter_id, "
               . "user_id, "
               . "url_cd, "
               . "remote_addr, "
               . "access_date "
               . ")VALUES( "
               . "nextval('td_cc_conversion_result_seq'), "
               . "'f', "
               . "now(), "
               . "now(), "
//               . "'user_id', "
               . "{$this->datas['conversion_id']}, "
               . "{$this->datas['clickcounter_id']}, "
               . "{$this->datas['user_id']}, "
               . "'{$this->datas['url_cd']}', "
               . "'{$_SERVER['REMOTE_ADDR']}', "
               . "'" . date("Y-m-d H:i:d", $this->datas['access_time']) . "'"
               . ") ";

        if(! pg_query( $this->db, $query )){
            $this->setError("DB Insert Error $query");
            return false ;
        }
        return true ;
    }

    function setAccessText()
    {

        $month    = date("Ym") ;
        $today    = date("Ymd") ;
        $datetime = date("Y-m-d H:i:s");
        $date     = date("Y-m-d");
        $hour     = date("H");
        $path     = "/var/www/clickcounter_log/{$this->datas['user_id']}/conversion/{$this->datas['clickcounter_id']}" ;

        // �ɣ��̤���¸
        $logFile  = $path."/conv_log_{$today}.txt" ;
        $access   = "{$datetime}\t{$this->datas['conversion_id']}\t{$this->datas['clickcounter_id']}\t{$this->datas['user_id']}\t{$this->datas['url_cd']}\t{$this->inputs['user_var']}\t{$_SERVER[REMOTE_ADDR]}\t{$date}\t{$hour}" ;

        // dir check
        if(! file_exists($path)){
          mkdir($path) OR die("NOT CREATED MONTH DIR");
        }

        // write
        $fp=fopen($logFile,"a") or die("NOT CREATED ACCESS FILE");
        flock($fp,LOCK_EX);
        fputs($fp,"$access\n");
        flock($fp,LOCK_UN);
        fclose($fp);


        return true ;
    }


//------------------------------------------------------------------------------------------//

    /**
     * DB�ȤΥ��ͥ�������Ϥ�
     * @return boolean ���ͥ�����󤬤Ϥ�ʤ����� false ���֤���
     */
    function setConnect()
    {
        $this->db = pg_connect($this->connection);
        if(! $this->db ){
            $this->setError("DB Connect Error");
            return false ;
        }
        return true ;
    }

  /**
   * error���������Ȥ��˥᡼������Ф�
   * @param string $message �᡼����ʸ
   */
  function setError($message)
  {
    $message = "ClickCounter Conversion ERROR \n\n".$message;
    mb_send_mail("kiyo@itm.ne.jp","itm-asp error",$message);// error
  }

  /**
   * $this->inputs ���ͤθ���
   * 
   */
  function isCheckVar($var)
  {
    if(! ereg("^[0-9A-Za-z]+$",$var) ){
      return false ;
    }
    return true ;
  }


  // ��������
  function setImage(){
    header("P3P: CP=\"NOI NOR UNI COM NAV INT DEVo PSDo OUR\", policyref=\"http://www.itm-asp.com/w3c/p3p.xml\"");
    header ("Content-type: image/gif");
    echo base64_decode($this->image);
    exit ;
  }
}
?>