<?php
/*
	[Aijiacms System] Copyright (c) 2011-2015 www.aijiacms.com
*/
require 'common.inc.php';
$username = $domain = '';
if(isset($homepage) && check_name($homepage)) {
	$username = $homepage;
} else if(!$cityid) {
	$host = get_env('host');
	if(substr($host, 0, 4) == 'www.') {
		$whost = $host;
		$host = substr($host, 4);
	} else {
		$whost = $host;
	}
	if($host && strpos(AJ_PATH, $host) === false) {
		if(substr($host, -strlen($CFG['com_domain'])) == $CFG['com_domain']) {
			$www = substr($host, 0, -strlen($CFG['com_domain']));
			if(check_name($www)) {
				$username = $homepage = $www;
			} else {
				include load('company.lang');
				$head_title = $L['not_company'];
				if($AJ_BOT) dhttp(404, $AJ_BOT);
				include template('com-notfound', 'message');
				exit;
			}
		} else {
			if($whost == $host) {//301 xxx.com to www.xxx.com
				$w3 = 'www.'.$host;
				$c = $db->get_one("SELECT userid FROM {$AJ_PRE}company WHERE domain='$w3'");
				if($c) d301('http://'.$w3);
			}
			$c = $db->get_one("SELECT username,domain FROM {$AJ_PRE}company WHERE domain='$whost'".($host == $whost ? '' : " OR domain='$host'"), 'CACHE');
			if($c) {
				$username = $homepage = $c['username'];
				$domain = $c['domain'];
			}
		}
	}
}
if($username) {
	$moduleid = 4;
	$module = 'company';
	$MOD = cache_read('module-'.$moduleid.'.php');
	include load('company.lang');
	require AJ_ROOT.'/module/'.$module.'/common.inc.php';
	include AJ_ROOT.'/module/'.$module.'/init.inc.php';
} else {
	if($AJ['safe_domain']) {
		$safe_domain = explode('|', $AJ['safe_domain']);
		$pass_domain = false;
		foreach($safe_domain as $v) {
			if(strpos($AJ_URL, $v) !== false) { $pass_domain = true; break; }
		}
		$pass_domain or dhttp(404);
	}
	if($AJ['index_html']) {
		$html_file = $CFG['com_dir'] ? AJ_ROOT.'/'.$AJ['index'].'.'.$AJ['file_ext'] : AJ_CACHE.'/index.inc.html';
		if(!is_file($html_file)) tohtml('index');		
		if(is_file($html_file)) exit(include($html_file));
	}
	$AREA or $AREA = cache_read('area.php');
	if($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'];
	$index = 1;
	$seo_title = $AJ['seo_title'];
	$head_keywords = $AJ['seo_keywords'];
	$head_description = $AJ['seo_description'];
	if($city_template) {
		include template($city_template, 'city');
	} else {		
		include template('index');
	}
}
?>