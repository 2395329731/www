<?php
defined('AJ_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form action="?">
<div class="tt"><?php echo $MOD['name'];?>搜索</div>
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td>
&nbsp;<?php echo $fields_select;?>&nbsp;
<input type="text" size="25" name="kw" value="<?php echo $kw;?>" title="关键词"/>&nbsp;
<?php echo $type_select;?>&nbsp;
<?php echo $level_select;?>&nbsp;
<?php echo $order_select;?>&nbsp;
<input type="text" name="psize" value="<?php echo $pagesize;?>" size="2" class="t_c" title="条/页"/>
<input type="submit" value="搜 索" class="btn"/>&nbsp;
<input type="button" value="重 置" class="btn" onclick="Go('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=<?php echo $action;?>');"/>
</td>
</tr>
<tr>
<td>
&nbsp;<select name="datetype">
<option value="edittime" <?php if($datetype == 'edittime') echo 'selected';?>>更新日期</option>
<option value="addtime" <?php if($datetype == 'addtime') echo 'selected';?>>发布日期</option>
<option value="totime" <?php if($datetype == 'totime') echo 'selected';?>>到期日期</option>
</select>&nbsp;
<?php echo dcalendar('fromdate', $fromdate, '');?> 至 <?php echo dcalendar('todate', $todate, '');?>&nbsp;
<?php echo category_select('catid', '房源状态', $catid, $moduleid);?>&nbsp;
<?php echo ajax_area_select('areaid', '所在地区', $areaid);?>&nbsp;
ID：<input type="text" size="4" name="itemid" value="<?php echo $itemid;?>"/>&nbsp;
<input type="checkbox" name="thumb" value="1"<?php echo $thumb ? ' checked' : '';?>/>图片&nbsp;
<input type="checkbox" name="guest" value="1"<?php echo $guest ? ' checked' : '';?>/>游客&nbsp;
</td>
</tr>
<tr>
<td>
&nbsp;单价：<input type="text" size="4" name="minprice" value="<?php echo $minprice;?>"/> ~ <input type="text" size="4" name="maxprice" value="<?php echo $maxprice;?>"/>&nbsp;


<input type="checkbox" name="price" value="1"<?php echo $price ? ' checked' : '';?>/>标价&nbsp;
<input type="checkbox" name="vip" value="1"<?php echo $vip ? ' checked' : '';?>/><?php echo VIP;?>&nbsp;
<input type="checkbox" name="elite" value="1"<?php echo $elite ? ' checked' : '';?>/>橱窗&nbsp;
</td>
</tr>
</table>
</form>
<form method="post">
<div class="tt"><?php echo $menus[$menuid][0];?></div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th width="25"><input type="checkbox" onclick="checkall(this.form);"/></th>
<th>楼盘名称</th>
<th>所在区域</th>
<th width="14"> </th>
<th width="50">资讯</th>
<th width="50">相册</th>
<th>视频</th>
<th>意向</th>
<th>问房</th>
<th>点评</th>
<th>楼盘报价</th>
<th>参考价</th>
<th>会员</th>
<th width="120"><?php echo $timetype == 'add' ? '添加' : '更新';?>时间</th>
<th width="120">管理操作</th>
</tr>
<?php foreach($lists as $k=>$v) {?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
<td><input type="checkbox" name="itemid[]" value="<?php echo $v['itemid'];?>"/></td>
<td><a href="<?php echo $v['linkurl'];?>" target="_blank"><?php if($v['thumb']) {?><font style="color:red">图&nbsp;</font><?php } ?><?php echo $v['title'];?></a><?php if($v['vip']) {?> <img src="<?php echo AJ_SKIN;?>image/vip.gif" title="<?php echo VIP;?>:<?php echo $v['vip'];?>"/><?php } ?><?php if($v['isfx']) {?><font style="color:red">&nbsp;&nbsp;已加入分销</font><?php } ?></td>
<td><?php echo area_pos($v['areaid'], ' ');?></td>
<td><?php if($v['level']) {?><a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=<?php echo $action;?>&level=<?php echo $v['level'];?>"><img src="admin/image/level_<?php echo $v['level'];?>.gif" title="<?php echo $v['level'];?>级" alt=""/></a><?php } ?></td>

<td><a href="javascript:Dwidget('?moduleid=8&file=<?php echo $file;?>&houseid=<?php echo $v['itemid'];?>&housename=<?php echo $v['title'];?>', '[<?php echo $v['alt'];?>] 资讯列表');">[<?php echo get_housenum('article_8',$v['itemid']);?>]</a></td>
<td><a href="javascript:Dwidget('?moduleid=12&file=<?php echo $file;?>&houseid=<?php echo $v['itemid'];?>&housename=<?php echo $v['title'];?>', '[<?php echo $v['alt'];?>] 图片列表');">[<?php echo get_housenum('photo_12',$v['itemid']);?>]</a></td>
<td><a href="javascript:Dwidget('?moduleid=14&file=<?php echo $file;?>&houseid=<?php echo $v['itemid'];?>&housename=<?php echo $v['title'];?>', '[<?php echo $v['alt'];?>] 视频列表');">[<?php echo get_housenum('video_14',$v['itemid']);?>]</a></td>
<td><a href="javascript:Dwidget('?moduleid=2&file=message&action=&typeid=1&title=<?php echo $v['title'];?>', '[<?php echo $v['alt'];?>] 意向列表');">[<?php echo get_buynum($v['title']);?>]</a></td>
<td><a href="javascript:Dwidget('?moduleid=3&file=wenfang&item_id=<?php echo $v['itemid'];?>', '[<?php echo $v['alt'];?>] 问房列表');">[<?php echo get_wfnum($v['itemid']);?>]</a></td>
<td><a href="javascript:Dwidget('?moduleid=3&file=comment&item_id=<?php echo $v['itemid'];?>', '[<?php echo $v['alt'];?>] 点评列表');">[<?php echo get_dpnum($v['itemid']);?>]</a></td>
<td><a href="javascript:Dwidget('?moduleid=6&file=price&action=add&pid=<?php echo $v['itemid'];?>&title=<?php echo $v['title'];?>', '[<?php echo $v['alt'];?>] 添加报价');"><img src="admin/image/add.png" width="16" height="16" title="添加报价" alt=""/></a>&nbsp;&nbsp;&nbsp;<a href="javascript:Dwidget('?moduleid=6&file=price&pid=<?php echo $v['itemid'];?>&title=<?php echo $v['title'];?>', '[<?php echo $v['alt'];?>] 报价列表');"><img src="admin/image/poll.png" width="16" height="16" title="报价记录" alt=""/></a></td>
<td><?php echo $v['price'] ? $v['price'] : '';?></td>
<td>
<?php if($v['username']) { ?>
<a href="javascript:_user('<?php echo $v['username'];?>');"><?php echo $v['username'];?></a>
<?php } else { ?>
	<a href="javascript:_ip('<?php echo $v['ip'];?>');" title="游客"><?php echo $v['ip'];?></a>
<?php } ?>
</td>
<?php if($timetype == 'add') {?>
<td class="px11" title="更新时间<?php echo timetodate($v['edittime'], 5);?>"><?php echo timetodate($v['addtime'], 3);?></td>
<?php } else { ?>
<td class="px11" title="添加时间<?php echo timetodate($v['addtime'], 5);?>"><?php echo timetodate($v['edittime'], 3);?></td>
<?php } ?>

<td>
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=edit&itemid=<?php echo $v['itemid'];?>">修改</a> |  
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&itemid=<?php echo $v['itemid'];?>" onclick="return _delete();">删除</a> 
</td>
</tr>
<?php } ?>
</table>
<div class="btns">

<?php if($action == 'check') { ?>

<input type="submit" value=" 通过审核 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=check';"/>&nbsp;
<input type="submit" value=" 拒 绝 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=reject';"/>&nbsp;
<input type="submit" value=" 移动分类 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=move';"/>&nbsp;
<input type="submit" value=" 回收站 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&recycle=1';"/>&nbsp;
<input type="submit" value=" 彻底删除 " class="btn" onclick="if(confirm('确定要删除选中<?php echo $MOD['name'];?>吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>&nbsp;

<?php } else if($action == 'expire') { ?>

<span class="f_red f_r">
批量延长过期时间 <input type="text" size="3" name="days" id="days" value="60"/> 
天 <input type="submit" value=" 确 定 " class="btn" onclick="if(Dd('days').value==''){alert('请填写天数');return false;}if(confirm('确定要延长'+Dd('days').value+'天吗？')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=expire&refresh=1&extend=1'}else{return false;}"/>
</span>

<input type="submit" value="刷新过期" class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=expire&refresh=1';"/>&nbsp;
<input type="submit" value=" 回收站 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&recycle=1';"/>&nbsp;
<input type="submit" value=" 彻底删除 " class="btn" onclick="if(confirm('确定要删除选中<?php echo $MOD['name'];?>吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>&nbsp;

<?php } else if($action == 'reject') { ?>

<input type="submit" value=" 回收站 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&recycle=1';"/>&nbsp;
<input type="submit" value=" 彻底删除 " class="btn" onclick="if(confirm('确定要删除选中<?php echo $MOD['name'];?>吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>&nbsp;

<?php } else if($action == 'recycle') { ?>

<input type="submit" value=" 彻底删除 " class="btn" onclick="if(confirm('确定要删除选中<?php echo $MOD['name'];?>吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>&nbsp;
<input type="submit" value=" 还 原 " class="btn" onclick="if(confirm('确定要还原选中<?php echo $MOD['name'];?>吗？状态将被设置为已通过')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=restore'}else{return false;}"/>&nbsp;
<input type="submit" value=" 清 空 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=clear';"/>

<?php } else { ?>

<input type="submit" value="刷新信息" class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=refresh';" title="刷新时间为最新"/>&nbsp;
<input type="submit" value=" 更新信息 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=update';"/>&nbsp;
<?php if($MOD['show_html']) { ?><input type="submit" value=" 生成网页 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=tohtml';"/>&nbsp;<?php } ?>
<input type="submit" value=" 回收站 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&recycle=1';"/>&nbsp;
<input type="submit" value=" 彻底删除 " class="btn" onclick="if(confirm('确定要删除选中<?php echo $MOD['name'];?>吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>&nbsp;
<input type="submit" value=" 移动分类 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=move';"/>&nbsp;
<?php echo level_select('level', '设置级别为</option><option value="0">取消', 0, 'onchange="this.form.action=\'?moduleid='.$moduleid.'&file='.$file.'&action=level\';this.form.submit();"');?>&nbsp;
<select name="tid" onchange="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=type';this.form.submit();">
<option value="">设置类型为</option>
<?php foreach($TYPE as $k=>$v) { ?>
<option value="<?php echo $k;?>"><?php echo $v;?></option>
<?php } ?>
</select>
<?php } ?>
</div>
</form>
<div class="pages"><?php echo $pages;?></div>
<br/>
<script type="text/javascript">Menuon(<?php echo $menuid;?>);</script>
<?php include tpl('footer');?>