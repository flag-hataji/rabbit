<?PHP
/*

  fileDounload( $fileName,$fielPath ) ;
  $fileName = ダウンロードされるときに付けれれるファイルの名前
  $fielPath = ダウンロードするファイルのパス
  なければ、コレを実行した後に出力したデータをダウンローど


2001/10/30 Pictsystm fileのダウンロードプログラム　ken&kiyo
2003/01 masaki UPDATE
___________________________________________________________*/

class Download
{

  var $fileName ;
  var $filePath ;
  var $fileType ;
  var $contentType ;

  // ---設定・実行
  function setFileDownload($fileName="",$contentType="",$filePath=""){

    if( !$fileName ){
      return False;
    }

    $this->fileName = $fileName ;
    $this->filePath = $filePath ;


    // 拡張子の取得
    if( !$contentType && $this->filePath ){
      $contentType = $this->getExtension($this->filePath);
    }else if( !$contentType && $this->fileName ){
      $contentType = $this->getExtension($this->fileName);
    }else if( !$contentType ){
      $contentType = "other";
    }

    switch( $contentType ){
      case  'html': $this->contentType = "text/html"; break;
      case 'plain': $this->contentType = "text/plain"; break;
      case   'css': $this->contentType = "text/css"; break;
      case  'jpeg': 
      case   'jpg': $this->contentType = "image/jpeg";
                    $this->fileType    = "image"; break;
      case   'gif': $this->contentType = "image/gif";
                    $this->fileType    = "image"; break;
      case  'tiff': $this->contentType = "image/tiff";
                    $this->fileType    = "image"; break;
      case   'png': $this->contentType = "image/x-png";
                    $this->fileType    = "image"; break;
      case   'pdf': $this->contentType = "application/pdf"; break;
      case   'tar': $this->contentType = "application/x-tar"; break;
      case   'zip': $this->contentType = "application/zip"; break;
      case   'csv': $this->contentType = "application/x-csv"; break;
      case   'doc': $this->contentType = "application/msword"; break;
      case   'xls': 
      case 'excel': $this->contentType = "application/vnd.ms-excel"; break;
      case   'ppt': $this->contentType = "application/vnd.ms-powerpoint"; break;
           default: $this->contentType = "application/octet-stream"; 
    }

    if( !$this->fileType ){
      $this->fileType = "txt";
    }

/*
print_r($this);
z
exit;
*/
    // ヘッダー呼び出し
    $this->setReadHeader();

    // 指定ファイルがあれば、そのファイルをダウンロード
    if( $this->filePath ){
      if( $this->setReadFile() ){
        return True;
      }else{
        return False;
      }
    }

    return ;

  }

  //-----------------
  // 拡張子取得
  //-----------------
   Function getExtension($file){
    $extension = str_replace(".","",strtolower( stristr( $file,".") ));
    return $extension;
  }



  //-----------------
  // ヘッダー呼び出し
  //-----------------
  Function setReadHeader(){

    // ここのヘッダーが命
    // 画像
    if( $this->fileType == "image" ){
      header("Content-disposition: attachment; filename=".$this->fileName);
      header("Content-type: ".$this->contentType);
      header("Content-length: ".filesize($this->filePath));
      header("Pragma: no-cache");
      header("Expires: 0");
    // その他
    }else{
      header("Content-disposition: filename=".$this->fileName);
      header("Content-type: ".$this->contentType."");
      header("Pragma: no-cache");
      header("Expires: 0");
    }


    return ;
  }

  //------------------------------------
  // 指定ファイルの出力(ダウンロードされる)
  //------------------------------------
  function setReadFile(){

    if( @readfile( $this->filePath ) ){
      return True;
    }else{
      return False;
    }
    
  }
}
?>
