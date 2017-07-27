<?php
/*
	[Aijiacms System] Copyright (c) 2011-2015 www.aijiacms.com

*/
require 'common.inc.php';
if($AJ_BOT) dhttp(403);
if($action != 'mobile') {
	check_referer() or exit;
}
require AJ_ROOT.'/include/post.func.php';
(isset($job) && check_name($job)) or $job = '';
@include AJ_ROOT.'/api/ajax/'.$action.'.inc.php';
?>