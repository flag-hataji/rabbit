<?php
/**
 * Table Definition for public.td_cc_ip
 */
require_once 'DB/DataObject.php';

class DataObjectes_Public_td_cc_ip extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'public.td_cc_ip';                 // table name
    var $cc_ip_id;                        // int4(4)  
    var $user_id;                         // int4(4)  
    var $title;                           // text(-1)  
    var $ip;                              // text(-1)  
    var $delete_flag;                     // bool(1)  
    var $insert_date;                     // timestamp(8)  
    var $update_date;                     // timestamp(8)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjectes_Public_td_cc_ip',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
