<?php
defined('IN_AIJIACMS') or exit('Access Denied');
$ips = glob(AJ_CACHE.'/ban/*.php');
if($ips) {
	$M = cache_read('module-2.php');
	$time = $AJ_TIME - $M['lock_hour']*3600;
	foreach($ips as $k=>$v) {
		if(filemtime($v) < $time) file_del($v);
	}
}
$db->query("DELETE FROM {$AJ_PRE}banip WHERE totime>0 and totime<$AJ_TIME");
if($db->affected_rows()) {
	if(!function_exists('cache_banip')) require_once AJ_ROOT.'/include/cache.func.php';
	cache_banip();
}
?>