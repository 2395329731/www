<?php
require 'common.inc.php';
$avatar = '';
if(!$_userid) {
	$auth = decrypt(get_cookie('bind'), AJ_KEY.'BIND');
	$openid = decrypt(get_cookie('weixin_openid'), AJ_KEY.'WXID');
	if(is_openid($openid) && $AJ_MOB['browser'] == 'weixin') {
		$U = $db->get_one("SELECT * FROM {$AJ_PRE}weixin_user WHERE openid='$openid'");
		if($U) {
			$OAUTH = cache_read('oauth.php');
			$nohead = AJ_PATH.'api/weixin/image/headimg.jpg';
			$avatar = $U['headimgurl'] ? $U['headimgurl'] : $nohead;
			$nickname = $U['nickname'] ? $U['nickname'] : 'USER';
			$site = $OAUTH['wechat']['name'];
			$connect = 'weixin.php?action=connect';
		}
	} else if(strpos($auth, '|') !== false) {
		$t = explode('|', $auth);
		$itemid = intval($t[0]);
		$U = $db->get_one("SELECT * FROM {$AJ_PRE}oauth WHERE itemid=$itemid");
		if($U && $U['site'] = $t[1]) {
			$OAUTH = cache_read('oauth.php');
			$nohead = AJ_PATH.'api/oauth/avatar.png';
			$avatar = $U['avatar'] ? $U['avatar'] : $nohead;
			$nickname = $U['nickname'] ? $U['nickname'] : 'USER';
			$site = $OAUTH[$U['site']]['name'];
			$connect = AJ_PATH.'api/oauth/'.$U['site'].'/connect.php';
		}
	}
}
if($avatar) {
	$head_title = $L['bind_title'].$AJ['seo_delimiter'].$head_title;
	$foot = 'my';
	include template('bind', 'mobile');
	if(AJ_CHARSET != 'UTF-8') toutf8();
	exit;
}
dheader('my.php?reload='.$AJ_TIME);
?>