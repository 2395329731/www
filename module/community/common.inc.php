<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
define('MD_ROOT', AJ_ROOT.'/module/'.$module);
require AJ_ROOT.'/include/module.func.php';
require MD_ROOT.'/global.func.php';
$table = $AJ_PRE.'newhouse_6';
$table_data = $AJ_PRE.'newhouse_data_6';
$table_search = $AJ_PRE.'newhouse_search_6';
$TYPE = explode('|', trim($MOD['type']));
?>