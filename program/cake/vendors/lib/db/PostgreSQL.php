<?php
/**
 *
 * postgres connection ファイル
 *
 */
class PostgreSQL
{

    var $host       = null ;
    var $user       = null ;
    var $password   = null ;
    var $db_name    = null ;
    var $port       = null ;
    var $connection = null ;
    var $resource   = null ;


    /**
     * host, user, password, dbname の配列が必要
     */
    function PostgreSQL( $connects = null)
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
        isset($connects['port'])  ? $this->port  = $connects['port'] : $this->port = null ;
    }


    function setDbConnect()
    {
        $connect = "host=$this->host user=$this->user dbname=$this->db_name" ;

        if( $this->password ){
            $connect .= " password=$this->password" ;
        }

        if( $this->port ){
            $connect .= " port=$this->port" ;
        }

        $this->resource = pg_connect($connect) or die('Could not connect database =' . $connect);
    }

    function getResource()
    {
        return $this->resource ;
    }

}
