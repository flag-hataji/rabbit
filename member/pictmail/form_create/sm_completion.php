<?php
/********************************************
	サンキューメール設定内容確認出力ファイル
********************************************/

	//ファイルの読み込み
//	require_once("MySmarty.class.php");
	require_once("SQLData.class.php");
	
	//インスタンス生成
//	$smarty = new MySmarty();
	$sql = new SQLData();
	
	//SESSIONよりユーザーID取得
	session_start();
	$user    = $_SESSION['user'];
	$user_id = $user['user_id'];
		if(($user_id=="")||(is_null($user_id))){
		require_once("./templates/loginError.html");
		exit;
	}
	
	//POSTで受けた値を取得
	$data = $_POST['data'];
	
	//それぞれの値を変数に格納
	$sendMail         = $data['sendMail'];
	$transmit_name    = $data['transmit_name'];
	$transmit_mailadd = $data['transmit_mailadd'];
	$return_err       = $data['return_err'];
	$subject          = $data['subject'];
	$text_mess        = $data['text_mess'];
	$use_html         = $data['use_html'];
	$html_mess        = $data['html_mess'];
	$use_mobail       = $data['use_mobail'];
	$mobail_mess      = $data['mobail_mess'];
	$del_flag         = $data['del_flag'];
	$flag             = $data['flag'];
		
	//DBクラスへ値を格納
	$sql->setSendMail($sendMail);
	$sql->setTransmitName($transmit_name);
	$sql->setTransmitMailAdd($transmit_mailadd);
	$sql->setReturnErr($return_err);
	$sql->setSubject($subject);
	$sql->setTextMess($text_mess);
	$sql->setUseHtml($use_html);
	$sql->setHtmlMess($html_mess);
	$sql->setUseMobail($use_mobail);
	$sql->setMobailMess($mobail_mess);
	$sql->setDeleteFlag($del_flag);
	$sql->setUserId($user_id);
	
	//データをDBへ保存
	if($flag=="in"){		//新規の処理
		$ans = $sql->insertSettingMailData();
		if(!$ans){
		echo $sql->errorm;
			exit;
		}
	}else if($flag=="up"){					//修正の処理
		$ans = $sql->updateSettingMailData();
		if(!$ans){
			echo $sql->errorm;
			exit;
		}
	}
	
	//html出力
	$url = "./index.php";
/*
	$smarty->assign("url",$url);
	$smarty->display("./completion.tpl");
*/
	require_once("./templates/completion.html");
?>