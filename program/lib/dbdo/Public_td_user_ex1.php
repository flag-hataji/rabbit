<?php
/**
 * Table Definition for public.td_user_ex1
 */
require_once 'DB/DataObject.php';

class DataObjectes_Public_td_user_ex1 extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'public.td_user_ex1';              // table name
    var $user_ex1_id;                     // int4(4)  
    var $user_id;                         // int4(4)  
    var $root_id;                         // int4(4)  
    var $medium_id;                       // int4(4)  
    var $text_root;                       // text(-1)  
    var $text_medium;                     // text(-1)  
    var $ip;                              // text(-1)  
    var $host;                            // text(-1)  
    var $referrer;                        // text(-1)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjectes_Public_td_user_ex1',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
