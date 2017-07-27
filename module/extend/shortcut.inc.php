<?php
defined('IN_AIJIACMS') or exit('Access Denied');
if($AJ_BOT) dhttp(403);
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
$data = "[InternetShortcut]\r\n";
$data .= "URL=".AJ_PATH."?from=desktop\r\n";
$data .= "IconFile=".AJ_PATH."favicon.ico\r\n";
$data .= "IconIndex=1";
$file = file_vname($AJ['sitename'].'.url');
$file = convert($file, AJ_CHARSET, 'GBK');
file_down('', $file, $data);
?>