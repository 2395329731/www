<?php
/*
	[Aijiacms System] Copyright (c) 2011-2015 www.aijiacms.com
	This is NOT a freeware, use is subject to license.txt
*/
defined('AJ_ADMIN') or exit('Access Denied');
isset($item) or msg();
require AJ_ROOT.'/include/module.func.php';
require AJ_ROOT.'/include/type.class.php';
$forward = '?file='.$file.'&item='.$item;
$do = new dtype;
$do->item = $item;
$do->cache = 1;
$TYPE = $do->get_list();
if($submit) {
	$do->update($post);
	dmsg('更新成功', $forward);
} else {
	$types = $TYPE;
	$parent_option = '<option value="0">上级分类</option>'.$do->parent_option($TYPE);
	$parent_select = '<select name="post[0][parentid]">'.$parent_option .'</select>';
	foreach($types as $k=>$v) {
		$types[$k]['style_select'] = dstyle('post['.$v['typeid'].'][style]', $v['style']);
		$types[$k]['parent_select'] = '<select name="post['.$v['typeid'].'][parentid]">'.str_replace('"'.$v['parentid'].'"', '"'.$v['parentid'].'" selected', $parent_option).'</select>';
	}
	$new_style = dstyle('post[0][style]');
	$lists = sort_type($types);
	include tpl('type');
}
?>