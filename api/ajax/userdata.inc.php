<?php
defined('IN_AIJIACMS') or exit('Access Denied');
if(!$_userid) exit;
isset($MODULE[$mid]) or exit;
if($job == 'get') {
	$file = AJ_ROOT.'/file/user/'.dalloc($_userid).'/'.$_userid.'/editor.data.'.$mid.'.php';
	$content = file_get($file);
	if($content) {
		echo substr($content, 13);
	} else {
		echo '';
	}
} else {
	if(!$content) exit;
	$content = stripslashes($content);
	$content = convert($content, 'UTF-8', AJ_CHARSET);
	$content = '<?php exit;?>'.timetodate($AJ_TIME).$content;
	file_put(AJ_ROOT.'/file/user/'.dalloc($_userid).'/'.$_userid.'/editor.data.'.$mid.'.php', $content);
}
?>