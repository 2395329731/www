<?php
defined('IN_AIJIACMS') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<div class="tt">客户处理</div>
<form method="post" action="?">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl"><span class="f_hid">*</span> 姓名</td>
<td><?php echo $truename;?></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 联系电话</td>
<td><?php echo $mobile;?></td>
</tr>
<tr class="on">
<td class="tl"><span class="f_hid">*</span> 意向区域</td>
<td><?php echo fenxiaoqy($areaid);?></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 楼盘</td>
<td><?php foreach(explode(',', rtrim($house, ",")) as $v) {?><input type="radio" name="post[house2]" value=" <?php echo $v;?>"<?php echo $house2 == $v ? ' checked' : '';?> /> <?php echo  fxlp($v);?><?php }?></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 备注</td>
<td><?php echo $note;?></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 推荐人</td>
<td><a href="javascript:_user('<?php echo $tuijian;?>');"><?php echo $tuijian;?></a></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 提交时间</td>
<td><?php echo $addtime;?></td>
</tr>

<tr>
<td class="tl"><span class="f_hid">*</span> 客户状态</td>
<td>
<input type="radio" name="post[status]" value="0"<?php echo $status == 0 ? ' checked' : '';?> /> 待受理
<input type="radio" name="post[status]" value="1"<?php echo $status == 1 ? ' checked' : '';?> id="s_1" onclick="S(this.value);"/> 已预约
<input type="radio" name="post[status]" value="2"<?php echo $status == 2 ? ' checked' : '';?>  id="s_2" onclick="S(this.value);"/> 已到访
<input type="radio" name="post[status]" value="3"<?php echo $status == 3 ? ' checked' : '';?>  id="s_3" onclick="S(this.value);"/> 已交定金
<input type="radio" name="post[status]" value="4"<?php echo $status == 4 ? ' checked' : '';?>  id="s_4" onclick="S(this.value);"/> 已成交
</td>
</tr>

</tbody>
<tbody id="send" style="display:none;">

<tr>
<td class="tl"><span class="f_hid">*</span> 发送通知</td>
<td>
<input type="radio" name="post[message]" value="1"/> 是&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="post[message]" value="0" checked/> 否
</td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 通知内容</td>
<td>
<textarea name="post[content]" rows="3" cols="60" id="content"></textarea>
<textarea id="c_1" style="display:none;">
尊敬的<?php echo $tuijian;?>:
您推荐的客户<?php echo $truename;?>已经预约。
</textarea>
<textarea id="c_2" style="display:none;">
尊敬的<?php echo $tuijian;?>:
您推荐的客户<?php echo $truename;?>已经到访。
</textarea>
<textarea id="c_3" style="display:none;">
尊敬的<?php echo $tuijian;?>:
您推荐的客户<?php echo $truename;?>已经交定金。
</textarea>
<textarea id="c_4" style="display:none;">
尊敬的<?php echo $tuijian;?>:
您推荐的客户<?php echo $truename;?>已经成交。
</textarea>

</td>
</tr>
</tbody>
<tbody id="pass" style="display:<?php if($status<4) {?> none <?php } ?>;">
<tr >
<td class="tl"><span class="f_hid">*</span> 成交楼盘</td>
<td>
<input  type="text" name="post[shouse]" size="60" value="<?php echo $shouse;?>"/>
</td>
</tr>
<td class="tl"><span class="f_hid">*</span> 成交总价</td>
<td>
<input  type="text" name="post[cprice]" size="5" value="<?php echo $cprice;?>"/> 万元
</td>
</tr>
<tr >
<td class="tl"><span class="f_hid">*</span> 返佣金</td>
<td>
<input  type="text" name="post[cmoney]" size="5" value="<?php echo $cmoney;?>"/> 元&nbsp;&nbsp;给推荐经纪人返佣金
</td>
</tr>

</tbody>
<tr>
<td class="tl"><span class="f_hid">*</span> 受理备注</td>
<td><textarea name="post[snote]" rows="4" cols="60"><?php echo $snote;?></textarea></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 受理人</td>
<td><?php echo $editor;?></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 受理时间</td>
<td><?php echo $edittime;?></td>
</tr>
</table>
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></div>
</form>
<script type="text/javascript">
function check() {
	return confirm('确定要执行此操作吗？');
}
function S(i) {
	if(i==1) {
		Dh('pass');Ds('send');
		try{Dd('content').value=Dd('c_1').value;}catch(e){}
	} else if(i==2) {
		Dh('pass');Ds('send');
		try{Dd('content').value=Dd('c_2').value;}catch(e){}
	} else if(i==3) {
		Dh('pass');Ds('send');
		try{Dd('content').value=Dd('c_3').value;}catch(e){}
	}
	 else if(i==4) {
		Ds('pass');Ds('send');
		try{Dd('content').value=Dd('c_4').value;}catch(e){}
	}
}
</script>
<script type="text/javascript">Menuon(0);</script>
<?php include tpl('footer');?>