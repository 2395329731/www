<?php
defined('IN_AIJIACMS') or exit('Access Denied');


require MD_ROOT.'/price.class.php';
$do = new price;
$menus = array (
	array('添加报价', '?file='.$file.'&moduleid='.$moduleid.'&pid='.$pid.'&title='.$title.'&action=add'),
	array('报价管理', '?file='.$file.'&moduleid='.$moduleid.'&pid='.$pid),
	array('报价审核', '?file='.$file.'&moduleid='.$moduleid.'&pid='.$pid.'&action=check'),
);

if(in_array($action, array('', 'check'))) {
	$sfields = array( '会员', 'IP', '编辑', '备注');
	$dfields = array( 'username', 'ip', 'editor', 'note');
	$sorder  = array('结果排序方式', '添加时间降序', '添加时间升序', '更新时间降序', '更新时间升序', '报价降序', '报价升序');
	$dorder  = array('addtime DESC', 'addtime DESC', 'addtime ASC', 'edittime DESC', 'edittime ASC', 'price DESC', 'price ASC');
		
	isset($fields) && isset($dfields[$fields]) or $fields = 0;
	isset($order) && isset($dorder[$order]) or $order = 0;
	$itemid or $itemid = '';
	$market = isset($market) ? intval($market) : 0;	
	$minprice = isset($minprice) ? dround($minprice) : '';
	$minprice or $minprice = '';
	$maxprice = isset($maxprice) ? dround($maxprice) : '';
	$maxprice or $maxprice = '';

	$fields_select = dselect($sfields, 'fields', '', $fields);
	$order_select  = dselect($sorder, 'order', '', $order);
	$condition = '';
	if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
	if($areaid) $condition .= ($ARE['child']) ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
	if($minprice)  $condition .= " AND price>=$minprice";
	if($maxprice)  $condition .= " AND price<=$maxprice";
	if($itemid) $condition .= " AND itemid=$itemid";
	 if($pid) $condition .= " AND pid=$pid";
	$timetype = strpos($dorder[$order], 'edit') === false ? 'add' : '';
}
switch($action) {
	case 'add':
		if($submit) {
			if($do->pass($post)) {
				$do->add($post);
				dmsg('添加成功', '?moduleid='.$moduleid.'&file='.$file.'&pid='.$post['pid']);
			} else {
				msg($do->errmsg);
			}
		} else {
			foreach($do->fields as $v) {
				isset($$v) or $$v = '';
			}
			$username = $_username;
			$status = 3;
			$addtime = timetodate($AJ_TIME);
			$menuid = 0;
			include tpl('price_edit', $module);
		}
	break;
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
			$menuid = 1;
			include tpl('price_edit', $module);
		}
	break;
	case 'delete':
		$itemid or msg('请选择信息');
		$do->delete($itemid);
		dmsg('删除成功', $forward);
	break;
	case 'check':
		if($itemid && !$psize) {
			$do->check($itemid);
			dmsg('审核成功', $forward);
		} else {
			$lists = $do->get_list('status=2'.$condition, $dorder[$order]);
			$menuid = 2;
			include tpl('price', $module);
		}
	break;
	default:
		$item = 0;
		$lists = $do->get_list('status=3'.$condition, $dorder[$order]);
		
		$menuid = 1;
		include tpl('price', $module);
	break;
}
?>