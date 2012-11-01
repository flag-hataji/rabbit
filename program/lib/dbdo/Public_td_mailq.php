<?php
/**
 * Table Definition for public.td_mailq
 */
require_once 'DB/DataObject.php';

class DataObjectes_Public_td_mailq extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'public.td_mailq';                 // table name
    var $mailq_id;                        // int4(4)  
    var $email;                           // text(-1)  
    var $email_name;                      // text(-1)  
    var $message_id;                      // int4(4)  
    var $flag_pc;                         // bool(1)  
    var $ins_date;                        // timestamp(8)  
    var $parameter1;                      // text(-1)  
    var $parameter2;                      // text(-1)  
    var $parameter3;                      // text(-1)  
    var $parameter4;                      // text(-1)  
    var $parameter5;                      // text(-1)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjectes_Public_td_mailq',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
