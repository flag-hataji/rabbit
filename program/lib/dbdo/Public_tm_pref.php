<?php
/**
 * Table Definition for public.tm_pref
 */
require_once 'DB/DataObject.php';

class DataObjectes_Public_tm_pref extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'public.tm_pref';                  // table name
    var $pref_id;                         // int4(4)  
    var $pref;                            // text(-1)  
    var $sort;                            // int2(2)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjectes_Public_tm_pref',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
