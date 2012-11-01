<?php

class WriteTable extends Table
{

  var $db;
  var $bean ;
  var $html = null ;

  function WriteTable(&$db, &$bean)
  {
    $this->db =& $db;
    $this->bean =& $bean;
    $this->setOffset();
    $this->html = null ;
  }

    /**
     * 一括登録の入力画面
     *
     */
    function getWriteTable($mode)
    {

        require_once(PHP_PATH . '/Model/Conversion.php');
        $conversion = new Conversion($this->db, $this->bean);
        
        // 改行コードを統一
        $data    = $this->nl2LF($this->bean->getInput("comment"));
        $changes = $this->nl2LF($this->bean->getInput("change"));
        $titles  = $this->nl2LF($this->bean->getInput("title"));
        $conversion_ids  = $this->nl2LF($this->bean->getInput("conversion_id"));
        $datas = explode("\n", $data);
        $i = 0 ;
        foreach($datas as $key => $str){
            if( preg_match("/s?https?:\/\/[-_.!~*'()a-zA-Z0-9;\/?:@&=+$,%#]+/",$str) ){
                $flag = $this->isSpecialUrl($str);
                if( $flag ){
                    echo "<div id='error_url'>\n";
                    echo "<strong>このURLは、すでに登録されているカウンターの可能性があります。登録済みのカウンターを新たに登録すると、２重にアクセスがカウントされ、正確な数値が判別できません。</strong><br />";
                    echo "</div>\n";
                }
            echo "<div id='url'>\n";
            echo "適応：<input type='checkbox' name='inputs[change][$i]' value='t' ".$this->getChecked($changes[$i],'t').">";
            echo "$str<br>\n";
            echo "タイトル：<input type='text' name='inputs[title][$i]' value='{$titles[$i]}' size='50'><br />\n";
            echo "コンバージョン：" . $conversion->getSelectBox( $conversion_ids[$i], "inputs[conversion_id][$i]") . "\n";
        echo "</div>\n";
        ++$i;
      }else{
        echo "$str<br>\n";
      }
    }
  }

    /**
     * 一括登録の確認画面
     *
     */
    function getWriteConf($mode)
    {
        $cc_setup =& $this->bean->getObject('cc_setup');

        require_once(PHP_PATH . '/Model/Conversion.php');
        $conversion = new Conversion($this->db, $this->bean);

        // 改行コードを統一
        $data    = $this->nl2LF($this->bean->getInput("comment"));
        $changes = $this->nl2LF($this->bean->getInput("change"));
        $titles  = $this->nl2LF($this->bean->getInput("title"));
        $conversion_ids  = $this->nl2LF($this->bean->getInput("conversion_id"));
        $datas = explode("\n", $data);
        $comment1 = "";
        $i = 0 ;
        foreach($datas as $key => $str){
            if( preg_match("/s?https?:\/\/[-_.!~*'()a-zA-Z0-9;\/?:@&=+$,%#]+/",$str, $matches) ){
                if( $changes[$i] =='t'){
                    $url_cd[$i] = $cc_setup->getUrlCd();
                    $cc_url     = $this->getUrl($url_cd[$i]);
                    $url[$i]    = $matches[0] ;
                    $str = str_replace($url[$i], $cc_url, $str)  ;

                    $conv = $conversion->getData($conversion_ids[$i]);//conversion 2007.03.06
                    if(! $conv ){
                        $conv = "未選択";
                    }

                    echo "<div id='url'>\n";
                    echo $str."<br />" ;
                    echo "タイトル：{$titles[$i]}<br />\n";
                    echo "コンバージョン：{$conv}<br />\n";
                    echo "</div>\n";
                }else{
                    echo "$str<br>\n";
                }
                ++$i;
            }else{
                echo "$str<br>\n";
            }
            $comment1 .= $str . "\n" ;
        }

        $this->bean->setInput("comment1", $comment1) ;
        $this->bean->setInput("url", $url);
        $this->bean->setInput("url_cd", $url_cd);
        $this->bean->setSession('inputs', $this->bean->getInputs());
    }

  function getUrl($url_cd)
  {
    $url = MY_URL.$_SESSION['user']['user_id']."/".$url_cd ;
    return $url; 
  }

  /**
   * 自分の設定しているドメインか,ITM-ASPかを判別する
   * @param  string $url URL
   * @return boolean true or false
   */
  function isSpecialUrl($url)
  {
//    if(ereg('itm-asp.com/cc',$url) || ereg( "^" . MY_URL . ".*$" , $url)){
    if(ereg('itm-asp.com/cc',$url) || ereg( MY_URL , $url)){
      return true ;
    }
    return false ;
  }

}
?>