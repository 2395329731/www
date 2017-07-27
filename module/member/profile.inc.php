<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
login();
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
$user = userinfo($_username);
extract($user);
$expired = $totime && $totime < $AJ_TIME ? true : false;
$havedays = $expired ? 0 : ceil(($totime-$AJ_TIME)/86400);
$head_title = $L['profile_title'];
include template('profile', $module);
?>