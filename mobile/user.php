<?php
require 'common.inc.php';
require 'user/extend.func.php';
require 'user/lang.inc.php';

$mid = isset($mid) ? intval($mid) : 0;
mobile_login();
if($mid) {
	include AJ_ROOT.'/module/member/admin.inc.php';
	$group_editor = $MG['editor'];
	in_array($group_editor, array('Default', 'Aijiacms', 'Simple', 'Basic')) or $group_editor = 'Aijiacms';
	$MST = cache_read('module-2.php');
	isset($admin_user) or $admin_user = false;
	$show_oauth = $MST['oauth'];
	$show_menu = $MST['show_menu'] ? true : false;
	$viewport = 0;
	if($_userid) $m_user = userinfo($_username);
	if(!$_userid) $action = 'add';//Guest
	if($_groupid > 5 && !$_edittime && $action == 'add') {
		//dlayerm('资料尚未完善','goback');
		dheader('edit.php');
	}
	if($action == 'add' || $action == 'edit') $foot = '';
	if($_groupid > 4 && (($MST['vemail'] && $MG['vemail']) || ($MST['vmobile'] && $MG['vmobile']) || ($MST['vtruename'] && $MG['vtruename']) || ($MST['vcompany'] && $MG['vcompany']) || ($MST['deposit'] && $MG['vdeposit']))) {
		$V = $db->get_one("SELECT vemail,vmobile,vtruename,vcompany,deposit FROM {$AJ_PRE}member WHERE userid=$_userid");
		if($MST['vemail'] && $MG['vemail']) {
			$V['vemail'] or dheader('/member/validate.php?action=email&itemid=1');
		}
		if($MST['vmobile'] && $MG['vmobile']) {
			$V['vmobile'] or dheader('/member/validate.php?action=mobile&itemid=1');
		}
		if($MST['vtruename'] && $MG['vtruename']) {
			$V['vtruename'] or dheader('/member/validate.php?action=truename&itemid=1');
		}
		if($MST['vcompany'] && $MG['vcompany']) {
			$V['vcompany'] or dheader('/member/validate.php?action=company&itemid=1');
		}
		if($MST['deposit'] && $MG['/member/vdeposit']) {
			$V['deposit'] > 99 or dheader('deposit.php?action=add&itemid=1');
		}
	}
	if($_credit < 0 && $MST['credit_less'] && $action == 'add') dheader('credit.php?action=less');
	if($submit) {
		check_post() or dalert($L['bad_data']);//safe
		$BANWORD = cache_read('banword.php');
		if($BANWORD && isset($post)) {
			$keys = array('title', 'tag', 'introduce', 'content');
			foreach($keys as $v) {
				if(isset($post[$v])) $post[$v] = banword($BANWORD, $post[$v]);
			}
		}
	}

	$MYMODS = array();
	if(isset($MG['moduleids']) && $MG['moduleids']) {
		$MYMODS = explode(',', $MG['moduleids']);
	}


	$vid = $mid;
	if($mid == 9 && isset($resume)) $vid = -9;
	//if(!$MYMODS || !in_array($vid, $MYMODS)) mobile_msg('');

	$IMVIP = isset($MG['vip']) && $MG['vip']; 
	$moduleid = $mid;
	$module = $MODULE[$moduleid]['module'];
	if(!$module) mobile_msg('');
	$MOD = cache_read('module-'.$moduleid.'.php');
	$my_file = 'user/'.$module.'.inc.php';
	//echo $my_file;
	if(is_file($my_file)) {
		require $my_file;
	} else {
		//dheader($MODULE[2]['linkurl']);
	}
} else {
	require 'user/'.$module.'.inc.php';
}
?>