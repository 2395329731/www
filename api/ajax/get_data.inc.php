<?php
defined('IN_AIJIACMS') or exit('Access Denied');
if(!$_userid) exit;
isset($MODULE[$mid]) or exit;
$file = AJ_ROOT.'/file/user/'.dalloc($_userid).'/'.$_userid.'/editor.data.'.$mid.'.php';
$content = file_get($file);
if($content) {
	echo substr($content, 13);
} else {
	echo '';
}
?>