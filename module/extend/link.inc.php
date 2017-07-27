<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
$MOD['link_enable'] or dheader(AJ_PATH);
require AJ_ROOT.'/include/post.func.php';
$ext = 'link';
$url = $EXT[$ext.'_url'];
$TYPE = get_type($ext, 1);
$_TP = sort_type($TYPE);
require MD_ROOT.'/'.$ext.'.class.php';
$do = new dlink();
$typeid = isset($typeid) ? intval($typeid) : 0;
$aijiacms_task = rand_task();
if($action == 'reg') {
	$MOD['link_reg'] or message($L['link_reg_close']);
	if($submit) {
		captcha($captcha, 1);
		$post = dhtmlspecialchars($post);
		if($do->pass($post)) {
			$r = $db->get_one("SELECT itemid FROM {$AJ_PRE}link WHERE linkurl='$post[linkurl]' AND username=''");
			if($r) message($L['link_url_repeat']);
			$post['status'] = 2;
			$post['level'] = 0;
			$post['areaid'] = $cityid;
			$do->add($post);
			message($L['link_check'], $url);
		} else {
			message($do->errmsg);
		}
	} else {
		$type_select = type_select($TYPE, 1, 'post[typeid]', $L['link_choose_type'], 0, 'id="typeid"');
		$head_title = $L['link_reg'].$AJ['seo_delimiter'].$L['link_title'];
		include template($ext, $module);
	}
} else {
	$head_title = $L['link_title'];
	if($catid) $typeid = $catid;
	if($typeid) {
		isset($TYPE[$typeid]) or dheader($url);
		$head_title = $TYPE[$typeid]['typename'].$AJ['seo_delimiter'].$head_title;
	}
	include template($ext, $module);
}
?>