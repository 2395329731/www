<?php
defined('IN_AIJIACMS') or exit('Access Denied');
if($AJ_BOT) dhttp(403);
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
$aijiacms_task = rand_task();
$head_title = $L['view_title'];
$pass = $img;
if(strpos($img, AJ_DOMAIN ? AJ_DOMAIN : AJ_PATH) !== false) {
	$pass = true;
} else {
	if($AJ['remote_url'] && strpos($img, $AJ['remote_url']) !== false) {
		$pass = true;
	} else {
		$pass = false;
	}
}
$pass or dheader($img);
$ext = file_ext($img);
in_array($ext, array('jpg', 'jpeg', 'gif', 'png', 'bmp')) or dheader(AJ_PATH);
$img = str_replace(array('.thumb.'.$ext, '.middle.'.$ext), array('', ''), $img);
include template('view', $module);
?>