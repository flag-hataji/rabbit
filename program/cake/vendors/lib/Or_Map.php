<?php
class Or_Map
{

    var $bean   ;
    var $db     ;
    var $con    ;
    var $limit  ;
    var $offset ;
    var $page   ;


    // __construct
    function Or_Map(&$bean)
    {
        $this->bean =& $bean;

        $this->limit  = 20 ;
        $this->page   = 1  ;
        $this->setOffset() ;

        $this->con =& $this->bean->getResource('db');
        $this->db  =& $this->bean->getObject('db');
    }


    function setConnect($con)
    {
        $this->con = $con ;
    }


    function setDb($con)
    {
        $this->db = $db ;
    }


    function setLimit($int = null)
    {
        if(! $int ){ return false ; }
        $this->limit = $int ;
        return true ;
    }

    function setPage( $int = null)
    {
        if( $int > 0 ){
            $this->page = $int ;
        }else{
            $this->page = 1 ;
        }
    }

    function setOffset()
    {
        $this->offset = ($this->page -1) * $this->limit ;
    }

    function getPage()
    {
        return $this->page ;
    }


    /**
     * limit ** offset ** の queryを返す
     * @return string query
     */
    function getLimitOffsetQuery()
    {
        switch( USE_DB ){
            case 'Postgresql' ;
            case 'Mysql' ;
                $query = " LIMIT $this->limit OFFSET $this->offset " ;
                break ;
            case 'Oracle' ;
                $limit = $this->page * $this->limit;
                $query = " rownum >= " . ($this->offset) . " AND rownum <= " . ($this->offset + $limit)  ;
                break ;
            default ;
                return false ;
        }

        return $query ;
    }


    /**
     * @param $count integer 全データ数
     * @return array 前のページ番号と次のページ番号
     */
    function getPageNumber($count)
    {
        $back = null ;
        $prev = null ;

        if($this->page <= 1){// 最初のページ
            if( $count > $this->limit * $this->page ){// 次のデータがあれば
                $prev = 2 ;
            }else{
                $prev = null ;
            }
            $back = null ;
        }elseif( $count <= $this->limit * $this->page){// 最終以降
            $prev = null ;
            $back = ceil($count / $this->limit) -1 ;
        }else{// 中ページ
            $prev = $this->page +1 ;
            $back = $this->page -1 ;
        }

        return array($back, $prev);
    }





    /**
     * 昇順ソートか降順ソートかの判別
     * @param $sort_key text 現在選択されているソートキー
     */
    function getOrder($sort_key = null)
    {
        $order = 0 ;
        $query = "";
        if( $sort_key ){
            if( $sort_key == $this->bean->getSession('sort_key')){
                $order = $this->bean->getSession('sort_order');
                if( $this->bean->getVar('submit_key') == 'sort'){
                    $order++ ;
                    $this->bean->setSession('sort_order', $order) ;
                }
            }else{
                $this->bean->setSession('sort_order', $order) ;
            }
            $this->bean->setSession('sort_key', $sort_key) ;
        }else{
            $this->bean->unsetSession('sort_key') ;
            $this->bean->setSession('sort_order', $order) ;
        }
        if( $order % 2 == 1){
            $query = "DESC" ;
        }
        return $query ;
    }


    /**
     * insert用のquery を返す。エスケープは先にしておくこと
     * @access public
     * @param  string $table_name 登録するテーブル名
     * @param  array  $values     値が入っている配列
     * @return string 生成されたquery
     */
    function getInsertQuery($table_name, $values){

        if(! is_array($values) ){
            return fasle ;
        }

        $query  = "INSERT INTO $table_name (";
        $query1 = "";
        $query2 = "";
        foreach($values as $key=>$val){
            $query1 .= $key.",";
            $query2 .= $val.",";
        }
        $query1 = substr($query1,0,-1);
        $query2 = substr($query2,0,-1);
        $query .= $query1.")VALUES(".$query2.")";

        return $query ;
    }

    // 結果を返す
    function getResult($query = null)
    {

        if( DEBUG ){
//              print "$query <br>\n";
        }
        if(! $result = $this->db->query($query)){
            $this->bean->setSystemError(__FILE__ . ':' . __LINE__ . "<br>query = {$query}<br>\n");
            return false ;
        }
        return $result ;
    }





    /**
     * @param $count integer 全データカウント
     * @param $url_query string URLのデータカウント
     */
    function getTablePage($count, $url_query = null)
    {
        list($back, $prev) = $this->getPageNumber($count);

        if( $url_query ){
            $url_query = "&" . $url_query ;
        }

        $table = "";
/*
        $table .= "
        <table  border='1' cellpadding='1' cellspacing='0' width='98%'>
          <tr>
            <td align='right' width='50%'>全<b>{$count}</b>件中　".($this->page * $this->limit - $this->limit)."〜".($this->page * $this->limit)."件</td>\n";


        if( $back != null && $back >= 0){
            $table .= "            <td align='right' width='20'><a href='index.php?searches[page]={$back}{$url_query}'>前</a></td>\n";
        }else{
            $table .= "            <td align='right' width='20'>前</td>\n";
        }

        $table .="            <td align='left' nowrap>| ";
        // 全カウントをリミットで割る
        $full_page = $count / $this->limit ;
        if($count % $this->limit != 0){
            ++$full_page ;
        }
        $i = 1;
        while($i <= $full_page){
            if($i == $this->page){
                $table .= "<b>{$i}</b> | \n";
            }else{
                $table .= "<a href='index.php?searches[page]={$i}{$url_query}'>{$i}</a> | \n";
            }
            ++$i ;
        }
        $table .= "</td>\n";


        if($prev > 0){
            $table .= "            <td align='right' width='20'><a href='index.php?searches[page]={$prev}{$url_query}'>次</a></TD>\n";
        }else{
            $table .= "            <td align='right' width='20'>次</td>\n";
        }
*/

        $table .= "
        <table  border='0' cellpadding='1' cellspacing='0' width='100%'>
          <tr>
            <td align='right'>全<b>{$count}</b>件中　".($this->page * $this->limit - $this->limit)."〜".($this->page * $this->limit)."件";


        if( $back != null && $back >= 0){
            $table .= "　<a href='index.php?searches[page]={$back}{$url_query}'>前</a>";
        }else{
            $table .= "　前";
        }

        $table .="　| ";
        // 全カウントをリミットで割る
        $full_page = $count / $this->limit ;
        if($count % $this->limit != 0){
            ++$full_page ;
        }
        $i = 1;
        while($i <= $full_page){
            if($i == $this->page){
                $table .= "<b>{$i}</b> | \n";
            }else{
                $table .= "<a href='index.php?searches[page]={$i}{$url_query}'>{$i}</a> | \n";
            }
            ++$i ;
        }
        $table .= "";


        if($prev > 0){
            $table .= "<a href='index.php?searches[page]={$prev}{$url_query}'>次</a></td>\n";
        }else{
            $table .= "次</td>\n";
        }

        $table .= "
          </tr>
        </table>";


        return $table ;
    }

}
