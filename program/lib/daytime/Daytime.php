<?PHP
/*

  ���ա�������Ϣ���饹

  Update : K Masaki 2004/05
  Update : K Masaki 2004/10
  Update : K Masaki 2005/02
*/


  class Daytime{

    var $year  = "";
    var $month = "";
    var $day   = "";
    var $ymd   = "";
    var $weekS = "";

    var $pY = "/";
    var $pM = "/";
    var $pD = "";

    var $pH = ":";
    var $pI = ":";
    var $pS = "";


    function Daytime(){

      $this->format();

    }

    /*
     * �����
     */
    function format(){

      // -���ߤ�ǯ����
      $this->year   = date('Y');
      $this->month  = date('m');
      $this->day    = date('d');
      $this->ymd    = (int)sprintf("%04d%02d%02d", $this->year, $this->month, $this->day);

      // -����
      $this->weekS['s'] = array(0=>"Sun",    1=>"Mon",    2=>"Tue",     3=>"Wed",       4=>"Thu",      5=>"Fri",    6=>"Sat");
      $this->weekS['l'] = array(0=>"Sunday", 1=>"Monday", 2=>"Tuesday", 3=>"Wednesday", 4=>"Thursday", 5=>"Friday", 6=>"Saturday");
      $this->weekS['w'] = array(0=>"��",     1=>"��",     2=>"��",      3=>"��",        4=>"��",       5=>"��",     6=>"��");


      return ;
    }


    /*
    * timestamp������������ʬ�����
    * 
    * -$timestamp     �����ॹ����׷��ǡ���
    * -$pY       ���ڤ�ʸ����ǯ
    * -$pM       ���ڤ�ʸ������
    * -$pD       ���ڤ�ʸ������
    * -$pDefault ���ڤ�ʸ���������ॹ����׷��Υǥե����
    *
    */
    function getDateFromTimestamp( $timestamp=False,$pY=False,$pM=False,$pD=False ){

      if($pY) $this->pY = $pY;
      if($pM) $this->pM = $pM;
      if($pD) $this->pD = $pD;

      //$date = explode(" ",$timestamp);
      //ereg_replace("^([0-9]+)-0?([0-9]+)-0?([0-9]+).*", '\1'.$this->pY.'\2'.$this->pM.'\3'.$this->pD, $date[0])

      list($date,$time) = explode(" ",$timestamp);
      list($y,$m,$d) = explode("-",$date);
      $date = sprintf("%04d",$y).$this->pY.sprintf("%02d",$m).$this->pM.sprintf("%02d",$d).$this->pD;

      return $date;
    }


    /*
    * timestamp�����������ʬ�����
    * 
    * -$timestamp     �����ॹ����׷��ǡ���
    * -$pH       ���ڤ�ʸ������
    * -$pI       ���ڤ�ʸ����ʬ
    * -$pS       ���ڤ�ʸ������
    * -$pDefault ���ڤ�ʸ���������ॹ����׷��Υǥե����
    *
    */
    function getTimeFromTimestamp( $timestamp=False,$pH=False,$pI=False,$pS=False ){

      if($pH) $this->pH = $pH;
      if($pI) $this->pI = $pI;
      if($pS) $this->pS = $pS;

      //ereg_replace("^([0-9]+):0?([0-9]+):0?([0-9]+).*", '\1'.$this->pH.'\2'.$this->pI.'\3'.$this->pS, $date[1]);

      list($date,$time) = explode(" ",$timestamp);
      list($h,$i,$s) = explode(":",$time);
      $time = sprintf("%02d",$h).$this->pH.sprintf("%02d",$i).$this->pI.sprintf("%02d",$s).$this->pS;

      return $time;
    }


    /*
     * �����κǽ������������
     * 
     */
    function getMonthLast( $year='' ,$month='' ){

      if( !$year  ) $year  = date('Y');
      if( !$month ) $month = date('m');

      $year  = sprintf("%04d",$year);
      $month = sprintf("%02d",$month);

      if( !checkdate($month,1,$year) ){
        return False;
      }

      switch( $month ){
        case  1: 
        case  3: 
        case  5: 
        case  7: 
        case  8: 
        case 10: 
        case 12: 
          $last = 31;
          break;

        case  4: 
        case  6: 
        case  9: 
        case 11: 
          $last = 30;
          break;

        case 2:
          if( (($year%4==0)&&($year%100!=0))||($year%400==0) ){ 
            $last = 29;
          }else{
            $last = 28;
          }
          break;

      }

      return $last;
    }



    /*
     * ����ǯ�����λ����������������
     * 
     */
    function getBeforeday( $year=False, $month=False, $day=False,$num=1 ){

       $date = date("Y-m-d", mktime (00,00,00,sprintf("%02d",$month),sprintf("%02d",($day-$num)),sprintf("%04d",$year)) );

       list($dateS['y'],$dateS['m'],$dateS['d']) = explode("-",$date);

      return $dateS;
    }


    /*
     * ����ǯ�����λ���������������
     * 
     */
    function getAfterday( $year=False, $month=False, $day=False,$num=1 ){

       $date = date("Y-m-d", mktime (00,00,00,sprintf("%02d",$month),sprintf("%02d",($day+$num)),sprintf("%04d",$year)) );

       list($dateS['y'],$dateS['m'],$dateS['d']) = explode("-",$date);

      return $dateS;
    }

    /*
     * �������������������
     * 
     */
    function getWeek( $mode=False,$year=False, $month=False, $day=False ){

      if( !$year  ) $year  = date('Y');
      if( !$month ) $month = date('m');
      if( !$day   ) $day   = date('d');


      // 1900ǯ�ʹ� 2038ǯ����
      if( $year > 1900 && $year < 2038 ){

        $num = date("w", mktime(0, 0, 0, $month, $day, $year)); // ����������

      // 1900ǯ���� 2038ǯ�ʹ�
      }else{

        // �ĥ��顼�θ���
        //1�2�����ǯ��13�14��Ȥ��Ʒ׻�
        if ($month<=2) {
          $year  -= 1;
          $month += 12;
        }
        $num = (($year + floor($year/4)-floor($year/100)+floor($year/400)+floor((13*$month + 8)/5)+$day)%7);


      }

      if( $mode ){
        $week = $this->weekS[$mode][$num];
      }else{
        $week = $num;
      }

      return $week;
    }

    /*
     * ����Ƚ�ꤹ�� 
     * ���Υץ�����,1989ǯ����2008ǯ�ޤ�ͭ���ΤϤ�
     * ʿ����ǯ(1989ǯ)�����ϡ�ŷ����������12/23�ǤϤʤ�
     * 2009ǯ����ˤϣ�Ϣ�٤Ȥʤ�
     *
     * �𡧽�����ΤˤĤ���갷���ˤ����
     *
     */
    function checkHoliday($year=False, $month=False,$day=False){

      // ���饹�˴�

      return ;
    }

  }
?>
