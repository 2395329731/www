<?php
require '../common.inc.php';
if($AJ_BOT) dhttp(403);
$url = AJ_PATH.'?from=desktop';
$ico = AJ_PATH.'favicon.ico';
$name = $AJ['sitename'];
if($itemid) {
	$t = $db->get_one("SELECT company,linkurl,catid FROM {$AJ_PRE}company WHERE userid=$itemid");
	if($t && $t['catid']) {
		$url = $t['linkurl'];
		$ico = '';
		$name = $t['company'];
	}
}
$data = "[InternetShortcut]\r\n";
$data .= "URL=".$url."\r\n";
if($ico) $data .= "IconFile=".$ico."\r\n";
$data .= "IconIndex=1";
$file = file_vname($name.'.url');
$file = convert($file, AJ_CHARSET, 'GBK');
file_down('', $file, $data);
?>