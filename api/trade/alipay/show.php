<?php
/*
	[Aijiacms System] Copyright (c) 2011-2015 www.aijiacms.com
	This is NOT a freeware, use is subject to license.txt
*/
require '../../../common.inc.php';
$itemid = intval(get_cookie('trade_id'));
if($itemid) {
	$r = $db->get_one("SELECT mid,mallid FROM {$AJ_PRE}mall_order WHERE itemid=$itemid");
	if($r) dheader(AJ_PATH.'api/redirect.php?mid='.$r['mid'].'&itemid='.$r['mallid']);
} 
dheader(isset($MODULE[16]) ? $MODULE[16]['linkurl'] : AJ_PATH);
?>