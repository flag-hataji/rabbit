<?php
/**
 *
 * oracle connection ファイル
 * //sqlplus runs_pc/runs_pc@10.235.0.166:1521/orclrun.au-run.jp
 * $db['pcstaging']['hostname'] = "10.235.0.166:1521/orclrun.au-run.jp";
 * $db['pcstaging']['username'] = "runs_pc";
 * $db['pcstaging']['password'] = "runs_pc";
 * $db['pcstaging']['database'] = "";
 * $db['pcstaging']['dbdriver'] = "oci8";
 * $db['pcstaging']['dbprefix'] = "";
 * $db['pcstaging']['active_r'] = TRUE;
 * $db['pcstaging']['pconnect'] = FALSE;
 * $db['pcstaging']['db_debug'] = TRUE;
 * $db['pcstaging']['cache_on'] = FALSE;
 * $db['pcstaging']['cachedir'] = "";
 *
 */
class Oracle
{

    var $connection = null ;
    var $resource   = null ;

    function Oracle()
    {
        if( TEST ){
            $this->connection = oci_connect("runs_pc","runs_pc","//10.235.0.166:1521/orclrun.au-run.jp");
        }else{
            $this->connection = oci_connect("runs_pc","runs_pc","RUNS");
        }

    }


    function setConnect( $connection = null )
    {
        $this->connection = $connection ;
    }

    function setDbConnect( $connection = null )
    {
        if( $connection === null){
            if( $this->connection === null){
                return false ;
            }else{
                $connection = $this->connection ;
            }
        }

        if(! $this->resource = $connection ){
            return false ;
        }
    }

    function getResource()
    {
        return $this->resource ;
    }

}
