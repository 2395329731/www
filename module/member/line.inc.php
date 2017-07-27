<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
login();
$forward or $forward = AJ_PATH;
$online = $_online ? 0 : 1;
$db->query("UPDATE {$AJ_PRE}member SET online=$online WHERE userid=$_userid");
$db->query("UPDATE {$AJ_PRE}online SET online=$online WHERE userid=$_userid");
dheader($forward);
?>