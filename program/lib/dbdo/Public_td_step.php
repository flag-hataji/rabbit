<?php
/**
 * Table Definition for public.td_step
 */
require_once 'DB/DataObject.php';

class DataObjectes_Public_td_step extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'public.td_step';                  // table name
    var $step_id;                         // int4(4)  
    var $scenario_id;                     // int4(4)  
    var $step_no;                         // int4(4)  
    var $step_name;                       // text(-1)  
    var $subject;                         // text(-1)  
    var $text_msg;                        // text(-1)  
    var $html_msg;                        // text(-1)  
    var $flag_html;                       // bool(1)  
    var $ins_date;                        // timestamp(8)  
    var $up_date;                         // timestamp(8)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjectes_Public_td_step',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
