<?PHP
/*

  出力関連


*/

  class OutputMaster {

    var $debug = "";
    var $base = "";
    var $html = "";
    var $page_max    = 20;
    var $code_output = "EUC-JP";

    // * コンストラクタ
    Function OutputMaster($base=False,$code_output=False,$page_max=False,$debug=False){

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
      global $libUtil, $libCode, $expUtil, $pField, $pVariable;

      if( $this->debug ) echo" - "._ROOT_PG_."OutputMaster.php | html({$mode},{$place}) <br>\n";

      $html = "";
      switch( $mode ){

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

            case 'confirm_plan': $html = _HTML_PG_CONFIRM_PLAN_; break;
            case 'finish_plan': $html = _HTML_PG_FINISH_PLAN_; break;

          }
          break;

        // マスターリスト
        case 'list':
          switch( $place ){
            case  'list': $html = _HTML_PG_LIST_; break;
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
     * プラン一覧出力
     */
    function shoePlan($mode='write'){
      global $libUtil,$libCode,$expUtil,$expPostgres,$pVariable;


      $baseQuery  = "SELECT #Column# FROM tm_plan #Where# ORDER BY tm_plan.plan_id ";

      if($mode=='confirm'){

        $column = "tm_plan.plan";

        $baseQuery  = str_replace("#Where#"," WHERE plan_id={$pVariable->inputS['plan_pictmail_id']} ",$baseQuery);

        $query  = str_replace("#Column#",$column,$baseQuery);
        if( $this->debug ) echo"<font size='1'> -  query =  {$query}</font> <br>\n";
        $mDataS = $libCode->encodeBase( $expPostgres->getOne( $query,PGSQL_ASSOC ), $this->code_output, 'EUC-JP');
        unset($query);

        echo"{$mDataS['plan']}";

      }else{

        $column  = "tm_plan.plan_id,";
        $column .= "tm_plan.plan";

        $baseQuery  = str_replace("#Where#","",$baseQuery);
        $query  = str_replace("#Column#",$column,$baseQuery);
        if( $this->debug ) echo"<font size='1'> -  query =  {$query}</font> <br>\n";
        $mDataS = $libCode->encodeBase( $expPostgres->getPlurality( $query,PGSQL_ASSOC ), $this->code_output, 'EUC-JP');
        unset($query);

        if( $mDataS['count']==0 ){

        }else{

          echo"<select name='inputS[plan_pictmail_id]'>\n";

          $i=1;
          while ( $i<=$mDataS['count'] ){

            $mDataS[$i] = $libUtil->getHtml($mDataS[$i]); 

            $selected = "";
            if( $mDataS[$i]['plan_id']==$pVariable->inputS['plan_pictmail_id'] ){
              $selected = "selected";
            }

            echo"<option value='{$mDataS[$i]['plan_id']}' {$selected}>{$mDataS[$i]['plan']}</option>\n";

            $i++;
          }

          echo"</select>\n";

        }

      }

      return ;
    }



    /*
     * エラー文 出力
     */
    Function error(){
      global $libUtil, $libCode, $expUtil, $pField, $pVariable;

      if( $this->debug ) echo"<font size='1'> - "._ROOT_PG_."OutputMaster.php | error()</font> <br>\n";

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

      if( $this->debug ) echo"<font size='1'> - "._ROOT_PG_."OutputMaster.php | hidden({$next})</font> <br>\n";

      $hidden = "";
      $hidden .= "<input type='hidden' name='".session_name()."' value='".session_id()."'>\n";
      $hidden .= "<input type='hidden' name='encoding'           value='文字コード判定用変数'>\n";

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
