<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
require AJ_ROOT.'/include/post.func.php';
$itemid or exit;
isset($MODULE[$mid]) or exit;
in_array($mid, explode(',', $MOD['comment_module'])) or exit;
if(in_array($itemid, cache_read('bancomment-'.$mid.'.php'))) {
	$template = 'close';
	$linkurl = $MODULE[$mid]['linkurl'];
	include template('commenthouse', $module);
	exit;
}
if($mid == 4) {
	$item = $db->get_one("SELECT company,linkurl,username,groupid FROM ".get_table($mid)." WHERE userid=$itemid");
	$item or exit;
	$item['groupid'] > 4 or exit;
	$item['title'] = $item['company'];
	$linkurl = $item['linkurl'];
} else {
	$item = $db->get_one("SELECT title,linkurl,username,status FROM ".get_table($mid)." WHERE itemid=$itemid");
	$item or exit;
	$item['status'] > 2 or exit;
	$linkurl = $MODULE[$mid]['linkurl'].$item['linkurl'];
}
$template = $message = $forward = '';
$username = $item['username'];
$title = $item['title'];
$could_del = false;
if($_groupid == 1) {
	if($MOD['comment_admin_del']) $could_del = true;
} else if($username && $_username == $username) {
	if($MOD['comment_user_del'] && in_array($mid, explode(',', $MOD['comment_user_del']))) $could_del = true;
}
switch($action) {
	case 'vote':
		if(!check_group($_groupid, $MOD['comment_vote_group']) || !$MOD['comment_vote']) exit('-2');
		$cid = isset($cid) ? intval($cid) : 0;
		$cid or exit('0');
		$op = $op ? 1 : 0;
		$f = $op ? 'agree' : 'against';
		if(get_cookie('comment_vote_'.$mid.'_'.$itemid.'_'.$cid)) exit('-1');
		$db->query("UPDATE {$AJ_PRE}comment SET `{$f}`=`{$f}`+1 WHERE itemid=$cid");
		set_cookie('comment_vote_'.$mid.'_'.$itemid.'_'.$cid, 1, $AJ_TIME + 365*86400);
		exit('1');
	break;
	case 'delete':
		$could_del or dalert($L['comment_msg_del']);
		$cid = isset($cid) ? intval($cid) : 0;
		$cid or dalert($L['comment_msg_cid']);
		$r = $db->get_one("SELECT * FROM {$AJ_PRE}comment WHERE itemid='$cid' LIMIT 1");
		if($r) {
			$star = 'star'.$r['star'];
			$db->query("UPDATE {$AJ_PRE}comment_stat SET comment=comment-1,`{$star}`=`{$star}`-1 WHERE itemid=$r[item_id] AND moduleid=$r[item_mid]");
			$db->query("DELETE FROM {$AJ_PRE}comment WHERE itemid=$cid");
			$forward = $MOD['linkurl'].'commenthouse.php?mid='.$mid.'&itemid='.$itemid.'&page='.$page.'&rand='.mt_rand(10, 99);
			dalert($L['comment_msg_del_success'], '', 'parent.window.location="'.$forward.'";');
		} else {
			dalert($L['comment_msg_not_comment']);
		}
	break;
	default:
		if(check_group($_groupid, $MOD['comment_group'])) {
			$user_status = 3;
		} else {
			if($_userid) {
				$user_status = 1;
			} else {
				$user_status = 2;
			}
		}
		$need_captcha = $MOD['comment_captcha_add'] == 2 ? $MG['captcha'] : $MOD['comment_captcha_add'];
		if($MOD['comment_pagesize']) {
			$pagesize = $MOD['comment_pagesize'];
			$offset = ($page-1)*$pagesize;
		}
		if($submit) {
			if($user_status != 3) dalert($L['comment_msg_permission']);
			if($username && $username == $_username) dalert($L['comment_msg_self']);
			$sql = $_userid ? "username='$_username'" : "ip='$AJ_IP'";
			if($MOD['comment_limit']) {
				$today = $today_endtime - 86400;
				$r = $db->get_one("SELECT COUNT(*) AS num FROM {$AJ_PRE}comment WHERE $sql AND addtime>$today");
				$r['num'] < $MOD['comment_limit'] or dalert(lang($L['comment_msg_limit'], array($MOD['comment_limit'], $r['num'])));
			}
			if($MOD['comment_time']) {
				$r = $db->get_one("SELECT addtime FROM {$AJ_PRE}comment WHERE $sql ORDER BY addtime DESC");
				if($r && $AJ_TIME - $r['addtime'] < $MOD['comment_time']) dalert(lang($L['comment_msg_time'], array($MOD['comment_time'])));
			}

			if($need_captcha) {
				$msg = captcha($captcha, 1, true);
				if($msg) dalert($msg);
			}
			$content = dhtmlspecialchars(trim($content));
			$content = preg_replace("/&([a-z]{1,});/", '', $content);
			$len = word_count($content);
			if($len < $MOD['comment_min']) dalert(lang($L['comment_msg_min'], array($MOD['comment_min'])));
			if($len > $MOD['comment_max']) dalert(lang($L['comment_msg_max'], array($MOD['comment_max'])));
			$BANWORD = cache_read('banword.php');
			if($BANWORD) $content = banword($BANWORD, $content, false);
			$star = intval($star);
			in_array($star, array(1, 2, 3,4,5)) or $star = 3;
			$status = get_status(3, $MOD['comment_check'] == 2 ? $MG['check_add'] : $MOD['comment_check']);
			$hidden = isset($hidden) ? 1 : 0;
			$content = nl2br($content);
			$quotation = '';
			$qid = isset($qid) ? intval($qid) : 0;
			if($qid) {
				$r = $db->get_one("SELECT ip,hidden,username,content,quotation,addtime FROM {$AJ_PRE}comment WHERE itemid=$qid");
				if($r) {
					if($r['username']) {
						$r['name'] = $r['hidden'] ? $MOD['comment_am'] : $r['username'];
					} else {
						$r['name'] = '游客';
					}
					$r['addtime'] = timetodate($r['addtime'], 6);
					if($r['quotation']) $r['content'] = $r['quotation'];
					$floor = substr_count($r['content'],'quote_content') + 1;
					if($floor == 1) {
						$quotation = addslashes('<div class="quote"><div class="quote_title"><span class="quote_floor">'.$floor.'</span>'.$r['name'].' '.$L['comment_quote_at'].' <span class="quote_time">'.$r['addtime'].'</span> '.$L['comment_quote_or'].'</div><div class="quote_content">'.$r['content'].'</div><!----></div>').$content;
					} else {
						$quotation = str_replace('<!----></div>', '</div><div class="quote_title"><span class="quote_floor">'.$floor.'</span>'.$r['name'].' '.$L['comment_quote_at'].' <span class="quote_time">'.$r['addtime'].'</span> '.$L['comment_quote_or'].'</div><div class="quote_content">', $r['content']);
						$quotation = '<div class="quote">'.$quotation.'</div><!----></div>';
						$quotation = addslashes($quotation).$content;
					}
				}
				$db->query("UPDATE {$AJ_PRE}comment SET quote=quote+1 WHERE itemid=$qid");
			}
			$db->query("INSERT INTO {$AJ_PRE}comment (item_mid,item_id,item_title,item_username,content,quotation,qid,addtime,username,hidden,star,ip,status) VALUES ('$mid','$itemid','$title','$username','$content','$quotation','$qid','$AJ_TIME','$_username','$hidden','$star','$AJ_IP','$status')");
			$cid = $db->insert_id();
			$r = $db->get_one("SELECT sid FROM {$AJ_PRE}comment_stat WHERE moduleid=$mid AND itemid=$itemid");
			$star = 'star'.$star;
			if($r) {
				$db->query("UPDATE {$AJ_PRE}comment_stat SET comment=comment+1,`{$star}`=`{$star}`+1 WHERE sid=$r[sid]");
			} else {
				$db->query("INSERT INTO {$AJ_PRE}comment_stat (moduleid,itemid,{$star},comment) VALUES ('$mid','$itemid','1','1')");
			}
			if($status == 3) {
				if($_username && $MOD['credit_add_comment']) {
					credit_add($_username, $MOD['credit_add_comment']);
					credit_record($_username, $MOD['credit_add_comment'], 'system', $L['comment_record_add'], 'ID:'.$cid);
				}
				$items = isset($items) ? intval($items)+1 : 1;
				$page = ceil($items/$pagesize);
				if($MOD['comment_show']) {
					$forward = $MOD['linkurl'].'commenthouse.php?mid='.$mid.'&itemid='.$itemid.'&page='.$page.'&rand='.mt_rand(10, 99).'#last';
					dalert('', '', 'parent.window.location="'.$forward.'";');
				} else {
					$forward = $MOD['comment_url'].rewrite('index.php?mid='.$mid.'&itemid='.$itemid.'&page='.$page.'&rand='.mt_rand(10, 99)).'#last';
					dalert('', '', 'top.window.location="'.$forward.'";');
				}
			} else {
				dalert($L['comment_check'], '', 'parent.window.location=parent.window.location;');
			}
		} else {
			$lists = array();
			$pages = '2';
			 $pagesize=2;
			$r = $db->get_one("SELECT COUNT(*) AS num FROM {$AJ_PRE}comment WHERE item_mid=$mid AND item_id=$itemid AND status=3");
			$items = $r['num'];
			if($MOD['comment_show']) {
				$pages = pages($items, $page, $pagesize);
				$result = $db->query("SELECT * FROM {$AJ_PRE}comment WHERE item_mid=$mid AND item_id=$itemid AND status=3 ORDER BY itemid DESC LIMIT $offset,$pagesize");
				$floor = $page == 1 ? 0 : ($page-1)*$pagesize;
				while($r = $db->fetch_array($result)) {
					$r['floor'] = ++$floor;
					$r['addtime'] = timetodate($r['addtime'], 5);
					$r['replytime'] = $r['replytime'] ? timetodate($r['replytime'], 5) : '';
					if($r['username']) {
						$r['name'] = $r['hidden'] ? $MOD['comment_am'] : $r['username'];
						$r['uname'] = $r['hidden'] ? '' : $r['username'];
					} else {
						$r['name'] = '游客';
						$r['uname'] = '';
					}
					$lists[] = $r;
				}
			}
			$stat = $r = $db->get_one("SELECT * FROM {$AJ_PRE}comment_stat WHERE moduleid=$mid AND itemid=$itemid");
			if($stat && $stat['comment']) {
				$stat['pc1'] = dround($stat['star1']*100/$stat['comment'], 2, true).'%';
				$stat['pc2'] = dround($stat['star2']*100/$stat['comment'], 2, true).'%';
				$stat['pc3'] = dround($stat['star3']*100/$stat['comment'], 2, true).'%';
			} else {
				$stat['star1'] = $stat['star2'] = $stat['star3'] = 0;
				$stat['pc1'] = $stat['pc2'] = $stat['pc3'] = '0%';
			}
			$count=($stat['star1']+$stat['star2']*2+$stat['star3']*3+$stat['star4']*4+$stat['star5']*5)/$stat['comment']*20;
		
			$head_title = $head_keywords = $head_description = $title.$L['comment_title'];
			$template = 'comment';
			include template('commenthouse', $module);
		}
	break;
}
?>