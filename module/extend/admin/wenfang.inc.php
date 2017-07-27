<?php
defined('IN_AIJIACMS') or exit('Access Denied');
require MD_ROOT.'/wenfang.class.php';
$do = new wenfang();
$menus = array (
    array('问房列表', '?moduleid='.$moduleid.'&file='.$file),
    array('问房审核', '?moduleid='.$moduleid.'&file='.$file.'&item_id='.$item_id.'&action=check'),
    array('问房设置', '?moduleid='.$moduleid.'&file=setting#wenfang'),
);
$this_forward = '?moduleid='.$moduleid.'&file='.$file;
if(in_array($action, array('', 'check'))) {
	$sfields = array('内容', '原文标题', '原文链接', '会员名', 'IP', '原文ID', '问房ID');
	$dfields = array('content', 'item_title', 'item_linkurl', 'username', 'ip', 'item_id', 'itemid');
	$sorder  = array('结果排序方式', '添加时间降序', '添加时间升序', '回复时间降序', '回复时间升序');
	$dorder  = array('itemid desc', 'addtime DESC', 'addtime ASC', 'replytime DESC', 'replytime ASC');
	$sstar = $L['star_type'];

	isset($fields) && isset($dfields[$fields]) or $fields = 0;
	isset($order) && isset($dorder[$order]) or $order = 0;
	
	isset($ip) or $ip = '';
	$mid = isset($mid) ? intval($mid) : 0;

	$fields_select = dselect($sfields, 'fields', '', $fields);
	$module_select = module_select('mid', '模块', $mid);
	$order_select  = dselect($sorder, 'order', '', $order);
	

	$condition = '';
	if($keyword) $condition .= in_array($dfields[$fields], array('item_id', 'itemid', 'ip')) ? " AND $dfields[$fields]='$kw'" : " AND $dfields[$fields] LIKE '%$keyword%'";
	if($mid) $condition .= " AND item_mid='$mid'";
	if($ip) $condition .= " AND ip='$ip'";
	if($item_id) $condition = " AND item_id=$item_id";
}
switch($action) {
	case 'edit':
		$itemid or msg();
		$do->itemid = $itemid;
		if($submit) {
			if($do->pass($post)) {
				$do->edit($post);
				dmsg('修改成功', $forward);
			} else {
				msg($do->errmsg);
			}
		} else {
			extract($do->get_one());
			$addtime = timetodate($addtime);
			$replytime = $replytime ? timetodate($replytime, 6) : '';
			include tpl('wenfang_edit', $module);
		}
	break;
	
	case 'delete':
		$itemid or msg('请选择问房');
		$do->delete($itemid);
		dmsg('删除成功', $this_forward);
	break;
	case 'check':
		if($itemid) {
			$status = $status == 3 ? 3 : 2;
			$do->check($itemid, $status);
			dmsg($status == 3 ? '审核成功' : '取消成功', $forward);
		} else {
			$lists = $do->get_list('status=2'.$condition, $dorder[$order]);
			$menuid = 1;
			include tpl('wenfang', $module);
		}
	break;
	default:
		$lists = $do->get_list('status=3'.$condition, $dorder[$order]);
		$menuid = 0;
		include tpl('wenfang', $module);
	break;
}
?>