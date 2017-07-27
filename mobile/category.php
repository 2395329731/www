<?php
/*
	[Aijiacms System] Copyright (c) 2011-2015 www.aijiacms.com
	This is NOT a freeware, use is subject to license.txt
*/
require 'common.inc.php';
if($moduleid < 4) $moduleid = 4;
$pid = isset($pid) ? intval($pid) : 0;
if($pid) {
	$P = get_cat($pid);
	$back_link = 'category.php?moduleid='.$moduleid.'&pid='.$P['parentid'];
} else {
	$back_link = mobileurl($moduleid);
}
$lists = get_maincat($pid, $moduleid);
$head_title = $MOD['name'].$AJ['seo_delimiter'].$head_title;
include template('category', 'mobile');
if(AJ_CHARSET != 'UTF-8') toutf8();
?>