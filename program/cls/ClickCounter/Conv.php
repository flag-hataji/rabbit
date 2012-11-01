<?php
class Conv
{

  var $connection   = "host=localhost port=5432 dbname=itm-asp user=pgsql";
  var $db           = null ;
  var $inputs       = null;

  var $image = 'R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==';
  var $url = 'http://www.itm-asp.com/conv/img.php' ;

  // __construct
  function Conv()
  {
    // 画像出力(headerを送る)
//    $this->setImage();

    $this->setInputsData();

    if(! $this->inputs['domain'] ){
      $this->setImage();
//      $this->setRedirect($this->url);
    }

    $this->setConnect();

    if( $this->inputs['conv'] ){
      $this->setClickCounter();
    }else{
      $this->setImage();
//      $this->setRedirect($this->url);
    }

    // アクセスデータがあるかチェック
    // click_id のデータと　$this->inputs['conv']['clickcounter_id'] で一致するものだけを抜き出す
    $flag = false ;
    foreach( $this->inputs['click_id'] as $key=>$id ){
      if( array_key_exists($id, $this->inputs['conv']) ){
        $flag = true ;
        break ;
      }
    }

    // IDが存在したらＤＢ登録
    if( $flag ){
      $this->setAccessDb($id);
      // 該当クッキーを削除
//      setcookie ("ITM_{$id}", "", time() - 3600, "/conv/{$this->inputs['conv'][$id]['user_id']}", ".itm-asp.com");// 一ヶ月
    }

    // リダイレクト
      $this->setImage();
//    $this->setRedirect($this->url);
  }


  /**
   * URLから変数を抜き出す。
   * 
   */
  function setInputsData()
  {
    $inputs = explode("/", $_SERVER["REQUEST_URI"]);
    array_shift($inputs);// 2階層ずらす
    array_shift($inputs);
    $this->inputs['user_id']  = array_shift($inputs);

    $this->inputs['domain'] = $_GET['domain'];
    $this->inputs['cookie'] = $_COOKIE ;

    // cookie データの分解
    $this->datas = false ;
    if(! is_array($this->inputs['cookie']) ){
      $this->inputs['conv'] = false ;
      return false ;
    }

    $i = 0 ;
    foreach( $this->inputs['cookie'] as $key => $val ){
      if( ereg("^ITM_[0-9]+$",$key) ){
        $clickcounter_id[$i] = str_replace("ITM_","",$key) ;
        list($user_id[$i], $url_cd[$i], $access_time[$i]) = explode("_",$val );
        $datas[$i]['clickcounter_id'] = $clickcounter_id[$i] ;
        $datas[$i]['user_id']         = $user_id[$i] ;
        $datas[$i]['url_cd']          = $url_cd[$i] ;
        $datas[$i]['access_time']     = $access_time[$i] ;
      }
      ++$i ;
      // sort
      array_multisort($access_time, SORT_DESC, SORT_NUMERIC,
                      $clickcounter_id, SORT_DESC, SORT_NUMERIC,
                      $url_cd, SORT_DESC, SORT_STRING,
                      $user_id, SORT_DESC, SORT_NUMERIC,
                      $datas);

      // click_counter_id を keyにして再構築
      foreach( $datas as $key => $ary ){
        $key = $ary['clickcounter_id'] ;
        $tmp[$key]['user_id']     = $ary['user_id'] ;
        $tmp[$key]['url_cd']      = $ary['url_cd'] ;
        $tmp[$key]['access_time'] = $ary['access_time'] ;
      }
      $this->inputs['conv'] = $tmp ;
    }
    return ture ;
  }

  /**
   * 最新の日時の分を取得してＤＢ検索
   * 
   */
  function setClickCounter()
  {
    // そのドメインが使われているクリックカウンターを取得 一ヶ月以内、100個まで、
    $date = date("Y-m-d", mktime(0,0,0,date("m") - 1,date("d"),date("Y")));

    $query = "SELECT clickcounter_id, url FROM td_clickcounter WHERE url LIKE '%" . pg_escape_string($this->inputs['domain']) . "%'  AND user_id = " . pg_escape_string($this->inputs['user_id']) ;
    $query .= " AND update_date >= '{$date}' ORDER BY update_date DESC LIMIT 100 "  ;

    $result = pg_query($this->db ,$query);
    if( pg_num_rows($result) != 0){
      $i = 0 ;
      while( @list($clickcounter_id, $url) = pg_fetch_array($result, $i)){
        $this->inputs['click_id'][$i] = $clickcounter_id ;
        ++$i ;
      }
    }else{
      return false ;
    }
    return ture ;
  }

  function setAccessDb($id)
  {
    $query = "INSERT INTO td_cc_conversion (
      conversion_id,
      clickcounter_id,
      user_id,
      url_cd,
      remote_addr,
      access_date,
      insert_date,
      update_date
    )VALUES(
      nextval('td_cc_conversion_seq'),
      $id,
      " . $this->inputs['conv'][$id]['user_id'] . ",
      '" . $this->inputs['conv'][$id]['url_cd'] . "',
      '{$_SERVER['REMOTE_ADDR']}',
      '". date("Y-m-d H:i:d",$this->inputs['conv'][$id]['access_time']) ."',
      now(),
      now()
    ) ";
    $result = pg_query( $this->db, $query );

    return true ;
  }



//------------------------------------------------------------------------------------------//

  /**
   * DBとのコネクションをはる
   * @return boolean コネクションがはれない場合に false を返す。
   */
  function setConnect()
  {
    $this->db = pg_connect($this->connection);
    if(! $this->db ){
      $this->setError("DB Connect Error");
      return false ;
    }
  }

  /**
   * errorが起きたときにメールを飛ばす
   * @param string $message メール本文
   */
  function setError($message)
  {
    $message = "ClickCounter ERROR \n\n".$message;
    mb_send_mail("system@itm.ne.jp","itm-asp error",$message);// error
  }

  /**
   * $this->inputs の値の検証
   * 
   */
  function isCheckVar($var)
  {
    if(! ereg("^[0-9A-Za-z]+$",$var) ){
      return false ;
    }
    return true ;
  }

  /**
   * リダイレクト
   * 
   */
  function setRedirect($url)
  {
    header("Location: {$url}");
    exit ;
  }

  // 画像出力
  function setImage(){
    header("P3P: CP=\"NOI DSP COR NID DEVa OUR NOR STA\"\r\n\r\n");
    header ("Content-type: image/gif");
    echo base64_decode($this->image);
    exit ;
  }

}
?>