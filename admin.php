<?php
/*
	[Aijiacms System] Copyright (c) 2011-2015 www.aijiacms.com
	This is NOT a freeware, use is subject to license.txt
*/
@set_time_limit(0);
define('AJ_ADMIN', true);
define('AJ_MEMBER', true);
require 'common.inc.php';
if($AJ_BOT) dhttp(403);
$_areaids = '';
$_areaid = array();
if($AJ['city']) {
	$AREA or $AREA = cache_read('area.php');
	if($_aid) {
		$_areaids = $AREA[$_aid]['child'] ? $AREA[$_aid]['arrchildid'] : $_aid;
		$_areaid = explode(',', $_areaids);
	}
} else {
	$_aid < 1 or dalert('系统未开启分站功能，您的分站管理帐号暂不可用', $MODULE[2]['linkurl'].'logout.php');
}
require AJ_ROOT.'/admin/global.func.php';
require AJ_ROOT.'/admin/license.func.php';
require AJ_ROOT.'/include/post.func.php';
require_once AJ_ROOT.'/include/cache.func.php';
isset($file) or $file = 'index';
$secretkey = 'a'.strtolower(substr(md5(AJ_KEY), -6));
if($CFG['authadmin'] == 'cookie') {
	$_aijiacms_admin = get_cookie($secretkey);
	$_aijiacms_admin = $_aijiacms_admin ? intval($_aijiacms_admin) : 0;
} else {
	$session = new dsession();
	$_aijiacms_admin = isset($_SESSION[$secretkey]) ? intval($_SESSION[$secretkey]) : 0;
}
$_founder = $CFG['founderid'] == $_userid ? $_userid : 0;
$_catids = $_childs = '';
$_catid = $_child = array();
if($file != 'login') {
	if($_groupid != 1 || $_admin < 1 || !$_aijiacms_admin) msg('', '?file=login&forward='.urlencode($AJ_URL));
	if(!admin_check()) {
		admin_log(1);
		$db->query("DELETE FROM {$db->pre}admin WHERE userid=$_userid AND url='?".$AJ_QST."'");
		msg('警告！您无权进行此操作 Error(00)');
	}
}
if($AJ['admin_log'] && $action != 'import') admin_log();
if($AJ['admin_online']) admin_online();
if(isset($reason) && is_array($itemid)) admin_notice();
$widget = isset($widget) ? intval($widget) : 0;
$psize = isset($psize) ? intval($psize) : 0;
if($psize > 0 && $psize != $pagesize) {
	$pagesize = $psize;
	$offset = ($page-1)*$pagesize;
}
if($module == 'aijiacms') {
	(include AJ_ROOT.'/admin/'.$file.'.inc.php') or msg();
} else {
	include AJ_ROOT.'/module/'.$module.'/common.inc.php';
	(include MD_ROOT.'/admin/'.$file.'.inc.php') or msg();
}
?>