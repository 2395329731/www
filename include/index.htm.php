<?php
/*
	 
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_AIJIACMS') or exit('Access Denied');
if($AJ['city']) {
	$AJ['index_html'] = 0;
	$C = cache_read('module-2.php');
	$M = $C['linkurl'];
} else {
	$M = $MODULE[2]['linkurl'];
}
$data = '';
$data .= 'var DTPath = "'.AJ_PATH.'";';
$data .= 'var SKPath = "'.AJ_SKIN.'";';
$data .= 'var MEPath = "'.$M.'";';
$data .= 'var DTEditor = "'.AJ_EDITOR.'";';
$data .= 'var CKDomain = "'.$CFG['cookie_domain'].'";';
$data .= 'var CKPath = "'.$CFG['cookie_path'].'";';
$data .= 'var CKPrex = "'.$CFG['cookie_pre'].'";';
file_put(AJ_ROOT.'/file/script/config.js', $data);
$filename = $CFG['com_dir'] ? AJ_ROOT.'/'.$AJ['index'].'.'.$AJ['file_ext'] : AJ_CACHE.'/index.inc.html';
if(!$AJ['index_html']) {
	if(is_file($filename)) unlink($filename);
	return false;
}
if(!$db->linked) return false;
$aijiacms_task = "moduleid=1&html=index";
$AREA = cache_read('area.php');
if($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'];
$index = 1;
$seo_title = $AJ['seo_title'];
$head_keywords = $AJ['seo_keywords'];
$head_description = $AJ['seo_description'];
ob_start();
include template('index');
$data = ob_get_contents();
ob_clean();
file_put($filename, $data);
return true;
?>