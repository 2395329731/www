<?php
/*
	[Aijiacms System] Copyright (c) 2011-2015 www.aijiacms.com

*/
$moduleid = 8;
require 'common.inc.php';
$itemid or dheader(mobileurl($moduleid));
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
include load('misc.lang');
$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");
$item or mobile_msg($L['not_exists']);
if($item['fromtime'] && $AJ_TIME > $item['fromtime']) mobile_msg($L['has_started']);
if($item['totime'] && $AJ_TIME > $item['totime']) mobile_msg($L['has_expired']);
$item['status'] == 3 or mobile_msg($L['not_exists']);
$item['username'] or mobile_msg($L['com_not_member']);
$_username != $item['username'] or mobile_msg($L['sign_self']);
$today = $today_endtime - 86400;
$sql = $_userid ? "username='$_username'" : "addtime>$today AND ip='$AJ_IP'";
$t = $db->get_one("SELECT id FROM {$table_order} WHERE id=$itemid AND $sql");
if($t) mobile_msg($L['sign_again']);
$linkurl = mobileurl($moduleid, 0, $itemid);
$need_captcha = $MOD['captcha_sign'] == 2 ? $MG['captcha'] : $MOD['captcha_sign'];
$head_name = $L['sign_title'];
$head_title = $head_name.$AJ['seo_delimiter'].$MOD['name'].$AJ['seo_delimiter'].$head_title;
$foot = '';
require AJ_ROOT.'/include/post.func.php';
if(isset($_POST['ok'])) {
	$captcha = isset($captcha) ? convert(input_trim($captcha), 'UTF-8', AJ_CHARSET) : '';
	$msg = captcha($captcha, $need_captcha, true);
	if($msg) exit('captcha');
	$amount = intval($amount);
	if($amount < 1) $amount = 1;
	$company = dhtmlspecialchars(convert(input_trim($company), 'UTF-8', AJ_CHARSET));
	$truename = dhtmlspecialchars(convert(input_trim($truename), 'UTF-8', AJ_CHARSET));
	if(strlen($truename) < 2*AJ_CHARLEN) exit('truename');
	if(!is_mobile($mobile)) exit('mobile');
	$areaid = intval($areaid);
	$address = dhtmlspecialchars(convert(input_trim($address), 'UTF-8', AJ_CHARSET));
	preg_match("/^[0-9]{6}$/", $postcode) or $postcode = '';
	is_email($email) or $email = '';
	is_qq($qq) or $qq = '';
	$content = dhtmlspecialchars(convert(input_trim($content), 'UTF-8', AJ_CHARSET));
	$user = $item['username'];
	$title = addslashes($item['title']);
	$db->query("INSERT INTO {$table_order} (id,user,title,amount,company,truename,mobile,areaid,address,postcode,email,qq,content,addtime,username,ip) VALUES ('$itemid','$user','$title','$amount','$company','$truename','$mobile','$areaid','$address','$postcode','$email','$qq','$content','$AJ_TIME','$_username','$AJ_IP')");
	$db->query("UPDATE {$table} SET orders=orders+1 WHERE itemid=$itemid");
	exit('ok');
}
if($_userid) {
	$user = userinfo($_username);
	$company = $user['company'];
	$truename = $user['truename'];
	$mobile = $user['mobile'];
	$areaid = $user['areaid'];
	$address = $user['address'];
	$postcode = $user['postcode'];
	$email = $user['mail'] ? $user['mail'] : $user['email'];
	$qq = $user['qq'];
} else {	
	$company = $truename = $mobile = $areaid = $address = $postcode = $email = $qq =  '';
}
include template('exhibit_sign', 'mobile');
if(AJ_CHARSET != 'UTF-8') toutf8();
?>