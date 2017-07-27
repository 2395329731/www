<?php
defined('AJ_ADMIN') or exit('Access Denied');
$db->query("DROP TABLE IF EXISTS `".$AJ_PRE.$module."_".$moduleid."`");
$db->query("DROP TABLE IF EXISTS `".$AJ_PRE.$module."_data_".$moduleid."`");
$db->query("DROP TABLE IF EXISTS `".$AJ_PRE.$module."_item_".$moduleid."`");
?>