<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';

$MTYPE = get_type('product-'.$_userid);
require AJ_ROOT.'/include/post.func.php';
include load($module.'.lang');
include load('my.lang');
require MD_ROOT.'/rent.class.php';
$do = new rent($moduleid);
if(in_array($action, array('add', 'edit'))) {
	$FD = cache_read('fields-'.substr($table, strlen($AJ_PRE)).'.php');
	if($FD) require AJ_ROOT.'/include/fields.func.php';
	isset($post_fields) or $post_fields = array();
	$CP = $MOD['cat_property'];
	if($CP) require AJ_ROOT.'/include/property.func.php';
	isset($post_ppt) or $post_ppt = array();
}
$user = userinfo($_username);
$sql = $_userid ? "username='$_username'" : "ip='$AJ_IP'";
$limit_used = $limit_free = $need_password = $need_captcha = $need_question = $fee_add = 0;
switch($action) {
	case 'add':
		

		if($submit) {
			if($fee_add && $fee_add > ($fee_currency == 'money' ? $_money : $_credit)) dalert($L['balance_lack']);
			if($need_password && !is_payword($_username, $password)) dalert($L['error_payword']);

			if(!$_userid) {
				//if(strlen($post['company']) < 4) dalert($L['type_company']);
				if($AREA) {
					if(!isset($AREA[$post['areaid']])) dalert($L['type_area']);
				} else {
					if(!$post['areaid']) dalert($L['type_area']);
				}
				if(strlen($post['truename']) < 4) dalert($L['type_truename']);
				if(strlen($post['mobile']) < 7) dalert($L['type_mobile']);
			}

			if($MG['add_limit']) {
				$last = $db->get_one("SELECT addtime FROM {$table} WHERE $sql ORDER BY itemid DESC");
				if($last && $AJ_TIME - $last['addtime'] < $MG['add_limit']) dalert(lang($L['add_limit'], array($MG['add_limit'])));
			}
			$msg = captcha($captcha, $need_captcha, true);
			if($msg) dalert($msg);
			$msg = question($answer, $need_question, true);
			if($msg) dalert($msg);

			if($do->pass($post)) {
				$CAT = get_cat($post['catid']);
				
				//if($MOD['upload_thumb'] && $MG['upload'] && strlen($post['thumb']) < 5) dalert($L['sell_upload_image']);
				$post['addtime'] = $post['level'] = $post['fee'] = 0;
				$post['style'] = $post['template'] = $post['note'] = $post['filepath'] = '';
				if(!$IMVIP && $MG['uploadpt']) $post['thumb1'] = $post['thumb2'] = '';
				$need_check =  $MOD['check_add'] == 2 ? $MG['check'] : $MOD['check_add'];
				$post['status'] = get_status(3, $need_check);
				$post['hits'] = 0;
				$post['username'] = $_username;

				if($could_elite && isset($elite) && $post['thumb'] && $_credit > $MOD['credit_elite']) {
					$post['level'] = 1;
					credit_add($_username, -$MOD['credit_elite']);
					credit_record($_username, -$MOD['credit_elite'], 'system', lang($L['credit_record_elite'], array($MOD['name'])), $post['title']);
				}

				if($could_color && $color && $_credit > $MOD['credit_color']) {
					$post['style'] = $color;
					credit_add($_username, -$MOD['credit_color']);
					credit_record($_username, -$MOD['credit_color'], 'system', $L['title_color'], '['.$MOD['name'].']'.$post['title']);
				}

				if($FD) fields_check($post_fields);
				if($CP) property_check($post_ppt);
				$do->addcaiji($post);
				//$do->add($post);
						if($swf_upload) {
				foreach(explode('|', $swf_upload) as $v) {
					if($v) {
						$thumb .= $v;
						$db->query("INSERT INTO {$AJ_PRE}house_pic (item,thumb,mid) VALUES ('$do->itemid', '$v',7)");
						if(!$post['thumb']) $db->query("UPDATE {$AJ_PRE}rent_7  SET thumb='$v' WHERE itemid=$do->itemid");
					}
				}
			}
				if($FD) fields_update($post_fields, $table, $do->itemid);
				if($CP) property_update($post_ppt, $moduleid, $post['catid'], $do->itemid);
				if($MOD['show_html'] && $post['status'] > 2) $do->tohtml($do->itemid);
             	if($fee_add) {
					if($fee_currency == 'money') {
						money_add($_username, -$fee_add);
						money_record($_username, -$fee_add, $L['in_site'], 'system', lang($L['credit_record_add'], array($MOD['name'])), 'ID:'.$do->itemid);
					} else {
						credit_add($_username, -$fee_add);
						credit_record($_username, -$fee_add, 'system', lang($L['credit_record_add'], array($MOD['name'])), 'ID:'.$do->itemid);
					}
				}				
				$msg = $post['status'] == 2 ? $L['success_check'] : $L['success_add'];
				$js = '';
				if(isset($post['sync_sina']) && $post['sync_sina']) $js .= sync_weibo('sina', $moduleid, $do->itemid);
				if(isset($post['sync_qq']) && $post['sync_qq']) $js .= sync_weibo('qq', $moduleid, $do->itemid);
				
				if($_userid) {
					set_cookie('dmsg', $msg);
					$forward = 'fang.php?mid='.$mid.'&status='.$post['status'];
					$msg = '';
				} else {
					$forward = 'fang.php?mid='.$mid.'&action=add';
				}
				$js .= 'window.onload=function(){parent.window.location="'.$forward.'";}';
				dalert($msg, '', $js);
			} else {
				dalert($do->errmsg, '', ($need_captcha ? reload_captcha() : '').($need_question ? reload_question() : ''));
			}
		} else {
			if($itemid) {
				$MG['copy'] && $_userid or dalert(lang('message->without_permission_and_upgrade'), 'goback');
				$do->itemid = $itemid;
				$item = $do->get_one();
				if(!$item || $item['username'] != $_username) message();
				extract($item);
				$thumb = $thumb1 = $thumb2 = '';
				$totime = $totime > $AJ_TIME ? timetodate($totime, 3) : '';
			} else {
				foreach($do->fields as $v) {
					$$v = '';
				}
				$content = '';
				$catid = 0;
				$days = 3;
				$totime = '';
				$typeid = 0;
				$mycatid = 0;
			}
			$item = array();
			$mycatid_select = type_select('product-'.$_userid, 0, 'post[mycatid]', $L['type_default']);
		}
	break;
	case 'edit':
		$itemid or message();
		$do->itemid = $itemid;
		$item = $do->get_one();
		$picnum = $db->get_one("SELECT COUNT(*) AS num FROM {$AJ_PRE}house_pic WHERE item=$itemid and mid=5");
		$picnum=$picnum['num'];
		if(!$item || $item['username'] != $_username) message();
        $piclists = $do->item_list("item=$itemid and mid=5");
		if($MG['edit_limit'] < 0) message($L['edit_refuse']);
		if($MG['edit_limit'] && $AJ_TIME - $item['addtime'] > $MG['edit_limit']*86400) message(lang($L['edit_limit'], array($MG['edit_limit'])));

		if($submit) {
			if($do->pass($post)) {
				$CAT = get_cat($post['catid']);
				
				$post['addtime'] = timetodate($item['addtime']);
				$post['level'] = $item['level'];
				$post['fee'] = $item['fee'];
				$post['style'] = addslashes($item['style']);
				$post['template'] = addslashes($item['template']);
				$post['filepath'] = addslashes($item['filepath']);
				$post['note'] = addslashes($item['note']);
				if(!$IMVIP && $MG['uploadpt']) {
					$post['thumb1'] = $item['thumb1'];
					$post['thumb2'] = $item['thumb2'];
				}
                $need_check =  $MOD['check_add'] == 2 ? $MG['check'] : $MOD['check_add'];
				$post['status'] = get_status($item['status'], $need_check);
				$post['hits'] = $item['hits'];
				$post['username'] = $_username;
				if($FD) fields_check($post_fields);
				if($CP) property_check($post_ppt);
				if($FD) fields_update($post_fields, $table, $do->itemid);
				if($CP) property_update($post_ppt, $moduleid, $post['catid'], $do->itemid);
				$do->edit($post);
					if($swf_upload) {
				foreach(explode('|', $swf_upload) as $v) {
					if($v) {
						$thumb .= $v;
						$db->query("INSERT INTO {$AJ_PRE}house_pic (item,thumb,mid) VALUES ('$do->itemid', '$v',5)");
						if(!$post['thumb']) $db->query("UPDATE {$AJ_PRE}rent_5  SET thumb='$v' WHERE itemid=$do->itemid");
					}
				}
			}
				set_cookie('dmsg', $L['success_edit']);
				dalert('', '', 'parent.window.location="'.$forward.'"');
			} else {
				dalert($do->errmsg);
			}
		} else {
			extract($item);
			$totime = $totime ? timetodate($totime, 3) : '';
			$mycatid_select = type_select('product-'.$_userid, 0, 'post[mycatid]', $L['type_default'], $mycatid);
		}
	break;
	case 'delete':
		$MG['delete'] or message();
		$itemid or message();
		$itemids = is_array($itemid) ? $itemid : array($itemid);
		foreach($itemids as $itemid) {
			$do->itemid = $itemid;
			$item = $db->get_one("SELECT username FROM {$table} WHERE itemid=$itemid");
			if(!$item || $item['username'] != $_username) message();
			$do->recycle($itemid);
		}
		dmsg($L['success_delete'], $forward);
	break;
	case 'refresh':
		$MG['refresh_limit'] > -1 or dalert(lang('message->without_permission_and_upgrade'), 'goback');
		$itemid or message($L['select_info']);
		$itemids = $itemid;
		$s = $f = 0;
		foreach($itemids as $itemid) {
			$do->itemid = $itemid;
			$item = $db->get_one("SELECT username,edittime FROM {$table} WHERE itemid=$itemid");
			$could_refresh = $item && $item['username'] == $_username;
			if($could_refresh && $MG['refresh_limit'] && $AJ_TIME - $item['edittime'] < $MG['refresh_limit']) $could_refresh = false;
			if($could_refresh && $MOD['credit_refresh'] && $MOD['credit_refresh'] > $_credit) $could_refresh = false;
			if($could_refresh) {
				$do->refresh($itemid);
				$s++;
				if($MOD['credit_refresh']) $_credit = $_credit - $MOD['credit_refresh'];
			} else {
				$f++;
			}			
		}
		if($MOD['credit_refresh'] && $s) {
			$credit = $s*$MOD['credit_refresh'];
			credit_add($_username, -$credit);
			credit_record($_username, -$credit, 'system', lang($L['credit_record_refresh'], array($MOD['name'])), lang($L['refresh_total'], array($s)));
		}
		$msg = lang($L['refresh_success'], array($s));
		if($f) $msg = $msg.' '.lang($L['refresh_fail'], array($f));
		dmsg($msg, $forward);
	break;
		case 'item_delete':
		$itemid or msg();
		$do->item_delete($itemid);
		dmsg('删除成功', $forward);
	break;
	case 'item_index':
		$itemid or msg();
		$do->item_index($itemid);
		dmsg('设置成功', $forward);
	break;
	default:
		$status = isset($status) ? intval($status) : 3;
		in_array($status, array(1, 2, 3, 4)) or $status = 3;
		$typeid = isset($typeid) ? ($typeid === '' ? -1 : intval($typeid)) : -1;
		$mycatid = isset($mycatid) ? ($mycatid === '' ? -1 : intval($mycatid)) : -1;
		$mycat_select = type_select('product-'.$_userid, 0, 'mycatid', $L['type_default'], $mycatid, '', $L['type_my']);

		$condition = "username='$_username' AND status=$status";
		if($keyword) $condition .= " AND keyword LIKE '%$keyword%'";
		if($catid) $condition .= $CAT['child'] ? " AND catid IN (".$CAT['arrchildid'].")" : " AND catid=$catid";
		if($typeid >= 0) $condition .= " AND typeid=$typeid";
		if($mycatid >= 0) $condition .= " AND mycatid IN (".type_child($mycatid, $MTYPE).")";

		$timetype = strpos($MOD['order'], 'add') !== false ? 'add' : '';
		$lists = $do->get_list($condition, $MOD['order']);
		
		foreach($lists as $k=>$v) {
			$lists[$k]['linkurl'] = mobileurl($moduleid, 0, $v['itemid']);
		}
	break;
}
if($_userid) {
	$nums = array();
	for($i = 1; $i < 5; $i++) {
		$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE username='$_username' AND status=$i");
		$nums[$i] = $r['num'];
	}
	$nums[0] = count($MTYPE);
}
$head_title = lang($L['module_manage'], array($MOD['name']));
include template('fang', 'mobile');
?>