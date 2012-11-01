<?php
/**
 * Table Definition for public.td_message
 */
require_once 'DB/DataObject.php';

class DataObjectes_Public_td_message extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'public.td_message';               // table name
    var $message_id;                      // int4(4)  
    var $user_id;                         // int4(4)  
    var $count;                           // int4(4)  
    var $email_from;                      // text(-1)  
    var $email_from_name;                 // text(-1)  
    var $email_error;                     // text(-1)  
    var $subject;                         // text(-1)  
    var $message;                         // text(-1)  
    var $ins_date;                        // timestamp(8)  
    var $send_date;                       // timestamp(8)  
    var $message_html;                    // text(-1)  
    var $flag_html;                       // int2(2)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjectes_Public_td_message',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
