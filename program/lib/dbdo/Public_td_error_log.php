<?php
/**
 * Table Definition for public.td_error_log
 */
require_once 'DB/DataObject.php';

class DataObjectes_Public_td_error_log extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'public.td_error_log';             // table name
    var $error_log_id;                    // int4(4)  
    var $user_id;                         // int4(4)  
    var $mail;                            // text(-1)  
    var $error_count;                     // int4(4)  
    var $date_insert;                     // timestamp(8)  
    var $date_update;                     // timestamp(8)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjectes_Public_td_error_log',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
