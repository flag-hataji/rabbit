//�����Х��ѿ������
var httpObj;
var timerId;
var timeout_sec=30;
var g;

function eliminateDropdownList(ID){
	//ɽ������Ƥ��륻�쥯�ȥ�˥塼��options��Ĵ�٤�
	var select_node = document.getElementById(ID);
	var opt_num = select_node.length;
	var i;
	for(i = opt_num -1 ; i >= 0; i--){
		select_node.remove(i);
	}
}


//�ɥ�åץ�����ꥹ�Ȥκ���
function generateDropdownList(text_data){
alert(g);
    var step_noNode   = text_data.getElementsByTagName("step_no");
    var step_nameNode = text_data.getElementsByTagName("step_name");
		var select_node = document.getElementById(g);
    //���֥��������ɲ�
    for( i = 0 ; i < step_noNode.length ; i++ ){
      var value   = step_noNode[i].getAttribute("value");
      var text    = step_nameNode[i].getAttribute("value");

				var opt   = document.createElement('option');
				opt.value = value;
				opt.text  = text;
				try{
					select_node.add(opt,null); //W3C DOM�֥饦��
				}catch(ex){
					select_node.add(opt,-1);   //IE��
				}
    }

}



//XML����
function printItemList(e){
	eliminateDropdownList('step_no');
	var target_node = getTargetNode(e);
	var id = target_node.value;
	target_url = 'GetStep.php?scenario_id=' + encodeURIComponent(id);
	//alert(target_url);
	g = 'step_no';
	httpRequest(target_url,generateDropdownList);
}

//XML������
function printItemList2(e){
	eliminateDropdownList('where_select2');
	var target_node = getTargetNode(e);
	var id = target_node.value;
	target_url = 'GetStep_Top.php?scenario_id=' + encodeURIComponent(id);
	//alert(target_url);
	g = 'where_select2';
	httpRequest(target_url,generateDropdownList);
}



//���Ǥκ�ɸ�����ꤷ�����֥������ȤȤ����֤�
function getTargetNode(e){
	var target_node;
	if(e.target){
		target_node = e.target;
	}else{
		target_node = e.srcElement;
	} 
//Safari�к�
  if(target_node.nodeType == 3){
		target_node = target_node.parentNode;
	}
	return target_node;
}



//������Ϳ����줿������
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

	//�����ޡ����å�
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


//XMLHttpRequest���֥������������˼��Ԥ������ν���
function httpObjGenerateFail(){
	alert('�����ѤΥ֥饦���Ǥϡ��������Ȥ����Ѥ��������ޤ���');
	return false;
}


//HTTP�����ॢ���Ȥν���
function timeoutCheck(){
	timeout_sec --;
	if(timeout_sec <= 0){
		clearInterval(timerId);
		httpObj.abort();
		alert('�����ॢ���ȤǤ�'+timeout_sec);
		return false;
	}
}



//���٥�ȥꥹ�ʡ��򥻥åȤ���
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


//���٥�ȥꥹ�ʡ���Ͽ
function addListener(elem,eventType,func,cap){
	if(elem.addEventListener){
		elem.addEventListener(eventType,func,cap);
	} else if(elem.attachEvent){
		elem.attachEvent('on' + eventType,func);
	}else{
		alert('�����ѤΥ֥饦���Ǥϥ��ݡ��Ȥ���Ƥ��ޤ���');
		return false;
	}
}


//load���Υ��٥�ȥꥹ�ʡ��򥻥åȤ���
addListener(window,'load',setListeners,false);
