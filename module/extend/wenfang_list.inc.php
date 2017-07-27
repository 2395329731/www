<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
require AJ_ROOT.'/include/post.func.php';
$itemid or dheader(AJ_PATH);
$mid = isset($mid) ? intval($mid) : 0;
isset($MODULE[$mid]) or dheader(AJ_PATH);
in_array($mid, explode(',', $MOD['wenfang_module'])) or exit;
if(in_array($itemid, cache_read('banwenfang-'.$mid.'.php'))) {
	$template = 'close';
	$linkurl = $MODULE[$mid]['linkurl'];
	include template('wenfang-show', $module);
	exit;
}
if($mid == 4) {
	$item = $db->get_one("SELECT company,linkurl,username,groupid FROM ".get_table($mid)." WHERE userid=$itemid");
	$item or dheader(AJ_PATH);
	$item['groupid'] > 4 or dheader(AJ_PATH);
	$item['title'] = $item['company'];
	$linkurl = $item['linkurl'];
} else {
	$item = $db->get_one("SELECT title,linkurl,username,status FROM ".get_table($mid)." WHERE itemid=$itemid");
	$item or dheader(AJ_PATH);
	$item['status'] > 2 or dheader(AJ_PATH);
	$linkurl = linkurl($MODULE[$mid]['linkurl'].$item['linkurl'], 1);
}
$template = $message = $forward = '';
$username = $item['username'];
$title = $item['title'];
$could_del = false;
if($_groupid == 1) {
	if($MOD['wenfang_admin_del']) $could_del = true;
} else if($username && $_username == $username) {
	if($MOD['wenfang_user_del'] && in_array($mid, explode(',', $MOD['wenfang_user_del']))) $could_del = true;
}
switch($action) {
	case 'vote':
		if(!check_group($_groupid, $MOD['wenfang_vote_group']) || !$MOD['wenfang_vote']) exit('-2');
		$cid = isset($cid) ? intval($cid) : 0;
		$cid or exit('0');
		$op = $op ? 1 : 0;
		$f = $op ? 'agree' : 'against';
		if(get_cookie('wenfang_vote_'.$mid.'_'.$itemid.'_'.$cid)) exit('-1');
		$db->query("UPDATE {$AJ_PRE}wenfang SET `{$f}`=`{$f}`+1 WHERE itemid=$cid");
		set_cookie('wenfang_vote_'.$mid.'_'.$itemid.'_'.$cid, 1, $AJ_TIME + 365*86400);
		exit('1');
	break;
	case 'delete':
		$could_del or dalert($L['wenfang_msg_del']);
		$cid = isset($cid) ? intval($cid) : 0;
		$cid or dalert($L['wenfang_msg_cid']);
		$r = $db->get_one("SELECT * FROM {$AJ_PRE}wenfang WHERE itemid='$cid' LIMIT 1");
		if($r) {
			
			$db->query("DELETE FROM {$AJ_PRE}wenfang WHERE itemid=$cid");
			$forward = rewrite('index.php?mid='.$mid.'&itemid='.$itemid.'&page='.$page.'&rand='.mt_rand(10, 99));
			dalert($L['wenfang_msg_del_success'], '', 'parent.window.location="'.$forward.'";');
		} else {
			dalert($L['wenfang_msg_not_wenfang']);
		}
	break;
	default:
		if(check_group($_groupid, $MOD['wenfang_group'])) {
			$user_status = 3;
		} else {
			if($_userid) {
				$user_status = 1;
			} else {
				$user_status = 2;
			}
		}
		$need_captcha = $MOD['wenfang_captcha_add'] == 2 ? $MG['captcha'] : $MOD['wenfang_captcha_add'];
		if($MOD['wenfang_pagesize']) {
			$pagesize = $MOD['wenfang_pagesize'];
			$offset = ($page-1)*$pagesize;
		}
		if($submit) {
			if($user_status != 3) dalert($L['wenfang_msg_permission']);
			if($username && $username == $_username) dalert($L['wenfang_msg_self']);
			$sql = $_userid ? "username='$_username'" : "ip='$AJ_IP'";
			if($MOD['wenfang_limit']) {
				$today = strtotime(timetodate($AJ_TIME, 3).' 00:00:00');
				$r = $db->get_one("SELECT COUNT(*) AS num FROM {$AJ_PRE}wenfang WHERE $sql AND addtime>$today");
				$r['num'] < $MOD['wenfang_limit'] or dalert(lang($L['wenfang_msg_limit'], array($MOD['wenfang_limit'], $r['num'])));
			}
			if($MOD['wenfang_time']) {
				$r = $db->get_one("SELECT addtime FROM {$AJ_PRE}wenfang WHERE $sql ORDER BY addtime DESC");
				if($r && $AJ_TIME - $r['addtime'] < $MOD['wenfang_time']) dalert(lang($L['wenfang_msg_time'], array($MOD['wenfang_time'])));
			}

			if($need_captcha) {
				$msg = captcha($captcha, 1, true);
				if($msg) dalert($msg);
			}
			$content = dhtmlspecialchars(trim($content));
			$content = preg_replace("/&([a-z]{1,});/", '', $content);
			$len = word_count($content);
			if($len < $MOD['wenfang_min']) dalert(lang($L['wenfang_msg_min'], array($MOD['wenfang_min'])));
			if($len > $MOD['wenfang_max']) dalert(lang($L['wenfang_msg_max'], array($MOD['wenfang_max'])));
			$BANWORD = cache_read('banword.php');
			if($BANWORD) $content = banword($BANWORD, $content, false);
			$star = intval($star);
			in_array($star, array(1, 2, 3)) or $star = 3;
			$status = get_status(3, $MOD['wenfang_check'] == 2 ? $MG['check_add'] : $MOD['wenfang_check']);
			$hidden = isset($hidden) ? 1 : 0;
			$content = nl2br($content);
			$quotation = '';
			$qid = isset($qid) ? intval($qid) : 0;
			if($qid) {
				$r = $db->get_one("SELECT ip,hidden,username,content,quotation,addtime FROM {$AJ_PRE}wenfang WHERE itemid=$qid");
				if($r) {
					if($r['username']) {
						$r['name'] = $r['hidden'] ? $MOD['wenfang_am'] : $r['username'];
					} else {
						$r['name'] = 'IP:'.hide_ip($r['ip']);
					}
					$r['addtime'] = timetodate($r['addtime'], 6);
					if($r['quotation']) $r['content'] = $r['quotation'];
					$floor = substr_count($r['content'],'quote_content') + 1;
					if($floor == 1) {
						$quotation = addslashes('<div class="quote"><div class="quote_title"><span class="quote_floor">'.$floor.'</span>'.$r['name'].' '.$L['wenfang_quote_at'].' <span class="quote_time">'.$r['addtime'].'</span> '.$L['wenfang_quote_or'].'</div><div class="quote_content">'.$r['content'].'</div><!----></div>').$content;
					} else {
						$quotation = str_replace('<!----></div>', '</div><div class="quote_title"><span class="quote_floor">'.$floor.'</span>'.$r['name'].' '.$L['wenfang_quote_at'].' <span class="quote_time">'.$r['addtime'].'</span> '.$L['wenfang_quote_or'].'</div><div class="quote_content">', $r['content']);
						$quotation = '<div class="quote">'.$quotation.'</div><!----></div>';
						$quotation = addslashes($quotation).$content;
					}
				}
				$db->query("UPDATE {$AJ_PRE}wenfang SET quote=quote+1 WHERE itemid=$qid");
			}
			$db->query("INSERT INTO {$AJ_PRE}wenfang (item_mid,item_id,item_title,item_linkurl,item_username,content,quotation,qid,addtime,username,hidden,star,ip,status) VALUES ('$mid','$itemid','$title','$linkurl','$username','$content','$quotation','$qid','$AJ_TIME','$_username','$hidden','$star','$AJ_IP','$status')");
			$cid = $db->insert_id();
			
			
			if($status == 3) {
				if($_username && $MOD['credit_add_wenfang']) {
					credit_add($_username, $MOD['credit_add_wenfang']);
					credit_record($_username, $MOD['credit_add_wenfang'], 'system', $L['wenfang_record_add'], 'ID:'.$cid);
				}
				$items = isset($items) ? intval($items)+1 : 1;
				$page = ceil($items/$pagesize);
				$forward = rewrite('index.php?mid='.$mid.'&itemid='.$itemid.'&page='.$page.'&rand='.mt_rand(10, 99)).'#last';
				dalert('', '', 'parent.window.location="'.$forward.'";');
			} else {
				dalert($L['wenfang_check'], '', 'parent.window.location=parent.window.location;');
			}
		} else {
			$lists = array();
			$pages = '';
			$r = $db->get_one("SELECT COUNT(*) AS num FROM {$AJ_PRE}wenfang WHERE item_mid=$mid AND item_id=$itemid AND status=3");
			$items = $r['num'];
			$pages = pages($items, $page, $pagesize);
			$result = $db->query("SELECT * FROM {$AJ_PRE}wenfang WHERE item_mid=$mid AND item_id=$itemid AND status=3 ORDER BY itemid ASC LIMIT $offset,$pagesize");
			$floor = $page == 1 ? 0 : ($page-1)*$pagesize;
			while($r = $db->fetch_array($result)) {
				$r['floor'] = ++$floor;
				$r['addtime'] = timetodate($r['addtime'], 6);
				$r['replytime'] = $r['replytime'] ? timetodate($r['replytime'], 6) : '';
				if($r['username']) {
					$r['name'] = $r['hidden'] ? $MOD['wenfang_am'] : $r['username'];
				} else {
					$r['name'] = 'IP:'.hide_ip($r['ip']);
				}
				$lists[] = $r;
			}
			
			$head_title = $head_keywords = $head_description = $title.$L['wenfang_title'];
			include template('wenfang_list', $module);
		}
	break;
}
?>