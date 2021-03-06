<?php
    class TempDisusedParseCsv extends AppModel {
        //  PHP4　ユーザ用の互換性のため
        var $name = "TempDisusedParseCsv";

        var $useTable = "temp_disused_parse_csvs";

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
        * @param object $userSessionId
        * @return void
        */
        function moveCsvFile($userSessionId) {
            $tempDisusedParseCsv = $this->data['TempDisusedParseCsv'];
            $micro_time = microtime(true);
            $arr = explode('.',$micro_time);
            $this->file_name = '-del'.$arr[0].'.csv';
            // 一時ファイルを移動させる
            if (move_uploaded_file($tempDisusedParseCsv['csv2']['tmp_name'], CSV_PATH.$userSessionId.$this->file_name)) {
                // 権限を変更する
                chmod(CSV_PATH.$userSessionId.$this->file_name, 0777);

                //エンコーディング
                $convertCsv = mb_convert_encoding(file_get_contents(CSV_PATH.$userSessionId.$this->file_name), "EUC-JP", "SJIS");
                //文字列をファイルに保存
                file_put_contents(CSV_PATH.$userSessionId.$this->file_name, $convertCsv);

                //return true;
                return CSV_PATH.$userSessionId.$this->file_name;
            } else {
                throw new Exception("削除用csvファイルの保存に失敗しました。");
            }
        }

        /**
        * cavファイルを「copy from」できるように要素の数を揃える
        * @param object $userSessionId
        * @return boolean
        */
        function convertCsvFile($userSessionId) {
            setlocale(LC_ALL, 'ja_JP');
            $tempDisusedParseCsv = $this->data['TempDisusedParseCsv'];
            $tmpCsvData = "";

            $fp = fopen(CSV_PATH.$userSessionId.$this->file_name, 'r');
            try {
                while (($csvData = fgetcsv($fp)) !== false) {
                	$tmpCsvData .= $userSessionId.",";
                    $tmpCsvData .= $userSessionId.",";
                    foreach ($csvData as $key => $value) {
                        //正しいメール形式なら
                        if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $value)) {
                            $tmpCsvData .= $value;
                            //メールアドレスが見つかったらループを抜ける
                            break;
                        }
                    }
                    
                    //配列を文字列へコンバート
                    //$tmpCsvData .= implode(",", $csvData);
                    $tmpCsvData .= "\n";
                }
                //文字列をファイルに保存
                if (!file_put_contents(CSV_PATH.$userSessionId.$this->file_name, $tmpCsvData)) {
                    $this->invalidate('error','<span style="color:#FF0000;">予期せぬエラーが発生しました。</span>');
                    throw new Exception("削除用csvファイルの保存に失敗しました。");
                }

            } catch (Exception $e) {
                return false;
            }
        }

        /**
        * cavファイルをデータベースに格納する
        * @param object $up_disused_file
        * @return boolean
        */
        function saveTempDisusedParseCsvDb($userSessionId) {
            $tempDisusedParseCsv = $this->data['TempDisusedParseCsv'];
            // トランザクション処理
            $this->begin();

            try {
                $sql = "COPY temp_disused_parse_csvs FROM'".CSV_PATH.$userSessionId.$this->file_name."' WITH CSV";

                $res = pg_query($sql);

                if (!$res) {
                    throw new Exception("削除用csvファイルの保存に失敗しました。");
                }
                $this->commit();
            } catch(Exception $e) {
                // ロールバック処理
                $this->rollback();

                return false;
            }
        }

        /**
        * 不要になったデータベースを削除する
        * @param object $userSessionId
        * @return boolean
        */
        function deleteData($userSessionId) {
            $TempDisusedParseCsvs = $this->data['TempDisusedParseCsv'];

            // トランザクション処理
            $this->begin();

            try {
                $sql = " DELETE FROM temp_disused_parse_csvs WHERE user_id = '".$userSessionId."'";
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