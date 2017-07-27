<?php
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
$url = $EXT['wap_url'];
if(isset($go)) {
	if($go == 'touch') {
		set_cookie('mobile', $go, $AJ_TIME + 86400*30);
		dheader($url);
	} else if($go == 'wap') {
		set_cookie('mobile', $go, $AJ_TIME + 86400*30);
		dheader($url);
	} else if($go == 'pc') {
		set_cookie('mobile', $go, $AJ_TIME + 86400*30);
		dheader(AJ_PATH);
	}
}
$head_title = $L['mobile_title'];
if(get_cookie('mobile') != 'pc') {
	if(preg_match("/(iPhone|iPod|Android)/i", $_SERVER['HTTP_USER_AGENT'])) dheader($url);
	if(preg_match("/(Phone|Mobile)/i", $_SERVER['HTTP_USER_AGENT'])) dheader($url);
}
include template('mobile', $module);
?>