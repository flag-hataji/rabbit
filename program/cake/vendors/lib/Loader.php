<?php

class Loader
{
   var $bean ;

    function Loader( &$bean )
    {
        $this->bean =& $bean ;
    }

    /**
     * 指定のクラスを呼び出して $beanに保存
     * @param string $name オブジェクト名(変数名)
     * @param string $path クラスまでのパス
     *
     */
    function setClassLoad($name, $path)
    {

        if(! $name ){
            $this->bean->setSystemError(__FILE__ . ':' . __LINE__ . "<br>\n");
            return false ;
        }
        if(! $path ){
            $this->bean->setSystemError(__FILE__ . ':' . __LINE__ . "<br>\n");
            return false ;
        }

        if( $this->bean->isObject( $name ) ){
            return true ;
        }
        if( file_exists($path) ){
            require_once $path ;
        } elseif (file_exists($path = (dirname(__FILE__) . '/' . $path))) {
            require_once $path ;
        } else {
            $this->bean->setSystemError(__FILE__ . ':' . __LINE__ . "<br>path={$path}<br>\n");
            return false ;
        }

        $class_name = basename($path,".php");

        $this->bean->setObject($name, new $class_name($this->bean));

        return true ;
    }


    /**
     * 指定のクラスを返す、beanに設定されてなく、第二引数にパスがあれば、呼び出して $beanに保存
     * @param string $name オブジェクト名(変数名)
     * @param string $path クラスまでのパス
     *
     */
    function getClassLoad( $name ,$path = "")
    {
        if(! $this->bean->isObject($name) ){
            if(! $this->setClassLoad($name, $path) ){
                $this->bean->setSystemError(__FILE__ . ':' . __LINE__ . "<br>\n");
                return false ;
            }
        }

        return $this->bean->getObject($name);
    }

}
