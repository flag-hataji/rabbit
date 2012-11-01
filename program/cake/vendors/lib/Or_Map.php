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
     * limit ** offset ** �� query���֤�
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
     * @param $count integer ���ǡ�����
     * @return array ���Υڡ����ֹ�ȼ��Υڡ����ֹ�
     */
    function getPageNumber($count)
    {
        $back = null ;
        $prev = null ;

        if($this->page <= 1){// �ǽ�Υڡ���
            if( $count > $this->limit * $this->page ){// ���Υǡ����������
                $prev = 2 ;
            }else{
                $prev = null ;
            }
            $back = null ;
        }elseif( $count <= $this->limit * $this->page){// �ǽ��ʹ�
            $prev = null ;
            $back = ceil($count / $this->limit) -1 ;
        }else{// ��ڡ���
            $prev = $this->page +1 ;
            $back = $this->page -1 ;
        }

        return array($back, $prev);
    }





    /**
     * ���祽���Ȥ��߽祽���Ȥ���Ƚ��
     * @param $sort_key text �������򤵤�Ƥ��륽���ȥ���
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
     * insert�Ѥ�query ���֤������������פ���ˤ��Ƥ�������
     * @access public
     * @param  string $table_name ��Ͽ����ơ��֥�̾
     * @param  array  $values     �ͤ����äƤ�������
     * @return string �������줿query
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

    // ��̤��֤�
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
     * @param $count integer ���ǡ����������
     * @param $url_query string URL�Υǡ����������
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
            <td align='right' width='50%'>��<b>{$count}</b>���桡".($this->page * $this->limit - $this->limit)."��".($this->page * $this->limit)."��</td>\n";


        if( $back != null && $back >= 0){
            $table .= "            <td align='right' width='20'><a href='index.php?searches[page]={$back}{$url_query}'>��</a></td>\n";
        }else{
            $table .= "            <td align='right' width='20'>��</td>\n";
        }

        $table .="            <td align='left' nowrap>| ";
        // ��������Ȥ��ߥåȤǳ��
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
            $table .= "            <td align='right' width='20'><a href='index.php?searches[page]={$prev}{$url_query}'>��</a></TD>\n";
        }else{
            $table .= "            <td align='right' width='20'>��</td>\n";
        }
*/

        $table .= "
        <table  border='0' cellpadding='1' cellspacing='0' width='100%'>
          <tr>
            <td align='right'>��<b>{$count}</b>���桡".($this->page * $this->limit - $this->limit)."��".($this->page * $this->limit)."��";


        if( $back != null && $back >= 0){
            $table .= "��<a href='index.php?searches[page]={$back}{$url_query}'>��</a>";
        }else{
            $table .= "����";
        }

        $table .="��| ";
        // ��������Ȥ��ߥåȤǳ��
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
            $table .= "<a href='index.php?searches[page]={$prev}{$url_query}'>��</a></td>\n";
        }else{
            $table .= "��</td>\n";
        }

        $table .= "
          </tr>
        </table>";


        return $table ;
    }

}
