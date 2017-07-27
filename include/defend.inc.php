<?php
/*
	[Aijiacms System] Copyright (c) 2011-2015 www.aijiacms.com
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_AIJIACMS') or exit('Access Denied');
if($AJ['close']) {
	if($AJ_BOT) dhttp(503);
	message($AJ['close_reason'].'&nbsp;');
}
if($AJ['defend_cc']) {
	if(!AJ_WIN && file_exists('/proc/loadavg')) {
		if($fp = @fopen('/proc/loadavg', 'r')) {
			list($loadaverage) = explode(' ', fread($fp, 6));
			fclose($fp);
			if($loadaverage > $AJ['defend_cc']) {
				if(defined('AJ_TASK')) exit;
				header("HTTP/1.0 503 Service Unavailable");
				exit(include(AJ_ROOT.'/api/503.php'));
			}
		}
	}
}
if($AJ['defend_reload'] && !$AJ_BOT) {
	$lastvisit = intval(decrypt(get_cookie('lastvisit'), AJ_KEY.'LAST'));
	set_cookie('lastvisit', encrypt("$AJ_TIME", AJ_KEY.'LAST'));
	if($AJ_TIME - $lastvisit < $AJ['defend_reload']) {
		if(defined('AJ_TASK')) exit;
		message(lang('include->defend_reload', array($AJ['defend_reload'])).'<script>setTimeout("this.location.reload();", '.($AJ['defend_reload']*3000).');</script>');
	}
}
if($AJ['defend_proxy']) {
	if($_SERVER['HTTP_X_FORWARDED_FOR'] || $_SERVER['HTTP_VIA'] || $_SERVER['HTTP_PROXY_CONNECTION'] || $_SERVER['HTTP_USER_AGENT_VIA'] || $_SERVER['HTTP_CACHE_INFO'] || $_SERVER['HTTP_PROXY_CONNECTION']) {
		if(defined('AJ_TASK')) exit;
		message(lang('include->defend_proxy'));
	}
}
?>