<?php
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
if(!check_group($_groupid, $MOD['group_index'])) include load('403.inc');
$maincat = get_maincat(0, $moduleid);
$seo_file = 'index';
include AJ_ROOT.'/include/seo.inc.php';
$aijiacms_task = "moduleid=$moduleid&html=index";
if($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'].mobileurl($moduleid, 0, 0, $page);
include template('index', $module);
?>