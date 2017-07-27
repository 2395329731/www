<?php
require '../../../common.inc.php';
require 'init.inc.php';
$OAUTH[$site]['sync'] or exit;
$_token = get_cookie('qq_token');
$_openid = get_cookie('qq_openid');
if($_token && $_openid) {
	$_openid = decrypt($_openid);
	require '../post.inc.php';
	$title = convert($title, AJ_CHARSET, 'UTF-8');
	$introduce = convert($introduce, AJ_CHARSET, 'UTF-8');
	$site = convert($AJ['sitename'], AJ_CHARSET, 'UTF-8');
	$par = 'access_token='.$_token.'&oauth_consumer_key='.QQ_ID.'&openid='.$_openid;
	$par .= '&format=xml&title='.$title.'&url='.$linkurl.'&site='.$site.'&fromurl='.AJ_PATH.'&nswb=1';
	if($introduce) $par .= '&summary='.$introduce;
	if($thumb) $par .= '&images='.$thumb;
	$cur = curl_init('https://graph.qq.com/share/add_share');
	curl_setopt($cur, CURLOPT_POST, 1);
	curl_setopt($cur, CURLOPT_POSTFIELDS, $par);
	curl_setopt($cur, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($cur, CURLOPT_HEADER, 0);
	curl_setopt($cur, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($cur, CURLOPT_RETURNTRANSFER, 1);
	$rec = curl_exec($cur);
	curl_close($cur);
	if(strpos($rec, '<msg>ok</msg>') === false) {
		//fail
	} else {
		//success
	}
}
?>