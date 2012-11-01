<?php
/**
 * Table Definition for public.tm_tool
 */
require_once 'DB/DataObject.php';

class DataObjectes_Public_tm_tool extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'public.tm_tool';                  // table name
    var $tool_id;                         // int4(4)  
    var $tool;                            // text(-1)  
    var $url;                             // text(-1)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjectes_Public_tm_tool',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
