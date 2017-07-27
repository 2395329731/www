<?php
defined('IN_AIJIACMS') or exit('Access Denied');
$time = $today_endtime - 3*86400;
$db->query("DELETE FROM {$AJ_PRE}finance_charge WHERE status=0 AND sendtime<$time");
?>