<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
define('MD_ROOT', AJ_ROOT.'/module/'.$module);
require AJ_ROOT.'/include/module.func.php';
require MD_ROOT.'/global.func.php';
$table = $AJ_PRE.$module.'_'.$moduleid;
$table_data = $AJ_PRE.$module.'_data_'.$moduleid;
$TYPE = explode('|', trim($MOD['type']));
?>