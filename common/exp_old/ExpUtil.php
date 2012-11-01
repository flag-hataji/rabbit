<?PHP
/*

  �ɲá���ĥ : WEB����


*/

class ExpUtil extends Util{

  Function ExpUtil(){


    return ;
  }

  // * �����פǻ����ѿ����֤�
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


  // * Selectbox(�Ƽ�Ϣ³���� ǯ)
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
   * Selectbox(ʸ���� ����Τ�)
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
   * Selectbox(��ƻ�ܸ�)
   */
  Function selectboxKen( $name='��ƻ�ܸ�', $selected=False, $output=False, $null=False, $null_value="", $null_view="" ){

    $ary = array("�̳�ƻ","�Ŀ���","��긩","�ܾ븩","���ĸ�","������","ʡ�縩",
                 "��븩","���ڸ�","���ϸ�","��̸�","���ո�","�����","�����",
                 "���㸩","�ٻ���","���","ʡ�温","������","Ĺ�","���츩",
                 "�Ų���","���θ�","���Ÿ�","���츩","������","�����","ʼ�˸�",
                 "���ɸ�","�²λ���","Ļ�踩","�纬��","������","���縩","������",
                 "���縩","���","��ɲ��","���θ�","ʡ����","���츩","Ĺ�긩",
                 "���ܸ�","��ʬ��","�ܺ긩","�����縩","���츩");

    return $this->selectboxStr( $name, $ary, $selected, $output, $null, $null_value, $null_view );
  }


}
?>
