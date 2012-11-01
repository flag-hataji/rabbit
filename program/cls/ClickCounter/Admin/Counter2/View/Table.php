<?php
class Table extends Html
{
  var $limit = 20 ;
  var $offset = 0 ;
  var $page = 1 ;

  function Table(&$db,&$inputs)
  {
  }

  function setOffset(){
    $this->page = 1 ;
    if( isset($_GET['page']) && ereg("^[0-9]+$",$_GET['page'])){
      if( $_GET['page'] > 0 ){
        $this->page = $_GET['page'] ;
      }
    }
    $this->offset = ($this->page -1) * $this->limit ;
  }


  function getTablePage($result,$list_url = null)
  {

    list($count) = pg_fetch_array($result,0);
    list($back,$prev) = $this->getPageNumber($this->page,$this->limit,$count);

    $table = "";
    $table .= "
        <table  border='0' cellpadding='0' cellspacing='0' width='99%'>
          <tr>
            <td align='right' colspan='1' class='gray12' width='610'>��<b>{$count}</b>���桡".($this->page*$this->limit - $this->limit)."��".($this->page * $this->limit)."��</td>\n";


    if( $back != null && $back >= 0){
      $table .= "            <td align='right' colspan='1' class='gray12' width='20'><a href='index.php?page={$back}&{$list_url}'>��</a></td>\n";
    }else{
      $table .= "            <td align='right' colspan='1' class='gray12' width='20'>��</td>\n";
    }

    $table .="            <td align='right' colspan='1' class='gray12' nowrap>| ";
    // ��������Ȥ��ߥåȤǳ��
    $page = $count / $this->limit ;
    if($count % $this->limit != 0){
      ++$page ;
    }
    $i = 1;
    while($i <= $page){
      if($i == $this->page){
        $table .= "<b>{$i}</b> | \n";
      }else{
        $table .= "<a href='index.php?page={$i}&{$list_url}'>{$i}</a> | \n";
      }
      ++$i ;
    }
    $table .= "</td>\n";


    if($prev > 0){
      $table .= "            <td align='right' colspan='1' class='gray12' width='20'><a href='index.php?page={$prev}&{$list_url}'>��</a></TD>\n";
    }else{
      $table .= "            <td align='right' colspan='1' class='gray12' width='20'>��</td>\n";
    }

    $table .= "
          </tr>
        </table>";


    return $table ;
  }


  // private
  function getPageNumber($page,$limit,$count)
  {
    $back = null ;
    $prev = null ;

    if($page <= 1){// �ǽ�Υڡ���
      if( $count > $limit * $page ){// ���Υǡ����������
        $prev = 2 ;
      }else{
        $prev = null ;
      }
      $back = null ;
    }elseif( $count <= $limit * $page){// �ǽ��ʹ�
      $prev = null ;
      $back = ceil($count / $limit) -1 ;
    }else{// ��ڡ���
      $prev = $page +1 ;
      $back = $page -1 ;
    }

    return array($back,$prev);
  }

  // private
  function customize($str)
  {
    return $str ;
  }

}
?>