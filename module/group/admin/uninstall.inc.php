<?php
defined('AJ_ADMIN') or exit('Access Denied');
$db->query("DROP TABLE IF EXISTS `".$AJ_PRE.$module."`");
$db->query("DROP TABLE IF EXISTS `".$AJ_PRE.$module."_data`");
$db->query("DROP TABLE IF EXISTS `".$AJ_PRE.$module."_order`");
?>