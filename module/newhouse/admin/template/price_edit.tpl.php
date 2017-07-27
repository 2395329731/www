<?php
defined('IN_AIJIACMS') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form method="post" action="?" id="dform" onsubmit="return check();">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<input type="hidden" name="post[pid]" value="<?php echo $pid;?>"/>
<input type="hidden" name="post[title]" value="<?php echo $title;?>"/>
<input name="post[username]" type="hidden"  size="20" value="<?php echo $username;?>" id="username"/> 
<input type="hidden" name="pid" value="<?php echo $pid;?>"/>
<div class="tt"><?php echo $action == 'add' ? '添加' : '修改';?>报价</div>
<table cellpadding="2" cellspacing="1" class="tb">

<tr>
<td class="tl"><span class="f_red">*</span> 价格</td>
<td><input name="post[price]" type="text" size="10" value="<?php echo $price;?>" id="price"/> <span id="dprice" class="f_red">(必须为数字，不要写单位)</span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 涨跌</td>
      <td><label class="ib" style="width:80px"><input name="post[trend]" id="trend_0" checked="" value="0" type="radio"> -</label><label class="ib" style="width:80px"><input name="post[trend]" id="trend_1" value="1" type="radio"> ↑</label><label class="ib" style="width:80px"><input name="post[trend]" id="trend_2" value="2" type="radio"> ↓</label>  </td>
    </tr>

</tbody>
<tr>
<td class="tl"><span class="f_hid">*</span> 备注</td>
<td><input name="post[note]" type="text" size="60" value="<?php echo $note;?>" id="note"/></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 信息状态</td>
<td>
<input type="radio" name="post[status]" value="3" <?php if($status == 3) echo 'checked';?>/> 通过
<input type="radio" name="post[status]" value="2" <?php if($status == 2) echo 'checked';?>/> 待审
</td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 报价时间</td>
<td><input type="text" size="22" name="post[addtime]" value="<?php echo $addtime;?>"/></td>
</tr>
</table>
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></div>
</form>
<?php load('guest.js'); ?>
<script type="text/javascript">
function check() {
	var l;
	var f;
	f = 'price';
	l = Dd(f).value.length;
	if(l < 1) {
		Dmsg('请填写报价', f);
		return false;
	}
	if(Dd('ismember_1').checked) {
		f = 'username';
		l = Dd(f).value.length;
		if(l < 2) {
			Dmsg('请填写会员名', f);
			return false;
		}
	} else {
		f = 'company';
		l = Dd(f).value.length;
		if(l < 2) {
			Dmsg('请填写公司名称', f);
			return false;
		}
		if(Dd('areaid_1').value == 0) {
			Dmsg('请选择所在地区', 'areaid');
			return false;
		}
	}
	return true;
}
</script>
<script type="text/javascript">Menuon(<?php echo $menuid;?>);</script>
<?php include tpl('footer');?>