<?php
/**
 *時間周り
 */

class Date_Time
{
    var $bean = null ;
    var $year = null;
    var $month = null;
    var $day = null ;
    var $hour = null ;
    var $min = null ;

    function Date_Time( &$bean )
    {
        $this->bean =& $bean ;

        $this->setYear();
        $this->setMonth();
        $this->setDay();
        $this->setHour();
        $this->setMin();

        $yobi = array(0=>"日",1=>"月",2=>"火",3=>"水",4=>"木",5=>"金",6=>"土");

        return true ;
    }

    function getYear()
    {
        return $this->year ;
    }

    function getMonth()
    {
        return $this->month ;
    }

    function getDay()
    {
        return $this->day ;
    }

    function getHour()
    {
        return $this->hour ;
    }

    function getMin()
    {
        return $this->min ;
    }

    function setYear()
    {
        $i = date("Y") -1 ;
        $k = date("Y") + 3 ;
        while( $i <= $k ){
            $this->year[$i] = $i ;
            ++$i ;
        }
    }


    function setMonth()
    {
        $i = 1 ;
        while( $i <= 12){
            $this->month[$i] = $i ;
            ++$i ;
        }
    }


    function setDay()
    {
        $i = 1 ;
        while( $i <= 31){
            $this->day[$i] = $i  ;
            ++$i ;
        }
    }


    function setHour()
    {
        $i = 0 ;
        while( $i <= 23){
            $this->hour[$i] = $i  ;
            ++$i ;
        }
    }


    function setMin()
    {
        $i = 0 ;
        while( $i <= 55){
            $this->min[$i] = $i  ;
            $i += 5 ;
        }
    }


    /**
     * @param $datetime string YYYY/MM/DD
     *
     */
    function getDate2String($timestamp = null)
    {
        if(! $timestamp ){ return false ; }
        $year  = substr($timestamp,0,4);
        $month = substr($timestamp,5,2);
        $day   = substr($timestamp,8,2);
        return "{$year}年{$month}月{$day}日(" . $this->getYobi($year, $month, $day) . ")";
    }


    function getYm2String($timestamp)
    {
        $year  = substr($timestamp,0,4);
        $month = substr($timestamp,5,2);
        return "{$year}年{$month}月" ;
    }

    function getHourTime2TimeStamp($time_stamp)
    {
        return substr($time_stamp,11,8) ;
    }

    function getYmdToTimeStamp($time_stamp)
    {
        return substr($time_stamp,0, 10) ;
    }

    function getYobi($year,$month,$day)
    {
        $int = date("w", mktime(0, 0, 0, $month, $day, $year));

        if( isset($this->yobi[$int]) ){
            return $this->yobi[$int] ;
        }else{
            return false ;
        }
  }

}
