<?php
/**
 * Table Definition for public.td_schedule
 */
require_once 'DB/DataObject.php';

class DataObjectes_Public_td_schedule extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'public.td_schedule';              // table name
    var $schedule_id;                     // int4(4)  
    var $scenario_id;                     // int4(4)  
    var $flag_delivery;                   // int2(2)  
    var $delivery_week;                   // text(-1)  
    var $delivery_day;                    // text(-1)  
    var $delivery_time;                   // time(8)  
    var $ins_date;                        // timestamp(8)  
    var $up_date;                         // timestamp(8)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjectes_Public_td_schedule',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
