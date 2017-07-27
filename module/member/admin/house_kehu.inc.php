<?php
defined('IN_AIJIACMS') or exit('Access Denied');
require MD_ROOT.'/kehu.class.php';
$do = new kehu();
$menus = array (
   // array('客户记录', '?moduleid='.$moduleid.'&file='.$file),
    array('待受理', '?moduleid='.$moduleid.'&file='.$file),
    array('已预约', '?moduleid='.$moduleid.'&file='.$file.'&action=yuyue'),
	array('已到访', '?moduleid='.$moduleid.'&file='.$file.'&action=daofang'),
	array('已交定金', '?moduleid='.$moduleid.'&file='.$file.'&action=dingjin'),
	array('已成交', '?moduleid='.$moduleid.'&file='.$file.'&action=chengjiao'),
);
$_status = array(
    '<span style="color:#0000FF;">待受理</span>',
	'<span style="color:#0000FF;">已预约</span>',
	'<span style="color:#FF0000;">已到访</span>',
	'<span style="color:#FF6600;">已交定金</span>',
	'<span style="color:#008000;">已成交</span>',
);


if(in_array($action, array('', 'yuyue', 'daofang', 'dingjin', 'chengjiao'))) {
	$sfields = array('姓名', '推荐人',  '电话');
	$dfields = array('truename', 'tuijian',  'mobile');
	$sorder  = array('结果排序方式', '时间降序', '时间升序', '受理时间降序', '受理时间升序');
	$dorder  = array('addtime DESC', 'addtime DESC', 'addtime ASC', 'edittime DESC', 'edittime ASC');

	isset($fields) && isset($dfields[$fields]) or $fields = 0;
	isset($order) && isset($dorder[$order]) or $order = 0;

	$fields_select = dselect($sfields, 'fields', '', $fields);
	$order_select  = dselect($sorder, 'order', '', $order);

	$condition = '';
	if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
}
$menuon = array('0', '1', '2', '3', '4');
switch($action) {
	case 'edit':
		$itemid or msg();
		$do->itemid = $itemid;
		if($submit) {
			if($do->edit($post)) {
				dmsg('操作成功', $forward);
			} else {
				msg($do->errmsg);
			}
		} else {
			extract($do->get_one());
			$user = $username ? userinfo($username) : array();
			$addtime = timetodate($addtime);
			$edittime = timetodate($edittime);
		
			
			include tpl('kehu_edit', $module);
		}
	break;
	case 'delete':
		$itemid or msg('请选择记录');
		$do->delete($itemid);
		dmsg('删除成功', $forward);
	break;
	case 'yuyue':
		$status = 1;
		$lists = $do->get_list('status='.$status.$condition, $dorder[$order]);
		include tpl('house_kehu', $module);
	break;
	case 'daofang':
		$status = 2;
		$lists = $do->get_list('status='.$status.$condition, $dorder[$order]);
		include tpl('house_kehu', $module);
	break;
	case 'dingjin':
		$status = 3;
		$lists = $do->get_list('status='.$status.$condition, $dorder[$order]);
		include tpl('house_kehu', $module);
	break;
	case 'chengjiao':
		$status = 4;
		$lists = $do->get_list('status='.$status.$condition, $dorder[$order]);
		include tpl('house_kehu', $module);
	break;
	default:
		$status = 0;
		$lists = $do->get_list('status='.$status.$condition, $dorder[$order]);
		include tpl('house_kehu', $module);
	break;
}
?>