<?php
/**
 * Table Definition for public.td_stepmail_member_back
 */
require_once 'DB/DataObject.php';

class DataObjectes_Public_td_stepmail_member_back extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'public.td_stepmail_member_back';    // table name
    var $stepmail_member_id;              // int4(4)  
    var $user_id;                         // int4(4)  
    var $scenario_id;                     // int4(4)  
    var $step_id;                         // int2(2)  
    var $step_no;                         // int2(2)  
    var $last_delivery_time;              // timestamp(8)  
    var $name_family;                     // text(-1)  
    var $email;                           // text(-1)  
    var $company;                         // text(-1)  
    var $post;                            // text(-1)  
    var $param1;                          // text(-1)  
    var $param2;                          // text(-1)  
    var $param3;                          // text(-1)  
    var $param4;                          // text(-1)  
    var $param5;                          // text(-1)  
    var $param6;                          // text(-1)  
    var $param7;                          // text(-1)  
    var $param8;                          // text(-1)  
    var $param9;                          // text(-1)  
    var $param10;                         // text(-1)  
    var $flag_send;                       // int2(2)  
    var $ins_date;                        // timestamp(8)  
    var $up_date;                         // timestamp(8)  
    var $name_first;                      // text(-1)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjectes_Public_td_stepmail_member_back',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
