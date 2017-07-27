<?php
define('AJ_REWRITE', true);
require '../common.inc.php';
$hname = safe_replace(trim($_GET['hname']));
$hid = safe_replace(trim($_GET['hid']));
login();
$head_title = '推荐客户--分销平台';
	include template('tuijian', 'fenxiao');
	

?>