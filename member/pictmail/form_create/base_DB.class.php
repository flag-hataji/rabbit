<?php

/*******************************************
	PostgresSQLへ接続するための	ベースクラス
********************************************/

	class base_DB{
		//フィールド
		var $errorm;
		var $db;
		//コンストラクタ
		function base_DB(){
			$this->db = pg_connect("host=localhost dbname=rabbit-mail user=postgres port=5432");
			if(!$this->db){
				$this->errorm = "データベースに接続できませんでした".pg_last_error();
				return false;
			}
			return $this->db;
		}
	}