<?php
/*
	 
	This is NOT a freeware, use is subject to license.txt
*/
define('AJ_MOBILE', true);
require substr(str_replace("\\", '/', dirname(__FILE__)), 0, -7).'/common.inc.php';
require AJ_ROOT.'/mobile/include/global.func.php';
if(is_pc()) dheader($EXT['mobile_url'].'mobile.php?action=device');
if(AJ_CHARSET != 'UTF-8') header("Content-type:text/html; charset=utf-8");
include load('mobile.lang');
$EXT['mobile_enable'] or mobile_msg($L['msg_mobile_close']);
if($AJ_BOT) $EXT['mobile_ajax'] = 0;
$_mobile = get_cookie('mobile');
if($_mobile == '' || $_mobile == 'pc') {
	set_cookie('mobile', 'touch', $AJ_TIME + 30*86400);
}
$UA = strtoupper($_SERVER['HTTP_USER_AGENT']);
$back_link = $head_link = $head_name = '';
$mobile_modules = array('member', 'newhouse', 'sale','rent', 'buy', 'company', 'article', 'info',  'video', 'photo');
$pages = '';
$areaid = isset($areaid) ? intval($areaid) : 0;
$site_name = $head_title = $EXT['mobile_sitename'] ? $EXT['mobile_sitename'] : $AJ['sitename'].$L['mobile_version'];
$kw = $kw ? strip_kw(decrypt($kw, AJ_KEY.'KW')) : '';
if(strlen($kw) < $AJ['min_kw'] || strlen($kw) > $AJ['max_kw']) $kw = '';
$keyword = $kw ? str_replace(array(' ', '*'), array('%', '%'), $kw) : '';
$MURL = $MODULE[2]['linkurl'];
if($AJ_MOB['browser'] == 'screen' && $_username) $MURL = 'mobile.php?action=sync&auth='.encrypt($_username.'|'.$AJ_IP.'|'.$AJ_TIME, AJ_KEY.'SCREEN').'&goto=';
$_cart = (isset($MODULE[16]) && $_userid) ? intval(get_cookie('cart')) : 0;
$share_icon = ($AJ_MOB['browser'] == 'weixin' || $AJ_MOB['browser'] == 'qq') ? AJ_PATH.'apple-touch-icon-precomposed.png' : '';
$MOB_MODULE = array();
foreach($MODULE as $v) {
	if(in_array($v['module'], $mobile_modules) && $v['module'] != 'member' && $v['ismenu']) $MOB_MODULE[] = $v;
}
$foot = 'channel';
?>