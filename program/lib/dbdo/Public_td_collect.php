<?php
/**
 * Table Definition for public.td_collect
 */
require_once 'DB/DataObject.php';

class DataObjectes_Public_td_collect extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'public.td_collect';               // table name
    var $collect_id;                      // int4(4)  
    var $tool_id;                         // int4(4)  
    var $user_id;                         // int4(4)  
    var $mail;                            // text(-1)  
    var $ip;                              // text(-1)  
    var $host;                            // text(-1)  
    var $flag_download;                   // int2(2)  
    var $date_insert;                     // timestamp(8)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjectes_Public_td_collect',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
