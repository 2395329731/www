<?php
defined('IN_AIJIACMS') or exit('Access Denied');
$setting = include(AJ_ROOT.'/file/setting/module-'.$moduleid.'.php');
update_setting($moduleid, $setting);
$sql = file_get(AJ_ROOT.'/file/setting/'.$module.'.sql');
sql_execute($sql);
include AJ_ROOT.'/module/'.$module.'/admin/remkdir.inc.php';
?>