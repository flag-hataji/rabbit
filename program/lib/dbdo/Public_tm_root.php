<?php
/**
 * Table Definition for public.tm_root
 */
require_once 'DB/DataObject.php';

class DataObjectes_Public_tm_root extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'public.tm_root';                  // table name
    var $root_id;                         // int4(4)  
    var $root;                            // text(-1)  
    var $sort;                            // int2(2)  
    var $flag_show;                       // int2(2)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjectes_Public_tm_root',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
