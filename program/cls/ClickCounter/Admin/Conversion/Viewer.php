<?php

class Viewer extends ItmViewer
{
//  private $html ;
  var $html ;

  function Viewer(&$db, &$bean)
//  public function __construct(&$db, &$bean)
  {
//    parent::__construct($db, $bean);
    $this->ItmViewer($db, $bean);
  }


  //-- --//
  // updateList
  function setUpdateList()
  {
    $this->bean->setView('navi', "修正") ;
    $this->bean->setView('title', "一覧画面") ;
    $this->bean->setView('message', "登録メッセージ") ;

    require_once dirname($_SERVER['SCRIPT_FILENAME']).'/list.html';
  }
  // deleteList
  function setDeleteList()
  {
    $this->bean->setView('navi', "削除") ;
    $this->bean->setView('title', "一覧画面") ;
    $this->bean->setView('message', "登録メッセージ") ;

    require_once dirname($_SERVER['SCRIPT_FILENAME']).'/list.html';
  }
  // insert
  function setInsert()
  {
    $this->bean->setView('navi', "新規") ;
    $this->bean->setView('title', "入力画面") ;
    $this->bean->setView('message', "登録メッセージ") ;
    $this->bean->setView('next_button', '<INPUT TYPE="submit" VALUE="確認画面へ" NAME="inputs[submit][confirm]">') ;

    require_once dirname($_SERVER['SCRIPT_FILENAME']).'/input.html';
  }
  // update
  function setUpdate()
  {
    $this->bean->setView('navi', "修正") ;
    $this->bean->setView('title', "入力画面") ;
    $this->bean->setView('message', "登録メッセージ") ;
    $this->bean->setView('next_button', '<INPUT TYPE="submit" VALUE="確認画面へ" NAME="inputs[submit][confirm]">') ;

    require_once dirname($_SERVER['SCRIPT_FILENAME']).'/input.html';
  }
  // delete
  function setDelete()
  {
    $this->bean->setView('navi', "削除") ;
    $this->bean->setView('title', "入力画面") ;
    $this->bean->setView('message', "登録メッセージ") ;
    $this->bean->setView('back_button', '<INPUT TYPE="submit" VALUE="削除リスト" NAME="inputs[submit][delete-list]">') ;
    $this->bean->setView('next_button', '<INPUT TYPE="submit" VALUE="削除登録" NAME="inputs[submit][finish]">') ;

    require_once dirname($_SERVER['SCRIPT_FILENAME']).'/confirm.html';
  }

  // confirm
  function setConfirm()
  {

    $this->bean->setView('title', "確認画面") ;
    $this->bean->setView('back_button', '<INPUT TYPE="submit" VALUE="戻る" NAME="inputs[submit][back]">') ;

    switch ($this->bean->getSession('mode')){
      case 'insert';
        $this->bean->setView('navi', "新規") ;
        $this->bean->setView('message', "下記の内容でよろしけば「登録する」をクリックして下さい。") ;
        $this->bean->setView('next_button', '<INPUT TYPE="submit" VALUE="登録する" NAME="inputs[submit][finish]">') ;
        break ;
      case 'update';
        $this->bean->setView('navi', "修正") ;
        $this->bean->setView('message', "下記の内容でよろしけば「修正する」をクリックして下さい。") ;
        $this->bean->setView('next_button', '<INPUT TYPE="submit" VALUE="修正する" NAME="inputs[submit][finish]">') ;
        break ;
      default ;
        die("not select mode".__FILE__.__LINE__);
    }

    require_once dirname($_SERVER['SCRIPT_FILENAME']).'/confirm.html';
  }
  // error back
  function setError()
  {
    switch ($this->bean->getSession('mode')){
      case 'insert';
        $this->setInsert();
        break ;
      case 'update';
        $this->setUpdate();
        break ;
      case 'delete';
        $this->setDelete();
        break ;
      default ;
        die("not select mode".__FILE__.__LINE__);
    }
  }
  // back
  function setBack()
  {
    switch ($this->bean->getSession('mode')){
      case 'insert';
        $this->setInsert();
        break ;
      case 'update';
        $this->setUpdate();
        break ;
      case 'delete';
        $this->setDelete();
        break ;
      default ;
        die("not select mode".__FILE__.__LINE__);
    }
  }

  // finish
  function setFinish()
  {

    $this->bean->setView('title', "完了画面") ;

    switch ($this->bean->getSession('mode')){
      case 'insert';
        $this->bean->setView('navi', "新規") ;
        $this->bean->setView('message', "登録メッセージ") ;
        break ;
      case 'update';
        $this->bean->setView('navi', "修正") ;
        $this->bean->setView('message', "修正メッセージ") ;
        break ;
      case 'delete';
        $this->bean->setView('navi', "削除") ;
        $this->bean->setView('message', "削除メッセージ") ;
        break ;
      default ;
        die("not select mode".__FILE__.__LINE__);
    }

    require_once dirname($_SERVER['SCRIPT_FILENAME']).'/finish.html';
  }




 // -- 表示用パーツ --//
  function viewConversionSelectList($selected, $name)
  {
    $this->setClassLoad('conversion', PHP_PATH . '/Model/Conversion.php');
    echo $this->object['conversion']->getSelectList($selected, $name);
  }
  function viewConversionSelect($selected)
  {
    echo $this->getConversionSelect($selected) ;
  }
  function getConversionSelect($selected)
  {
    $this->setClassLoad('conversion', PHP_PATH . '/Model/Conversion.php');
    return $this->object['conversion']->getDataName($selected);
  }

  function viewConversionList()
  {
    echo $this->getConversionList();
  }
  function getConversionList()
  {
    $this->setClassLoad('conversion', PHP_PATH . '/Model/Conversion.php');
    return $this->object['conversion']->getList();
  }

  function viewPageNavi()
  {
    echo $this->getPageNavi();
  }
  function getPageNavi()
  {
    $this->setClassLoad('conversion', PHP_PATH . '/Model/Conversion.php');
    return $this->object['conversion']->getListTablePage();
  }
}

?>