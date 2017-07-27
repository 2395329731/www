<?php
defined('IN_AIJIACMS') or exit('Access Denied');
$time = $today_endtime - 30*86400;
$db->query("DELETE FROM {$AJ_PRE}chat WHERE lasttime<$time");
?>