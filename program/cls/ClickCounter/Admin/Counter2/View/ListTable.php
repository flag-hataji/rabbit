<?php
class ListTable extends Table
{

  var $db;
  var $inputs;
  var $search;
  var $html = null ;

  function ListTable(&$db, &$inputs, &$search)
  {
    $this->db =& $db;
    $this->inputs =& $inputs;
    $this->search =& $search;
    $this->setOffset();
    $this->html = null ;
  }

  function getListTable($mode)
  {
    $query = $this->getQuery(1,$mode);

    $result = pg_query($this->db, $query);

//    require_once dirname(__FILE__).'/Client.php';
//    $client = new Client();

    $table = "";

    $i = 0;
    $old_cate_name = null ;
    $old_header = "";
    while(@list($clickcounter_id,$url_cd,$url,$title,$comment,$category_name) = pg_fetch_array($result,$i)){

      list($url_cd,$url,$title,$comment,$category_name) = $this->getHtml($url_cd,$url,$title,$comment,$category_name);

//      $sokonm = $this->customize($sokonm);
      $comment = mb_strimwidth($comment,0,40, "…");

      if( $category_name != $old_cate_name ){
        $table .= "
							<tr>
								<td class='black12' bgcolor='#cccccc' colspan='4'></td>
							</tr>
							<tr>
								<td class='black12' bgcolor='#C8DDFF' colspan='4'>
									{$category_name}
								</td>
							</tr>";
      }

      $table .= "
							<tr>
								<td class='black12' bgcolor='#FFFFFF' rowspan='2'>
									{$title}
								</td>
								<td class='black12' bgcolor='#FFFFFF'>
									<a href='{$url}' target='_blank'>{$url}</a>
								</td>
								<td class='black12' bgcolor='#FFFFFF' rowspan='2'>
									{$comment}
								</td>
								<td class='black12' bgcolor='#FFFFFF' align='center' rowspan='2'>";
      if($_SESSION[SESSION_KEY_NAME]['mode'] == 'delete'){
        $table .= "<a href='index.php?inputs[submit][delete]={$clickcounter_id}'>[削除]</a>";
      }else{
        $table .= "<a href='index.php?inputs[submit][update]={$clickcounter_id}'>[修正登録]</a>";
      }
      $table .="
								</td>
							</tr>
							<tr>
								<td class='black12' bgcolor='#FFFFFF'>
									<a href='".MY_URL."{$_SESSION['user']['user_id']}/{$url_cd}' target='_blank'>".MY_URL."{$_SESSION['user']['user_id']}/{$url_cd}</a>
									
								</td>
							</tr>";

      $old_cate_name = $category_name ;
      ++$i;
    }
    return $table ;
  }

  function getQuery($int,$mode)
  {
    $query = "";

    if($int == 1){
      $query .= " SELECT t1.clickcounter_id, t1.url_cd, t1.url, t1.title, t1.comment1, t2.title";
    }elseif($int == 2){
      $query .= " SELECT count(*) ";
    }

    $query .= " FROM td_clickcounter as t1 JOIN td_cc_category as t2 USING(category_id) ";
    $query .= " WHERE t1.delete_flag = 'f' AND t2.delete_flag='f'";
    $query .= " AND t1.user_id = '".pg_escape_string($_SESSION['user']['user_id'])."'"  ;

    if( isset($this->search) ){
      foreach($this->search as $key=>$val){
        switch( $key ){
          case 'category_id' :
            $query .= " AND t1.category_id = $val";
            break ;
        }
      }
    }

    if($int == 1){
      $query .= " ORDER BY category_id DESC ";
    }elseif($int == 2){
      $query .= "  ";
    }

    if(! isset($this->search) ){
      $query .= " LIMIT 100 ";
    }

//echo $query ;
    return $query ;
  }



  function getListTablePage($mode)
  {

    if($this->html != null){
      return $this->html ;
    }

    $query = $this->getQuery(2,$mode);

//    print "query = {$query} <bR>\n";

    $result = pg_query($this->db, $query);
    list($list_url) = $this->getPageQuery();

    $this->html = $this->getTablePage($result,$list_url);

    return $this->html ;
  }


  // private
  function getPageQuery($ary=null)
  {
    if(! is_array($ary)){
      return false ;
    }

    foreach($ary as $key=>$val){
      switch($key){
        case 'email' :
          if( trim($val) != ""){
            $query .= "inputs[submit][search]=1&";
            $query .= "search[email]=$val" ;
          }
          break ;
        case 'list' :
          $query .= "inputs[submit][list]=1&";
          $query .= "inputs[start_year]={$this->inputs[start_year]}&";
          $query .= "inputs[start_month]={$this->inputs[start_month]}&";
          $query .= "inputs[start_day]={$this->inputs[start_day]}&";
          $query .= "inputs[end_year]={$this->inputs[end_year]}&";
          $query .= "inputs[end_month]={$this->inputs[end_month]}&";
          $query .= "inputs[end_day]={$this->inputs[end_day]}&";
          break ;
      }
    }
    return $query ;
  }

  // private
  function customize($sokonm)
  {
//    $insert_date = substr($insert_date,0,16);
    $str = "";
    switch($sokonm){
      case '01' :
        $str = 'フクソー';
        break ;
      case '11' :
        $str = 'オノウン';
        break ;
      case '31' :
        $str = 'ライオン';
        break ;
      default :
        $str = $sokonm ;
    }

    return $str ;
  }

}
?>