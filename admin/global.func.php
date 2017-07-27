<?php
/*
	 
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_AIJIACMS') or exit('Access Denied');
function msg($msg = errmsg, $forward = 'goback', $time = '1') {
	global $CFG;
	if(!$msg && $forward && $forward != 'goback') dheader($forward);
	include AJ_ROOT.'/admin/template/msg.tpl.php';
    exit;
}

function dialog($dcontent) {
	global $CFG;
	include AJ_ROOT.'/admin/template/dialog.tpl.php';
    exit;
}

function tpl($file = 'index', $mod = 'aijiacms') {
	global $CFG, $AJ;
	return $mod == 'aijiacms' ? AJ_ROOT.'/admin/template/'.$file.'.tpl.php' : AJ_ROOT.'/module/'.$mod.'/admin/template/'.$file.'.tpl.php';
}

function progress($sid, $fid, $tid) {
	if($tid > $sid && $fid < $tid) {
		$p = dround(($fid-$sid)*100/($tid-$sid), 0, true);
		if($p > 100) $p = 100;
		$p = $p.'%';
	} else {
		$p = '100%';
	}
	return '<table cellpadding="0" cellspacing="0" width="100%" style="margin:0"><tr><td><div class="progress"><div style="width:'.$p.';">&nbsp;</div></div></td><td style="color:#666666;font-size:10px;width:40px;text-align:center;">'.$p.'</td></tr></table>';
}

function show_menu($menus = array()) {
	global $module, $file, $action;
    $menu = '';
    foreach($menus as $id=>$m) {
		if(isset($m[1])) {
			$extend = isset($m[2]) ? $m[2] : '';
			$menu .= '<td id="Tab'.$id.'" class="tab"><a href="'.$m[1].'" '.$extend.'>'.$m[0].'</a></td><td class="tab_nav">&nbsp;</td>';
		} else {
			$class = $id == 0 ? 'tab_on' : 'tab';
			$menu .= '<td id="Tab'.$id.'" class="'.$class.'"><a href="javascript:Tab('.$id.');">'.$m[0].'</a></td><td class="tab_nav">&nbsp;</td>';
		}
	}
	include AJ_ROOT.'/admin/template/menu.tpl.php';
}

function update_setting($item, $setting) {
	global $db;
	$db->query("DELETE FROM {$db->pre}setting WHERE item='$item'");
	foreach($setting as $k=>$v) {
		if(is_array($v)) $v = implode(',', $v);
		$db->query("INSERT INTO {$db->pre}setting (item,item_key,item_value) VALUES ('$item','$k','$v')");
	}
	return true;
}

function get_setting($item) {
	global $db;
	$setting = array();
	$query = $db->query("SELECT * FROM {$db->pre}setting WHERE item='$item'");
	while($r = $db->fetch_array($query)) {
		$setting[$r['item_key']] = $r['item_value'];
	}
	return $setting;
}

function update_category($CAT) {
	global $db, $AJ;
	$linkurl = listurl($CAT);
	if($AJ['index']) $linkurl = str_replace($AJ['index'].'.'.$AJ['file_ext'], '', $linkurl);
	$db->query("UPDATE {$db->pre}category SET linkurl='$linkurl' WHERE catid=".$CAT['catid']);
}

function tips($tips) {
	echo ' <img src="admin/image/help.png" width="11" height="11" title="'.$tips.'" alt="tips" class="c_p" onclick="Dconfirm(this.title, \'\', 450);" />';
}

function array_save($array, $arrayname, $file) {
	$data = var_export($array,true);
	$data = "<?php\n".$arrayname." = ".$data.";\n?>";
	return file_put($file,$data);
}

function fetch_url($url) {
	global $db;
	$fetch = array();
	$tmp = parse_url($url);
	$domain = $tmp['host'];
	$r = $db->get_one("SELECT * FROM {$db->pre}fetch WHERE domain='$domain' ORDER BY edittime DESC");
	if($r) {
		$content = file_get($url);
		if($content) {
			$content = convert($content, $r['encode'], AJ_CHARSET);
			preg_match("/<title>(.*)<\/title>/isU", $content, $m);
			if(isset($m[1])) $fetch['title'] = trim($r['title'] ? str_replace($r['title'], '', $m[1]) : $m[1]);
			preg_match("/<meta[\s]+name=['\"]description['\"] content=['\"](.*)['\"]/isU", $content, $m);
			if(isset($m[1])) $fetch['introduce'] = $m[1];
			list($f, $t) = explode('[content]', $r['content']);
			if($f && $t) {
				$s = strpos($content, $f);
				if($s !== false) {
					$e = strpos($content, $t, $s);
					if($e !== false && $e > $s) {
						$fetch['content'] = substr($content, $s + strlen($f), $e - $s - strlen($f));
					}
				}
			}
		}
	}
	return $fetch;
}

function admin_log($force = 0) {
	global $AJ, $db, $moduleid, $file, $action, $_username, $AJ_QST, $AJ_IP, $AJ_TIME;
	if($force) $AJ['admin_log'] = 2;
	if(!$AJ['admin_log'] || !$AJ_QST || ($moduleid == 1 && $file == 'index')) return false;
	if($AJ['admin_log'] == 2 || ($AJ['admin_log'] == 1 && ($file == 'setting' || in_array($action, array('delete', 'edit', 'move', 'clear', 'add'))))) {
		if(strpos($AJ_QST, 'file=log') !== false) return false;
		$fpos = strpos($AJ_QST, '&forward');
		if($fpos) $AJ_QST = substr($AJ_QST, 0, $fpos);
		$logstring = get_cookie('logstring');
		$md5string = md5($AJ_QST);
		if($md5string == $logstring)  return false;
		$db->query("INSERT INTO {$db->pre}admin_log(qstring, username, ip, logtime) VALUES('$AJ_QST','$_username','$AJ_IP','$AJ_TIME')");
		set_cookie('logstring', $md5string);
	}
}

function admin_online() {
	global $AJ, $db, $moduleid, $_username, $AJ_QST, $AJ_IP, $AJ_TIME;
	if(!$AJ['admin_online'] || !$_username) return false;
	$qstring = $AJ_QST;
	$fpos = strpos($qstring, '&forward');
	if($fpos) $qstring = substr($qstring, 0, $fpos);
	$qstring = preg_replace("/rand=([0-9]{1,})\&/", "", $qstring);
	$db->query("REPLACE INTO {$db->pre}admin_online (sid,username,ip,moduleid,qstring,lasttime) VALUES ('".session_id()."','$_username','$AJ_IP','$moduleid','$qstring','$AJ_TIME')");	
	$lastime = $AJ_TIME - $AJ['online'];
	$db->query("DELETE FROM {$db->pre}admin_online WHERE lasttime<$lastime");
}

function admin_check() {
	global $CFG, $db, $_admin, $_userid, $moduleid, $file, $action, $catid, $_catids, $_childs;
	if(!check_name($file)) return false;
	if(in_array($file, array('logout', 'cloud', 'mymenu', 'search', 'ip', 'mobile'))) return true;//All user
	if($moduleid == 1 && $file == 'index') return true;
	if($CFG['founderid'] && $CFG['founderid'] == $_userid) return true;//Founder
	if($_admin == 2) {
		$R = cache_read('right-'.$_userid.'.php');
		if(!$R) return false;
		if(!isset($R[$moduleid])) return false;
		if(!$R[$moduleid]) return true;//Module admin
		if(!isset($R[$moduleid][$file])) return false;
		if(!$R[$moduleid][$file]) return true;
		if($action && $R[$moduleid][$file]['action'] && !in_array($action, $R[$moduleid][$file]['action'])) return false;
		if(!$R[$moduleid][$file]['catid']) return true;
		$_catids = implode(',', $R[$moduleid][$file]['catid']);
		if($catid) {
			if(in_array($catid, $R[$moduleid][$file]['catid'])) return true;
			//Childs
			$result = $db->query("SELECT catid,child,arrchildid FROM {$db->pre}category WHERE moduleid=$moduleid AND catid IN ($_catids)");
			while($r = $db->fetch_array($result)) {
				$_childs .= ','.($r['child'] ? $r['arrchildid'] : $r['catid']);
			}
			if(strpos($_childs.',', ','.$catid.',') !== false) return true;
			return false;
		}
	} else if($_admin == 1) {
		if(in_array($file, array('admin', 'setting', 'module', 'area', 'database', 'template', 'skin', 'log', 'update', 'group', 'fields', 'loginlog'))) return false;//Founder || Common Admin Only
	}
	return true;
}

function admin_notice() {
	global $AJ, $MODULE, $db, $moduleid, $file, $itemid, $action, $reason, $msg, $eml, $sms, $wec;
	if(!is_array($itemid)) return;
	if(count($itemid) == 0) return;
	$S = array(
		'delete' => '已经被删除', 
		'check' => '已经通过审核', 
		'reject' => '没有通过审核',
		'onsale' => '已经上架',
		'unsale' => '已经下架',
	);
	$N = array(
		'honor' => '荣誉资质', 
		'news' => '公司新闻', 
		'page' => '公司单页', 
		'link' => '友情链接',
	);
	if(!isset($S[$action])) return;
	if($moduleid > 4) {
		$table = get_table($moduleid);
		$name = $MODULE[$moduleid]['name'];
		if($moduleid == 9) {
			if($file == 'resume') {
				$table = $db->pre.$file;
				$name = '简历';
			} else {
				$name = '招聘';
			}
		} else if($moduleid == 16) {
			$name = '商品';
		}
	} else if(isset($N[$file])) {
		$table = $db->pre.$file;
		$name = $N[$file];
	} else {
		return;
	}
	if($reason == '操作原因') $reason = '';
	$msg = isset($msg) ? 1 : 0;
	if(strlen($reason) > 2) $msg = 1;
	$eml = isset($eml) ? 1 : 0;
	if($msg == 0 && $eml == 0) return;
	$sms = isset($sms) ? 1 : 0;
	$wec = isset($wec) ? 1 : 0;
	if($msg == 0) $sms = $wec = 0;
	$result = $db->query("SELECT itemid,title,username,linkurl FROM {$table} WHERE itemid IN (".implode(',', $itemid).")");
	while($r = $db->fetch_array($result)) {
		$username = $r['username'];
		if(!check_name($username)) continue;
		$title = $r['title'];
		$linkurl = strpos($r['linkurl'], '://') === false ? $MODULE[$moduleid]['linkurl'].$r['linkurl'] : $r['linkurl'];
		$subject = '您发布的['.$name.']'.$title.'(ID:'.$r['itemid'].')'.$S[$action];
		$body = '尊敬的会员：<br/>您发布的['.$name.']<a href="'.$linkurl.'" target="_blank">'.$title.'</a>(ID:'.$r['itemid'].')'.$S[$action].'！<br/>';
		if($reason) $body .= '操作原因：<br/>'.$reason.'<br/>';
		$body .= '如果您对此操作有异议，请及时与网站联系。';
		if($msg) send_message($username, $subject, $body);
		if($wec) send_weixin($username, $subject);
		if($eml || $sms) {
			$user = userinfo($username);
			if($eml) send_mail($user['email'], $subject, $body);
			if($sms) send_sms($user['mobile'], $subject.$AJ['sms_sign']);
		}
	}
}

function item_check($itemid) {
	global $db, $table, $_child, $moduleid;
	if($moduleid == 3) return true;
	$fd = 'itemid';
	if($moduleid == 2 || $moduleid == 4) $fd = 'userid';
	$r = $db->get_one("SELECT catid FROM {$table} WHERE `$fd`=$itemid");
	if($r && $_child && in_array($r['catid'], $_child)) return true;
	return false;
}

function city_check($itemid) {
	global $db, $table, $_areaid, $moduleid;
	if($moduleid == 3) return true;
	$fd = 'itemid';
	if($moduleid == 2 || $moduleid == 4) $fd = 'userid';
	$r = $db->get_one("SELECT areaid FROM {$table} WHERE `$fd`=$itemid");
	if($r && $_areaid && in_array($r['areaid'], $_areaid)) return true;
	return false;
}

function split_content($moduleid, $part) {
	global $db, $CFG, $MODULE;
	$table = $db->pre.$moduleid.'_'.$part;
	$fd = $moduleid == 4 ? 'userid' : 'itemid';
	if($db->version() > '4.1' && $CFG['db_charset']) {
		$type = " ENGINE=MyISAM DEFAULT CHARSET=".$CFG['db_charset'];
	} else {
		$type = " TYPE=MyISAM";
	}	
	$db->query("CREATE TABLE IF NOT EXISTS `{$table}` (`{$fd}` bigint(20) unsigned NOT NULL default '0',`content` longtext NOT NULL,PRIMARY KEY  (`{$fd}`))".$type." COMMENT='".$MODULE[$moduleid]['name']."内容_".$part."'");
}

function split_sell($part) {
	global $db, $CFG, $MODULE;
	$sql = file_get(AJ_ROOT.'/file/setting/split_sell.sql');
	$sql or dalert('请检查文件file/setting/split_sell.sql是否存在');
	$sql = str_replace('aijiacms_sell', $db->pre.'sell_5_'.$part, $sql);
	if($db->version() > '4.1' && $CFG['db_charset']) {
		$sql .= " ENGINE=MyISAM DEFAULT CHARSET=".$CFG['db_charset'];
	} else {
		$sql .= " TYPE=MyISAM";
	}
	$sql .= " COMMENT='".$MODULE[5]['name']."分表_".$part."';";
	$db->query($sql);
}

function seo_title($title, $show = '') {
	$SEO = array(
		'modulename'		=>	'模块名称',
		'page'				=>	'页码',
		'sitename'			=>	'网站名称',
		'sitetitle'			=>	'网站SEO标题',
		'sitekeywords'		=>	'网站SEO关键词',
		'sitedescription'	=>	'网站SEO描述',
		'catname'			=>	'分类名称',
		'cattitle'			=>	'分类SEO标题',
		'catkeywords'		=>	'分类SEO关键词',
		'catdescription'	=>	'分类SEO描述',
		'showtitle'			=>	'内容标题',
		'showintroduce'		=>	'内容简介',
		'kw'				=>	'关键词',
		'areaname'			=>	'地区',
		'delimiter'			=>	'分隔符',
	);
	if(is_array($show)) {
		foreach($show as $v) {
			if(isset($SEO[$v])) echo '<a href="javascript:_into(\''.$title.'\', \'{'.$SEO[$v].'}\');" title="{'.$SEO[$v].'}">{'.$SEO[$v].'}</a>&nbsp;&nbsp;';
		}
	} else {
		foreach($SEO as $k=>$v) {
			$title = str_replace($v, '$seo_'.$k, $title);
		}
		return $title;
	}
}

function seo_check($str) {
	foreach(array('<', '>', ';', '?', '"', '()') as $v) {
		if(strpos($str, $v) !== false) return false;
	}
	if(preg_match_all("/\(([^\)]+)\)/i", $str, $matches)) {
		foreach($matches[1] as $m) {
			$m = trim($m);
			if(strlen($m) < 2) return false;			
			foreach(array('$', ',', "'") as $v) {
				if(strpos($m, $v) !== false) return false;
			}
		}
	}
	return true;
}

function install_file($file, $dir, $extend = 0) {
	$content = "<?php\n";
	if($extend == 1) $content .= "define('AJ_REWRITE', true);\n";
	$content .= "require 'config.inc.php';\n";
	$content .= "require '../common.inc.php';\n";
	$content .= "require AJ_ROOT.'/module/'.\$module.'/".$file.".inc.php';\n";
	$content .= '?>';
	return file_put(AJ_ROOT.'/'.$dir.'/'.$file.'.php', $content);
}

function list_dir($dir) {
	include AJ_ROOT.'/'.$dir.'/these.name.php';
	$list = $dirs = array();
	$files = glob(AJ_ROOT.'/'.$dir.'/*');
	foreach($files as $v) {
		if(is_file($v)) continue;
		$v = basename($v);
		$dirs[$v] = $v;
	}
	foreach($names as $k=>$v) {
		if(isset($dirs[$k])) {
			$list[] = array('dir'=>$k, 'name'=>$v);
			unset($dirs[$k]);
		}
	}
	foreach($dirs as $v) {
		$list[] = array('dir'=>$v, 'name'=>$v);
	}
	return $list;
}

function pass_encode($str) {
	$len = strlen($str);
	if($len < 1) return '';
	$new = '';
	for($i = 0; $i < $len; $i++) {
		$new .= ($i == 0 || $i == $len - 1) ? $str{$i} : '*';
	}
	return $new;
}

function pass_decode($new, $old) {
	return $new == pass_encode($old) ? $old : $new;
}

function fix_domain($domain) {
	if(strpos($domain, '.') === false) return '';
	if(substr($domain, 0, 4) != 'http') $domain = 'http://'.$domain;
	if(substr($domain, -1) != '/') $domain = $domain.'/';
	return $domain;
}
?>