<?php
/*
	[Aijiacms System] Copyright (c) 2011-2015 www.aijiacms.com
	This is NOT a freeware, use is subject to license.txt
*/
require 'common.inc.php';
if($moduleid < 4) $moduleid = 4;
$AREA = cache_read('area.php');
$pid = isset($pid) ? intval($pid) : 0;
$back_link = $pid ? 'area.php?moduleid='.$moduleid.'&pid='.$AREA[$pid]['parentid'] : mobileurl($moduleid);
$lists = array();
foreach($AREA as $a) {
	if($a['parentid'] == $pid) $lists[] = $a;
}
$head_title = $MOD['name'].$AJ['seo_delimiter'].$head_title;
include template('area', 'mobile');
if(AJ_CHARSET != 'UTF-8') toutf8();
?>