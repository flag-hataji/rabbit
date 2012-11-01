<?php
/********************************************
	データをDBから取出、保存するためのファイル
*********************************************/

	//ＤＢクラスファイル読み込み
	require_once("base_DB.class.php");

	//DB接続クラスを継承
	class SQLData extends base_DB{
	
		//フィールド
		//correction.php用
		var $form_name;
		var	$form_header;
		var	$param_name;
		var	$param_val;
		var	$check;
		var	$check_val;
		var	$thk_url;
		//settingMail.php用
		var	$sendMail;
		var	$transmit_name;
		var	$transmit_mailadd;
		var	$return_err;
		var	$subject;
		var	$text_mess;
		var	$use_html;
		var	$html_mess;
		var $use_mobail;
		var $mobail_mess;
		
		//confirmForm.php用
		var	$name_family;
		var	$name_first;
		var	$user_mail_add;
		var	$param;
		var	$p_name;
		//共通
		var	$del_flag;
		var	$dt;
		var	$user_id;
		
		//ゲッター
		//correction.php用
		function getFormName()	  	 {return $this->form_name;}
		function getFormHeader()  	 {return $this->formheader;}
		function getParamName()   	 {return $this->param_name;}
		function getParamVal()	  	 {return $this->param_val;}
		function getCheckData()   	 {return $this->check_data;}
		function getcheckVal()	  	 {return $this->check_val;}
		function getThkUrl() 	  	 {return $this->thk_url;}
		//settingMail.php用
		function getSendMail()		 {return $this->sendMail;}
		function getTransmitName()	 {return $this->transmit_name;}
		function getTransmitMailAdd(){return $this->transmit_mailadd;}
		function getReturnErr()		 {return $this->return_err;}
		function getSubject()		 {return $this->subject;}
		function getTextMess()		 {return $this->text_mess;}
		function getUseHtml()		 {return $this->use_html;}
		function getHtmlMess()		 {return $this->html_mess;}
		function getUseMobail()		 {return $this->use_mobail;}
		function getMobailMess()	 {return $this->mobail_mess;}
		//confirmForm.php用
		function getNameFamily()	 {return $this->name_family;}
		function getNameFirst()		 {return $this->name_first;}
		function getUserMailAdd()	 {return $tnis->user_mail_add;}
		function getParam()			 {return $this->param;}
		function getPName()			 {return $this->p_name;}
		//共通
		function getDeleteFlag()  	 {return $this->del_flag;}
		function getDt()	  		 {return $this->dt;}
		function getUserId()	  	 {return $this->user_id;}
		
		//セッター
		//correction.php用
		function setFormName($form_name)	    	  {$this->form_name        = $form_name;}
		function setFormHeader($form_header)    	  {$this->form_header      = $form_header;}
		function setParamName($param_name)			  {$this->param_name       = $param_name;}
		function setParamVal($param_val)			  {$this->param_val        = $param_val;}
		function setCheck($check)  					  {$this->check            = $check;}
		function setCheckVal($check_val)			  {$this->check_val        = $check_val;}
		function setThkUrl($thk_url)		    	  {$this->thk_url          = $thk_url;}
		//settingMail.php用
		function setSendMail($sendMail)			  	  {$this->sendMail         = $sendMail;}
		function setTransmitName($transmit_name)	  {$this->transmit_name    = $transmit_name;}
		function setTransmitMailAdd($transmit_mailadd){$this->transmit_mailadd = $transmit_mailadd;}
		function setReturnErr($return_err)			  {$this->return_err       = $return_err;}
		function setSubject($subject)				  {$this->subject		   = $subject;}
		function setTextMess($text_mess)			  {$this->text_mess        = $text_mess;}
		function setUseHtml($use_html)				  {$this->use_html         = $use_html;}
		function setHtmlMess($html_mess)			  {$this->html_mess        = $html_mess;}
		function setUseMobail($use_mobail)			  {$this->use_mobail       = $use_mobail;}
		function setMobailMess($mobail_mess)		  {$this->mobail_mess      = $mobail_mess;}
		//confirmForm.php用
		function setNameFamily($name_family)		  {$this->name_family      = $name_family;}
		function setNameFirst($name_first)			  {$this->name_first       = $name_first;}
		function setUserMailAdd($user_mail_add)		  {$this->user_mail_add    = $user_mail_add;}
		function setParam($param)					  {$this->param            = $param;}
		function setPName($p_name)					  {$this->p_name           = $p_name;}
		//共通
		function setDeleteFlag($del_flag)			  {$this->del_flag         = $del_flag;}
		function setDt($dt)							  {$this->dt	           = $dt;}
		function setUserId($user_id)		    	  {$this->user_id          = $user_id;}
		
		/*******************************************************
		*														*
		*						共通							*
		*														*
		*******************************************************/
		
		//DB内のフォームデータ有無確認
		function getTableData($tableName,$user_id){
			
			//SQL文発行
			$sql = "select * from $tableName where user_id = $user_id";
			
			//クエリー実行
			$res = pg_query($sql);
			if(!$res){
				$this->errorm = "データの取得に失敗しました";
				return "f";
			}
			
			//データの取得
			$qres = pg_fetch_assoc($res);
			
			return $qres;
		}
		
		//登録フォームID取得
		function getFormId($user_id){
			
			//SQL文発行
			$sql = "select applicant_id from td_form_create2 where user_id =$user_id";
			
			//クエリ実行
			$res = @pg_query($sql);
			if(!$res){
				$this->errorm="データの取得に失敗しました";
				return "f";
			}
			
			//データの取得
			$qres = pg_fetch_row($res);
			$f_id = $qres[0];
			
			return $f_id;
		}
		
		//ユーザーIDと登録フォームIDの一致確認
		function isValidUser($user_id,$f_id){
			
			//SQL発行
			$sql = "select applicant_id from td_form_create2 where user_id = $user_id";
			
			//クエリ実行
			$res = @pg_query($sql);
			if(!$res){
				$this->errorm = "データの取得に失敗しました";
				return "f";
			}
			
			//データの取得
			if(!$qres = pg_fetch_array($res)){
				return false;
			}
			
			//データの比較
			if($f_id == $qres['applicant_id']){
				return true;
			}
			return false;
		}
		/*******************************************************
		*														*
		*			ここからcorrection.php用					*
		*														*
		*******************************************************/
		
		//DB内へフォームデータを格納　新規の場合
		function insertFormData(){
		
			//パラメーターの名前、値をエスケープし連結
			$param_name = $this->param_name;
			foreach($param_name as $key=>$value){
				$param      .= "param".$key.",";
				$value       = addslashes($value);
				$param_val  .= "'".$value."',";
			}
			
			$len       = mb_strlen($param);
			$param     = substr_replace($param,'',-1,$len);
			$len       = mb_strlen($param_val);
			$param_val = substr_replace($param_val,'',-1,$len);
			
			//チェックの名前、値を連結
			$check = $this->check;
			foreach($check as $key=>$value){
				$check_data .="check".$key.",";
				$check_val  .="".$value.",";
			}
			
			$len        = mb_strlen($check_data);
			$check_data = substr_replace($check_data,'',-1,$len);
			$len        = mb_strlen($check_val);
			$check_val  = substr_replace($check_val,'',-1,$len);
			
			//文字列エスケープ
			$form_name   = addslashes($this->form_name);
			$form_header = addslashes($this->form_header);
			$thk_url     = addslashes($this->thk_url);
			
			//SQL文発行
			$sql = "insert into td_form_create2(".
					"applicant_id,form_name,form_header,".
					"$param,$check_data,thk_url,del_flag,".
					"dt,user_id) values(".
					"nextval('td_form_create2_applicant_id_seq'),'$form_name',".
					"'$form_header',$param_val,".
					"$check_val,'$thk_url',$this->del_flag,".
					"'now()',$this->user_id)";
					
			//クエリー実行
			$res = @pg_query($sql);
			if(!$res){
				$this->errorm = "フォームデータのセットに失敗しました";
				return false;
			}
			
			return true;
		}
		
		//DB内へフォームデータを格納　修正の場合
		function updateFormData(){
		
			//パラメーターの名前、値をエスケープし連結
			$param_name = ($this->param_name);
			foreach($param_name as $key=>$value){
				$value  = addslashes($value);
				$param .= "param".$key."='".$value."',";
			}
			
			$len       = mb_strlen($param);
			$param     = substr_replace($param,'',-1,$len);
			$len       = mb_strlen($param_val);
			$param_val = substr_replace($param_val,'',-1,$len);
			
			//チェックの名前、値を連結
			$check = ($this->check);
			foreach($check as $key=>$value){
				$check_data .="check".$key."='".$value."',";
			}
			
			$len        = mb_strlen($check_data);
			$check_data = substr_replace($check_data,'',-1,$len);
			$len        = mb_strlen($check_val);
			$check_val  = substr_replace($check_val,'',-1,$len);
			
			//文字列をエスケープ
			$form_name   = addslashes($this->form_name);
			$form_header = addslashes($this->form_header);
			$thk_url     = addslashes($this->thk_url);
			
			//SQL文発行
			$sql = "update td_form_create2 set form_name='$form_name',".
					"form_header='$form_header',$param,".
					"$check_data,".
					"thk_url='$thk_url',del_flag='$this->del_flag',".
					"dt='now()' where user_id=$this->user_id";
					
			//クエリ実行
			$res = @pg_query($sql);
			if(!$res){
				$this->errorm = "フォームデータの修正に失敗しました";
				return false;
			}
			return true;
		}
		
		/*******************************************************
		*														*
		*			ここからsettingMail.php用					*
		*														*
		*******************************************************/
		
		//ユーザーIDよりサンキューメール設定情報取得
		function getSettingMailData($user_id){
			
			//SQL文発行
			$sql = "select * from td_setting_thankmail2 where user_id = $user_id";
			
			//クエリ実行
			$res = @pg_query($sql);
			if(!$res){
				$this->errorm = "設定情報の取得に失敗しました";
				return false;
			}
			
			//データの取得
			$qres = pg_fetch_assoc($res);
			
			return $qres;
		}
		
		//新規データをDBへ保存
		function insertSettingMailData(){
			
			//フラグの置換
			//メール配信のフラグ
			if($this->sendMail=="t"){
				$sendMail = "1";
			}else if($this->sendMail=="f"){
				$sendMail = "0";
			}
			
			//htmlメッセージ使用のフラグ
			if($this->use_html=="t"){
				$use_html = "1";
			}else{
				$use_html = "0";
			}
			
			//文字をエスケープ
			$transmit_name    = pg_escape_string($this->transmit_name);
			$transmit_mailadd = pg_escape_string($this->transmit_mailadd);
			$return_err       = pg_escape_string($this->return_err);
			$subject          = pg_escape_string($this->subject);
			$text_mess        = pg_escape_string($this->text_mess);
			$html_mess        = pg_escape_string($this->html_mess);
			$mobail_mess      = pg_escape_string($this->mobail_mess);
			
			//SQL文を発行
			$sql = "insert into td_setting_thankmail2 values(nextval('td_setting_thankmail2_applicant_id_seq'),".
			"$sendMail,'$transmit_name','$transmit_mailadd','$return_err',".
			"'$subject','$text_mess',$use_html,'$html_mess',$this->del_flag,".
			"'now()',$this->user_id,$this->use_mobail,'$mobail_mess')";
			echo $sql;
			//クエリ実行
			$res = @pg_query($sql);
			if(!$res){
				$this->errorm = "新規データの保存に失敗しました";
				return false;
			}
			return true;
		}
		
		//修正データをDBへ保存
		function updateSettingMailData(){
			
			//フラグの置換
			//メール配信のフラグ
			if($this->sendMail=="t"){
				$sendMail = "1";
			}else if($this->sendMail=="f"){
				$sendMail = "0";
			}
			
			//htmlメッセージ使用のフラグ
			if($this->use_html=="t"){
				$use_html = "1";
			}else{
				$use_html = "0";
			}
			
			//文字をエスケープ
			$transmit_name    = addslashes($this->transmit_name);
			$transmit_mailadd = addslashes($this->transmit_mailadd);
			$return_err       = addslashes($this->return_err);
			$subject          = addslashes($this->subject);
			$text_mess        = addslashes($this->text_mess);
			$html_mess        = addslashes($this->html_mess);
			$mobail_mess      = addslashes($this->mobail_mess);
			
			//SQL文発行
			$sql = "update td_setting_thankmail2 set sendmail_flag=$sendMail,".
					"transmit_name='$transmit_name',transmit_mailadd='$transmit_mailadd',".
					"return_err='$return_err',subject='$subject',text_mess='$text_mess',".
					"html_flag=$use_html,html_mess='$html_mess',del_flag=$this->del_flag,".
					"mobail_flag=$this->use_mobail,mobail_mess='$mobail_mess',".
					"dt='now()' where user_id=$this->user_id";
					
			//クエリ実行
			$res = @pg_query($sql);
			if(!res){
				$this->errorm = "データの更新に失敗しました";
				return false;
			}
			return true;
		}
		
		/*******************************************************
		*														*
		*			ここからconfirmForm.php用					*
		*														*
		*******************************************************/
		
		//入力されたフォームデータを保存
		function saveUserData(){
			
			//文字をエスケープ
			$name_family   = addslashes($this->name_family);
			$name_first    = addslashes($this->name_first);
			$user_mail_add = addslashes($this->user_mail_add);
			
			//パラメーターの値をエスケープし,連結
			$param           = $this->param;
			foreach($param as $key=>$value){
				$str_param  .= "param".$key.",";
				$value       = addslashes($value);
				$param_val  .= "'".$value."',";
			}
			
			$len       = mb_strlen($str_param);
			$str_param = substr_replace($str_param,'',-1,$len);
			$len       = mb_strlen($param_val);
			$param_val = substr_replace($param_val,'',-1,$len);
			
			//パラメーター名の値をエスケープし、連結
			$p_name          = $this->p_name;
			foreach($p_name as $key=>$value){
				$str_p_name .= "param_name".$key.",";
				$value       = addslashes($value);
				$p_name_val .= "'".$value."',";
			}
			
			$len           = mb_strlen($str_p_name);
			$str_p_name    = substr_replace($str_p_name,'',-1,$len);
			$len           = mb_strlen($p_name_val);
			$p_name_val    = substr_replace($p_name_val,'',-1,$len);
			
			//SQL文発行
			$sql = "insert into td_userdata2(".
					"applicant_id,name_family,name_first,".
					"user_mail_add,$str_param,$str_p_name,del_flag,".
					"dt,user_id) ".
					"values(nextval('td_userdata2_applicant_id_seq'),".
					"'$name_family','$name_first','$user_mail_add',".
					"$param_val,$p_name_val,$this->del_flag,'now()',".
					"$this->user_id)";
			
			//クエリ実行
			$res = @pg_query($sql);
			if(!$res){
				$this->errorm = "データの保存に失敗しました";
				return false;
			}
			return true;

		}
		
		/*******************************************************
		*														*
		*			ここからshowUserData.php用		 			*
		*														*
		*******************************************************/
		
		//CSVダウンロード画面用
		function showUserData($user_id){
			
			//SQL文発行
			$sql = "select name_family,name_first,user_mail_add,dt,applicant_id from td_userdata2 ".
							"where user_id=$user_id order by dt desc limit 100";
			//クエリー実行
			$res = @pg_query($sql);
			if(!$res){
				$this->errorm = "登録者一覧の取得に失敗しました";
				return false;
			}
			
			$user_list= array();
			while($fres = pg_fetch_assoc($res)){
				//$name_family     = $fres['name_family'];
			//	$name_first      = $fres['name_first'];
				$user_mail_add   = $fres['user_mail_add'];
				//日付の小数点切捨て
				$dt_arr			 = explode(".",$fres['dt']);
				$dt				 = $dt_arr[0];
				$app_id			 = $fres['applicant_id'];
				/*
				$arr_data	     = array("name_family"=>"$name_family","name_first"=>$name_first,
										"user_mail_add"=>"$user_mail_add","dt"=>$dt,"applicant_id"=>$app_id);
			    */
				$arr_data	     = array("user_mail_add"=>"$user_mail_add","dt"=>$dt,"applicant_id"=>$app_id);
				//２次元配列として配列を格納
				$user_list[]	 = $arr_data;
			}
			return $user_list;
		}
		
		/*******************************************************
		*														*
		*			ここからdetailed.php用			 			*
		*														*
		*******************************************************/

		//登録者詳細画面用
		function detailed($app_id){
			
			//SQL文発行
			$sql = "select * from td_userdata2 where applicant_id=$app_id";
			
			//クエリ実行
			$res = pg_query($sql);
			if(!$res){
				$this->errorm="登録者詳細の取得に失敗しました";
				return false;
			}
	
			$fres = pg_fetch_assoc($res);
			//$name_family    = $fres['name_family'];
			//$name_first     = $fres['name_first'];
			$user_mail_add  = $fres['user_mail_add'];
			$dt             = $fres['dt'];

			//名前の置換
			$name = $name_family."　".$name_first;
			
			//日付の置換
			$dt_arr = explode(".",$dt);
			$dt     = $dt_arr[0];

			//配列に格納
			//$app_list = array("登録ID"=>"$app_id","登録日"=>"$dt","名前"=>"$name","メールアドレス"=>"$user_mail_add");
			$app_list = array("登録ID"=>"$app_id","登録日"=>"$dt","メールアドレス"=>"$user_mail_add");
			$i=1;
			while($i<=5){
				if(($fres['param_name'.$i]!="")||($fres['param'.$i]!="")){
					$app_list[$fres['param_name'.$i]] = $fres['param'.$i];
				}
				$i++;
			}
			
			return $app_list;
			
		}
		
		/*******************************************************
		*														*
		*			ここからgetcsv.php用			 			*
		*														*
		*******************************************************/

		function getcsvData($user_id){
			
			//フィールド名取得用SQL発行
			$sql = "select param_name1,param_name2,param_name3,param_name4,param_name5 from td_userdata2 where user_id=$user_id";
			
			//クエリ実行
			$res = pg_query($sql);
			if(!$res){
				$this->errorm="CSVファイルへのデータの取得に失敗しました";
				return false;
			}
			
			//データの取得
			$fres = pg_fetch_assoc($res);
			$param_name1 = $fres['param_name1'];
			$param_name2 = $fres['param_name2'];
			$param_name3 = $fres['param_name3'];
			$param_name4 = $fres['param_name4'];
			$param_name5 = $fres['param_name5'];
			
			//CSVフィールドへ書き込むテキスト生成
			//$csvStr = "登録ID,名前(姓),名前(名),メールアドレス,$param_name1,".
			//		"$param_name2,$param_name3,$param_name4,$param_name5,日付\n";

			$csvStr = "登録ID,メールアドレス,日付\n";

			//SJISへエンコードしCSVへ書き込み
			print(mb_convert_encoding($csvStr,"SJIS","EUC-JP"));
			
			//レコード用SQL文発行
			//$sql = "select applicant_id,name_family,name_first,user_mail_add,".
			//		"param1,param2,param3,param4,param5,dt from td_userdata2 where user_id=$user_id";

			$sql = "select applicant_id,user_mail_add,dt from td_userdata2 where user_id=$user_id";
					
			//クエリ実行
			$res2 = pg_query($sql);
			if(!$res2){
				$this->errorm="CSVファイルへのデータの取得に失敗しました";
				return false;
			}
			
			for($i=0;$i<pg_num_rows($res);$i++){
				for($j=0;$j<pg_num_fields($res2);$j++){
					$csvStr2    = pg_fetch_result($res2,$i,$j);
					$str .=$csvStr2.","; 
				}				
				$len        = mb_strlen($str);
				$csvStr3    = substr_replace($str,'',-11,($len));
				print(mb_convert_encoding($csvStr3,"SJIS","EUC-JP").",\n");
				unset($str);
			}
		}
		
		/*******************************************************
		*														*
		*			ここからgetcsvPict.php用			 			*
		*														*
		*******************************************************/

		function getcsvPictData($user_id){
			
			//フィールド名取得用SQL発行
			$sql = "select param_name1,param_name2,param_name3,param_name4,param_name5 from td_userdata2 where user_id=$user_id";
			
			//クエリ実行
			$res = pg_query($sql);
			if(!$res){
				$this->errorm="CSVファイルへのデータの取得に失敗しました";
				return false;
			}
			
			//データの取得
			$fres = pg_fetch_assoc($res);
			$param_name1 = $fres['param_name1'];
			$param_name2 = $fres['param_name2'];
			$param_name3 = $fres['param_name3'];
			$param_name4 = $fres['param_name4'];
			$param_name5 = $fres['param_name5'];
			
			//CSVフィールドへ書き込むテキスト生成
			//$csvStr = "名前,メールアドレス,$param_name1,".
			//		"$param_name2,$param_name3,$param_name4,$param_name5,日付\n";

			$csvStr = "メールアドレス,日付\n";

			//SJISへエンコードしCSVへ書き込み
			print(mb_convert_encoding($csvStr,"SJIS","EUC-JP"));
			
			//レコード用SQL文発行
			//$sql = "select name_family,name_first,user_mail_add,".
			//		"param1,param2,param3,param4,param5,dt from td_userdata2 where user_id=$user_id";

			$sql = "select user_mail_add,dt from td_userdata2 where user_id=$user_id";

			//クエリ実行
			$res2 = pg_query($sql);
			if(!$res2){
				$this->errorm="CSVファイルへのデータの取得に失敗しました";
				return false;
			}
			
			for($i=0;$i<pg_num_rows($res);$i++){
				for($j=0;$j<pg_num_fields($res2);$j++){
					$csvStr2    = pg_fetch_result($res2,$i,$j);
						$str .=$csvStr2.","; 
				}				
				$len        = mb_strlen($str);
				$csvStr3    = substr_replace($str,'',-11,($len));
				print(mb_convert_encoding($csvStr3,"SJIS","EUC-JP").",\n");
				unset($str);
			}
		}

		//全ユーザーデータ(CSVファイル用)削除メソッド
		function delUserAllData($user_id){
			
			//SQL文発行
			$sql = "delete from td_userdata2 where user_id=$user_id";
			
			//クエリ実行
			$res = pg_query($sql);
			if(!$sql){
				$this->errorm="データの削除に失敗しました";
				return false;
			}
			
			return true;
		}
		
		//個人ユーザーデータ(CSVファイル用)削除メソッド
		function delUserData($user_id,$app_id){
			
			//SQL文発行
			$sql = "delete from td_userdata2 where user_id=$user_id and applicant_id=$app_id";
			
			//クエリ実行
			$res = pg_query($sql);
			if(!$sql){
				$this->errorm="データの削除に失敗しました";
				return false;
			}
			
			return true;
		}
 
	}
	
?>