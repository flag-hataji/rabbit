<?PHP
/*

  出力関連


*/

  class OutputUser {

    var $debug = "";
    var $base = "";
    var $html = "";
    var $page_max    = 20;
    var $code_output = "EUC-JP";

    // * コンストラクタ
    Function OutputUser($base=False,$code_output=False,$page_max=False,$debug=False){

      if( $debug )       $this->debug       = True;
      if( $base )        $this->base        = $base;
      if( $page_max )    $this->page_max    = $page_max;
      if( $code_output ) $this->code_output = $code_output;

      return ;
    }


    /*
     * html出力
     */
    function html($mode=False,$place=False){
      global $mstAry,$libUtil, $libCode, $expUtil, $pField, $pVariable;

      if( $this->debug ) echo" - "._ROOT_PG_."OutputUser.php | html({$mode},{$place}) <br>\n";

      $html = "";
      switch( $mode ){

        // ユーザートップ
        case 'top':
          switch( $place ){
            case  'error': $html = _HTML_PG_ERROR_;  break;
            case   'menu': $html = _HTML_PG_MENU_;   break;
            case 'logout':
            case  'login': $html = _HTML_PG_LOGIN_;  break;
          }
          break;

        // ID・Password忘れ
        case 'forget':
          switch( $place ){
            case   'write': $html = _HTML_PG_WRITE_;   break;
            case   'error': $html = _HTML_PG_WRITE_;   break;
            case  'finish': $html = _HTML_PG_FINISH_;  break;
          }
          break;

        // 新規登録
        // 修正登録
        case 'new':
        case 'renew':
          switch( $place ){
            case   'write': $html = _HTML_PG_WRITE_;   break;
            case 'confirm': $html = _HTML_PG_CONFIRM_; break;
            case 'rewrite': $html = _HTML_PG_WRITE_;   break;
            case   'error': $html = _HTML_PG_WRITE_;   break;
            case  'finish': $html = _HTML_PG_FINISH_;  break;
          }
          break;

      }

      if( !$html ) die('NOT HTML');

      // 表示・出力用文字変換
      $pField->nameS     = $libCode->encodeBase( $pField->nameS,    $this->code_output, 'EUC-JP');
      $pVariable->viewS  = $libCode->encodeBase( $pVariable->viewS, $this->code_output, 'EUC-JP');
      $pVariable->writeS = $libCode->encodeBase( $pVariable->writeS,$this->code_output, 'EUC-JP');


      require_once _HTML_PG_BASE_ ;

      return;
    }


    /*
     * プラン出力
     */
    Function showPlan($mode=False,$value=False){
      global $libCode,$mstAry,$expPostgres,$expUtil,$pField;

      if( $this->debug ) echo"<font size='1'> - "._ROOT_PG_."OutputUser.php | showPlan({$mode},{$value})</font> <br>\n";


      $query  = "SELECT * FROM tm_plan WHERE flag_open=1 ";


      switch($mode){

        case   'write':

          $query .= " ORDER BY plan_id ";
          if( $this->debug ) echo"<font size='1'> -  query =  {$query}</font> <br>\n";
          $pDataS = $libCode->encodeBase( $expPostgres->getPlurality( $query,PGSQL_ASSOC ), $this->code_output, 'EUC-JP');




          $i=1;
          while ( $i<=$pDataS['count'] ){
            $checked = "";
            if( $value==$pDataS[$i]['plan_id'] ){
              $checked = "checked";
            }

            $price_first = number_format(floor($pDataS[$i]['price_first']*1.05));
            $price_month = number_format(floor($pDataS[$i]['price_month']*1.05));
            $price_month6 = number_format(floor(floor($pDataS[$i]['price_month']*1.05)*6));

            echo "
              <table width='535' height='80' border='0' cellpadding='0' cellspacing='1' bgcolor='#948E8E'>
                <tr bgcolor='#FFFFFF' class='gray12'> 
                  <td align='center' width='150' bgcolor='#F4F3F1'>
                    <input type='radio' name='inputS[plan_id]' value='{$pDataS[$i]['plan_id']}' {$checked}>{$pDataS[$i]['plan']}<br>
                  </td> 
                  <td align='left'>

                    <table width='350' border='0' cellpadding='5' cellspacing='0' bgcolor='#948E8E'>
                      <tr bgcolor='#FFFFFF' class='gray12'> 
                        <td align='center' width='120'>
                          メール送信可能件数
                        </td> 
                        <td align='left'>
                          ： {$pDataS[$i]['send_max']} 件（最大）<br>
                        </td> 
                      </tr>
                      <tr bgcolor='#FFFFFF' class='gray12'> 
                        <td align='center'>
                          初期設定費
                        </td> 
                        <td align='left'>
                          ： {$price_first}円<br>
                        </td> 
                      </tr>
                      <tr bgcolor='#FFFFFF' class='gray12'> 
                        <td align='center'>
                          6ヶ月の料金
                        </td> 
                        <td align='left'>
                          ： {$price_month6}円 (1ヶ月 {$price_month}円) <br>
                        </td> 
                      </tr>
                      <tr bgcolor='#FFFFFF' class='gray12'> 
                        <td align='center'>
                          お支払方法
                        </td> 
                        <td align='left'>
                          ： 銀行振り込み <br>
                        </td> 
                      </tr>
                      <tr bgcolor='#FFFFFF' class='red12'> 
                        <td align='left' colspan='2'>
                          ".nl2br($pDataS[$i]['comment'])."
                          
                        </td> 
                      </tr>
                    </table> 



                  </td> 
                </tr>
              </table> 
              <br>

            ";
/*
*/


            $i++;
          }
          break;

        case 'confirm':
          $query .= " AND plan_id={$value}";
          if( $this->debug ) echo"<font size='1'> -  query =  {$query}</font> <br>\n";
          $pDataS = $libCode->encodeBase( $expPostgres->getOne( $query,PGSQL_ASSOC ), $this->code_output, 'EUC-JP');

          echo "　<b>{$pDataS['plan']}</b><br>";
          echo "■ 二回目以降の口座自動引き落とし　：";
          if( isset($_POST['inputS']['auto_money']) && $_POST['inputS']['auto_money']=='t' ){
            echo "　<b>する</b>";
          }else{
            echo "　<b>しない</b>";
          }
          break;
      }

      return ;
    }


    /*
     * 都道府県セレクトボックス出力
     */
    function selectboxKen($name=False,$selected=False){
      global $libCode,$expUtil;

      if( $this->debug ) echo"<font size='1'> - "._ROOT_PG_."OutputUser.php | selectBoxKen({$name},{$selected})</font> <br>\n";

      echo $libCode->encodeBase( $expUtil->selectboxKen( $name, $selected ), $this->code_output, 'EUC-JP');

      return;
    }


    /*
     * エラー文 出力
     */
    Function error(){
      global $libUtil, $libCode, $expUtil, $pField, $pVariable;

      if( $this->debug ) echo"<font size='1'> - "._ROOT_PG_."OutputUser.php | error()</font> <br>\n";

      $error = "";

      if( $pVariable->errorS ){
        $error = "<br>";
        if( isset($pVariable->errorS) && $pVariable->errorS ){
          foreach($pVariable->errorS as $key=>$word){
            $error .= "{$word}<br>\n";
          }
        }
        $error .= "<br>";

      }
      echo $libCode->encodeBase( $error, $this->code_output, 'EUC-JP');

      return ;
    }


    /*
     * hidden出力
     */
    Function hidden($next=False ){
      global $libUtil, $libCode, $expUtil, $pField, $pVariable;

      if( $this->debug ) echo"<font size='1'> - "._ROOT_PG_."OutputUser.php | hidden({$next})</font> <br>\n";

      $hidden = "";
      $hidden .= "<input type='hidden' name='".session_name()."' value='".session_id()."'>\n";
      $hidden .= "<input type='hidden' name='encoding'           value='もじこーどはんていようていすう'>\n";

      if( $next ) $hidden .= "<input type='hidden' name='hidden' value='{$next}'>\n";

      if( isset($pVariable->hiddenS) && is_array($pVariable->hiddenS) ){
        foreach($pVariable->hiddenS as $name=>$value ){
          $hidden .= "<input type='hidden' name='{$name}' value='{$value}'>\n";
          if( $this->debug ) echo"<font size='2'>＜input type='hidden' name='{$name}' value='{$value}'＞</font><br>\n";
        }
      }

      echo $libCode->encodeBase( $hidden, $this->code_output, 'EUC-JP');

      return;
    }

  }
?>
