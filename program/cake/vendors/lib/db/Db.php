<?php

/*
postgresql と Mysql の両立をめざすクラス
*/

class Db
{

    var $db ;

    function Db( &$db )
    {
        $this->db =& $db ;
    }


    function query( $query )
    {
        switch( USE_DB ){
            case 'PostgreSQL' ;
                $result = pg_query($this->db, $query) ;
                break ;
            case 'MySQL' ;
                $result = mysql_query($query, $this->db) ;
                break ;
            case 'Oracle' ;
                $state  = oci_parse($this->db, $query);
                if(! oci_execute($state)){
                    return false ;
                }else{
                    $result = $state ;
                }
                break ;
            default ;
                return false ;
        }
        return $result ;
    }


    function escape_string( $str )
    {
        switch( USE_DB ){
            case 'PostgreSQL' ;
                $str = pg_escape_string($str) ;
                break ;
            case 'MySQL' ;
                $str = mysql_escape_string($str) ;
                break ;
            case 'Oracle' ;
                $str = str_replace("'","''",$str);
                break ;
            default ;
                return false ;
        }
        return $str ;
    }


    function num_rows( $result )
    {
        switch( USE_DB ){
            case 'PostgreSQL' ;
                $row = pg_num_rows($result);
                break ;
            case 'MySQL' ;
                $row = mysql_num_rows($result);
                break ;
            case 'Oracle' ;
                $row = oci_num_rows($result);
                break ;
            default ;
                return false ;
        }
        return $row ;
    }


    function fetch_array($result, $str = null )
    {
        $datas = null ;
        switch( USE_DB ){
            case 'PostgreSQL' ;
                $i = 0 ;
                if( $str === null ){ $str = PGSQL_BOTH ; }
                if( $str == 'num' ){ $str = PGSQL_NUM ; }
                if( $str == 'assoc' ){ $str = PGSQL_ASSOC ; }
                while(@$datas[] = pg_fetch_array($result,$i, $str)){
                    $i++ ;
                }
                break ;
            case 'MySQL' ;
                if( $str === null ){ $str = MYSQL_BOTH ; }
                if( $str == 'num' ){ $str = MYSQL_NUM ; }
                if( $str == 'assoc' ){ $str = MYSQL_ASSOC ; }
                while( @$datas[] = mysql_fetch_array($result, $str)){
                }
                array_pop($datas);
                break ;
            case 'Oracle' ;
                if( $str === null ){ $str = OCI_BOTH ; }
                if( $str == 'num' ){ $str = OCI_NUM ; }
                if( $str == 'assoc' ){ $str = OCI_ASSOC ; }
                while( @$datas[] = oci_fetch_array($result, $str)){
                }
//                array_pop($datas);
                break ;
            default ;
                return false ;
        }
        return $datas ;
    }

}
