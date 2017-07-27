<?php
/*
	 
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_AIJIACMS') or exit('Access Denied');
function dcloud($url) {
	$arr = explode('->', $url);
	$url = 'http://cloud.aijiacms.com/'.$arr[0].'/';
	$par = $arr[1].'&version='.AJ_VERSION.'&release='.AJ_RELEASE.'&charset='.AJ_CHARSET.'&domain='.(AJ_DOMAIN ? AJ_DOMAIN : AJ_PATH).'&uid='.AJ_CLOUD_UID.'&auth='.encrypt($arr[1], AJ_CLOUD_KEY);
	return dcurl($url, $par);
}

function mobile2area($mobile) {
	global $AJ_TIME;
	if(!is_mobile($mobile)) return 'Unknown';
	$cid = AJ_ROOT.'/file/cloud/mobile/'.substr($mobile, 0, 3).'/'.substr($mobile, 3, 4).'/'.$mobile.'.php';
	if(is_file($cid) && $AJ_TIME - filemtime($cid) < 86400*90) {
		$rec = substr(file_get($cid), 13);
	} else {
		$rec = dcloud('mobile->mobile='.$mobile);
		if(substr($rec, 0, 4) !== 'ERR:') file_put($cid, '<?php exit;?>'.$rec);
	}
	return $rec ? convert($rec, 'UTF-8', AJ_CHARSET) : 'Unknown';
}
?>