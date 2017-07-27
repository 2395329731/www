<?php
defined('IN_AIJIACMS') or exit('Access Denied');
$time = $today_endtime - 90*86400;
$db->query("DELETE FROM {$AJ_PRE}finance_credit WHERE addtime<$time");
?>