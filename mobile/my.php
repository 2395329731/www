<?php
/*
	[Aijiacms System] Copyright (c) 2011-2015 www.aijiacms.com
	This is NOT a freeware, use is subject to license.txt
*/
$moduleid = 2;
require 'common.inc.php';
if($action) {
	$_userid or dheader('login.php?forward='.urlencode('my.php?action='.$action));
}
if($action == 'back') {
	$t = explode('.php', $AJ_REF);
	$r = basename($t[0]);
	if($r.'.php' == $AJ['file_my']) {
		$action = 'info';
	} else {
		if(in_array($r, array('trade', 'group', 'record', 'charge', 'deposit', 'cash', 'credit', 'address'))) {
			$action = 'trade';
		} else if(in_array($r, array('home', 'style', 'news', 'page', 'honor', 'link'))) {
			$action = 'home';
		} else {
			$action = 'member';
		}
	}
}
if($action == 'member') {
	$user = $db->get_one("SELECT deposit FROM {$AJ_PRE}member WHERE userid=$_userid");
	$head_name = $L['my_member'];
} elseif($action == 'info') {
	$head_name = $L['my_info'];	
	$MYMODS = array();
	if(isset($MG['moduleids']) && $MG['moduleids']) {
		$MYMODS = explode(',', $MG['moduleids']);
	}
	if($MYMODS) {
		foreach($MYMODS as $k=>$v) {
			$v = abs($v);
			if(!isset($MODULE[$v])) unset($MYMODS[$k]);
		}
	}
} elseif($action == 'trade') {
	$head_name = $L['my_trade'];
} elseif($action == 'home') {
	$head_name = $L['my_home'];
} else {
	$head_name = $L['my_title'];
}
$head_title = $MOD['name'].$AJ['seo_delimiter'].$head_title;
$foot = 'my';
include template('my', 'mobile');
if(AJ_CHARSET != 'UTF-8') toutf8();
?>