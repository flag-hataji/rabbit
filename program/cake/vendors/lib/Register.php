<?php
/*
$_POST
$_GET
$_SESSION
などを、$bean に登録するクラス


*/
class Register
{

    var $bean = null ;

    // __construct( &$bean )
    function Register( &$bean )
    {
        $this->bean =& $bean ;

        $this->bean->setInputs($this->getInputsData());
        $this->setSubmitData();
        $this->bean->setSearches($this->getSearchesData());
        $this->bean->setFiles($this->getFilesData());
        $this->bean->setViews($this->getViewsData());
        $this->bean->setErrors($this->getErrorsData());

        return true ;
    }


    function getInputsData()
    {
        if(isset($_GET['inputs'])){
            return $_GET['inputs'] ;
        }elseif(isset($_POST['inputs'])){
            return $_POST['inputs'] ;
        }
    }


    function setSubmitData()
    {
        if(isset($_GET['submit'])){
            $submit_key = key($_GET['submit']);
            $submit_val = @key($_GET['submit'][$submit_key]);
        }elseif(isset($_POST['submit'])){
            $submit_key = key($_POST['submit']);
            $submit_val = @key($_POST['submit'][$submit_key]);
        }else{
            $submit_key = null ;
            $submit_val = null ;
        }

        if( ereg(".*_[xy]{1}$",$submit_key) ){
            $submit_key = substr($submit_key,0,-2);
        }
        $this->bean->setVar('submit_key', $submit_key);
        $this->bean->setVar('submit_val', $submit_val);
    }


    function getSearchesData()
    {

        if(isset($_GET['searches'])){
            if(! isset($_GET['searches']['page']) ){
                $_GET['searches']['page'] = 1 ;
            }
            // submit_key がソートならセット
            if( $this->bean->getVar('submit_key') == 'sort' ){
                $_GET['searches']['sort_key'] = $this->getSubmitValue() ;
                $_GET['searches']['page'] = 1 ;
            }
            return $_GET['searches'] ;
        }elseif(isset($_POST['searches'])){
            if(! isset($_POST['searches']['page']) ){
                $_POST['searches']['page'] = 1 ;
            }
            // submit_key がソートならセット
            if( $this->bean->getVar('submit_key') == 'sort' ){
                $_POST['searches']['sort_key'] = $this->getSubmitValue() ;
                $_POST['searches']['page'] = 1 ;
            }
            return $_POST['searches'] ;
        }
    }


    /**
     * $_FILESがある際、$_FILESデータを取得し、分解してbeanに保存
     *
     * @return Array $files 分解されたfileデータ
     */
    function getFilesData()
    {
        if(isset($_FILES['inputs'])){
            foreach( $_FILES['inputs']['error'] as $key => $val ){
                if( $val === 0){
                    $files[$key]['name']     = $_FILES['inputs']['name'][$key];
                    $files[$key]['tmp_name'] = $_FILES['inputs']['tmp_name'][$key];
                    $files[$key]['error']    = $_FILES['inputs']['error'][$key];
                    $files[$key]['size']     = $_FILES['inputs']['size'][$key];
                }
            }
            return $files;
        }
        return null ;
    }


    function getViewsData()
    {
        return null ;
    }


    function getErrorsData()
    {
        return null ;
    }


}
