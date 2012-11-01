<?php
/**
 * Table Definition for public.td_click_analyze
 */
require_once 'DB/DataObject.php';

class DataObjectes_Public_td_click_analyze extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'public.td_click_analyze';         // table name
    var $click_access_id;                 // int4(4)  
    var $clickcounter_id;                 // int4(4)  
    var $user_counter_id;                 // int4(4)  
    var $user_id;                         // int4(4)  
    var $url_cd;                          // text(-1)  
    var $user_var;                        // text(-1)  
    var $remote_addr;                     // text(-1)  
    var $http_user_agent;                 // text(-1)  
    var $http_referer;                    // text(-1)  
    var $date;                            // date(4)  
    var $access_date;                     // timestamp(8)  
    var $insert_date;                     // timestamp(8)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjectes_Public_td_click_analyze',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
