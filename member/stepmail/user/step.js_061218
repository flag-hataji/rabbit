//グローバル変数の定義
var httpObj;
var timerId;
var timeout_sec=30;
var g;

function eliminateDropdownList(ID){
	//表示されているセレクトメニューのoptionsを調べる
	var select_node = document.getElementById(ID);
	var opt_num = select_node.length;
	var i;
	for(i = opt_num -1 ; i >= 0; i--){
		select_node.remove(i);
	}
}


//ドロップダウンリストの作成
function generateDropdownList(text_data){
alert(g);
    var step_noNode   = text_data.getElementsByTagName("step_no");
    var step_nameNode = text_data.getElementsByTagName("step_name");
		var select_node = document.getElementById(g);
    //オブジェクト追加
    for( i = 0 ; i < step_noNode.length ; i++ ){
      var value   = step_noNode[i].getAttribute("value");
      var text    = step_nameNode[i].getAttribute("value");

				var opt   = document.createElement('option');
				opt.value = value;
				opt.text  = text;
				try{
					select_node.add(opt,null); //W3C DOMブラウザ
				}catch(ex){
					select_node.add(opt,-1);   //IE用
				}
    }

}



//XML取得
function printItemList(e){
	eliminateDropdownList('step_no');
	var target_node = getTargetNode(e);
	var id = target_node.value;
	target_url = 'GetStep.php?scenario_id=' + encodeURIComponent(id);
	//alert(target_url);
	g = 'step_no';
	httpRequest(target_url,generateDropdownList);
}

//XML取得２
function printItemList2(e){
	eliminateDropdownList('where_select2');
	var target_node = getTargetNode(e);
	var id = target_node.value;
	target_url = 'GetStep_Top.php?scenario_id=' + encodeURIComponent(id);
	//alert(target_url);
	g = 'where_select2';
	httpRequest(target_url,generateDropdownList);
}



//要素の座標を特定し、オブジェクトとして返す
function getTargetNode(e){
	var target_node;
	if(e.target){
		target_node = e.target;
	}else{
		target_node = e.srcElement;
	} 
//Safari対策
  if(target_node.nodeType == 3){
		target_node = target_node.parentNode;
	}
	return target_node;
}



//引数に与えられた・・・
function httpRequest(target_url, functionReference){
	try{
		if(window.XMLHttpRequest){
			httpObj = new XMLHttpRequest();
		} else if(window.ActiveXObject){
			httpObj = new ActiveXObject("Microsoft.XMLHTTP");
		}else{
			httpObj = false;
		}
	}catch(e){
		httpObj = false;
	}
	if(! httpObj){
		httpObjGenerateFail();
	}

	//タイマーセット
	timerId = setInterval('timeoutCheck()',1000);

alert('httpObj.open : '+target_url);
	httpObj.open("GET",target_url, true);
	httpObj.onreadystatechange = function(){
		if(httpObj.readyState == 4){
			clearInterval(timerId);
			if(httpObj.status == 200){
				functionReference(httpObj.responseXML);
			}else{
				alert(httpObj.status+':'+httpObj.statusText);
				return false;
			}
		}else{
				alert('NG');
		}
	}
	httpObj.send('');

}


//XMLHttpRequestオブジェクト生成に失敗した場合の処理
function httpObjGenerateFail(){
	alert('ご利用のブラウザでは、当サイトをご利用いただけません。');
	return false;
}


//HTTPタイムアウトの処理
function timeoutCheck(){
	timeout_sec --;
	if(timeout_sec <= 0){
		clearInterval(timerId);
		httpObj.abort();
		alert('タイムアウトです'+timeout_sec);
		return false;
	}
}



//イベントリスナーをセットする
function setListeners(e){
	var scenario = document.getElementById('scenario');
	addListener(scenario,'change',printItemList,false);

	var where_select1 = document.getElementById('where_select1');
	addListener(where_select1,'change',printItemList2,false);

abcd();
alert('next');
wxyz();

}

function abcd(){
alert('hoge');
	eliminateDropdownList('where_select2');
	var where_select1 = document.getElementById('where_select1');
	var id = where_select1.value;
	target_url = 'GetStep_Top.php?scenario_id=' + encodeURIComponent(id);
	alert(target_url);
	g = 'where_select2';
	alert(g);
	httpRequest(target_url,generateDropdownList);
}

function wxyz(){
alert('hoge2');

	eliminateDropdownList('step_no');
	var scenario = document.getElementById('scenario');
	var id2 = scenario.value;
	target_url = 'GetStep.php?scenario_id=' + encodeURIComponent(id2);
	g = 'step_no';
	httpRequest(target_url,generateDropdownList);
}


//イベントリスナー登録
function addListener(elem,eventType,func,cap){
	if(elem.addEventListener){
		elem.addEventListener(eventType,func,cap);
	} else if(elem.attachEvent){
		elem.attachEvent('on' + eventType,func);
	}else{
		alert('ご利用のブラウザではサポートされていません');
		return false;
	}
}


//load時のイベントリスナーをセットする
addListener(window,'load',setListeners,false);
