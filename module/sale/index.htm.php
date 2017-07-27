<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
$fileroot = AJ_ROOT.'/'.$MOD['moduledir'].'/';
$filename = $fileroot.$AJ['index'].'.'.$AJ['file_ext'];
if(!$MOD['index_html']) {
	if(is_file($filename)) unlink($filename);
	return false;
}
if($AJ['rewrite']) {
	defined('AJ_REWRITE') or define('AJ_REWRITE', true);
	$_SERVER["SCRIPT_NAME"] = 'index.php';
	$_SERVER['QUERY_STRING'] = '';
}
$GLOBALS['AJ_URL'] = $AJ_URL = 'index.php';
$typeid = 99;
$dtype = '';
$maincat = get_maincat(0, $moduleid);
if($page == 1) $head_canonical = $MOD['linkurl'];
$seo_file = 'index';
include AJ_ROOT.'/include/seo.inc.php';
$aijiacms_task = "moduleid=$moduleid&html=index";
if($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'].mobileurl($moduleid, 0, 0, $page);
ob_start();
include template($MOD['template_index'] ? $MOD['template_index'] : 'index', $module);
$data = ob_get_contents();
ob_clean();
file_put($filename, $data);
return true;
?>