<?php
    class ParseCsvController extends AppController {
        /*
        SSLの使用・不使用
        使用時 $sslflag = true;
        */
        var $sslflag = true;

        /*
        controller名

        @var string
        @access public
        */
        var $name = "ParseCsv";

        /**
         * 使用するモデル。複数モデルを使用する場合は、配列で渡す
         * 不使用時はfalse
         * var $uses = array("model1","model2");
         *
         * @var mixed
         * @access public
         */
        var $uses = array('ParseCsv', 'TempParseCsv', 'TempDisusedParseCsv');

        /**
         * 使用するヘルパー
         * Html, Form, Session ヘルパーは、デフォルトで利用することが可能。
         * 不使用時はfalse
         * $helpers = array('helpers1','helpers2');
         *
         * @var mixed
         * @access public
         */
        var $helpers = array('Form','Javascript','AppForm');

        /**
         * 使用するコンポーネント
         * 不使用時はfalse
         * $components = array('components1','components2');
         *
         * @var mixed
         * @access public
         */
        var $components = array('Session');

        /**
         * 使用するレイアウト。
         * app/views/layouts/の中に設置するレイアウト名を設定する。
         * 定義していない場合は、app/view/layouts/default.ctpを表示(render)する。
         * $layout = "itm.ctp";
         * app/view/layouts/itm.ctp
         *
         * @var string
         * @access public
         */
        var $layout = "default";

        /*
        ページのタイトル
        layoutの中に、$titlie_for_layoutとして使用可能
        */
        var $pageTitle = "csv解析";

        //解析用CSV名
        var $temp_parse_csv_name;
        
        //削除用CSV名
        var $temp_disued_parse_csv_name;


        /**
         * constructメソッド
         *
         * @param void
         * @access public
         * @return void
         */
        function __contrust() {
            parent::__construct();
        }

        /*
        デフォルトで呼び出されるメソッド
        */
        function index() {
            //submitkeyをセット
            $submit = $this->data['submit'];
            $this->sub_key = @key($submit);

            switch($this->sub_key){
                case 'upload' :
                    $this->_upload();
                    break;
                default :
                    $this->_setCsvfile();
            }
        }

        /**
         * 入力画面の処理
         *
         * @param void
         * @access praivate
         * @return void
         */
        function _setCsvfile() {
            $this->render('set_csv_file');
        }

        /**
         * 参照用csvと削除用csvの登録処理
         *
         * @param void
         * @access praivate
         * @return void
         */
        function _upload() {
        //    $this->TempParseCsv->setConnection();
            //モデルにデータを渡す
            $this->ParseCsv->create($this->data['ParseCsv']);
            $this->TempParseCsv->create($this->data['ParseCsv']);
            $this->TempDisusedParseCsv->create($this->data['ParseCsv']);

            // ユーザIDの取得
            $userSessionId = $this->_getSessionId();
            if(!$userSessionId){
                //エラーページへ
                $this->render('access_err');
            }
            //  入力内容のエラーチェック
            $val_flag = $this->ParseCsv->validates();
            // csvの入力エラーチェック
            // エラーがなかったら
            if($val_flag) {
                // データベース登録中にエラーが発生しなかったら
                try {

                    //ファイルの保存
                    $this->temp_parse_csv_name = $this->TempParseCsv->moveCsvFile($userSessionId);
                    $this->temp_disued_parse_csv_name = $this->TempDisusedParseCsv->moveCsvFile($userSessionId);

                    //ファイルのコンバート
                    $this->TempParseCsv->convertCsvFile($userSessionId);
                    $this->TempDisusedParseCsv->convertCsvFile($userSessionId);

                    // 参照用csvをデータベースに登録する
                    $this->TempParseCsv->saveTempParseCsvDb($userSessionId);
                    // 削除用csvをデータベースに登録する
                    $this->TempDisusedParseCsv->saveTempDisusedParseCsvDb($userSessionId);

                    // ファイルを解析する
                    $downloadCsv = $this->TempParseCsv->getqueryData($userSessionId);
                    $this->TempParseCsv->deleteData($userSessionId);
                    $this->TempDisusedParseCsv->deleteData($userSessionId);

                } catch (Exception $e) {
                    $this->appCakeError($e);
                }
                if ($downloadCsv == 1) {
                    //エラー時のデザイン
                    $this->render('error');

                } else {
                    //配列を文字列へ
                    $newCsvData = $this->ParseCsv->convertQueryArray($downloadCsv, $userSessionId);
                    $this->_deleteFile($userSessionId);
                    // ファイルのダウンロード
                    $this->_download($userSessionId, $newCsvData);

                    //終了
                    exit;
                }
            } else {
               //エラー時のデザイン
                $this->render('error');
            }
        }

         /**
         * ユーザIDの取得
         *
         * @param void
         * @access praivate
         * @return $user_ran
         */
        function _getSessionId() {
            session_cache_limiter('public');
            session_start();
            if(isset($_SESSION['user']['user_id'])){
                return $_SESSION['user']['user_id'];
            }else{
                return false;
            }
        }

        /**
         * エラー時の処理
         *
         * @param $e
         * @access praivate
         * @return void
         */
        function appCakeError($e){
            $err_msg = $e->getMessage()."\n".$e->getFile()." on line ".$e->getLine()."\n";
            $params = array(array('err_msg'=>$err_msg,'mail_flag'=>ERROR_EMAIL_FLAG));
            $this->cakeError("error",$params);
            exit;
        }
        /**
        * 不要なデータをデータベースから削除する
        *
        * @param object $userSessionId
        * @access praivate
        * @return void
        */
        function deleteParseCsvDb($userSessionId) {
            $this->TempParseCsv->deleteAll("user_id");
            $this->TempDisusedParseCsv->deleteAll("user_id");
        }

        /**
         * ファイルのダウンロード
         *
         * @param $userSessionId, $newCsvData
         * @access praivate
         * @return void
         */
        function _download($userSessionId, $newCsvData) {
            $newCsvData = mb_convert_encoding($newCsvData, "SJIS-win", Configure::read("App.encoding"));
            $this->autoRender = false; // Viewを使わないように
            $csv_file = sprintf("%s_%s.csv", $userSessionId, date("Ymd-his"));
            header("Content-disposition: attachment; filename=".$csv_file);
            header("Content-type: application/octet-stream; name=".$csv_file);
            print $newCsvData;

            return;
        }
		
        /**
         * ファイルの削除
         *
         * @param $userSessionId
         * @access praivate
         * @return void
         */
        function _deleteFile($userSessionId) {
            //ファイルの削除
            unlink($this->temp_parse_csv_name);
            unlink($this->temp_disued_parse_csv_name);
        }
    }
?>