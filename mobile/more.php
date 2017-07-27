<?php
require 'common.inc.php';
$head_title = $L['more_title'].$AJ['seo_delimiter'].$head_title;
$app = '';
if(!in_array($AJ_MOB['browser'], array('app', 'b2b'))) {
	if($AJ_MOB['os'] == 'ios') {
		if($EXT['mobile_ios']) {
			if(preg_match("/^([0-9]{1,})@([a-z0-9]{16,})$/i", $EXT['mobile_ios'])) {
				$app = AJ_PATH.'api/app.php';
			} else {
				$app = $EXT['mobile_ios'];
			}
		}
	} else if($AJ_MOB['os'] == 'android') {
		if($EXT['mobile_adr']) {
			if(preg_match("/^([0-9]{1,})@([a-z0-9]{16,})$/i", $EXT['mobile_adr'])) {
				$app = AJ_PATH.'api/app.php';
			} else {
				$app = $EXT['mobile_adr'];
			}
		}
	}
}
$foot = 'more';
include template('more', 'mobile');
if(AJ_CHARSET != 'UTF-8') toutf8();
?>