<?PHP
/*

  ÄÉ²Ã¡¦³ÈÄ¥ : WEB»ÈÍÑ


*/

class ExpUtil extends Util{

  Function ExpUtil(){


    return ;
  }

  // * ¾ò·ï°ìÃ×¤Ç»ØÄêÊÑ¿ô¤òÊÖ¤¹
  Function marked( $setValue=False, $value=False, $marked=False, $output=False ){

    $check = "";
    if( $setValue==$value ){
      $check = $marked;
      if( $output ){
        echo $marked ;
        return ;
      }
    }

    return $check ;
  }


  // * Selectbox(³Æ¼ïÏ¢Â³¿ôÃÍ Ç¯)
  Function selectboxInt( $name=False, $start=0, $row=0, $selected=False, $output=False, $null=False, $null_value=False, $null_view=False ){

    $data = "";

    $data = "<select name='{$name}'>\n";
    if( $output ){
      echo "<select name='{$name}'>\n";
    }

    if( $null ){
      $data .= "<option value='{$null_value}'>{$null_view}</option>\n"; 
      if( $output ){
        echo "<option value='{$null_value}'>{$null_view}</option>\n"; 
      }
    }


    $i = $start;
    $end = ($start+$row);
    while( $i<$end ){

      $data .= "<option value='{$i}' ".$this->marked($i, $selected, 'selected' ).">{$i}</option>\n";
      if( $output ){
        echo "<option value='{$i}' "; 
        $this->marked($i, $selected, 'selected', True ); 
        echo " >{$i}</option>\n";
      }

      $i++;
    }

    $data .= "</select>\n";
    if( $output ){
      echo "</select>\n";
      return ;
    }

    return $data;
  }



  /**
   * Selectbox(Ê¸»úÎó ÇÛÎó¤Î¤ß)
   */
  Function selectboxStr( $name=False, $ary=False, $selected=False, $output=False, $null=False, $null_value=False, $null_view=False ){

    if( !is_array($ary) ){
      return ;
    }

    $data = "";

    $data = "<select name='{$name}'>\n";
    if( $output ){
      echo "<select name='{$name}'>\n";
    }

    if( $null ){
      $data .= "<option value='{$null_value}'>{$null_view}</option>\n"; 
      if( $output ){
        echo "<option value='{$null_value}'>{$null_view}</option>\n"; 
      }
    }

    foreach( $ary as $key=>$value ){
      $data .= "<option value='{$value}' ".$this->marked($value, $selected, 'selected' )." >{$value}</option>\n";
      if( $output ){
        echo "<option value='{$value}' "; 
        $this->marked($value, $selected, 'selected', True ); 
        echo " >{$value}</option>\n";
      }
    }

    $data .= "</select>\n";
    if( $output ){
      echo "</select>\n";
      return ;
    }

    return $data;
  }




  /**
   * Selectbox(ÅÔÆ»ÉÜ¸©)
   */
  Function selectboxKen( $name='ÅÔÆ»ÉÜ¸©', $selected=False, $output=False, $null=False, $null_value="", $null_view="" ){

    $ary = array("ËÌ³¤Æ»","ÀÄ¿¹¸©","´ä¼ê¸©","µÜ¾ë¸©","½©ÅÄ¸©","»³·Á¸©","Ê¡Åç¸©",
                 "°ñ¾ë¸©","ÆÊÌÚ¸©","·²ÇÏ¸©","ºë¶Ì¸©","ÀéÍÕ¸©","ÅìµþÅÔ","¿ÀÆàÀî¸©",
                 "¿·³ã¸©","ÉÙ»³¸©","ÀÐÀî¸©","Ê¡°æ¸©","»³Íü¸©","Ä¹Ìî¸©","´ôÉì¸©",
                 "ÀÅ²¬¸©","°¦ÃÎ¸©","»°½Å¸©","¼¢²ì¸©","µþÅÔÉÜ","ÂçºåÉÜ","Ê¼¸Ë¸©",
                 "ÆàÎÉ¸©","ÏÂ²Î»³¸©","Ä»¼è¸©","Åçº¬¸©","²¬»³¸©","¹­Åç¸©","»³¸ý¸©",
                 "ÆÁÅç¸©","¹áÀî¸©","°¦É²¸©","¹âÃÎ¸©","Ê¡²¬¸©","º´²ì¸©","Ä¹ºê¸©",
                 "·§ËÜ¸©","ÂçÊ¬¸©","µÜºê¸©","¼¯»ùÅç¸©","²­Æì¸©");

    return $this->selectboxStr( $name, $ary, $selected, $output, $null, $null_value, $null_view );
  }


}
?>
