<?php
class Bean 
{

    var $objects  ; // object��
    var $resource ; // resource��
    var $inputs   ; // inputs��
    var $searches ; // ������
    var $files    ; // file upload��
    var $views    ; // ���ɽ����
    var $errors   ; // ���顼��
    var $system_error ; // �������顼��

    function Bean()
    {
    }

    /**
     * �ѿ�����Ͽ���Ф�
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
     * ���֥������ȴط�����Ͽ�����Ф����������Ͽ��ǧ
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
     * �꥽��������¸
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
     * Inputs�ط����̾������ѿ�
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
     * searches�ط�����Ͽ�����Ф����������Ͽ��ǧ
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
     * files �ط�����Ͽ�����Ф����������Ͽ��ǧ
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
     * views�ط�����Ͽ�����Ф����������Ͽ��ǧ
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
     * errors�ط�����Ͽ�����Ф����������Ͽ��ǧ
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
     * systemerrors�ط�����Ͽ�����Ф�
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
     * session�ط�����Ͽ�����Ф����������Ͽ��ǧ
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
     * HTMLɽ����
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
     * ���ӡ�����ѿ��ؤγ�Ǽ
     * 
     * ����ѿ���$key�ʥ����ˤ�$val���Ǽ
     * 
     * @param string $key ��Ǽ��������ѿ��Υ�����['����']�η���
     * @param string $val ��Ǽ������
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
     * ���ӡ�����ѿ��μ���
     * 
     * ����ѿ���$key�ʥ����ˤ��ͤ������['����']�η���
     * ���������$return�ˤ��ͤ���֤�
     * 
     * @param string $key ������������ѿ��Υ���
     * @return string $return���֤�
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
     * ���ӡ�����ѿ��κ��
     * ����ѿ���$key�ʥ����ˤ���
     * ���������$return(True or False)���֤�
     * 
     * @param string $key �����������ѿ��Υ�����['����']�η���
     * @param string $type �����������ѿ��μ���
     * @return boolean $return(True or False)���֤�
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
