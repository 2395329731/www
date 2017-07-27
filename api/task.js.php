<?php
@set_time_limit(0);
#@ignore_user_abort(true);
define('AJ_TASK', true);
require '../common.inc.php';
check_referer() or exit;
if($AJ_BOT) exit;
#header("Content-type:text/javascript");	
include template('line', 'chip');
$db->linked or exit;
isset($html) or $html = '';
if($html) {
	$task_index = intval($AJ['task_index']);
	$task_index > 60 or $task_index = 300;
	$task_list = intval($AJ['task_list']);
	$task_list > 300 or $task_list = 1800;
	$task_item = intval($AJ['task_item']);
	$task_item > 1800 or $task_item = 3600;
	if($moduleid == 1) {
		if($AJ['index_html'] && $AJ_TIME - @filemtime(AJ_ROOT.'/'.$AJ['index'].'.'.$AJ['file_ext']) > $task_index) tohtml('index');
	} else {
		include AJ_ROOT.'/module/'.$module.'/common.inc.php';
		include AJ_ROOT.'/module/'.$module.'/task.inc.php';
	}
}
include AJ_ROOT.'/api/cron.inc.php';
$db->close();
?>