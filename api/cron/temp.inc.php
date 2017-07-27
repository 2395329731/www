<?php
defined('IN_AIJIACMS') or exit('Access Denied');
$F = glob(AJ_ROOT.'/file/temp/*');
if($F) {
	foreach($F as $k=>$v) {
		if(is_dir($v)) {
			dir_delete($v);
		} else {
			if(basename($v) == 'index.html') continue;
			file_del($v);
		}
	}
}
?>