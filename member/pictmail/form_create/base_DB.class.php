<?php

/*******************************************
	PostgresSQL����³���뤿���	�١������饹
********************************************/

	class base_DB{
		//�ե������
		var $errorm;
		var $db;
		//���󥹥ȥ饯��
		function base_DB(){
			$this->db = pg_connect("host=localhost dbname=rabbit-mail user=postgres port=5432");
			if(!$this->db){
				$this->errorm = "�ǡ����١�������³�Ǥ��ޤ���Ǥ���".pg_last_error();
				return false;
			}
			return $this->db;
		}
	}