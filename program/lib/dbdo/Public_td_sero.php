<?php
/**
 * Table Definition for public.td_sero
 */
require_once 'DB/DataObject.php';

class DataObjectes_Public_td_sero extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'public.td_sero';                  // table name
    var $sero_id;                         // int4(4)  
    var $url;                             // text(-1)  
    var $searchword;                      // text(-1)  
    var $rank_google;                     // int4(4)  
    var $rank_yahoo;                      // int4(4)  
    var $ip;                              // text(-1)  
    var $date_insert;                     // timestamp(8)  
    var $flag_archive;                    // int4(4)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjectes_Public_td_sero',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
