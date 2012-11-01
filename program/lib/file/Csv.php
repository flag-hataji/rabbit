<?PHP
/*

  ファイル・CSV保存クラス集

*/

class Csv{

  var $name  = '';        // ファイル名
  var $path  = '';        // 書き込み先ファイルパス
  var $code  = 'EUC-JP';  // 保存文字コード
  var $mode  = 'a';       // 書き込みモード

  var $error = "";				// ERROR内容
  
  /**
   * CSV保存
   */
  Function isWrite( $path=False, $data=False, $code=False, $mode=False ){

    if( ! ($path===false) ) $this->path = $path;
    if( ! ($code===false) ) $this->code = $code;
    if( ! ($mode===false) ) $this->mode = $mode;

    // データの取得
    $regist = "";
    if( is_array($data) ){
      foreach( $data as $key=>$value ){
        $regist = $value."\n";
      }
    }else{
      $regist = $data;
    }
    
    // 保存文字コード
    if ( $code!="EUC-JP" ) {
    	$regist = mb_convert_encoding($regist, $code, "EUC-JP");
    }

    // ファイルの書き込み
    $fopen = fopen($this->path, $this->mode);
    flock($fopen,LOCK_EX);
    $flag = fwrite($fopen, $regist);
    flock($fopen, LOCK_UN);
    fclose($fopen);         

    // 書き込み失敗
    if ( $flag === false ){
    	$this->error = "ファイルの書き込みに失敗しました";
    	return false;
    }

    return True;
  }

}
?>