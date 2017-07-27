<?php
/*
	 
	This is NOT a freeware, use is subject to license.txt
*/
require 'common.inc.php';
($AJ_MOB['os'] == 'ios' || $AJ_MOB['os'] == 'android') or dheader('index.php?reload='.$AJ_TIME);
if($action == 'house') {
	if(get_cookie('mobile') != 'house') set_cookie('mobile', 'house', $AJ_TIME + 30*86400);
	$AJ_MOB['browser'] = 'house';
	if(isset($url) && strpos($url, $EXT['mobile_url']) === 0) dheader($url);
} else {
	if(get_cookie('mobile') != 'app') set_cookie('mobile', 'app', $AJ_TIME + 30*86400);
	$AJ_MOB['browser'] = 'app';
}
$ads = array();
$pid = intval($EXT['mobile_pid']);
if($pid > 0) {
	$result = $db->query("SELECT * FROM {$AJ_PRE}ad WHERE pid=$pid AND status=3 AND totime>$AJ_TIME ORDER BY listorder ASC,addtime ASC LIMIT 10", 'CACHE');
	while($r = $db->fetch_array($result)) {
		$r['image_src'] = linkurl($r['image_src']);
		$r['url'] = $r['stat'] ? AJ_PATH.'api/redirect.php?aid='.$r['aid'] : linkurl($r['url']);
		$ads[] = $r;
	}
}
$MOD_MY = array();
$data = '';
$local = get_cookie('mobile_setting');
if($local) {
	$data = $local;
} else if($_userid) {
	$data = file_get(AJ_ROOT.'/file/user/'.dalloc($_userid).'/'.$_userid.'/mobile.php');
	if($data) set_cookie('mobile_setting', $data, $AJ_TIME + 30*86400);
}
if($data) {
	$MOB_MOD = array();
	foreach($MOB_MODULE as $m) {
		$MOB_MOD[$m['moduleid']] = $m;
	}
	foreach(explode(',', $data) as $id) {
		if(isset($MOB_MOD[$id])) $MOD_MY[] = $MOB_MOD[$id];
	}
}
if(count($MOD_MY) < 2) $MOD_MY = $MOB_MODULE;
$head_name = $EXT['mobile_sitename'] ? $EXT['mobile_sitename'] : $AJ['sitename'];
$head_keywords = $AJ['seo_keywords'];
$head_description = $AJ['seo_description'];
$foot = 'home';
include template('index', 'mobile');
if(AJ_CHARSET != 'UTF-8') toutf8();
?>