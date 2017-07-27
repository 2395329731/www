<?php
defined('IN_AIJIACMS') or exit('Access Denied');
require_once AJ_ROOT.'/module/member/global.func.php';
function home_pages($total, $pagesize, $demo_url, $page = 1) {
	global $MOD, $L;
	$pages = '';
	$items = $total;
	$total = ceil($total/$pagesize);
	$page = intval($page);
	$home_url = str_replace('{aijiacms_page}', '1', str_replace(array('%7B', '%7D'), array('{', '}'), $demo_url));
	include AJ_ROOT.'/api/pages.sample.php';
	return $pages;
}
?>