<?php
/**
 * Table Definition for public.td_log
 */
require_once 'DB/DataObject.php';

class DataObjectes_Public_td_log extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'public.td_log';                   // table name
    var $log_id;                          // int4(4)  
    var $user_id;                         // int4(4)  
    var $message_id;                      // int4(4)  
    var $name_from;                       // text(-1)  
    var $mail_from;                       // text(-1)  
    var $mail_error;                      // text(-1)  
    var $month_count;                     // int4(4)  
    var $send_count;                      // int4(4)  
    var $send_count_pc;                   // int4(4)  
    var $send_count_mobile;               // int4(4)  
    var $subject;                         // text(-1)  
    var $message;                         // text(-1)  
    var $message_html;                    // text(-1)  
    var $send_date;                       // timestamp(8)  
    var $flag_pc;                         // int2(2)  
    var $flag_mobile;                     // int2(2)  
    var $flag_type;                       // int2(2)  
    var $ip;                              // text(-1)  
    var $host;                            // text(-1)  
    var $date_pc;                         // timestamp(8)  
    var $date_mobile;                     // timestamp(8)  
    var $date_insert;                     // timestamp(8)  
    var $mail_confirm;                    // text(-1)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjectes_Public_td_log',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
