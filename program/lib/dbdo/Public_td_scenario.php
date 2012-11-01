<?php
/**
 * Table Definition for public.td_scenario
 */
require_once 'DB/DataObject.php';

class DataObjectes_Public_td_scenario extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'public.td_scenario';              // table name
    var $scenario_id;                     // int4(4)  
    var $user_id;                         // int4(4)  
    var $schedule_id;                     // int4(4)  
    var $scenario_name;                   // text(-1)  
    var $email_from;                      // text(-1)  
    var $email_from_name;                 // text(-1)  
    var $email_error;                     // text(-1)  
    var $text_header;                     // text(-1)  
    var $text_footer;                     // text(-1)  
    var $html_header;                     // text(-1)  
    var $html_footer;                     // text(-1)  
    var $flag_send;                       // int4(4)  
    var $ins_date;                        // timestamp(8)  
    var $up_date;                         // timestamp(8)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjectes_Public_td_scenario',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
