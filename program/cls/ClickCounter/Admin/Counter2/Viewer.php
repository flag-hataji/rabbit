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

  function viewErrorMessages()
  {
    if(! is_array($this->bean->error['message']) ){
      return ;
    }
    foreach( $this->bean->error['message'] as $val ){
      echo $val."<br />\n";
    }
  }
  function viewErrorMessage()
  {
    $ary = func_get_args();
    foreach( $ary as $key=>$val ){
      if( isset($this->bean->error['code'][$val]) ){
        echo $this->bean->error['code'][$val] ;
      }
    }
  }

  function viewErrorTag()
  {
    $ary = func_get_args();
    foreach( $ary as $key=>$val ){
      if( isset($this->bean->error['code'][$val]) ){
        echo 'error_box';
        break ;
      }
    }
  }

  //-- --//
  // insert
  function setInsert()
  {
    $this->bean->setView('navi', "��Ͽ") ;
    $this->bean->setView('title', "���ϲ���") ;
    $this->bean->setView('message', "��Ͽ��å�����") ;
    $this->bean->setView('next_button', '<INPUT TYPE="submit" VALUE="������Ͽ����" NAME="inputs[submit][write]">') ;

    require_once dirname($_SERVER['SCRIPT_FILENAME']).'/input.html';
  }
  // write
  function setWrite()
  {
    $this->bean->setView('navi', "��Ͽ") ;
    $this->bean->setView('title', "���ϲ���") ;
    $this->bean->setView('message', "��Ͽ��å�����") ;
    $this->bean->setView('next_button', '<INPUT TYPE="submit" VALUE="��ǧ���̤�" NAME="inputs[submit][confirm]">') ;
    $this->bean->setView('back_button', '<INPUT TYPE="submit" VALUE="���ޥ���Ͽ�����" NAME="inputs[submit][insert-back]">') ;

    require_once dirname($_SERVER['SCRIPT_FILENAME']).'/input2.html';
  }
  // insert-back
  function setInsertBack()
  {
    $this->bean->setView('navi', "��Ͽ") ;
    $this->bean->setView('title', "���ϲ���") ;
    $this->bean->setView('message', "��Ͽ��å�����") ;
    $this->bean->setView('next_button', '<INPUT TYPE="submit" VALUE="������Ͽ����" NAME="inputs[submit][write]">') ;

    require_once dirname($_SERVER['SCRIPT_FILENAME']).'/input.html';
  }
  // confirm
  function setConfirm()
  {
    $this->bean->setView('navi', "��Ͽ") ;
    $this->bean->setView('title', "��ǧ����") ;
    $this->bean->setView('message', "���������ƤǤ�����С���Ͽ����פ򥯥�å����Ʋ�������") ;
    $this->bean->setView('next_button', '<INPUT TYPE="submit" VALUE="��Ͽ����" NAME="inputs[submit][finish]">') ;
    $this->bean->setView('back_button', '<INPUT TYPE="submit" VALUE="���" NAME="inputs[submit][back]">') ;

    require_once dirname($_SERVER['SCRIPT_FILENAME']).'/confirm.html';
  }
  // error back
  function setError()
  {
    $this->bean->setView('navi', "��Ͽ") ;
    $this->bean->setView('title', "���顼����") ;
    $this->bean->setView('message', "��Ͽ��å�����") ;
    $this->bean->setView('next_button', '<INPUT TYPE="submit" VALUE="��ǧ���̤�" NAME="inputs[submit][confirm]">') ;
    $this->bean->setView('back_button', '<INPUT TYPE="submit" VALUE="���ޥ���Ͽ�����" NAME="inputs[submit][insert-back]">') ;

    require_once dirname($_SERVER['SCRIPT_FILENAME']).'/input2.html';
  }
  // back
  function setBack()
  {
    $this->bean->setView('navi', "��Ͽ") ;
    $this->bean->setView('title', "���ϲ���") ;
    $this->bean->setView('message', "��Ͽ��å�����") ;

    $this->bean->setView('next_button', '<INPUT TYPE="submit" VALUE="��ǧ���̤�" NAME="inputs[submit][confirm]">') ;
    $this->bean->setView('back_button', '<INPUT TYPE="submit" VALUE="���ޥ���Ͽ�����" NAME="inputs[submit][insert-back]">') ;

    require_once dirname($_SERVER['SCRIPT_FILENAME']).'/input2.html';
  }

  // finish
  function setFinish()
  {
    $this->bean->setView('navi', "��Ͽ") ;
    $this->bean->setView('title', "��λ����") ;
    $this->bean->setView('message', "��Ͽ��å�����") ;

    require_once dirname($_SERVER['SCRIPT_FILENAME']).'/finish.html';
  }

  // over
  function setOver()
  {
    $this->bean->setView('navi', "�ʥ�") ;
    $this->bean->setView('title', "�����ȥ�") ;
    $this->bean->setView('message', "��å�����") ;
    require_once dirname($_SERVER['SCRIPT_FILENAME']).'/over.html';
  }




 // -- ɽ���ѥѡ��� --//
  function viewCategorySelectList($selected, $name)
  {
    $this->setClassLoad('category', PHP_PATH . '/Model/Category.php');
    echo $this->object['category']->getSelectList($selected, $name);
  }
  function viewCategorySelect($selected)
  {
    echo $this->getCategorySelect($selected) ;
  }
  function getCategorySelect($selected)
  {
    $this->setClassLoad('category', PHP_PATH . '/Model/Category.php');
    return $this->object['category']->getDataName($selected);
  }

  function viewWriteTable()
  {
    $this->setClassLoad('writetable', dirname(__FILE__) . '/View/WriteTable.php');
    echo $this->object['writetable']->getWriteTable($this->bean->getSession('mode'));
  }
  function viewWriteConf()
  {
    $this->setClassLoad('writetable', dirname(__FILE__) . '/View/WriteTable.php');
    echo $this->object['writetable']->getWriteConf($this->bean->getSession('mode'));
  }

}

?>