<?php
/**
 * Table Definition for public.tm_plan
 */
require_once 'DB/DataObject.php';

class DataObjectes_Public_tm_plan extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'public.tm_plan';                  // table name
    var $plan_id;                         // int4(4)  
    var $plan;                            // text(-1)  
    var $price_first;                     // int4(4)  
    var $price_month;                     // int4(4)  
    var $price_month6;                    // int4(4)  
    var $price_year;                      // int4(4)  
    var $send_max;                        // int4(4)  
    var $month_max;                       // int4(4)  
    var $sort;                            // int4(4)  
    var $comment;                         // text(-1)  
    var $flag_open;                       // int2(2)  
    var $date_update;                     // timestamp(8)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjectes_Public_tm_plan',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
