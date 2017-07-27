<?php
/*
	[Aijiacms System] Copyright (c) 2011-2015 www.aijiacms.com
	This is NOT a freeware, use is subject to license.txt
*/
defined('AJ_ADMIN') or exit('Access Denied');
function edition($k = -1) {
	$E = array();
	$E[0] = AJ_DOMAIN;
	$E[1] = '商业版';
	return $k >= 0 ? $E[$k] : $E;
}
?>
