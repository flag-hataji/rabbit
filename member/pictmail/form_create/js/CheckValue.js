//入力チェック用JavaScriptファイル


//必須入力チェック用メソッド
function requiredCheck(strVal,strErr){
	if((strVal == "")||(strVal == undefined)){
		return strErr + "が入力されていません。\n";
	}else{
		return "";
	}
}

//URLチェック用メソッド
function urlCheck(url){
	if((url == "")||(url == undefined)){
		return "";
	}else{
			//正規表現パターン
			var str = /^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/;
			var check = url.match(str);
//			document.write(check);
			if(check==null){
				return "URLが正しい形式で入力されていません。";
			}else{
				return "";
			}
	}
}

//全角チェック(日本語表記)用メソッド
function zenCheck(strVal,strErr){
	if((strVal == "")||(strVal == undefined)){
		return "";
	}else{

			cnt=0;
			for(i=0;i<strVal.length;i++){
				if(escape(strVal.charAt(i)).length>=4){
					cnt +=2;	
				}else{
					cnt++;
				}
			}
			
			//半角カナチェック
			var check = strVal.match(/[^ｱ-ﾝ]/);
			
			if(cnt!=strVal.length*2){
				return strErr + "は日本語表記(全角文字)で入力して下さい。\n";	
			}else if(check==null){
				return  strErr + "は日本語表記(全角文字)で入力して下さい。\n";
			}else{
				return "";
			}
	}
}

//メールアドレス用メソッド
function mailCheck(strVal,strErr){
	if((strVal == "")||(strVal == undefined)){
		return "";
	}else{
		var check = strVal.match(/[!#-9A-~]+@+[a-z0-9]+.+[^.]$/i);
								  
		if(!check){
			return strErr + "は半角英数字の正しい形式で入力して下さい。\n";
		}else{
			return "";
		}
	}
}

