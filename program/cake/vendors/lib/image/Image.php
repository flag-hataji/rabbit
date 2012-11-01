<?php
/**
* @copyright 2007 (c)Copyright ITManagement Co., Ltd. 2007 All rights reserved.
* @version Release: @package_version@ITM admin tools version 2.0.1
* @link http://www.itm.ne.jp
* @since Class available since Release 2.0.1
* @deprecated Class deprecated in Release 2.0.1
* @author ���ڿ��� <niki@itm.ne.jp>
*/

class Image
{
    var $bean = null ;
    var $max_file_size = 8000000 ;//2M default
    var $resize_flag = false ;
    var $error = null ;

    /**
     *@param resource DB�Υ꥽����(connect�ޤ�) 
     *@param object �ǡ����ν�����
     */
    function Image(&$bean)
    {
        $this->bean =& $bean ;
        $this->isUploadDir( UPLOAD_TMP_PATH );
        $this->isUploadDir( UPLOAD_PATH );
    }

    /**
     * �ǥ��쥯�ȥ�κ���
     */
    function isUploadDir( $path = null )
    {
        //�ǥ��쥯�ȥ��̵ͭ��ǧ
        if(! file_exists($path) ){
            if(! mkdir($path,0777) ){
                die("not make or parmission " . $path );
            }
        }
    }


    function setMaxFileSize( $size )
    {
        $this->max_file_size = $size ;
    }

    /**
     * $_FILES����������ǡ�����ʬ�򤷡��ե��������¸
     *
     * @param array $files form��file���������ä��ǡ���
     * @return String "" ���ｪλ������ʸ�������顼���ϥ��顼���֤�
     */
    function setImageData($files)
    {
        $images = array();
        $this->error = null ;
        $i = 1 ;
        foreach( $files as $key => $val ){

            $file_name = $val['name'];      //�ե�����̾
            $size      = $val['size'];      //�ե�����Υ�����
            $tmp_name  = $val['tmp_name'];  //����ե�����̾(path)

            // error check size
            if( $size <= 0){
                $this->error[$key] = "1"; // file size zero
                ++$i;
                continue ;
            }

            if($size >= $this->max_file_size ){
                $this->error[$key] = "2"; // over file size
                ++$i;
                continue ;
            }

            //�ե����륿���ץ����å�
            if(! $imginfo = getimagesize($tmp_name) ){
//                $this->error[$key] = "3"; // not image file type
//                ++$i;
//                continue ;
                $imginfo[2] = 17 ;
                $imginfo[3] = 2000000 ;
            }

            //�ե�����̾���ѹ�
            $img_name = $this->changeImageName( $this->getImageTypeToExtension($imginfo[2]) , $i);

            //����ե�������¸��ѥ�����
            $tmp_path = UPLOAD_TMP_PATH . '/' . $img_name ;


            if( $resize_flag ){
                //�����ε��������
                $my_width  = WIDTH ;
                $my_height = HEIGHT ;
                 //�����Υ����������
                $width  = $imginfo[0] ;
                $height = $imginfo[1] ;

                //width��height���˵���ʲ��ξ��
                if(($width<=$my_width) && ($height<=$my_height) ){
                    $res = $this->getResizeImage($tmp_name, $img_name, $imginfo);
                    if(!$res){
                        $this->error[$key] = "4"; // resize error
                        ++$i;
                        continue ;
                    }
                }
                //�ꥵ������β�������������
                $imginfo = getimagesize($tmp_path);
            }

            //�ե���������ե�����˰�ư
            if(! move_uploaded_file($tmp_name, $tmp_path) ){ 
                $this->error[$key] = "5"; // upload error
                ++$i;
                continue ;
            }

            $images[$key]['image_name'] = $img_name ;
            $images[$key]['image_path'] = UPLOAD_TMP_URL . '/' . $img_name;
            $images[$key]['image_size'] = $imginfo[3] ;

            ++$i ;
        }

        if( $error ){
            return false ;
        }
        return $images ;
    }


    /**
     * ��ĥ�Ҥ�����
     * php5 �Ǥϡ�image_type_to_extension �äƴؿ�������
     */
    function getImageTypeToExtension($type, $dot = true){
        $extension = "";
        switch( $type ){
            case 1 : $extension = 'gif' ; break ;
            case 2 : $extension = 'jpg' ; break ;
            case 3 : $extension = 'png' ; break ;
            case 4 : $extension = 'swf' ; break ;
            case 5 : $extension = 'psd' ; break ;
            case 6 : $extension = 'bmp' ; break ;
            case 7 : $extension = 'tiff' ; break ;
            case 8 : $extension = 'tiff' ; break ;
            case 9 : $extension = 'jpc' ; break ;
            case 10 : $extension = 'jp2' ; break ;
            case 11 : $extension = 'jpx' ; break ;
            case 12 : $extension = 'jb2' ; break ;
            case 13 : $extension = 'swc' ; break ;
            case 14 : $extension = 'iff' ; break ;
            case 15 : $extension = 'wbmp' ; break ;
            case 16 : $extension = 'xbm' ; break ;
            case 17 : $extension = 'pdf' ; break ;
            default :
        }
        if( $dot ){
            $extension = "." . $extension ;
        }
        return $extension ;
    }


    /**
     * �ե�����̾���ѹ�����
     *
     * @param String $extension �ե��������
     * @return String $img_name    �ѹ���Υե�����̾
     */
    function changeImageName($extension, $i = 0)
    {
        return "img" . date("YmdHis") . "_{$i}{$extension}" ;
    }


    /**
     * ���������ե����������¸�ե�����ذ�ư
     * @param $from_path
     * @param `to_path
     */
    function moveImageData($from_pah, $to_path)
    {
        $this->error = null ;

        //�ե���������å�
        if(! file_exists($from_pah)){
            $this->error[$key] = "6 = {$from_pah}"; // file not found
            return false ;
        }

        // �ǥ��쥯�ȥ�����å�
        if(! file_exists(dirname($to_path))){
            $this->error[$key] = "7 = {$to_path}"; // dir not found
            return false ;
        }

        //�ե�����ΰ�ư
        if(! rename($from_pah,$to_path)){
            $this->error[$key] = "8 = rename error"; // from_path can't rename
            return false ;
        }

        return true ;
    }


    /**
     * @param String $tmp_name ���åץ��ɤ��줿�����ե�����
     * @param String $img_name �ѹ�����������̾��
     * @param Array $imginfo getimagesize�������������
     */
    function getResizeImage($tmp_name,$img_name,$imginfo)
    {
/*
        //�����ε��������
        $my_width  = WIDTH;
        $my_height = HEIGHT;

        //�����Υ����������
        $width  = $imginfo[0];
        $height = $imginfo[1];

        //�����μ������
        $img_type = $imginfo[2];   //1 = GIF��2 = JPG��3 = PNG

        //������width��height�����˵���ʾ�ν���
        if(($width>$my_width)&&($height>$my_height)){
            if($width>$height){         //width������height���Ǥ������ν���
                $x = round(($my_width/$width)*100,0);
                $new_width = $my_width;
                $new_height = round($height*($x/100),0);
            }else if(($width<$height)||($width==$height)){//height������width���Ǥ�������height��width��Ʊ���礭���ξ��ν���
                $x = round(($my_height/$height)*100,0);
                $new_height = $my_height;
                $new_width = round($width*($x/100),0);
            }
        }

        //������width���������礭����height�������꾮�������ν���
        if(($width>$my_width)&&($height<$my_height)){
                $x = round(($my_width/$width)*100,0);
                $new_width = $my_width;
                $new_height = round($height*($x/100),0);
        }

        //������height���������礭����width�������꾮�������ν���
        if(($width<$my_width)&&($height>$my_height)){
                $x = round(($my_height/$height)*100,0);
                $new_height = $my_height;
                $new_width = round($width*($x/100),0);
        }

*/
         //����ե�������¸��ѥ�����
        $tmp_path = UPLOAD_TMP_PATH.$img_name;
        $com = ("convert -resize ". "340x255 ".$tmp_name." ".$tmp_path);

//        $com = ("convert -resize ". $new_width."x".$new_height." ".$tmp_name." ".$tmp_path);

        $res = system($com,$returnStatus);

       if($returnStatus){
           return false;
       }

/*
        //�ꥵ����
        switch ($img_type){
            case "1":           //gif�ν���
                $src=@imagecreatefromgif($tmp_name);
                break;
            case "2":          //jpg�ν���
                $src=@imagecreatefromjpeg($tmp_name);
                break;
            case "3":           //png�ν���
                $src=@imagecreatefrompng($tmp_name);
                break;
            default:
                return false;
        }

        //$dst=imagecreate($new_width,$new_height);
        // $chk = imagecopyresized($dst,$src,0,0,0,0,$new_width,$new_height,$width,$height);

        //��������
        switch ($img_type){
            case "1":           //gif�ν���
                imagegif($dst,UPLOAD_TMP_PATH.$img_name);
                break;
            
            case "2":          //jpg�ν���
                imagejpeg($dst,UPLOAD_TMP_PATH.$img_name);
                break;
            case "3":           //png�ν���
                imagepng($dst,UPLOAD_TMP_PATH.$img_name);
                break;
            default:
                return false;
        }
*/
        return true;
    }


    /**
     * ����ͥ���κ���
     *
     */
    function getThumbnailImage($file_name,$move_file,$num){
        $path = THUMBNAIL_DIR;
        $thum_file_name = "thum_".$file_name;
        $thum_file = $path.$thum_file_name;

        $com = ("convert -resize ". "110x82 ".$move_file." ".$thum_file);
        $res = system($com,$returnStatus);
       if($returnStatus){
           return false;
       }
       $this->bean->setInput("thumbnail_name".$num,$thum_file_name);
       return true;
    }

}
