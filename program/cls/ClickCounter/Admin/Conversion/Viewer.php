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
    $this->bean->setView('navi', "����") ;
    $this->bean->setView('title', "��������") ;
    $this->bean->setView('message', "��Ͽ��å�����") ;

    require_once dirname($_SERVER['SCRIPT_FILENAME']).'/list.html';
  }
  // deleteList
  function setDeleteList()
  {
    $this->bean->setView('navi', "���") ;
    $this->bean->setView('title', "��������") ;
    $this->bean->setView('message', "��Ͽ��å�����") ;

    require_once dirname($_SERVER['SCRIPT_FILENAME']).'/list.html';
  }
  // insert
  function setInsert()
  {
    $this->bean->setView('navi', "����") ;
    $this->bean->setView('title', "���ϲ���") ;
    $this->bean->setView('message', "��Ͽ��å�����") ;
    $this->bean->setView('next_button', '<INPUT TYPE="submit" VALUE="��ǧ���̤�" NAME="inputs[submit][confirm]">') ;

    require_once dirname($_SERVER['SCRIPT_FILENAME']).'/input.html';
  }
  // update
  function setUpdate()
  {
    $this->bean->setView('navi', "����") ;
    $this->bean->setView('title', "���ϲ���") ;
    $this->bean->setView('message', "��Ͽ��å�����") ;
    $this->bean->setView('next_button', '<INPUT TYPE="submit" VALUE="��ǧ���̤�" NAME="inputs[submit][confirm]">') ;

    require_once dirname($_SERVER['SCRIPT_FILENAME']).'/input.html';
  }
  // delete
  function setDelete()
  {
    $this->bean->setView('navi', "���") ;
    $this->bean->setView('title', "���ϲ���") ;
    $this->bean->setView('message', "��Ͽ��å�����") ;
    $this->bean->setView('back_button', '<INPUT TYPE="submit" VALUE="����ꥹ��" NAME="inputs[submit][delete-list]">') ;
    $this->bean->setView('next_button', '<INPUT TYPE="submit" VALUE="�����Ͽ" NAME="inputs[submit][finish]">') ;

    require_once dirname($_SERVER['SCRIPT_FILENAME']).'/confirm.html';
  }

  // confirm
  function setConfirm()
  {

    $this->bean->setView('title', "��ǧ����") ;
    $this->bean->setView('back_button', '<INPUT TYPE="submit" VALUE="���" NAME="inputs[submit][back]">') ;

    switch ($this->bean->getSession('mode')){
      case 'insert';
        $this->bean->setView('navi', "����") ;
        $this->bean->setView('message', "���������ƤǤ�����С���Ͽ����פ򥯥�å����Ʋ�������") ;
        $this->bean->setView('next_button', '<INPUT TYPE="submit" VALUE="��Ͽ����" NAME="inputs[submit][finish]">') ;
        break ;
      case 'update';
        $this->bean->setView('navi', "����") ;
        $this->bean->setView('message', "���������ƤǤ�����Сֽ�������פ򥯥�å����Ʋ�������") ;
        $this->bean->setView('next_button', '<INPUT TYPE="submit" VALUE="��������" NAME="inputs[submit][finish]">') ;
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

    $this->bean->setView('title', "��λ����") ;

    switch ($this->bean->getSession('mode')){
      case 'insert';
        $this->bean->setView('navi', "����") ;
        $this->bean->setView('message', "��Ͽ��å�����") ;
        break ;
      case 'update';
        $this->bean->setView('navi', "����") ;
        $this->bean->setView('message', "������å�����") ;
        break ;
      case 'delete';
        $this->bean->setView('navi', "���") ;
        $this->bean->setView('message', "�����å�����") ;
        break ;
      default ;
        die("not select mode".__FILE__.__LINE__);
    }

    require_once dirname($_SERVER['SCRIPT_FILENAME']).'/finish.html';
  }




 // -- ɽ���ѥѡ��� --//
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