<?php
/**
 * Table Definition for public.td_inquiry
 */
require_once 'DB/DataObject.php';

class DataObjectes_Public_td_inquiry extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'public.td_inquiry';               // table name
    var $inquiry_id;                      // int4(4)  
    var $user_id;                         // int4(4)  
    var $name_family;                     // text(-1)  
    var $name_first;                      // text(-1)  
    var $kana_family;                     // text(-1)  
    var $kana_first;                      // text(-1)  
    var $name_company;                    // text(-1)  
    var $kana_company;                    // text(-1)  
    var $mail;                            // text(-1)  
    var $tel;                             // text(-1)  
    var $mobile;                          // text(-1)  
    var $fax;                             // text(-1)  
    var $inquiry;                         // text(-1)  
    var $date_insert;                     // timestamp(8)  
    var $date_update;                     // timestamp(8)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjectes_Public_td_inquiry',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
