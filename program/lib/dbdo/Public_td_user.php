<?php
/**
 * Table Definition for public.td_user
 */
require_once 'DB/DataObject.php';

class DataObjectes_Public_td_user extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'public.td_user';                  // table name
    var $user_id;                         // int4(4)  
    var $job_id;                          // int4(4)  
    var $id;                              // text(-1)  
    var $password;                        // text(-1)  
    var $name_family;                     // text(-1)  
    var $name_first;                      // text(-1)  
    var $kana_family;                     // text(-1)  
    var $kana_first;                      // text(-1)  
    var $birthday;                        // date(4)  
    var $mail;                            // text(-1)  
    var $tel;                             // text(-1)  
    var $mobile;                          // text(-1)  
    var $fax;                             // text(-1)  
    var $zip;                             // int4(4)  
    var $area;                            // text(-1)  
    var $address1;                        // text(-1)  
    var $address2;                        // text(-1)  
    var $comment;                         // text(-1)  
    var $date_insert;                     // timestamp(8)  
    var $date_update;                     // timestamp(8)  
    var $flag_gender;                     // int2(2)  
    var $flag_pictmail;                   // bool(1)  
    var $flag_stepmail;                   // bool(1)  
    var $name_company;                    // text(-1)  
    var $kana_company;                    // text(-1)  
    var $flag_cc;                         // bool(1)  
    var $cc_start_date;                   // date(4)  
    var $cc_end_date;                     // date(4)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjectes_Public_td_user',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
