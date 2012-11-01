<?php
/**
*  デバッグクラス
*
*  文字コード：EUC-JP
*
*  用途：各種デバッグ表示
*
* @package /lib/org/
* @author  Kiyosue, Masaki
* @since   PHP5
* @version 2006.12.01
*/

class Debug {

    function Debug()
    {

    }

    function viewIni()
    {
        print_r(ini_get_all());
        return;
    }

    function viewIniHtml($str = null)
    {
        if( $str ){
            echo "$str = ".ini_get($str)."<br>\n";
        }else{
            $result = print_r(ini_get_all(),true);
            echo nl2br($result);
        }
        return;
    }

    function viewDefine()
    {
        $result = get_defined_constants();
        echo"<table>\n";
        echo"<tr>\n";
        echo"<td><b>Define Name</b></td>\n";
        echo"<td></td>\n";
        echo"<td><b>Define Value</b></td>\n";
        echo"</tr>\n";
        foreach( $result as $key=>$val ){
            echo "<tr>\n";
            echo "<td> {$key} </td>\n";
            echo "<td width='20' align='center'> = </td>\n";
            echo "<td> {$val} </td>\n";
            echo "</tr>\n";
        }
        echo"</table>\n";
        return;
    }

    function viewDefineHtml($str=null)
    {
        if( $str ){
          if(defined($str)){
              echo "$str = ".constant($str)."<br>\n";
          }else{
              echo "$str = not set<br>\n";
          }
        }else{
            $result = print_r(get_defined_constants(),true);
            echo nl2br($result);
        }
        return;
    }

    function viewDefineEx($isFlagView=False)
    {

        if( $isFlagView ){
            $result = get_defined_constants();
            echo"<table>\n";
            echo"<tr>\n";
            echo"<td><b>Define Name</b></td>\n";
            echo"<td></td>\n";
            echo"<td><b>Define Value</b></td>\n";
            echo"</tr>\n";
            foreach( $result as $key=>$val ){
                if( substr($key,0,3)=='EX_'  ){
                    echo "<tr>\n";
                    echo "<td> {$key} </td>\n";
                    echo "<td width='20' align='center'> = </td>\n";
                    echo "<td> {$val} </td>\n";
                    echo "</tr>\n";
                }
            }
            echo"</table>\n";
        }

        return;
    }

    function viewDefineIS($isFlagView=False)
    {

        if( $isFlagView ){
            $result = get_defined_constants();
            echo"<table>\n";
            echo"<tr>\n";
            echo"<td><b>Define Name</b></td>\n";
            echo"<td></td>\n";
            echo"<td><b>Define Value</b></td>\n";
            echo"</tr>\n";
            foreach( $result as $key=>$val ){
                if( substr($key,0,3)=='IS_'  ){
                    echo "<tr>\n";
                    echo "<td> {$key} </td>\n";
                    echo "<td width='20' align='center'> = </td>\n";
                    echo "<td> {$val} </td>\n";
                    echo "</tr>\n";
                }
            }
            echo"</table>\n";
        }

        return;
    }


    // ini check
    function setIni($str,$val)
    {
        if(! ini_set($str,$val)){
            echo "<strong>Warning:</strong>".$_SERVER['PHP_SELF']." NOT INI SET str = $str : val = $val<br>\n";
        }
    }

    // valiable chekc
    function viewVariable($val = null)
    {
        if( is_array($val) ){
            $result = print_r($val,true);
            echo "<pre>".$result."</pre>";
        }elseif($val){
            echo $val."<br>";
        }
        return;
    }


    /**
     * オブジェクト表示
     */
    function viewObject( $data=False, $title=False, $view=False )
    {

        if( $view ){
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

            foreach( $data as $key=>$value ){
                if( is_array($value) ){
                    $this->viewObjectOption($value,"{$title}->{$key}");
                }else{
                    echo "<tr><td> {$title}->{$key} </td><td width='20' align='center'> = </td><td> {$value} </td></tr>\n";
                }
            }
            echo"
            </table>
            <br>
            ";
        }
        return;
    }
    function viewObjectOption( $data=False,$str=False ){

        foreach( $data as $key=>$value ){

            if( is_array($value) ){
                $this->viewArrayOption($value,"{$str}['{$key}']");
            }else{
                echo "<tr><td> {$str}['{$key}'] </td><td width='20' align='center'> = </td><td> {$value} </td></tr>\n";
            }

        }

        return $str;
    }


    /**
     * 配列内表示
     */
    function viewArray( $data=False, $title=False, $view=False )
    {

        if( $view ){
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
                        $this->viewArrayOption($value,"{$title}['{$key}']");
                    }else{
                        echo "<tr><td> {$title}['{$key}'] </td><td width='20' align='center'> = </td><td> {$value} </td></tr>\n";
                    }
                }
            }

            echo"
            </table>
            <br>
            ";
        }

        return ;
    }
    function viewArrayOption( $data=False,$str=False ){

        foreach( $data as $key=>$value ){

            if( is_array($value) ){
                $this->viewArrayOption($value,"{$str}['{$key}']");
            }else{
                echo "<tr><td> {$str}['{$key}'] </td><td width='20' align='center'> = </td><td> {$value} </td></tr>\n";
            }

        }

        return $str;
    }

}
