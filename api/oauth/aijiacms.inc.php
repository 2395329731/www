<?php
/*
	[Aijiacms System] Copyright (c) 2011-2015 www.aijiacms.com
*/
defined('IN_AIJIACMS') or exit('Access Denied');
function del_token($arr) {
	if($arr) {
		foreach($arr as $v) {
			$_SESSION[$v] = '';
		}
	}
}
if($success) {
	$U = $db->get_one("SELECT * FROM {$AJ_PRE}oauth WHERE openid='$openid' AND site='$site'");
	if($U) {
		$update = "logintimes=logintimes+1,logintime=$AJ_TIME";
		if($_username && $U['username'] != $_username) $update .= ",username='$_username'";
		if($U['nickname'] != $nickname) $update .= ",nickname='".addslashes($nickname)."'";
		if($U['avatar'] != $avatar) $update .= ",avatar='".addslashes($avatar)."'";
		if($U['url'] != $url) $update .= ",url='".addslashes($url)."'";
		$db->query("UPDATE {$AJ_PRE}oauth SET {$update} WHERE itemid=$U[itemid]");
	} else {
		$db->query("INSERT INTO {$AJ_PRE}oauth (username,site,openid,nickname,avatar,url,addtime,logintime,logintimes) VALUES ('$_username','$site','".addslashes($openid)."','".addslashes($nickname)."','".addslashes($avatar)."','".addslashes($url)."','$AJ_TIME','$AJ_TIME','1')");
		$U = array();
		$U['itemid'] = $db->insert_id();
		$U['username'] = $_username;
		$U['site'] = $site;
		$U['openid'] = $openid;
		$U['nickname'] = $nickname;
		$U['avatar'] = $avatar;
		$U['url'] = $url;
		$U['addtime'] = $AJ_TIME;
		$U['logintime'] = $AJ_TIME;
		$U['logintimes'] = 1;
	}
	if($_userid) {
		del_token($DS);
		dheader($MODULE[2]['linkurl'].'oauth.php');
	} else {
		if($U['username']) {
			include load('member.lang');
			$MOD = cache_read('module-2.php');
			include AJ_ROOT.'/include/module.func.php';
			include AJ_ROOT.'/module/member/member.class.php';
			$do = new member;
			$user = $do->login($U['username'], '', 0, true);
			if($user) {
				$forward = get_cookie('forward_url');
				if($forward) set_cookie('forward_url', '');
				if(strpos($forward, 'api/oauth') !== false) $forward = '';
				$forward or $forward = $MODULE[2]['linkurl'];
				if($AJ_TOUCH && strpos($forward, $EXT['mobile_url']) === false) $forward = $EXT['mobile_url'].'my.php';
				del_token($DS);
				$api_msg = '';
				if($MOD['passport'] == 'uc') {				
					$action = 'oauth';
					$passport = $user['passport'];
					include AJ_ROOT.'/api/'.$MOD['passport'].'.inc.php';
				}
				if($api_msg) message($api_msg, $forward, -1);
				dheader($forward);
			} else {
				message($do->errmsg, $MODULE[2]['linkurl'].$AJ['file_login']);
			}
		} else {
			set_cookie('bind', encrypt($U['itemid'].'|'.$site, AJ_KEY.'BIND'));
			if($AJ_TOUCH) {
				dheader($EXT['mobile_url'].'bind.php');
			} else {
				if(!get_cookie('oauth_site')) {
					set_cookie('oauth_user', $nickname);
					set_cookie('oauth_site', $site);
					dheader(AJ_PATH);
				}				
				$moduleid = 2;
				$module = 'member';
				$MOD = cache_read('module-2.php');
				include template('bind', 'member');
			}
		}
	}
} else {
	del_token($DS);
	set_cookie('oauth_user', '');
	set_cookie('oauth_site', '');
	dheader($MODULE[2]['linkurl'].$AJ['file_login'].'?error=oauth&step=userinfo&site='.$site);
}
?>