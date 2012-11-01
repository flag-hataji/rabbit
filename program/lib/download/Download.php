<?PHP
/*

  fileDounload( $fileName,$fielPath ) ;
  $fileName = ��������ɤ����Ȥ����դ�����ե������̾��
  $fielPath = ��������ɤ���ե�����Υѥ�
  �ʤ���С������¹Ԥ�����˽��Ϥ����ǡ�������������


2001/10/30 Pictsystm file�Υ�������ɥץ���ࡡken&kiyo
2003/01 masaki UPDATE
___________________________________________________________*/

class Download
{

  var $fileName ;
  var $filePath ;
  var $fileType ;
  var $contentType ;

  // ---���ꡦ�¹�
  function setFileDownload($fileName="",$contentType="",$filePath=""){

    if( !$fileName ){
      return False;
    }

    $this->fileName = $fileName ;
    $this->filePath = $filePath ;


    // ��ĥ�Ҥμ���
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
    // �إå����ƤӽФ�
    $this->setReadHeader();

    // ����ե����뤬����С����Υե��������������
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
  // ��ĥ�Ҽ���
  //-----------------
   Function getExtension($file){
    $extension = str_replace(".","",strtolower( stristr( $file,".") ));
    return $extension;
  }



  //-----------------
  // �إå����ƤӽФ�
  //-----------------
  Function setReadHeader(){

    // �����Υإå�����̿
    // ����
    if( $this->fileType == "image" ){
      header("Content-disposition: attachment; filename=".$this->fileName);
      header("Content-type: ".$this->contentType);
      header("Content-length: ".filesize($this->filePath));
      header("Pragma: no-cache");
      header("Expires: 0");
    // ����¾
    }else{
      header("Content-disposition: filename=".$this->fileName);
      header("Content-type: ".$this->contentType."");
      header("Pragma: no-cache");
      header("Expires: 0");
    }


    return ;
  }

  //------------------------------------
  // ����ե�����ν���(��������ɤ����)
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
