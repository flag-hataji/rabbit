<?php

/******************************************
	���ϥ����å��ѥ��饹�ե�����

*******************************************/

	//Smarty�ե�������ɤ߹���
//	require_once("MySmarty.class.php");
	
	//���ϥ����å��ѥ��饹
	class CheckValue{
		//���顼��å�����
		var	 $errorm;
		var	 $error;
		
		//���󥹥ȥ饯��
		function CheckValue(){
			$this->errorm = array();
		}
		
		//���å���
		function getError(){
			return $this->errorm;
		}
		
		//���å���
		function setError($errorm){
			$this->errorm[] = $errorm;
		}
		
		//���顼ɽ���ѥ᥽�å�
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
		
		//ɬ�������ѥ᥽�å�
		function requireCheck($strVal,$strErr){
			if((is_null($strVal))||(trim($strVal)=="")){
				$this->errorm[] = $strErr."�����Ϥ���Ƥ��ޤ���";
			}
		}
		
		//���ܸ�ɽ��(���Х���ʸ��)�ѥ᥽�å�
		function zenCheck($strVal,$strErr){
			if((is_null($strVal)==false)&&(trim($strVal)!="")){
				if((mb_strlen($strVal)*2)!=(strlen($strVal))){
					$this->errorm[] = $strErr."�����ܸ�ɽ��(����ʸ��)�����Ϥ��Ʋ�����";
				}else if($check = mb_ereg("^[��-�ݎގ�]+$",$strVal)){
					$this->errorm[] = $strErr."�����ܸ�ɽ��(����ʸ��)�����Ϥ��Ʋ�����";
				}
			}
		}

		//�᡼�륢�ɥ쥹�����å��ѥ᥽�å�
		function mailCheck($strVal,$strErr){
			if((is_null($strVal)==false)&&(trim($strVal)!="")){
				$mailStr = "[!#-9A-~]+@+[a-z0-9]+.+[^.]$";
				$check = ereg($mailStr,$strVal);
				if($check==false){
					$this->errorm[] = $strErr."�����������������Ϥ��Ʋ�����";
				}
			}
		}

		//URL�����å��ѥ᥽�å�
		function urlCheck($url){
			if((is_null($url)==false)&&(trim($url)!="")){
				//����ɽ���ѥ�����
				$str = "/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/";
				
				//���ϥ����å�
				if(!preg_match($str,$url)){
					$this->errorm[] = "URL�����������������Ϥ���Ƥ��ޤ���";
				}
			}
		}
	}
	
?>