<?php
defined('AJ_ADMIN') or exit('Access Denied');
$menu = array(
	array("楼盘列表", "?moduleid=$moduleid"),
	array("团购管理", "?moduleid=2&file=house_groupbuy"),
	array("图库管理", "?moduleid=12"),
	array("报价管理", "?moduleid=$moduleid&file=price"),
	array("问房管理", "?moduleid=3&file=wenfang"),
	array("点评管理", "?moduleid=3&file=comment"),
	array("物业类型", "?file=category&mid=$moduleid"),
	array("更新数据", "?moduleid=$moduleid&file=html"),
	array("模块设置", "?moduleid=$moduleid&file=setting"),
	
);
?>