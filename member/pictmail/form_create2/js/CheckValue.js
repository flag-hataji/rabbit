//���ϥ����å���JavaScript�ե�����


//ɬ�����ϥ����å��ѥ᥽�å�
function requiredCheck(strVal,strErr){
	if((strVal == "")||(strVal == undefined)){
		return strErr + "�����Ϥ���Ƥ��ޤ���\n";
	}else{
		return "";
	}
}

//URL�����å��ѥ᥽�å�
function urlCheck(url){
	if((url == "")||(url == undefined)){
		return "";
	}else{
			//����ɽ���ѥ�����
			var str = /^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/;
			var check = url.match(str);
//			document.write(check);
			if(check==null){
				return "URL�����������������Ϥ���Ƥ��ޤ���";
			}else{
				return "";
			}
	}
}

//���ѥ����å�(���ܸ�ɽ��)�ѥ᥽�å�
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
			
			//Ⱦ�ѥ��ʥ����å�
			var check = strVal.match(/[^��-��]/);
			
			if(cnt!=strVal.length*2){
				return strErr + "�����ܸ�ɽ��(����ʸ��)�����Ϥ��Ʋ�������\n";	
			}else if(check==null){
				return  strErr + "�����ܸ�ɽ��(����ʸ��)�����Ϥ��Ʋ�������\n";
			}else{
				return "";
			}
	}
}

//�᡼�륢�ɥ쥹�ѥ᥽�å�
function mailCheck(strVal,strErr){
	if((strVal == "")||(strVal == undefined)){
		return "";
	}else{
		var check = strVal.match(/[!#-9A-~]+@+[a-z0-9]+.+[^.]$/i);
								  
		if(!check){
			return strErr + "��Ⱦ�ѱѿ��������������������Ϥ��Ʋ�������\n";
		}else{
			return "";
		}
	}
}

