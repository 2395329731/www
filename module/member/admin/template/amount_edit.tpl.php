<?php
defined('IN_AIJIACMS') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<div class="tt">佣金结算</div>
<form method="post" action="?">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
<input type="hidden" name="amount" value="<?php echo $amount;?>"/>
<input type="hidden" name="username" value="<?php echo $username;?>"/>
<input type="hidden" name="kehu" value="<?php echo $kehu;?>"/>
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<table cellpadding="2" cellspacing="1" class="tb">

<tr>
<td class="tl"><span class="f_hid">*</span> 成交客户</td>
<td><?php echo $kehu;?></td>
</tr>
<tr class="on">
<td class="tl"><span class="f_hid">*</span> 佣金金额</td>
<td><?php echo $amount;?></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 推荐人</td>
<td><a href="javascript:_user('<?php echo $username;?>');"><?php echo $username;?></a></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 提交时间</td>
<td><?php echo $addtime;?></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 备注信息</td>
<td><textarea name="note" rows="4" cols="60"><?php echo $note;?></textarea></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 受理状态</td>
<td>
<input type="radio" name="status" value="0"<?php echo $status == 0 ? ' checked' : '';?>/> 未结算
<input type="radio" name="status" value="1"<?php echo $status == 1 ? ' checked' : '';?>/> 已结算

</td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 受理人</td>
<td><?php echo $admin;?></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 受理时间</td>
<td><?php echo $admintime;?></td>
</tr>

</table>
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></div>
</form>
<script type="text/javascript">Menuon(0);</script>
<?php include tpl('footer');?>