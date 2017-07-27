<?php
define('AJ_REWRITE', true);
require '../common.inc.php';
require AJ_ROOT.'/module/member/kehu.class.php';
$do = new kehu();
login();
$head_title = '我已推荐的买房人--分销平台';

$table=$AJ_PRE.'fenxiao';
$status="status IN ('0','1', '2', '3', '4','5')";
$_status = array(
    '<span style="color:#0000FF;">待受理</span>',
	'<span style="color:#0000FF;">已预约</span>',
	'<span style="color:#FF0000;">已到访</span>',
	'<span style="color:#FF6600;">已交定金</span>',
	'<span style="color:#008000;">已成交</span>',
);
$st = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE tuijian='$_username' ");
		$sy= $st['num'];
if($_userid) {
	$nums = array();
	for($i = 1; $i < 5; $i++) {
		$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE tuijian='$_username' AND status=$i");
		$nums[$i] = $r['num'];
	}
	//$nums[0] = count($MTYPE);
}
$condition=" and tuijian='$_username'";
$lists = $do->get_list($status.$condition);
	include template('client', 'mobile');
	

?>