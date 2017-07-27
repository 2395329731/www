<?php
/*
	[Aijiacms System] Copyright (c) 2011-2015 www.aijiacms.com
*/
defined('IN_AIJIACMS') or exit('Access Denied');
if(!function_exists('file_put_contents')) {
	define('FILE_APPEND', 8);
	function file_put_contents($file, $string, $append = '') {
		$mode = $append == '' ? 'wb' : 'ab';
		$fp = @fopen($file, $mode) or exit("Can not open $file");
		flock($fp, LOCK_EX);
		$stringlen = @fwrite($fp, $string);
		flock($fp, LOCK_UN);
		@fclose($fp);
		return $stringlen;
	}
}

function file_ext($filename) {
	return strtolower(trim(substr(strrchr($filename, '.'), 1)));
}

function file_vname($name) {
	if(strpos($name, '/') === false) return str_replace(array(' ', '\\', ':', '*', '?', '"', '<', '>', '|', "'", '$', '&', '%', '#', '@'), array('-', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''), $name);
	$tmp = explode('/', $name);
	$str = '';
	foreach($tmp as $k=>$v) {
		$str .= ($k ? '/' : '').file_vname($v);
	}
	return $str;
}

function file_down($file, $filename = '', $data = '') {
	if(!$data && !is_file($file)) exit;
	$filename = $filename ? $filename : basename($file);
	$filetype = file_ext($filename);
	$filesize = $data ? strlen($data) : filesize($file);
    ob_end_clean();
	@set_time_limit(0);
	if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false) {
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
	} else {
		header('Pragma: no-cache');
	}
	header('Expires: '.gmdate('D, d M Y H:i:s').' GMT');
	header('Content-Encoding: none');
	header('Content-Length: '.$filesize);
	header('Content-Disposition: attachment; filename='.$filename);
	header('Content-Type: '.$filetype);
	if($data) { echo $data; } else { readfile($file); }
	exit;
}

function file_list($dir, $fs = array()) {
	$files = glob($dir.'/*');
	if(!is_array($files)) return $fs;
	foreach($files as $file) {
		if(is_dir($file)) {
			$fs = file_list($file, $fs);
		} else {
			$fs[] = $file;
		}
	}
	return $fs;
}

function file_copy($from, $to) {
	dir_create(dirname($to));
	if(is_file($to) && AJ_CHMOD) @chmod($to, AJ_CHMOD);	
	if(strpos($from, AJ_PATH) !== false) $from = str_replace(AJ_PATH, AJ_ROOT.'/', $from);
	if(@copy($from, $to)) {
		if(AJ_CHMOD) @chmod($to, AJ_CHMOD);
		return true;
	} else {
		return false;
	}
}

function file_put($filename, $data) {
	dir_create(dirname($filename));	
	if(@$fp = fopen($filename, 'wb')) {
		flock($fp, LOCK_EX);
		$len = fwrite($fp, $data);
		flock($fp, LOCK_UN);
		fclose($fp);
		if(AJ_CHMOD) @chmod($filename, AJ_CHMOD);
		return $len;
	} else {
		return false;
	}
}

function file_get($filename) {
	return @file_get_contents($filename);
}

function file_del($filename) {
	if(AJ_CHMOD) @chmod($filename, AJ_CHMOD);
	return is_file($filename) ? @unlink($filename) : false;
}

function dir_path($dirpath) {
	$dirpath = str_replace('\\', '/', $dirpath);
	if(substr($dirpath, -1) != '/') $dirpath = $dirpath.'/';
	return $dirpath;
}

function dir_create($path) {
	if(is_dir($path)) return true;
	if(AJ_CACHE != AJ_ROOT.'/file/cache' && strpos($path, AJ_CACHE) !== false) {
		$dir = str_replace(AJ_CACHE.'/', '', $path);
		$dir = dir_path($dir);
		$temp = explode('/', $dir);
		$cur_dir = AJ_CACHE.'/';
		$max = count($temp) - 1;
		for($i = 0; $i < $max; $i++) {
			$cur_dir .= $temp[$i].'/';
			if(is_dir($cur_dir)) continue;
			@mkdir($cur_dir);
			if(AJ_CHMOD) @chmod($cur_dir, AJ_CHMOD);
		}
	} else {
		$dir = str_replace(AJ_ROOT.'/', '', $path);
		$dir = dir_path($dir);
		$temp = explode('/', $dir);
		$cur_dir = AJ_ROOT.'/';
		$max = count($temp) - 1;
		for($i = 0; $i < $max; $i++) {
			$cur_dir .= $temp[$i].'/';
			if(is_dir($cur_dir)) continue;
			@mkdir($cur_dir);
			if(AJ_CHMOD) @chmod($cur_dir, AJ_CHMOD);
		}
	}
	return is_dir($path);
}

function dir_chmod($dir, $mode = '', $require = 0) {
	if(!$require) $require = substr($dir, -1) == '*' ? 2 : 0;
	if($require) {
		if($require == 2) $dir = substr($dir, 0, -1);
	    $dir = dir_path($dir);
		$list = glob($dir.'*');
		foreach($list as $v) {
			if(is_dir($v)) {
				dir_chmod($v, $mode, 1);
			} else {
				@chmod(basename($v), $mode);
			}
		}
	}
	if(is_dir($dir)) {
		@chmod($dir, $mode);
	} else {
		@chmod(basename($dir), $mode);
	}
}

function dir_copy($fromdir, $todir) {
	$fromdir = dir_path($fromdir);
	$todir = dir_path($todir);
	if(!is_dir($fromdir)) return false;
	if(!is_dir($todir)) dir_create($todir);
	$list = glob($fromdir.'*');
	foreach($list as $v) {
		$path = $todir.basename($v);
		if(is_file($path) && !is_writable($path)) {
			if(AJ_CHMOD) @chmod($path, AJ_CHMOD);
		}
		if(is_dir($v)) {
		    dir_copy($v, $path);
		} else {
			@copy($v, $path);
			if(AJ_CHMOD) @chmod($path, AJ_CHMOD);
		}
	}
    return true;
}

function dir_delete($dir) {
	$dir = dir_path($dir);
	if(!is_dir($dir)) return false;
	$dirs = array(AJ_ROOT.'/admin/', AJ_ROOT.'/api/', AJ_CACHE.'/', AJ_ROOT.'/file/', AJ_ROOT.'/include/', AJ_ROOT.'/lang/', AJ_ROOT.'/member/', AJ_ROOT.'/module/', AJ_ROOT.'/skin/', AJ_ROOT.'/template/', AJ_ROOT.'/mobile/');
	if(substr($dir, 0, 1) == '.' || in_array($dir, $dirs)) die("Cannot Remove System DIR $dir ");
	$list = glob($dir.'*');
	if($list) {
		foreach($list as $v) {
			is_dir($v) ? dir_delete($v) : @unlink($v);
		}
	}
    return @rmdir($dir);
}

function get_file($dir, $ext = '', $fs = array()) {
	$files = glob($dir.'/*');
	if(!is_array($files)) return $fs;
	foreach($files as $file) {
		if(is_dir($file)) {
			if(is_file($file.'/index.php') && is_file($file.'/config.inc.php')) continue;
			$fs = get_file($file, $ext, $fs);
		} else {
			if($ext) {
				if(preg_match("/\.($ext)$/i", $file)) $fs[] = $file;
			} else {
				$fs[] = $file;
			}
		}
	}
	return $fs;
}

function is_write($file) {
	if(AJ_WIN) {
		if(substr($file, -1) == '/') {
			if(is_dir($file)) {
				$file = $file.'writeable-test.tmp';
				if(@$fp = fopen($file, 'a')) {
					flock($fp, LOCK_EX);
					fwrite($fp, 'OK');
					flock($fp, LOCK_UN);
					fclose($fp);
					$tmp = file_get_contents($file);
					unlink($file);
					if($tmp == 'OK') return true;
				}
				return false;
			} else {
				dir_create($file);
				if(is_dir($file)) return is_write($file);
				return false;
			}
		} else {
			if(@$fp = fopen($file, 'a')) {
				fclose($fp);
				return true;
			}
			return false;
		}
	} else {
		return is_writeable($file);
	}
}
?>