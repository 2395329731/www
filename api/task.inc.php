<?php
defined('IN_AIJIACMS') or exit('Access Denied');
if($AJ_BOT) {
	//
} else {
	include template('line', 'chip');
	$db->close();
}
?>