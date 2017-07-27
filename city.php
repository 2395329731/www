<?php
/*
	[aijiacms System] Copyright (c) 2008-2011 aijiacms.com
	This is NOT a freeware, use is subject to license.txt
*/
require 'common.inc.php';
$AJ['city'] or dheader(AJ_PATH);
if($action == 'go') {
	if(isset($auto)) {
		if($AJ['city_ip']) {
			set_cookie('city', '');
		} else {
			$iparea = ip2area($AJ_IP);
			$result = $db->query("SELECT * FROM {$AJ_PRE}city");
			while($r = $db->fetch_array($result)) {
				if(preg_match("/".$r['name'].($r['iparea'] ? '|'.$r['iparea'] : '')."/i", $iparea)) {
					if($r['domain']) {
						dheader($r['domain']);
					} else {
						set_cookie('city', $r['areaid'].'|'.$r['domain'], $AJ_TIME + 365*86400);
					}
					break;
				}
			}
		}
		dheader(AJ_PATH);
	}
	$areaid = isset($areaid) ? intval($areaid) : 0;
	if($areaid) {
		$r = $db->get_one("SELECT areaid,name,domain,template FROM {$AJ_PRE}city WHERE areaid=$areaid");
		if($r) {
			set_cookie('city', $r['areaid'].'|'.$r['domain'], $AJ_TIME + 365*86400);
			$url = '';
			if($forward) {
				if(strpos($forward, AJ_PATH) !== false) {
					if($r['domain']) {
						$url = str_replace(AJ_PATH, $r['domain'], $forward);
					} else {
						$url = $forward;
					}
				} else if($city_domain && strpos($forward, $city_domain) !== false) {
					if($r['domain']) {
						$url = str_replace($city_domain, $r['domain'], $forward);
					} else {
						//$url = str_replace($city_domain, AJ_PATH, $forward); For Module Subdomain
					}
				}
			}
			dheader($url ? $url : AJ_PATH);
		}
	}
	set_cookie('city', '0|', $AJ_TIME + 365*86400);
	dheader(AJ_PATH);
}



$lists = array();
$result = $db->query("SELECT areaid,name,style,domain,letter FROM {$AJ_PRE}city ORDER BY listorder,letter");
while($r = $db->fetch_array($result)) {
	$r['linkurl'] = $r['domain'] ? $r['domain'] : '';
	$lists[strtoupper($r['letter'])][] = $r;
}
$head_title = $L['citytitle'];
include template('city', 'city');
?>