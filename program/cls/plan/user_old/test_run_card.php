#!/usr/local/bin/php -q
<?PHP
/*
 * ���쥸�åȷ��
 * plan_change@itm-asp.com �ˤƵ�ư
 *
 */







  $mlfr = "info@itm-asp.com";
  $mlto = "plan_change@itm-asp.com";
  $mlsb = "title1_title2";
  $mlms = "plan_change";

  // �᡼������
  $rcd = @mail($mlto, $mlsb, $mlms, $mlfr);


  exit;
?>
