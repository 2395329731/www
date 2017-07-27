<?php
defined('IN_AIJIACMS') or exit('Access Denied');
require MD_ROOT.'/message.class.php';
$menus = array (
    array('发送信件', '?moduleid='.$moduleid.'&file='.$file.'&action=send'),
    array('会员信件', '?moduleid='.$moduleid.'&file='.$file),
    array('系统信件', '?moduleid='.$moduleid.'&file='.$file.'&action=system'),
    array('邮件转发', '?moduleid='.$moduleid.'&file='.$file.'&action=mail'),
    array('信件清理', '?moduleid='.$moduleid.'&file='.$file.'&action=clear'),
);
$do = new message;
$this_forward = '?moduleid='.$moduleid.'&file='.$file;

$NAME = array('普通', '意向登记', '报价', '留言', '信使');

switch($action) {
	case 'send':
		if($submit) {
			if($do->_send($message)) {
				dmsg('发送成功', $this_forward);
			} else {
				msg($do->errmsg);
			}
		} else {
			isset($touser) or $touser = '';
			include tpl('message_send', $module);
		}
	break;
	case 'edit':
		$itemid or msg();
		$do->itemid = $itemid;
		if($submit) {
			$do->_edit($message);
			dmsg('修改成功', '?moduleid='.$moduleid.'&file='.$file.'&action=system');
		} else {
			extract($do->get_one());
			include tpl('message_edit', $module);
		}
	break;
	case 'clear':
		if($submit) {
			if($do->_clear($message)) {
				dmsg('清理成功', $forward);
			} else {
				msg($do->errmsg);
			}
		} else {
			$todate = timetodate(strtotime('-1 year'), 3);
			include tpl('message_clear', $module);
		}
	break;
	
	case '_delete':
		if(!$itemid) msg();
		$do->_delete($itemid);
		dmsg('删除成功', $this_forward);
	break;
	
	case 'delete':
		if(!$itemid) msg();
		$do->itemid = $itemid;
		$do->delete();
		dmsg('删除成功', $forward);
	break;
	
	default:
		$sfields = array('标题', '发件人', '收件人');
		$dfields = array('title', 'fromuser', 'touser');
		$S = array('状态', '草稿箱', '发件箱', '收件箱', '回收站');

		isset($fields) && isset($dfields[$fields]) or $fields = 0;
		$typeid = isset($typeid) ? intval($typeid) : -1;
		$read = isset($read) ? intval($read) : -1;
		$send = isset($send) ? intval($send) : -1;
		$status = isset($status) ? intval($status) : 0;

		$fields_select = dselect($sfields, 'fields', '', $fields);
		$status_select = dselect($S, 'status', '', $status);

		$condition = "groupids=''";
		if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
		if($status) $condition .= " AND status=$status";
		$condition .= " AND typeid=1";
		if($read > -1) $condition .= " AND isread=$read";
		if($send > -1) $condition .= " AND issend=$send";
        if($title) $condition .= " AND title='$title'";
		$lists = $do->get_list($condition);
		include tpl('house_groupbuy', $module);
	break;
}
?>