#!/usr/local/bin/php -q
<?PHP
/*
 * クレジット決済
 * plan_change@itm-asp.com にて起動
 *
 */







  $mlfr = "info@itm-asp.com";
  $mlto = "plan_change@itm-asp.com";
  $mlsb = "title1_title2";
  $mlms = "plan_change";

  // メール送信
  $rcd = @mail($mlto, $mlsb, $mlms, $mlfr);


  exit;
?>
