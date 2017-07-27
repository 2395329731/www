<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
$fileroot = AJ_ROOT.'/'.$MOD['moduledir'].'/';
$filename = $fileroot.$AJ['index'].'.'.$AJ['file_ext'];
if(!$MOD['index_html']) {
	if(is_file($filename)) unlink($filename);
	return false;
}
$maincat = get_maincat(0, $moduleid, 1);
$seo_file = 'index';
include AJ_ROOT.'/include/seo.inc.php';
$template = $MOD['template_index'] ? $MOD['template_index'] : 'index';
$aijiacms_task = "moduleid=$moduleid&html=index";
if($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'].mobileurl($moduleid, 0, 0, $page);
ob_start();
include template($template, $module);
$data = ob_get_contents();
ob_clean();
file_put($filename, $data);
return true;
?>