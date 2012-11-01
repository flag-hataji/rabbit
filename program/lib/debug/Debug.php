<?PHP
/*

  デバッグ

*/

class Debug {

  /*
      * 定数表示

      前後を"_"で囲んだ定数
   */
  function defineView($view=False){

    if( !$view ){
      return;
    }

    echo"<table>\n";
    echo"<tr>\n";
    echo"<td><b>Define Name</b></td>\n";
    echo"<td></td>\n";
    echo"<td><b>Define Value</b></td>\n";
    echo"</tr>\n";

    foreach( get_defined_constants() as $key=>$val ){
      if( substr($key,0,1)=='_' && substr($key,-1,1)=='_'  ){
        echo "<tr>\n";
        echo "<td> {$key} </td>\n";
        echo "<td width='20' align='center'> = </td>\n";
        echo "<td> {$val} </td>\n";
        echo "</tr>\n";
      }
    }

    echo"</table>\n";

    return ;
  }


  /**
   * 配列内表示
   */
  function arrayView( $data=False, $title=False, $view=False ){

    if( !$view ){
      return;
    }
    echo"
    <table>
      <tr>
        <td colspan='3'><b>{$title}</b></td>
      </tr>
    ";

    if(!$data){
      echo "
      <tr>
        <td colspan='3'><b>Array</b> NoData</b></td>
      </tr>
    </table>
    <br>
      ";
      return ;
    }

    echo"
      <tr>
        <td><b>Array Key's</b></td>
        <td></td>
        <td><b>Array Value</b></td>
      </tr>
    ";
    if( is_array($data) ){
      foreach( $data as $key=>$value ){

        if( is_array($value) ){
          $this->arrayViewOption($value,"{$title}['{$key}']");
        }else{
          echo "<tr><td> {$title}['{$key}'] </td><td width='20' align='center'> = </td><td> {$value} </td></tr>\n";
        }
      }
    }

    echo"
    </table>
    <br>
    ";

    return ;
  }

  function arrayViewOption( $data=False,$str=False ){

    foreach( $data as $key=>$value ){

      if( is_array($value) ){
        $this->arrayViewOption($value,"{$str}['{$key}']");
      }else{
        echo "<tr><td> {$str}['{$key}'] </td><td width='20' align='center'> = </td><td> {$value} </td></tr>\n";
      }

    }

    return $str;
  }

}
?>
