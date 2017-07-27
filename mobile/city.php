<?php
require 'common.inc.php';
$areaid = isset($areaid) ? intval($areaid) : 0;
if($areaid) {
	if($areaid == -2) {
		$iparea = ip2area($AJ_IP);
		$result = $db->query("SELECT * FROM {$AJ_PRE}city");
		while($r = $db->fetch_array($result)) {
			if(preg_match("/".$r['name'].($r['iparea'] ? '|'.$r['iparea'] : '')."/i", $iparea)) {
				set_cookie('city', $r['areaid'].'|'.$r['domain'], $AJ_TIME + 30*86400);
				exit('ok');
			}
		}
	} else if($areaid == -1) {
		set_cookie('city', '0|', $AJ_TIME + 30*86400);
		exit('ok');
	} else {
		$r = $db->get_one("SELECT areaid,name,domain,template FROM {$AJ_PRE}city WHERE areaid=$areaid");
		if($r) {
			set_cookie('city', $r['areaid'].'|'.$r['domain'], $AJ_TIME + 30*86400);
			exit('ok');
		}
	}
	exit('ko');
}
$lists = array();
$result = $db->query("SELECT areaid,name,style,domain,letter FROM {$AJ_PRE}city ORDER BY letter,listorder");
while($r = $db->fetch_array($result)) {
	$r['linkurl'] = $r['domain'] ? $r['domain'] : '';
	$lists[strtoupper($r['letter'])][] = $r;
}
$head_title = $L['city_title'].$AJ['seo_delimiter'].$head_title;
$foot = '';
include template('city', 'mobile');
if(AJ_CHARSET != 'UTF-8') toutf8();
?>