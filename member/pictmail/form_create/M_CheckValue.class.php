<?php

/******************************************
	���̓`�F�b�N�p�N���X�t�@�C��

*******************************************/

	//Smarty�t�@�C����ǂݍ���
//	require_once("MySmarty.class.php");
	
	//���̓`�F�b�N�p�N���X
	class M_CheckValue{
		//�G���[���b�Z�[�W
		var	 $errorm;
		var	 $error;
		
		//�R���X�g���N�^
		function M_CheckValue(){
			$this->errorm = array();
		}
		
		//�Q�b�^�[
		function getError(){
			return $this->errorm;
		}
		
		//�Z�b�^�[
		function setError($errorm){
			$this->errorm[] = $errorm;
		}
		
		//�G���[�\���p���\�b�h
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
		
		//�K�{���͗p���\�b�h
		function requireCheck($strVal,$strErr){
			if((is_null($strVal))||(trim($strVal)=="")){
				$this->errorm[] = $strErr."�����͂���Ă��܂���";
			}
		}
		
		//���{��\�L(�Q�o�C�g����)�p���\�b�h
		function zenCheck($strVal,$strErr){
			if((is_null($strVal)==false)&&(trim($strVal)!="")){
				if((mb_strlen($strVal)*2)!=(strlen($strVal))){
					$this->errorm[] = $strErr."�͓��{��\�L(�S�p����)�œ��͂��ĉ�����";
				}else if($check = mb_ereg("^[�-���]+$",$strVal)){
					$this->errorm[] = $strErr."�͓��{��\�L(�S�p����)�œ��͂��ĉ�����";
				}
			}
		}

		//���[���A�h���X�`�F�b�N�p���\�b�h
		function mailCheck($strVal,$strErr){
			if((is_null($strVal)==false)&&(trim($strVal)!="")){
				$mailStr = "[!#-9A-~]+@+[a-z0-9]+.+[^.]$";
				$check = ereg($mailStr,$strVal);
				if($check==false){
					$this->errorm[] = $strErr."�͐������`���œ��͂��ĉ�����";
				}
			}
		}

		//URL�`�F�b�N�p���\�b�h
		function urlCheck($url){
			if((is_null($url)==false)&&(trim($url)!="")){
				//���K�\���p�^�[��
				$str = "/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/";
				
				//���̓`�F�b�N
				if(!preg_match($str,$url)){
					$this->errorm[] = "URL���������`���œ��͂���Ă��܂���";
				}
			}
		}
	}
	
?>