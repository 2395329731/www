<?php
/*
	[Aijiacms System] Copyright (c) 2011-2015 www.aijiacms.com
*/
defined('AJ_ADMIN') or exit('Access Denied');
$menus = array (
    array('文件备份', '?file=patch'),
    array('木马扫描', '?file=scan'),
    array('文件校验', '?file=md5'),
);
$sys = array('admin', 'api', 'include', 'lang', 'module', 'template', 'mobile');
$fbs = array('file');
switch($action) {
	case 'delete':
		preg_match("/^[0-9]{4}[\-]{1}[0-9]{2}[\-]{1}[0-9]{2}[\s]{1}[0-9]{2}[\.]{1}[0-9]{2}$/", $mirror) or msg('请选择镜像文件');
		file_del(AJ_ROOT.'/file/md5/'.$mirror.'.php');
		dmsg('删除成功', '?file='.$file);
	break;
	case 'add':
		$filedir or $filedir = $sys;
		$fileext or $fileext = 'php|js|htm';
		$files = array();
		foreach(glob(AJ_ROOT.'/*.*') as $f) {
			if(preg_match("/(config\.inc\.php|version\.inc\.php)$/i", $f)) continue;
			if(preg_match("/\.($fileext)$/i", $f)) $files[] = $f;
		}
		foreach($filedir as $d) {
			$files = array_merge($files, get_file(AJ_ROOT.'/'.$d, $fileext));
		}
		$data = '<?php exit;?>';
		foreach($files as $f) {
			if(preg_match("/(index\.html|these\.name\.php)$/i", $f)) continue;
			$data .= md5_file($f).' '.str_replace(AJ_ROOT.'/', '', $f)."\n";
		}
		file_put(AJ_ROOT.'/file/md5/'.timetodate($AJ_TIME, 'Y-m-d H.i').'.php', $data);
		is_file(AJ_ROOT.'/file/md5/'.AJ_VERSION.'.php') or file_put(AJ_ROOT.'/file/md5/'.AJ_VERSION.'.php', $data);
		if(isset($js)) exit;
		dmsg('创建成功', '?file='.$file);
	break;
	default:
		if($submit) {
			$mirror or $mirror = AJ_VERSION;
			$mirror = $mirror.'.php';
			is_file(AJ_ROOT.'/file/md5/'.$mirror) or msg('请选择镜像文件');
			$filedir or $filedir = $sys;
			$fileext or $fileext = 'php|js|htm';
			$files = array();
			foreach(glob(AJ_ROOT.'/*.*') as $f) {
				if(preg_match("/(config\.inc\.php|version\.inc\.php)$/i", $f)) continue;
				if(preg_match("/\.($fileext)$/i", $f)) $files[] = $f;
			}
			foreach($filedir as $d) {
				$files = array_merge($files, get_file(AJ_ROOT.'/'.$d, $fileext));
			}
			$lists = array();
			foreach($files as $f) {
				if(preg_match("/(index\.html|these\.name\.php)$/i", $f)) continue;
				$lists[md5_file($f)] = str_replace(AJ_ROOT.'/', '', $f);
			}
			$content = substr(trim(file_get(AJ_ROOT.'/file/md5/'.$mirror)), 13);
			foreach(explode("\n", $content) as $v) {
				list($m, $f) = explode(' ', trim($v));
				if(isset($lists[$m]) && $lists[$m] == $f) unset($lists[$m]);
			}
		} else {
			is_file(AJ_ROOT.'/file/md5/'.AJ_VERSION.'.php') or msg('正在创建镜像文件..', '?file='.$file.'&action=add');
			$files = glob(AJ_ROOT.'/*');
			$dirs = $rfiles = array();
			foreach($files as $f) {
				if(is_file($f)) {
					$rfiles[] = basename($f);
				} else {
					$dirs[] = basename($f);
				}
			}
			$mfiles = glob(AJ_ROOT.'/file/md5/*.php');
		}
		include tpl('md5');
	break;
}
?>