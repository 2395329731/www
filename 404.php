<?php
/*
	[Aijiacms System] Copyright (c) 2011-2015 www.aijiacms.com
	This is NOT a freeware, use is subject to license.txt
*/
require 'common.inc.php';
if(strpos($_SERVER['QUERY_STRING'], '404;') !== false) {
	$AJ_URL = str_replace('404;', '', $_SERVER['QUERY_STRING']);
	$AJ_URL = str_replace(':80', '', $AJ_URL);
}
if($AJ['log_404'] && strpos($AJ_URL, '/404.php') === false) {
	require AJ_ROOT.'/file/config/robot.inc.php';
	$url = addslashes(dhtmlspecialchars($AJ_URL));
	$refer = addslashes(dhtmlspecialchars($AJ_REF));
	$time = $AJ_TIME - 86400;
	$r = $db->get_one("SELECT itemid FROM {$AJ_PRE}404 WHERE addtime>$time AND url='$url'");
	if(!$r) $db->query("INSERT INTO {$AJ_PRE}404 (url,refer,robot,username,ip,addtime) VALUES ('$url','$refer','".get_robot()."','$_username','$AJ_IP','$AJ_TIME')");
}
if($AJ_BOT) dhttp(404, $AJ_BOT);
$head_title = '404 Not Found';
if($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'].'404.php';
include template('404', 'message');
?>