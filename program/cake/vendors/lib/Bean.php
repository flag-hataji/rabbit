<?php
class Bean 
{

    var $objects  ; // object用
    var $resource ; // resource用
    var $inputs   ; // inputs用
    var $searches ; // 検索用
    var $files    ; // file upload用
    var $views    ; // 一時表示用
    var $errors   ; // エラー用
    var $system_error ; // 内部エラー用

    function Bean()
    {
    }

    /**
     * 変数の登録取り出し
     */
    function setVar($name, $val)
    {
        $this->$name = $val ;
    }
    function getVar($name)
    {
        if( $this->isVar($name) ){
            return $this->$name ;
        }
    }
    function isVar($name)
    {
        return isset( $this->$name );
    }


    /**
     * オブジェクト関係、登録、取り出し、削除、登録確認
     */
    function setObject($name, &$object)
    {
        $this->objects[$name] =& $object ;
    }
    function getObject($name)
    {
        if( $this->isObject($name) ){
            return $this->objects[$name] ;
        }
    }
    function unsetObject($name)
    {
        unset( $this->objects[$name] );
    }
    function isObject($name)
    {
        return isset( $this->objects[$name] );
    }
    function setObjects($var){
        $this->objects = $var ;
    }
    function getObjects(){
        return $this->objects ;
    }

    /**
     * リソースの保存
     */
    function setResource($name, $resource)
    {
        $this->resource[$name] = $resource ;
    }
    function getResource($name)
    {
        if( $this->isResource($name) ){
            return $this->resource[$name] ;
        }
    }
    function unsetResource($name)
    {
        unset( $this->resource[$name] );
    }
    function isResource($name)
    {
        return isset( $this->resource[$name] );
    }

    /**
     * Inputs関係、通常利用変数
     */
    function setInput($key, $val)
    {
      $this->inputs[$key] = $val ;
    }
    function getInput($key)
    {
      if( $this->isInput($key) ){
        return $this->inputs[$key];
      }
    }
    function unsetInput($key)
    {
      unset($this->inputs[$key]) ;
    }
    function isInput($key)
    {
      return isset( $this->inputs[$key] );
    }
    function setInputs($var){
      $this->inputs = $var ;
    }
    function getInputs(){
      return $this->inputs ;
    }

    /**
     * searches関係、登録、取り出し、削除、登録確認
     */
    function setSearch($key, $val)
    {
      $this->searches[$key] = $val ;
    }
    function getSearch($key)
    {
      if( $this->isSearch($key) ){
        return $this->searches[$key];
      }
    }
    function unsetSearch($key)
    {
      unset($this->searches[$key]) ;
    }
    function isSearch($key)
    {
      return isset( $this->searches[$key] );
    }
    function setSearches($var){
      $this->searches = $var ;
    }
    function getSearches()
    {
      return $this->searches ;
    }


    /**
     * files 関係、登録、取り出し、削除、登録確認
     */
    function setFile($key, $val)
    {
        $this->files[$key] = $val ;
    }
    function getFile($key)
    {
        if( $this->isFile($key) ){
            return $this->files[$key];
        }
    }
    function unsetFile($key)
    {
        unset($this->files[$key]) ;
    }
    function isFiles($key)
    {
        return isset( $this->files[$key] );
    }
    function setFiles($var)
    {
        $this->files = $var ;
    }
    function getFiles()
    {
        return $this->files ;
    }


    /**
     * views関係、登録、取り出し、削除、登録確認
     */
    function setView($key, $val)
    {
        $this->views[$key] = $val ;
    }
    function getView($key)
    {
        if( $this->isView($key) ){
            return $this->views[$key];
        }
    }
    function unsetView($key)
    {
        unset($this->views[$key]) ;
    }
    function isView($key)
    {
        return isset( $this->views[$key] );
    }
    function setViews($var)
    {
        $this->views = $var ;
    }
    function getViews()
    {
        return $this->views ;
    }


    /**
     * errors関係、登録、取り出し、削除、登録確認
     */
    function setError($key, $val)
    {
        $this->errors[$key] = $val ;
    }
    function getError($key)
    {
        if( $this->isError($key) ){
            return $this->errors[$key];
        }
    }
    function isError($key)
    {
        return isset( $this->errors[$key] );
    }
    function setErrors($var)
    {
        $this->errors = $var ;
    }
    function getErrors()
    {
      return $this->errors ;
    }


    /**
     * systemerrors関係、登録、取り出し
     */
    function setSystemError($str)
    {
        $this->system_error .= $str ;
    }
    function getSystemError()
    {
        return $this->system_error ;
    }


    /**
     * session関係、登録、取り出し、削除、登録確認
     */
    function setSession($key, $val)
    {
        if( defined("SESSION_KEY_NAME") ){
            $_SESSION[SESSION_KEY_NAME][$key] = $val ;
        } else {
            $_SESSION[$key] = $val ;
        }
    }
    function getSession($key)
    {
        if( defined("SESSION_KEY_NAME") ){
            if( isset($_SESSION[SESSION_KEY_NAME][$key]) ){
                return $_SESSION[SESSION_KEY_NAME][$key] ;
            }
        } else {
            if( isset($_SESSION[$key]) ){
                return $_SESSION[$key] ;
            }
        }
    }
    function unsetSession($key)
    {
        if( defined("SESSION_KEY_NAME") ){
            unset($_SESSION[SESSION_KEY_NAME][$key]) ;
        }else{
            unset($_SESSION[$key]) ;
        }
    }
    function setInputSession($key, $val)
    {
        if( defined("SESSION_KEY_NAME") ){
            $_SESSION[SESSION_KEY_NAME]['inputs'][$key] = $val ;
        } else {
            $_SESSION['inputs'][$key] = $val ;
        }
    }


    /**
     * HTML表示用
     *
     */
    function viewInputHtml( $str )
    {
        echo nl2br(htmlspecialchars($this->getInput($str)));
    }

    function viewSearchHtml( $str )
    {
        echo nl2br(htmlspecialchars($this->getSearch($str)));
    }

    function viewViewHtml( $str )
    {
        echo nl2br(htmlspecialchars($this->getView($str)));
    }

    function viewErrorHtml( $str )
    {
        echo nl2br(htmlspecialchars($this->getError($str)));
    }



    /**
     * 用途：定義変数への格納
     * 
     * 定義変数の$key（キー）に$valを格納
     * 
     * @param string $key 格納する定義変数のキー（['〜〜']の形）
     * @param string $val 格納する値
     * @access public
     */
    function setSPG($key="",$val="",$type="")
    {
        $return = "";
        if ($key!="" && $type!="") {
            $command = "\$_".$type.$key." = \$val;";
            eval($command);
        }
        return ;
    }

    /**
     * 用途：定義変数の取得
     * 
     * 定義変数の$key（キー）の値を取得（['〜〜']の形）
     * 成功すれば$returnにて値をを返す
     * 
     * @param string $key 取得する定義変数のキー
     * @return string $returnを返す
     * @access public
     */
    function getSPG($key="",$type="")
    {
        $return = "";
        if ($key!="" && $type!="") {
            $command  = "if(isset(\$_".$type.$key.")){";
            $command .= "\$return = \$_".$type.$key.";";
            $command .= "}";
            eval($command);
        }
        return $return;
    }

    /**
     * 用途：定義変数の削除
     * 定義変数の$key（キー）を削除
     * 成功すれば$return(True or False)を返す
     * 
     * @param string $key 削除する定義変数のキー（['〜〜']の形）
     * @param string $type 削除する定義変数の種類
     * @return boolean $return(True or False)を返す
     * @access public
     */
    function setUnsetSPG($key="",$type="")
    {
        $return = false;
        if ($key!="" && $type!="") {
            $command  = "if(isset(\$_".$type.$key.")){";
            $command .= "unset(\$_".$type.$key.");";
            $command .= "\$return = true;";
            $command .= "}";
            eval($command);
            
        }
        return $return;
    }
}
