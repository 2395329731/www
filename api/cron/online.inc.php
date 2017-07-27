<?php
defined('IN_AIJIACMS') or exit('Access Denied');
$lastime = $AJ_TIME - $AJ['online'];
$db->query("DELETE FROM {$AJ_PRE}online WHERE lasttime<$lastime");
?>