<?php
defined('IN_AIJIACMS') or exit('Access Denied');
header("Content-Type:text/html;charset=UTF-8");
if($EXT['mobile_enable']) {
	$str = $EXT['mobile_sitename'] ? $EXT['mobile_sitename'] : $AJ['sitename'];
	$str .= '#AIJIACMS#';
	$str .= $EXT['mobile_url'];
	echo convert($str, AJ_CHARSET, 'UTF-8');
} else {
	echo '0';
}
?>