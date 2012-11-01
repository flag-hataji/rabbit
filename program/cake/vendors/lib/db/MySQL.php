<?php
/**
 *
 * Mysql connect ファイル
 *
 */

class MySQL
{

    var $host       = null ;
    var $user       = null ;
    var $password   = null ;
    var $db_name    = null ;
    var $port       = null ;
    var $mb_code    = null ;
    var $resource   = null ;

    /**
     * host, user, password, dbname の配列が必要
     */
    function MySQL( $connects = null)
    {
        if( $connects ){
            $this->setConnectData( $connects );
        }
    }


    function setConnectData( $connects )
    {
        if(! isset($connects) ){
            return false ;
        }

        isset($connects['host'])     ? $this->host     = $connects['host'] : $this->host = null ;
        isset($connects['user'])     ? $this->user     = $connects['user'] : $this->user = null ;
        isset($connects['password']) ? $this->password = $connects['password'] : $this->password = null ;
        isset($connects['db_name'])  ? $this->db_name  = $connects['db_name'] : $this->db_name = null ;
        isset($connects['port'])  ? $this->db_name  = $connects['port'] : $this->port = null ;
        isset($connects['mb_code'])  ? $this->mb_code  = $connects['mb_code'] : $this->mb_code = 'ujis' ;
    }


    function setDbConnect()
    {
        if(! $this->password ){
            if(! $this->resource = mysql_connect($this->host, $this->user) ){
                return false ;
            }
        }else{
            if(! $this->resource = mysql_connect($this->host, $this->user, $this->password) ){
                return false ;
            }
        }
        mysql_select_db($this->db_name, $this->resource) or die('Could not select database ='.$this->db_name);

        // 文字コードセット
        $query = "SET NAMES " . $this->mb_code ;
        mysql_query($query);
    }


    function getResource()
    {
        return $this->resource ;
    }

}