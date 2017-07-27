<?php
/*
	[Aijiacms System] Copyright (c) 2011-2015 www.aijiacms.com
	This is NOT a freeware, use is subject to license.txt
*/
$_COOKIE = array();
require '../common.inc.php';
if($AJ_BOT) dhttp(403);
$url = isset($url) ? trim($url) : '';
$name = isset($name) ? trim($name) : '';
strlen($url) > 15 or dheader(AJ_PATH);
$ext = file_ext($url);
$ext or dheader(AJ_PATH);
$name or dheader($url);
$ext == file_ext($name) or dheader(AJ_PATH);
in_array($ext, array('rar', 'zip', 'gz', 'tar', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx')) or dheader($url);
strpos($url, AJ_PATH.'file/upload/') === 0 or dheader($url);
$file = substr($url, strlen(AJ_PATH.'file/upload/'));
$filename = substr($file, 0, -strlen($ext)-1);
preg_match("/^[0-9\-\/]{21,}$/", $filename) or dheader($url);
$localfile = AJ_ROOT.'/file/upload/'.$file;
is_file($localfile) or dheader($url);
$title = convert(substr($name, 0, -strlen($ext)-1), 'UTF-8', AJ_CHARSET);
$title = file_vname($title);
$title or dheader($url);
if(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== false) $title = convert($title, AJ_CHARSET, 'UTF-8');
if(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== false) $title = str_replace(' ', '_', $title);
if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false) $title = convert($title, AJ_CHARSET, 'GBK');
$title or dheader($url);
file_down($localfile, $title.'.'.$ext);
?>