<?php
/**
 * Table Definition for public.td_pictmail
 */
require_once 'DB/DataObject.php';

class DataObjectes_Public_td_pictmail extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'public.td_pictmail';              // table name
    var $pictmail_id;                     // int4(4)  
    var $user_id;                         // int4(4)  
    var $plan_pictmail_id;                // int4(4)  
    var $account;                         // int2(2)  
    var $price_month;                     // int4(4)  
    var $price_month6;                    // int4(4)  
    var $price_year;                      // int4(4)  
    var $send_max;                        // int4(4)  
    var $month_max;                       // int4(4)  
    var $month_now;                       // int4(4)  
    var $flag_permission;                 // int2(2)  
    var $flag_dm;                         // int2(2)  
    var $flag_del;                        // int2(2)  
    var $date_insert;                     // timestamp(8)  
    var $date_update;                     // timestamp(8)  
    var $send_now;                        // int4(4)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjectes_Public_td_pictmail',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
