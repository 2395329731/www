<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
$filename = AJ_CACHE.'/htm/company.htm';
if(!$MOD['index_html']) {
	if(is_file($filename)) file_del($filename);
	return false;
}
if($AJ['rewrite']) {
	defined('AJ_REWRITE') or define('AJ_REWRITE', true);
	$_SERVER["SCRIPT_NAME"] = 'index.php';
	$_SERVER['QUERY_STRING'] = '';
}
$GLOBALS['AJ_URL'] = $AJ_URL = 'index.php';
$seo_file = 'index';
include AJ_ROOT.'/include/seo.inc.php';
$aijiacms_task = "moduleid=$moduleid&html=index";
if($page == 1) $head_canonical = $MOD['linkurl'];
if($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'].mobileurl($moduleid, 0, 0, $page);
ob_start();
include template('index', $module);
$data = ob_get_contents();
ob_clean();
file_put($filename, $data);
return true;
?>