<?php

require_once 'JSON.php';
 /**
     * 为图片添加水印
     * @param $image  原图片
     * @param $waterFile  水印图片
     * @param $waterTrans  透明度
     * @param $waterQuality  jpg水印图质量
     * @param $waterPlace  水印位置
     * @param $minWidth  添加条件：原图最小宽度
     * @param $minHeight 添加条件：  原图最小高度
     * @param $watername 水印图片保存位置
     */
function waterMark($image,$waterFile, $waterTrans = 50, $waterQuality = 90,
                              $waterPlace = 9, $minWidth='', $minHeight = '', $watername = '') {
        if(empty($watername)) $watername = $image;
        if (! empty ( $waterFile ) && file_exists ( $waterFile )) {
            //水印图信息
            $ifwaterimage = 1;
            $water_info = getimagesize ( $waterFile );
            $width = $water_info [0];
            $height = $water_info [1];
            $source_info = getimagesize ( $image );
            //原图信息
            $source_w = $source_info [0];
            $source_h = $source_info [1];
            !$minWidth && $minWidth = $width;
            !$minHeight && $minHeight = $height;
            if ($source_w < $minWidth || $source_h < $minHeight)
                return false;
            switch ($source_info [2]) {
                case 1 :
                    $source_img = imagecreatefromgif ( $image );
                    break;
                case 2 :
                    $source_img = imagecreatefromjpeg ( $image );
                    break;
                case 3 :
                    $source_img = imagecreatefrompng ( $image );
                    break;
                default :
                    return false;
            }
            switch ($water_info [2]) {
                case 1 :
                    $water_img = imagecreatefromgif ( $waterFile );
                    break;
                case 2 :
                    $water_img = imagecreatefromjpeg ( $waterFile );
                    break;
                case 3 :
                    $water_img = imagecreatefrompng ( $waterFile );
                    break;
                default :
                    return;
            }
        } else {
            return ;
        }
        switch ($waterPlace) {
            case 0 :
                $wx = rand ( 0, ($source_w - $width) );
                $wy = rand ( 0, ($source_h - $height) );
                break;
            case 1 :
                $wx = 5;
                $wy = 5;
                break;
            case 2 :
                $wx = ($source_w - $width) / 2;
                $wy = 0;
                break;
            case 3 :
                $wx = $source_w - $width;
                $wy = 0;
                break;
            case 4 :
                $wx = 0;
                $wy = ($source_h - $height) / 2;
                break;
            case 5 :
                $wx = ($source_w - $width) / 2;
                $wy = ($source_h - $height) / 2;
                break;
            case 6 :
                $wx = $source_w - $width;
                $wy = ($source_h - $height) / 2;
                break;
            case 7 :
                $wx = 0;
                $wy = $source_h - $height;
                break;
            case 8 :
                $wx = ($source_w - $width) / 2;
                $wy = $source_h - $height;
                break;
            case 9 :
                $wx = $source_w - $width;
                $wy = $source_h - $height;
                break;
            default :
                $wx = rand ( 0, ($source_w - $width) );
                $wy = rand ( 0, ($source_h - $height) );
                break;
        }
        if ($water_info [2] == 3) {  //png  的图片实现透明度有些问题            
            imageCopy ( $source_img, $water_img, $wx, $wy, 0, 0, $width, $height );
//          imagecopymerge ( $source_img, $water_img, $wx, $wy, 0, 0, $width, $height, $waterTrans );
        } else {                        
            $r = imagecopymerge ( $source_img, $water_img, $wx, $wy, 0, 0, $width, $height, $waterTrans );
        }        
        switch ($source_info [2]) {
            case 1 :
                imagegif ( $source_img, $watername );
                break;
            case 2 :
                imagejpeg ( $source_img, $watername, $waterQuality );
                break;
            case 3 :
                imagepng ( $source_img, $watername );
                break;
            default :
                return;
        }
        if (isset ( $water_info )) {
            unset ( $water_info );
        }
        if (isset ( $water_img )) {
            imagedestroy ( $water_img );
        }
        unset ( $source_info );
        imagedestroy ( $source_img );
        return true;
    }
require '../../../common.inc.php';


$php_path = dirname(__FILE__) . '/';
$php_url = $AJ['linkurl'];
//文件保存目录路径
$save_path = $php_path . '../../../file/upload/';
//文件保存目录URL
$save_url = $php_url.'/file/upload/';
//定义允许上传的文件扩展名
$ext_arr = array(
	'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
	'flash' => array('swf', 'flv'),
	'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
	'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
);
//最大文件大小
$max_size = 1000000;

$save_path = realpath($save_path) . '/';

//PHP上传失败
if (!empty($_FILES['imgFile']['error'])) {
	switch($_FILES['imgFile']['error']){
		case '1':
			$error = '超过php.ini允许的大小。';
			break;
		case '2':
			$error = '超过表单允许的大小。';
			break;
		case '3':
			$error = '图片只有部分被上传。';
			break;
		case '4':
			$error = '请选择图片。';
			break;
		case '6':
			$error = '找不到临时目录。';
			break;
		case '7':
			$error = '写文件到硬盘出错。';
			break;
		case '8':
			$error = 'File upload stopped by extension。';
			break;
		case '999':
		default:
			$error = '未知错误。';
	}
	alert($error);
}

//有上传文件时
if (empty($_FILES) === false) {
	//原文件名
	$file_name = $_FILES['imgFile']['name'];
	//服务器上临时文件名
	$tmp_name = $_FILES['imgFile']['tmp_name'];
	//文件大小
	$file_size = $_FILES['imgFile']['size'];
	//检查文件名
	if (!$file_name) {
		alert("请选择文件。");
	}
	//检查目录
	if (@is_dir($save_path) === false) {
		alert("上传目录不存在。");
	}
	//检查目录写权限
	if (@is_writable($save_path) === false) {
		alert("上传目录没有写权限。");
	}
	//检查是否已上传
	if (@is_uploaded_file($tmp_name) === false) {
		alert("上传失败。");
	}
	//检查文件大小
	if ($file_size > $max_size) {
		alert("上传文件大小超过限制。");
	}
	//检查目录名
	$dir_name = empty($_GET['dir']) ? 'image' : trim($_GET['dir']);
	if (empty($ext_arr[$dir_name])) {
		alert("目录名不正确。");
	}
	//获得文件扩展名
	$temp_arr = explode(".", $file_name);
	$file_ext = array_pop($temp_arr);
	$file_ext = trim($file_ext);
	$file_ext = strtolower($file_ext);
	//检查扩展名
	if (in_array($file_ext, $ext_arr[$dir_name]) === false) {
		alert("上传文件扩展名是不允许的扩展名。\n只允许" . implode(",", $ext_arr[$dir_name]) . "格式。");
	}
	//创建文件夹
	if ($dir_name !== '') {
		$save_path .= $dir_name . "/";
		$save_url .= $dir_name . "/";
		if (!file_exists($save_path)) {
			mkdir($save_path);
		}
	}
	$ymd = date("Ymd");
	$save_path .= $ymd . "/";
	$save_url .= $ymd . "/";
	if (!file_exists($save_path)) {
		mkdir($save_path);
	}
	//新文件名
	$new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
	//移动文件
	$file_path = $save_path . $new_file_name;
	if (move_uploaded_file($tmp_name, $file_path) === false) {
		alert("上传文件失败。");
	}
	@chmod($file_path, 0644);
	$file_url = $save_url . $new_file_name;

	header('Content-type: text/html; charset=UTF-8');
	$json = new Services_JSON();
	/*水印配置开始*/
    $water_mark = 1;//1为加水印, 其它为不加
    $water_pos = 9;//水印位置，10种状态【0为随机，1为顶端居左，2为顶端居中，3为顶端居右；4为中部居左，5为中部居中，6为中部居右；7为底端居左，8为底端居中，9为底端居】
    $water_img = $_SERVER['DOCUMENT_ROOT'] .'/file/image/watermark.png';//水印图片,默认填写空,请将图片上传至：attachments/water/目录下,例: logo.gif
    $water_alpha = 60;//水印透明度
    $water_text = '';//水印字符串,默认填写空;
    //$water_fontfile = $_SERVER['DOCUMENT_ROOT'] .'attachments/fonts/arial.ttf';//文字水印使用的字体;
    if($water_mark == 1){
    waterMark($file_path, $water_img, $water_alpha,90, $water_pos,"","",""); 
	
    }
    /*水印配置结束*/
	echo $json->encode(array('error' => 0, 'url' => $file_url));
	exit;
}

function alert($msg) {
	header('Content-type: text/html; charset=UTF-8');
	$json = new Services_JSON();
	echo $json->encode(array('error' => 1, 'message' => $msg));
	exit;
}
