<?php
/**
 * Table Definition for public.download
 */
require_once 'DB/DataObject.php';

class DataObjectes_Public_download extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'public.download';                 // table name
    var $name_family;                     // text(-1)  
    var $name_first;                      // text(-1)  
    var $mail;                            // text(-1)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjectes_Public_download',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
