<?php
/**
 * Table Definition for public.td_click_access
 */
require_once 'DB/DataObject.php';

class DataObjectes_Public_td_click_access extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'public.td_click_access';          // table name
    var $click_access_id;                 // int4(4)  
    var $clickcounter_id;                 // int4(4)  
    var $user_id;                         // int4(4)  
    var $url_cd;                          // text(-1)  
    var $remote_addr;                     // text(-1)  
    var $http_user_agent;                 // text(-1)  
    var $http_referer;                    // text(-1)  
    var $date;                            // date(4)  
    var $insert_date;                     // timestamp(8)  
    var $update_date;                     // timestamp(8)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjectes_Public_td_click_access',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
