<?php

/******************************************
	入力チェック用クラスファイル

*******************************************/

	//Smartyファイルを読み込み
//	require_once("MySmarty.class.php");
	
	//入力チェック用クラス
	class M_CheckValue{
		//エラーメッセージ
		var	 $errorm;
		var	 $error;
		
		//コンストラクタ
		function M_CheckValue(){
			$this->errorm = array();
		}
		
		//ゲッター
		function getError(){
			return $this->errorm;
		}
		
		//セッター
		function setError($errorm){
			$this->errorm[] = $errorm;
		}
		
		//エラー表示用メソッド
		function showResult($html_name){
			if(count($this->errorm)>0){
				//$smarty = new MySmarty();
				//$smarty->assign("errorm",$this->errorm);
				//$smarty->display($html_name);
				$errorm = $this->errorm;
				require_once("$html_name");
				exit();
			}
		}
		
		//必須入力用メソッド
		function requireCheck($strVal,$strErr){
			if((is_null($strVal))||(trim($strVal)=="")){
				$this->errorm[] = $strErr."が入力されていません";
			}
		}
		
		//日本語表記(２バイト文字)用メソッド
		function zenCheck($strVal,$strErr){
			if((is_null($strVal)==false)&&(trim($strVal)!="")){
				if((mb_strlen($strVal)*2)!=(strlen($strVal))){
					$this->errorm[] = $strErr."は日本語表記(全角文字)で入力して下さい";
				}else if($check = mb_ereg("^[ｱ-ﾝﾞﾟ]+$",$strVal)){
					$this->errorm[] = $strErr."は日本語表記(全角文字)で入力して下さい";
				}
			}
		}

		//メールアドレスチェック用メソッド
		function mailCheck($strVal,$strErr){
			if((is_null($strVal)==false)&&(trim($strVal)!="")){
				$mailStr = "[!#-9A-~]+@+[a-z0-9]+.+[^.]$";
				$check = ereg($mailStr,$strVal);
				if($check==false){
					$this->errorm[] = $strErr."は正しい形式で入力して下さい";
				}
			}
		}

		//URLチェック用メソッド
		function urlCheck($url){
			if((is_null($url)==false)&&(trim($url)!="")){
				//正規表現パターン
				$str = "/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/";
				
				//入力チェック
				if(!preg_match($str,$url)){
					$this->errorm[] = "URLが正しい形式で入力されていません";
				}
			}
		}
	}
	
?>