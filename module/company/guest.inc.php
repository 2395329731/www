<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
$head_title = $L['guest_title'];
include template('guest', 'message');
?>