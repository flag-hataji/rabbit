<?php
    class TempParseCsv extends AppModel {
        //  PHP4���桼���Ѥθߴ����Τ���
        var $name = "TempParseCsv";

        var $useTable = "temp_parse_csvs";

        /**
         * /app/config/database.php�����������ɤΥѥ�᡼������Ѥ��뤫�����
         * �ǥե���Ȥ� 'default'
         *
         * @var string
         * @access public
         */
        var $useDbConfig = "default";

        /**
         * �ǡ����١����ơ��֥�ե�����ɤξܺ٤Ǥ���᥿�ǡ���
         * ��DB�Ի��ѻ���formhelper��Ȥ��ȥ��顼��������
         * ����Ȥ���$_schema��������ꤷ�Ƥ���ɬ�פ�����餷���Τǥ��ߡ�������
         */
       // var $_schema = array();

        /**
         * ����å������ѡ��Ի���
         * @var boolean
         * @access public
         */
        var $cacheQueries = false;


        /**
         * ���Ѥ���ӥإ��ӥ�
         * �Ի��ѻ���false
         * $actAs = array('behavior'=>'array('param')','behavior2');
         *
         * @var mixed
         * @access public
         * @link http://book.cakephp.org/ja/view/90/Using-Behaviors
         */
        var $actsAs = array('Form', 'Convert', 'ExValidate');

        /**
        * cav�ե�����򥵡��С�����¸����
        * @param object $up_compare_file, $userSessionId
        * @return void
        */
        function moveCsvFile($userSessionId) {
            $tempParseCsvs = $this->data['TempParseCsv'];
            $micro_time = microtime(true);
            $arr = explode('.',$micro_time);
            $this->file_name = '-'.$arr[0].'.csv';
            // ����ե�������ư������
            if (move_uploaded_file($tempParseCsvs['csv1']['tmp_name'], CSV_PATH.$userSessionId.$this->file_name)) {
                // ���¤��ѹ�����
                chmod(CSV_PATH.$userSessionId.$this->file_name, 0777);

                //csv�ե�����򥨥󥳡��ǥ��󥰤���
                $convertCsv = mb_convert_encoding(file_get_contents(CSV_PATH.$userSessionId.$this->file_name), "EUC-JP", "SJIS");
                //$convertCsv = file_get_contents(CSV_PATH.$userSessionId.$this->file_name);
                
                //ʸ�����ե��������¸
                file_put_contents(CSV_PATH.$userSessionId.$this->file_name, $convertCsv);
                //return true;
                return CSV_PATH.$userSessionId.$this->file_name;
            } else {
                throw new Exception("������csv�ե��������¸�˼��Ԥ��ޤ�����");
            }

        }

        /**
        * cav�ե�������copy from�פǤ���褦�����Ǥο���·����
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
                        
                        //�������᡼������ʤ�
                        if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $value)) {
                            //$tmpCsvData .= $value."\t";
                            //�᡼�륢�ɥ쥹�����Ĥ��ä���롼�פ�ȴ����
                            break;
                        }
                    }
                    */
                    //�����ʸ����إ���С���
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
                //ʸ�����ե��������¸
                if (!file_put_contents(CSV_PATH.$userSessionId.$this->file_name, $tmpCsvData)) {
                    $this->invalidate('error','<span style="color:#FF0000;">ͽ�����̥��顼��ȯ�����ޤ�����</span>');
                    throw new Exception("������csv�ե��������¸�˼��Ԥ��ޤ�����");
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
        * cav�ե������ǡ����١����˳�Ǽ����
        * @param object $userSessionId
        * @return void
        */
        function saveTempParseCsvDb($userSessionId) {

            $tempParseCsvs = $this->data['TempParseCsv'];

            // �ȥ�󥶥���������
            $this->begin();

            try {
                //echo $sql = "COPY temp_parse_csvs FROM '".CSV_PATH.$userSessionId.$this->file_name."' USING DELIMITERS ',' WITH NULL AS ''";
                $sql = "COPY temp_parse_csvs FROM '".CSV_PATH.$userSessionId.$this->file_name."' WITH CSV";
                
                $res = pg_query($sql);

                if (!$res) {
                    throw new Exception("������csv�ե��������¸�˼��Ԥ��ޤ�����");
                }
                $this->commit();
            } catch(Exception $e) {
                // ����Хå�����
                $this->rollback();

                return false;
            }
        }

        /**
         * ������-�ǡ����μ���
         *
         * @param void
         * @access praivate
         * @return $result
         */
        function getqueryData($userSessionId) {

            $sql = "SELECT * from temp_parse_csvs where user_id = '".$userSessionId."' AND mail IS NOT NULL AND mail NOT IN (SELECT mail from temp_disused_parse_csvs where user_id = '".$userSessionId."' AND mail IS NOT NULL GROUP BY mail )";

            $res = pg_query($sql);
            if(!$res){
                throw new Exception("DB������˼��Ԥ��ޤ���");
            }
            while($fres = pg_fetch_assoc($res)){
                $arr[] = $fres;
            }

            if (count($arr) == 0) {
            	$error_txt = "<span style=\"color:#FF0000;\">���Ϥ˼��Ԥ��ޤ������ʲ������򤴳�ǧ������<br>\n";
            	$error_txt .= "����������ե����������㤦�ե��������ꤷ�Ƥ��ʤ���<br>\n";
            	$error_txt .= "����̾���˵����¸ʸ�������äƤ��ʤ���</br>\n";
            	$error_txt .= "���ۿ��ꥹ��csv�η������ְ�äƤ��ʤ�����B��˥᡼�륢�ɥ쥹��</span>\n";
                $this->invalidate('noData',$error_txt);
                return true;
            }
            return $arr;

        }

        /**
        * ���פˤʤä��ǡ����١�����������
        * @param object $userSessionId
        * @return void
        */
        function deleteData($userSessionId) {
            $tempParseCsvs = $this->data['TempParseCsv'];

            // �ȥ�󥶥���������
            $this->begin();

            try {
                $sql = " DELETE FROM temp_parse_csvs WHERE user_id = '".$userSessionId."'";
                $res = pg_query($sql);

                if (!$res) {
                    throw new Exception("�ǡ����١����κ���˼��Ԥ��ޤ�����");
                }
                $this->commit();
            } catch(Exception $e) {
                // ����Хå�����
                $this->rollback();

                return false;
            }
        }

    }
?>