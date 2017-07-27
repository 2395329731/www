<?php
defined('IN_AIJIACMS') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form action="?">
<div class="tt">记录搜索</div>
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td>
&nbsp;<?php echo $fields_select;?>&nbsp;
<input type="text" size="50" name="kw" value="<?php echo $kw;?>" title="关键词"/>&nbsp;
<?php echo $order_select;?>
&nbsp;
<input type="text" name="psize" value="<?php echo $pagesize;?>" size="2" class="t_c" title="条/页"/>
<input type="submit" value="搜 索" class="btn"/>&nbsp;
<input type="button" value="重 置" class="btn" onclick="Go('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=<?php echo $action;?>');"/>
</td>
</tr>
</table>
</form>
<form method="post">
<div class="tt">客户列表</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th width="25"><input type="checkbox" onclick="checkall(this.form);"/></th>
<th width="35">姓名</th>
<th width="60">联系电话</th>
<th  width="90">意向楼盘</th>
<th width="40">意向区域</th>
<th width="70">备注</th>
<th width="35">推荐人</th>
<th width="50">推荐时间</th>
<th width="30">状态</th>
<th width="58">成交价(万元)</th>
<th width="35">返佣</th>
<th width="45">成交楼盘</th>
<th width="50">受理时间</th>
<th width="30">管理</th>
</tr>
<?php foreach($lists as $k=>$v) {?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
<td><input type="checkbox" name="itemid[]" value="<?php echo $v['itemid'];?>"/></td>
<td><?php echo $v['truename'];?></td>
<td><?php echo $v['mobile'];?></td>
<td><?php echo $v['hname'];?></td>
<td><?php echo fenxiaoqy($v[areaid], ' ');?></td>
<td><?php echo $v['note'];?></td>
<td ><a href="javascript:_user('<?php echo $v['tuijian'];?>');"><?php echo $v['tuijian'];?></a></td>
<td class="px11"><?php echo timetodate($v['addtime'], 3);?></td>
<td><?php echo $_status[$v['status']];?></td>
<td><?php echo $v['cprice'];?></td>
<td><?php echo $v['cmoney'];?></td>
<td><?php echo $v['shouse'];?></td>
<td class="px11"><?php echo timetodate($v['saddtime'], 3);?></td>
<td>
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=edit&itemid=<?php echo $v['itemid'];?>"><img src="admin/image/edit.png" width="16" height="16" title="受理" alt=""/></a>
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&itemid=<?php echo $v['itemid'];?>" onclick="return _delete();"><img src="admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a>
</td>
</tr>
<?php }?>
</table>
<div class="btns">
<input type="submit" value=" 删 除 " class="btn" onclick="if(confirm('确定要删除选中吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>
</div>
</form>
<div class="pages"><?php echo $pages;?></div>
<br/>
<script type="text/javascript">Menuon(<?php echo $menuon[$status];?>);</script>
<?php include tpl('footer');?>