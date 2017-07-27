<?php
defined('IN_AIJIACMS') or exit('Access Denied');
function nexttime($schedule, $time) {
	if(strpos($schedule, ',') !== false) {
		list($h, $m) = explode(',', $schedule);
		$t = strtotime(timetodate($time, 3).' '.($h < 10 ? '0'.$h : $h).':'.($m < 10 ? '0'.$m : $m).':00');
		return $t > $time ? $t : $t + 86400;
	} else {
		$m = intval($schedule);
		return $time + ($m ? $m : 1800)*60;
	}
}
$result = $db->query("SELECT * FROM {$AJ_PRE}cron WHERE nexttime<$AJ_TIME ORDER BY itemid");
while($cron = $db->fetch_array($result)) {
	if($cron['status']) continue;
	include AJ_ROOT.'/api/cron/'.$cron['name'].'.inc.php';
	$nexttime = nexttime($cron['schedule'], $AJ_TIME);
	$db->query("UPDATE {$AJ_PRE}cron SET lasttime=$AJ_TIME,nexttime=$nexttime WHERE itemid=$cron[itemid]");
}
if($AJ['message_email'] && $AJ['mail_type'] != 'close' && !$_userid) include AJ_ROOT.'/api/cron/message.php';
?>