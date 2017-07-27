<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
require MD_ROOT.'/member.class.php';
require AJ_ROOT.'/include/post.func.php';
$do = new member;

	$username = trim($username);
	$password = trim($password);
	$cookietime = isset($cookietime) ? 86400*30 : 0;
	$api_msg = $api_url = '';
	$option = isset($option) ? trim($option) : 'username';
	if(is_email($username) && $option == 'username') $option = 'email';
	if(!check_name($username) && $option == 'username') $option = 'passport';
	in_array($option, array('username', 'passport', 'email', 'mobile', 'company', 'userid')) or $option = 'username';
	$r = $db->get_one("SELECT username,passport FROM {$AJ_PRE}member WHERE `$option`='$username'");
	if($r) {
		$username = $r['username'];
		$passport = $r['passport'];
		
	} else {
		if($option == 'username' || $option == 'passport') {
			$passport = $username;
			if($option == 'username' && $MOD['passport']) {
				$r = $db->get_one("SELECT username FROM {$AJ_PRE}member WHERE `passport`='$username'");
				if($r) $username = $r['username'];
			}
		} else {
			message($L['login_msg_not_member'].'?');
		}
	}
	$user = $do->login($username, $password, $cookietime);
    $callback = trim($_GET['callback']);
if($user)
{

echo $callback.'({"data":"<ul class=\"fr\"><li class=\"top_z\"><a href=\"http:\/\/my.zhijia.com\/agent\/\" class=\"top_p\" title=\"\u6b22\u8fce\u4f60\uff1ahangzhou\"><img src=\"http:\/\/static.zhijia.com\/v2.1\/images\/common\/nophoto_45x45.gif\"><\/a><span class=\"msgl\">1<\/span><div class=\"top_lged\">\r\n\t\t\t\t\t\t<a href=\"http:\/\/my.zhijia.com\/agent\/\" class=\"top_p1\">\u7528\u6237\u4e2d\u5fc3<\/a>\r\n\t\t\t\t\t\t<a href=\"http:\/\/my.zhijia.com\/agent\/message\/\" class=\"top_p5\">\u77ed\u6d88\u606f<\/a>\r\n\t\t\t\t\t\t<a href=\"http:\/\/my.zhijia.com\/agent\/message\/sys\" class=\"top_p2\">\u7cfb\u7edf\u6d88\u606f(<span class=\"red\">1<\/span>)<\/a>\r\n\t\t\t\t\t\t<a href=\"http:\/\/my.zhijia.com\/agent\/credits\/\" class=\"top_p3\">\u6211\u7684\u79ef\u5206<\/a>\r\n\t\t\t\t\t\t<a href=\"http:\/\/passport.zhijia.com\/logout\/do\" class=\"top_p4\">\u9000\u51fa<\/a>\r\n\t\t\t\t\t<\/div><\/li><li><a href=\"http:\/\/help.zhijia.com\/\" class=\"top_h\" title=\"\u5e2e\u52a9\u4e2d\u5fc3\" target=\"_blank\">\u5e2e\u52a9\u4e2d\u5fc3<\/a><\/li>\r\n\t\t\t\t<li><a href=\"http:\/\/sjz.zhijia.com\/m\/\" class=\"top_m\" target=\"_blank\">\u624b\u673a\u7248<\/a>\r\n\t\t\t\t\t<div>\r\n\t\t\t\t\t\t<img src=\"http:\/\/static.zhijia.com\/v3\/images\/logo\/sjz\/qr.png\">\r\n\t\t\t\t\t<\/div>\r\n\t\t\t\t<\/li><\/ul>"})';
}
else
{
echo $callback.'({"data":"<form action=\"\/index.php?s=member\/index\/login\/inajax\/yes\" method=\"post\"><input type=\"hidden\" value=\"\" name=\"referer\">\u5e10\u53f7\uff1a<input name=\"username\" type=\"text\" required=\"required\"> \u5bc6\u7801\uff1a<input name=\"password\" type=\"password\" required=\"required\"> <button name=\"dosubmit\" type=\"submit\"><\/button><a href=\"\/register.html\" rel=\"nofollow\">\u6ce8\u518c<\/a> | <a href=\"\/forget_password.html\" rel=\"nofollow\">\u627e\u56de\u5bc6\u7801<\/a><\/form>"})';
}


?>