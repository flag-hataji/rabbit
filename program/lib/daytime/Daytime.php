<?PHP
/*

  日付・曜日関連クラス

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
     * 初期化
     */
    function format(){

      // -現在の年月日
      $this->year   = date('Y');
      $this->month  = date('m');
      $this->day    = date('d');
      $this->ymd    = (int)sprintf("%04d%02d%02d", $this->year, $this->month, $this->day);

      // -曜日
      $this->weekS['s'] = array(0=>"Sun",    1=>"Mon",    2=>"Tue",     3=>"Wed",       4=>"Thu",      5=>"Fri",    6=>"Sat");
      $this->weekS['l'] = array(0=>"Sunday", 1=>"Monday", 2=>"Tuesday", 3=>"Wednesday", 4=>"Thursday", 5=>"Friday", 6=>"Saturday");
      $this->weekS['w'] = array(0=>"日",     1=>"月",     2=>"火",      3=>"水",        4=>"木",       5=>"金",     6=>"土");


      return ;
    }


    /*
    * timestamp型から日付部分を抽出
    * 
    * -$timestamp     タイムスタンプ型データ
    * -$pY       区切り文字：年
    * -$pM       区切り文字：月
    * -$pD       区切り文字：日
    * -$pDefault 区切り文字：タイムスタンプ型のデフォルト
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
    * timestamp型から時間部分を抽出
    * 
    * -$timestamp     タイムスタンプ型データ
    * -$pH       区切り文字：時
    * -$pI       区切り文字：分
    * -$pS       区切り文字：秒
    * -$pDefault 区切り文字：タイムスタンプ型のデフォルト
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
     * 指定月の最終日を取得する
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
     * 指定年月日の指定前日を取得する
     * 
     */
    function getBeforeday( $year=False, $month=False, $day=False,$num=1 ){

       $date = date("Y-m-d", mktime (00,00,00,sprintf("%02d",$month),sprintf("%02d",($day-$num)),sprintf("%04d",$year)) );

       list($dateS['y'],$dateS['m'],$dateS['d']) = explode("-",$date);

      return $dateS;
    }


    /*
     * 指定年月日の指定後日を取得する
     * 
     */
    function getAfterday( $year=False, $month=False, $day=False,$num=1 ){

       $date = date("Y-m-d", mktime (00,00,00,sprintf("%02d",$month),sprintf("%02d",($day+$num)),sprintf("%04d",$year)) );

       list($dateS['y'],$dateS['m'],$dateS['d']) = explode("-",$date);

      return $dateS;
    }

    /*
     * 指定日時の曜日を取得
     * 
     */
    function getWeek( $mode=False,$year=False, $month=False, $day=False ){

      if( !$year  ) $year  = date('Y');
      if( !$month ) $month = date('m');
      if( !$day   ) $day   = date('d');


      // 1900年以降 2038年以前
      if( $year > 1900 && $year < 2038 ){

        $num = date("w", mktime(0, 0, 0, $month, $day, $year)); // 一日の曜日

      // 1900年以前 2038年以降
      }else{

        // ツェラーの公式
        //1月、2月は前年の13月、14月として計算
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
     * 祝日判定する 
     * このプログラムは,1989年から2008年まで有効のはず
     * 平成元年(1989年)以前は、天皇誕生日は12/23ではない
     * 2009年９月には４連休となる
     *
     * 註：拾いものにつき取り扱いには注意
     *
     */
    function checkHoliday($year=False, $month=False,$day=False){

      // クラス破棄

      return ;
    }

  }
?>
