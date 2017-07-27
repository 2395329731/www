<?php
defined('IN_AIJIACMS') or exit('Access Denied');
$menus = array (
    array('佣金结算', '?moduleid='.$moduleid.'&file='.$file),
    //array('', 'javascript:Dwidget(\'?file=type&item='.$file.'\', \'问题分类\');'),
);
$stars = array('', '<span style="color:red;">不满意</span>', '基本满意', '<span style="color:green;">非常满意</span>');
switch($action) {
	case 'edit':
		$itemid or msg();
		if($submit) {
			$note = addslashes(save_remote(save_local(stripslashes($note))));
			$db->query("UPDATE {$AJ_PRE}finance_amount SET status=$status,admin='$_username',admintime='$AJ_TIME',note='$note' WHERE itemid=$itemid");
			if($status == 1){
			        money_add($username, $amount);
					money_record($username, $amount, $L['in_site'], 'system', '分销平台返佣金', '推荐客户'.$kehu.'返佣金');
			
				}	
			dmsg('受理成功', $forward);
		} else {
			$r = $db->get_one("SELECT * FROM {$AJ_PRE}finance_amount WHERE itemid=$itemid");
			$r or msg();
			extract($r);
			$addtime = timetodate($addtime, 5);
			$admintime = timetodate($admintime, 5);
			include tpl('amount_edit', $module);
		}
	break;
	case 'delete':
		$itemid or msg();
		if(is_array($itemid)) {
			foreach($itemid as $v) {
			$db->query("DELETE FROM {$AJ_PRE}finance_amount WHERE itemid=$v ");
			}
		} 
		else{
		$db->query("DELETE FROM {$AJ_PRE}finance_amount WHERE itemid=$itemid ");}
		dmsg('删除成功', '?moduleid='.$moduleid.'&file='.$file);
	break;
	
	default:
		$_status = array('未结算', '<span style="color:red;">已结算</span>');
		$sfields = array('按条件', '成交客户', '推荐人', '受理人');
		$dfields = array('kehu', 'kehu',  'username',  'admin');
		$dstatus = array('未结算', '已结算');
		$sorder  = array('结果排序方式', '提交时间降序', '提交时间升序', '受理时间降序', '受理时间升序', '佣金降序', '佣金升序');
		$dorder  = array('itemid DESC', 'itemid DESC', 'itemid ASC', 'admintime DESC', 'admintime ASC', 'amount DESC', 'amount ASC');
		isset($fields) && isset($dfields[$fields]) or $fields = 0;
		isset($typeid) or $typeid = 0;
		$status = isset($status) && isset($dstatus[$status]) ? intval($status) : '';
		isset($order) && isset($dorder[$order]) or $order = 0;
		$fields_select = dselect($sfields, 'fields', '', $fields);
		$type_select   = type_select('ask', 1, 'typeid', '请选择分类', $typeid);
		$status_select = dselect($dstatus, 'status', '受理状态', $status, '', 1, '', 1);
		$order_select  = dselect($sorder, 'order', '', $order);
		$condition = '1';
		if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
		if($typeid > 0) $condition .= " AND typeid=$typeid";
		if($status !== '') $condition .= " AND status=$status";
		if($page > 1 && $sum) {
			$items = $sum;
		} else {
			$r = $db->get_one("SELECT COUNT(*) AS num FROM {$AJ_PRE}finance_amount WHERE $condition");
			$items = $r['num'];
		}
		$pages = pages($items, $page, $pagesize);
		$asks = array();
		$result = $db->query("SELECT * FROM {$AJ_PRE}finance_amount WHERE $condition ORDER BY $dorder[$order] LIMIT $offset,$pagesize");
		while($r = $db->fetch_array($result)) {
			$r['addtime'] = timetodate($r['addtime'], 5);
			$r['dstatus'] = $_status[$r['status']];
			$r['type'] = $r['typeid'] && isset($TYPE[$r['typeid']]) ? set_style($TYPE[$r['typeid']]['typename'], $TYPE[$r['typeid']]['style']) : '默认';
			$amount[] = $r;
		}
		include tpl('amount', $module);
	break;
}
?>