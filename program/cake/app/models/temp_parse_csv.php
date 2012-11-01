<?php
    class TempParseCsv extends AppModel {
        //  PHP4　ユーザ用の互換性のため
        var $name = "TempParseCsv";

        var $useTable = "temp_parse_csvs";

        /**
         * /app/config/database.php内で定義したどのパラメータを使用するかを指定
         * デフォルトは 'default'
         *
         * @var string
         * @access public
         */
        var $useDbConfig = "default";

        /**
         * データベーステーブルフィールドの詳細であるメタデータ
         * ※DB不使用時、formhelperを使うとエラーが起きる
         * 回避として$_schema最低限設定しておく必要があるらしいのでダミーを設定
         */
       // var $_schema = array();

        /**
         * キャッシュを使用・不使用
         * @var boolean
         * @access public
         */
        var $cacheQueries = false;


        /**
         * 使用するビヘイビア
         * 不使用時はfalse
         * $actAs = array('behavior'=>'array('param')','behavior2');
         *
         * @var mixed
         * @access public
         * @link http://book.cakephp.org/ja/view/90/Using-Behaviors
         */
        var $actsAs = array('Form', 'Convert', 'ExValidate');

        /**
        * cavファイルをサーバーに保存する
        * @param object $up_compare_file, $userSessionId
        * @return void
        */
        function moveCsvFile($userSessionId) {
            $tempParseCsvs = $this->data['TempParseCsv'];
            $micro_time = microtime(true);
            $arr = explode('.',$micro_time);
            $this->file_name = '-'.$arr[0].'.csv';
            // 一時ファイルを移動させる
            if (move_uploaded_file($tempParseCsvs['csv1']['tmp_name'], CSV_PATH.$userSessionId.$this->file_name)) {
                // 権限を変更する
                chmod(CSV_PATH.$userSessionId.$this->file_name, 0777);

                //csvファイルをエンコーディングする
                $convertCsv = mb_convert_encoding(file_get_contents(CSV_PATH.$userSessionId.$this->file_name), "EUC-JP", "SJIS");
                //$convertCsv = file_get_contents(CSV_PATH.$userSessionId.$this->file_name);
                
                //文字列をファイルに保存
                file_put_contents(CSV_PATH.$userSessionId.$this->file_name, $convertCsv);
                //return true;
                return CSV_PATH.$userSessionId.$this->file_name;
            } else {
                throw new Exception("解析用csvファイルの保存に失敗しました。");
            }

        }

        /**
        * cavファイルを「copy from」できるように要素の数を揃える
        * @param object $userSessionId
        * @return void
        */
        function convertCsvFile($userSessionId) {

            setlocale(LC_ALL, 'ja_JP');
            
            $tempParseCsvs = $this->data['TempParseCsv'];
            $tmpCsvData = "";
            
            $fp = fopen(CSV_PATH.$userSessionId.$this->file_name, 'r');
            
            try {
                while (($csvData = fgetcsv($fp)) !== false) {
                    $tmpCsvData .= $userSessionId.",";
                    $tmpCsvData .= $userSessionId.",";
                    /*
                    foreach ($csvData as $key => $value) {
                        
                        //正しいメール形式なら
                        if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $value)) {
                            //$tmpCsvData .= $value."\t";
                            //メールアドレスが見つかったらループを抜ける
                            break;
                        }
                    }
                    */
                    //配列を文字列へコンバート
                    $cnt = count($csvData);
                    if($cnt<=7){
                        $tmpCsvData .= implode(",", $csvData);
                        while(7>$cnt){
                            $tmpCsvData .= ',';
                            $cnt++;
                        }
                    }else{
                        $tmpCsvData .= $csvData[0].',';
                        $tmpCsvData .= $csvData[1].',';
                        $tmpCsvData .= $csvData[2].',';
                        $tmpCsvData .= $csvData[3].',';
                        $tmpCsvData .= $csvData[4].',';
                        $tmpCsvData .= $csvData[5].',';
                        $tmpCsvData .= $csvData[6];
                    }
                    $tmpCsvData .= "\n";
                }
                //文字列をファイルに保存
                if (!file_put_contents(CSV_PATH.$userSessionId.$this->file_name, $tmpCsvData)) {
                    $this->invalidate('error','<span style="color:#FF0000;">予期せぬエラーが発生しました。</span>');
                    throw new Exception("解析用csvファイルの保存に失敗しました。");
                }
            } catch (Exception $e) {
                return false;
            }
        }

        function setConnection(){
            $db =& ConnectionManager::getDataSource('default');
            $this->con &= $db->connection;
        }

        /**
        * cavファイルをデータベースに格納する
        * @param object $userSessionId
        * @return void
        */
        function saveTempParseCsvDb($userSessionId) {

            $tempParseCsvs = $this->data['TempParseCsv'];

            // トランザクション処理
            $this->begin();

            try {
                //echo $sql = "COPY temp_parse_csvs FROM '".CSV_PATH.$userSessionId.$this->file_name."' USING DELIMITERS ',' WITH NULL AS ''";
                $sql = "COPY temp_parse_csvs FROM '".CSV_PATH.$userSessionId.$this->file_name."' WITH CSV";
                
                $res = pg_query($sql);

                if (!$res) {
                    throw new Exception("解析用csvファイルの保存に失敗しました。");
                }
                $this->commit();
            } catch(Exception $e) {
                // ロールバック処理
                $this->rollback();

                return false;
            }
        }

        /**
         * クエリ-データの取得
         *
         * @param void
         * @access praivate
         * @return $result
         */
        function getqueryData($userSessionId) {

            $sql = "SELECT * from temp_parse_csvs where user_id = '".$userSessionId."' AND mail IS NOT NULL AND mail NOT IN (SELECT mail from temp_disused_parse_csvs where user_id = '".$userSessionId."' AND mail IS NOT NULL GROUP BY mail )";

            $res = pg_query($sql);
            if(!$res){
                throw new Exception("DBクエリに失敗しました");
            }
            while($fres = pg_fetch_assoc($res)){
                $arr[] = $fres;
            }

            if (count($arr) == 0) {
            	$error_txt = "<span style=\"color:#FF0000;\">解析に失敗しました。以下の点をご確認下さい<br>\n";
            	$error_txt .= "・エクセルファイル等、違うファイルを指定していないか<br>\n";
            	$error_txt .= "・お名前に機種依存文字が入っていないか</br>\n";
            	$error_txt .= "・配信リストcsvの形式が間違っていないか（B列にメールアドレス）</span>\n";
                $this->invalidate('noData',$error_txt);
                return true;
            }
            return $arr;

        }

        /**
        * 不要になったデータベースを削除する
        * @param object $userSessionId
        * @return void
        */
        function deleteData($userSessionId) {
            $tempParseCsvs = $this->data['TempParseCsv'];

            // トランザクション処理
            $this->begin();

            try {
                $sql = " DELETE FROM temp_parse_csvs WHERE user_id = '".$userSessionId."'";
                $res = pg_query($sql);

                if (!$res) {
                    throw new Exception("データベースの削除に失敗しました。");
                }
                $this->commit();
            } catch(Exception $e) {
                // ロールバック処理
                $this->rollback();

                return false;
            }
        }

    }
?>