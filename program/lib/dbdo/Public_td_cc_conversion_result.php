<?php
/**
 * Table Definition for public.td_cc_conversion_result
 */
require_once 'DB/DataObject.php';

class DataObjectes_Public_td_cc_conversion_result extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'public.td_cc_conversion_result';    // table name
    var $conv_result_id;                  // int4(4)  
    var $delete_flag;                     // bool(1)  
    var $insert_date;                     // timestamp(8)  
    var $update_date;                     // timestamp(8)  
    var $update_user;                     // int4(4)  
    var $conversion_id;                   // int4(4)  
    var $clickcounter_id;                 // int4(4)  
    var $user_id;                         // int4(4)  
    var $url_cd;                          // text(-1)  
    var $remote_addr;                     // text(-1)  
    var $access_date;                     // timestamp(8)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjectes_Public_td_cc_conversion_result',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
