<?php
/*****************************************
	サンキューメール設定用ファイル
****************************************/

	//ファイルの読み込み
//	require_once("MySmarty.class.php");
	require_once("CheckValue.class.php");
	require_once("SQLData.class.php");
	
	//インスタンス生成
//	$smarty = new MySmarty();
	$chk = new CheckValue();
	$sql = new SQLData();
	
	//SESSIONよりユーザーID取得
	session_start();
	$user    = $_SESSION['user'];
	$user_id = $user['user_id'];
		if(($user_id=="")||(is_null($user_id))){
		require_once("./templates/loginError.html");
		exit;
	}
	
	//deleteフラグ
	$del_flag="0";
	
	//フォームの入力データを取得
	$data = $_POST['data'];
	
	//TEXTメッセージの初期値設定
	$text_mess = "メッセージを入力して下さい";
	
	//hrmlメッセージの初期値設定
	$html_mess = "";
	
	//DBからデータを取得
	$sql_data = $sql->getSettingMail3Data($user_id);
	if(!$sql_data==""){
	
		//サンキューメールのフラグ取得	
		$sendMail         = $sql_data['sendmail_flag'];
		if($sendMail=="1"){
			$sendMail="t";
		}else if($sendMail=="0"){
			$sendMail="f";
		}
		//送信者名取得
		$transmit_name    = $sql_data['transmit_name'];
		//送信元メールアドレス取得
		$transmit_mailadd = $sql_data['transmit_mailadd'];
		//エラー戻り先メールアドレスの取得
		$return_err       = $sql_data['return_err'];
		//件名の取得
		$subject          = $sql_data['subject'];
		//TEXTメッセージの取得
		$text_mess        = $sql_data['text_mess'];
		//HTMLメッセージ使用のフラグ取得
		$use_html         = $sql_data['html_flag'];
		//携帯メッセージを取得
		$mobail_mess      = $sql_data['mobail_mess'];
		$use_mobail       = $sql_data['mobail_flag'];
		//html用に変数置換
		if($use_html=="1"){
			$use_html="t";
		}
		
		//HTMLメッセージの取得
		$html_mess        = $sql_data['html_mess'];
		//更新用のフラグ
		$flag = "up";
	}else{								//新規作成の場合の処理
		if(is_null($data)){
			$flag="in";
			
			//携帯への対処初期値
			$use_mobail = 2;
		/*
			//htmlへ変数代入
			$smarty->assign("flag",$flag);
			$smarty->assign("text_mess",$text_mess);
			$smarty->assign("postFlag",$postFlag);
			//html出力
			$smarty->display("./settingMail.tpl");
		*/
			require_once("./templates/settingMail3.html");
			exit;
		}
	}
	
	//POSTで来た時の対処
	if(!is_null($data)){
	
		//サンキューメールのフラグ取得	
		$sendMail         = $data['sendMail'];
		//送信者名取得						※必須項目
		$transmit_name    = $data['transmit_name'];
		//送信元メールアドレス取得			※必須項目
		$transmit_mailadd = $data['transmit_mailadd'];
		//エラー戻り先メールアドレスの取得	※必須項目
		$return_err       = $data['return_err'];
		//件名の取得						※必須項目
		$subject          = $data['subject'];
		//TEXTメッセージの取得				※必須項目
		$text_mess        = $data['text_mess'];
		//HTMLメッセージ使用のフラグ取得
		$use_html         = $data['use_html'];
		//HTMLメッセージの取得
		$html_mess        = $data['html_mess'];
		//携帯用メッセージ取得
		$mobail_mess      = $data['mobail_mess'];
		//携帯用フラグ取得
		$use_mobail       = $data['use_mobail'];

		//モードの取得
		$mode             = $data['mode'];
		//フラグの取得
		$flag             = $data['flag'];
		/*入力内容のエラーチェック
			requireCheckは必須項目確認メソッド
			zenCheckは２バイト文字確認メソッド
			mailCheckはメールアドレスチェックメソッド*/
		$chk->requireCheck($transmit_name,"送信者名");
//		$chk->zenCheck($transmit_name,"送信者名");
		$chk->requireCheck($transmit_mailadd,"送信元メールアドレス");
		$chk->mailCheck($transmit_mailadd,"送信元メールアドレス");
		$chk->requireCheck($return_err,"エラー戻り先メールアドレス");
		$chk->mailCheck($return_err,"エラー戻り先メールアドレス");
		$chk->requireCheck($subject,"件名");
		$chk->requireCheck($text_mess,"TEXTメッセージ");
		
		
		if($mode=="check"){
			//HTML確認画面用に変換
			$transmit_name    = htmlspecialchars($transmit_name);
			$transmit_mailadd = htmlspecialchars($transmit_mailadd);
			$return_err       = htmlspecialchars($return_err);
			$subject          = htmlspecialchars($subject);
			$s_text_mess      = htmlspecialchars($text_mess);
			$s_text_mess      = nl2br($s_text_mess);
			$s_html_mess      = htmlspecialchars($html_mess);
			$s_html_mess      = nl2br($s_html_mess);
			$html_mess        = ereg_replace('"',"'",$html_mess);
			$s_mobail_mess    = nl2br(htmlspecialchars($mobail_mess));
		}
	}
/*
	//HTMLへ変数代入
	$smarty->assign("sendMail",$sendMail);
	$smarty->assign("transmit_name",$transmit_name);
	$smarty->assign("transmit_mailadd",$transmit_mailadd);
	$smarty->assign("return_err",$return_err);
	$smarty->assign("subject",$subject);
	$smarty->assign("text_mess",$text_mess);
	$smarty->assign("s_text_mess",$s_text_mess);
	$smarty->assign("use_html",$use_html);
	$smarty->assign("html_mess",$html_mess);
	$smarty->assign("s_html_mess",$s_html_mess);
	$smarty->assign("del_flag",$del_flag);
	$smarty->assign("flag",$flag);
*/
	//エラーの数を取得し、エラーがあればエラー表示
	$errorm = array();
	$errorm = $chk->getError();
	$cnt = count($errorm);
	if($cnt>0){
	/*
		//HTMLへ変数代入
		$smarty->assign("errorm",$errorm);
		//HTML出力
		$smarty->display("./settingMail.tpl");
	*/
		require_once("./templates/settingMail3.html");
	}else{
	
		if(is_null($data)){				//修正画面
			//HTML出力
			//$smarty->display("./settingMail.tpl");
			require_once("./templates/settingMail3.html");
		}else{
			if($mode=="input"){			//登録内容変更時
				//$smarty->display("./settingMail.tpl");
				require_once("./templates/settingMail3.html");
			}else if($mode=="check"){
				//HTML出力					//登録時
				//$smarty->display("./sm_check.tpl");
				require_once("./templates/sm_check3.html");
			}
		}
		
	}

?>