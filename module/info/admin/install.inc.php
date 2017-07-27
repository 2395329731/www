<?php
defined('AJ_ADMIN') or exit('Access Denied');
$setting = include(AJ_ROOT.'/file/setting/module-22.php');
update_setting($moduleid, $setting);
$sql = file_get(AJ_ROOT.'/file/setting/'.$module.'.sql');
$sql = str_replace('_22', '_'.$moduleid, $sql);
$sql = str_replace('招商', $modulename, $sql);
sql_execute($sql);
include AJ_ROOT.'/module/'.$module.'/admin/remkdir.inc.php';
?>