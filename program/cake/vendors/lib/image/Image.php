<?php
/**
* @copyright 2007 (c)Copyright ITManagement Co., Ltd. 2007 All rights reserved.
* @version Release: @package_version@ITM admin tools version 2.0.1
* @link http://www.itm.ne.jp
* @since Class available since Release 2.0.1
* @deprecated Class deprecated in Release 2.0.1
* @author 仁木慎也 <niki@itm.ne.jp>
*/

class Image
{
    var $bean = null ;
    var $max_file_size = 8000000 ;//2M default
    var $resize_flag = false ;
    var $error = null ;

    /**
     *@param resource DBのリソース(connectまで) 
     *@param object データの集合体
     */
    function Image(&$bean)
    {
        $this->bean =& $bean ;
        $this->isUploadDir( UPLOAD_TMP_PATH );
        $this->isUploadDir( UPLOAD_PATH );
    }

    /**
     * ディレクトリの作成
     */
    function isUploadDir( $path = null )
    {
        //ディレクトリの有無確認
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
     * $_FILESから受けたデータを分解し、フォルダへ保存
     *
     * @param array $files formのfileから受け取ったデータ
     * @return String "" 正常終了時、空文字。エラー時はエラーを返す
     */
    function setImageData($files)
    {
        $images = array();
        $this->error = null ;
        $i = 1 ;
        foreach( $files as $key => $val ){

            $file_name = $val['name'];      //ファイル名
            $size      = $val['size'];      //ファイルのサイズ
            $tmp_name  = $val['tmp_name'];  //一時ファイル名(path)

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

            //ファイルタイプチェック
            if(! $imginfo = getimagesize($tmp_name) ){
//                $this->error[$key] = "3"; // not image file type
//                ++$i;
//                continue ;
                $imginfo[2] = 17 ;
                $imginfo[3] = 2000000 ;
            }

            //ファイル名を変更
            $img_name = $this->changeImageName( $this->getImageTypeToExtension($imginfo[2]) , $i);

            //一時ファイル保存先パス設定
            $tmp_path = UPLOAD_TMP_PATH . '/' . $img_name ;


            if( $resize_flag ){
                //画像の規定数取得
                $my_width  = WIDTH ;
                $my_height = HEIGHT ;
                 //画像のサイズを取得
                $width  = $imginfo[0] ;
                $height = $imginfo[1] ;

                //width、height共に規定以下の場合
                if(($width<=$my_width) && ($height<=$my_height) ){
                    $res = $this->getResizeImage($tmp_name, $img_name, $imginfo);
                    if(!$res){
                        $this->error[$key] = "4"; // resize error
                        ++$i;
                        continue ;
                    }
                }
                //リサイズ後の画像サイズ取得
                $imginfo = getimagesize($tmp_path);
            }

            //ファイルを一時フォルダに移動
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
     * 拡張子を設定
     * php5 では、image_type_to_extension って関数がある
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
     * ファイル名を変更する
     *
     * @param String $extension ファイル情報
     * @return String $img_name    変更後のファイル名
     */
    function changeImageName($extension, $i = 0)
    {
        return "img" . date("YmdHis") . "_{$i}{$extension}" ;
    }


    /**
     * 画像を一時フォルダから保存フォルダへ移動
     * @param $from_path
     * @param `to_path
     */
    function moveImageData($from_pah, $to_path)
    {
        $this->error = null ;

        //ファイルチェック
        if(! file_exists($from_pah)){
            $this->error[$key] = "6 = {$from_pah}"; // file not found
            return false ;
        }

        // ディレクトリチェック
        if(! file_exists(dirname($to_path))){
            $this->error[$key] = "7 = {$to_path}"; // dir not found
            return false ;
        }

        //ファイルの移動
        if(! rename($from_pah,$to_path)){
            $this->error[$key] = "8 = rename error"; // from_path can't rename
            return false ;
        }

        return true ;
    }


    /**
     * @param String $tmp_name アップロードされた画像ファイル
     * @param String $img_name 変更した画像の名前
     * @param Array $imginfo getimagesizeから取得した値
     */
    function getResizeImage($tmp_name,$img_name,$imginfo)
    {
/*
        //画像の規定数取得
        $my_width  = WIDTH;
        $my_height = HEIGHT;

        //画像のサイズを取得
        $width  = $imginfo[0];
        $height = $imginfo[1];

        //画像の種類取得
        $img_type = $imginfo[2];   //1 = GIF、2 = JPG、3 = PNG

        //画像のwidth、heightが共に規定以上の処理
        if(($width>$my_width)&&($height>$my_height)){
            if($width>$height){         //widthの方がheightよりでかい場合の処理
                $x = round(($my_width/$width)*100,0);
                $new_width = $my_width;
                $new_height = round($height*($x/100),0);
            }else if(($width<$height)||($width==$height)){//heightの方がwidthよりでかいか、heightとwidthが同じ大きさの場合の処理
                $x = round(($my_height/$height)*100,0);
                $new_height = $my_height;
                $new_width = round($width*($x/100),0);
            }
        }

        //画像のwidthが規定より大きく、heightが規定より小さい場合の処理
        if(($width>$my_width)&&($height<$my_height)){
                $x = round(($my_width/$width)*100,0);
                $new_width = $my_width;
                $new_height = round($height*($x/100),0);
        }

        //画像のheightが規定より大きく、widthが規定より小さい場合の処理
        if(($width<$my_width)&&($height>$my_height)){
                $x = round(($my_height/$height)*100,0);
                $new_height = $my_height;
                $new_width = round($width*($x/100),0);
        }

*/
         //一時ファイル保存先パス設定
        $tmp_path = UPLOAD_TMP_PATH.$img_name;
        $com = ("convert -resize ". "340x255 ".$tmp_name." ".$tmp_path);

//        $com = ("convert -resize ". $new_width."x".$new_height." ".$tmp_name." ".$tmp_path);

        $res = system($com,$returnStatus);

       if($returnStatus){
           return false;
       }

/*
        //リサイズ
        switch ($img_type){
            case "1":           //gifの処理
                $src=@imagecreatefromgif($tmp_name);
                break;
            case "2":          //jpgの処理
                $src=@imagecreatefromjpeg($tmp_name);
                break;
            case "3":           //pngの処理
                $src=@imagecreatefrompng($tmp_name);
                break;
            default:
                return false;
        }

        //$dst=imagecreate($new_width,$new_height);
        // $chk = imagecopyresized($dst,$src,0,0,0,0,$new_width,$new_height,$width,$height);

        //画像作成
        switch ($img_type){
            case "1":           //gifの処理
                imagegif($dst,UPLOAD_TMP_PATH.$img_name);
                break;
            
            case "2":          //jpgの処理
                imagejpeg($dst,UPLOAD_TMP_PATH.$img_name);
                break;
            case "3":           //pngの処理
                imagepng($dst,UPLOAD_TMP_PATH.$img_name);
                break;
            default:
                return false;
        }
*/
        return true;
    }


    /**
     * サムネイルの作成
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
