<?php
defined('AJ_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<script type="text/javascript" src="<?php echo AJ_SKIN;?>js/jquery-1.7.1.js"></script>  
<script type="text/javascript">
$(function(){

$("#address").blur(function(){
$.get("<?php echo $MODULE[6][linkurl];?>house.php?action=map&address="+$("#address").val()+"&areaid="+$("#areaid_1").val(),null,function(data)
{
$("#map").val(data); 
});
}) 
})
</script> 
<form method="post" action="?" id="dform" onsubmit="return check();">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="post[isnew]" value="1"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<input type="hidden" name="post[mycatid]" value="<?php echo $mycatid;?>"/>
<div class="tt"></div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl"><span class="f_red">*</span> 销售状态</td>
<td>
<?php foreach($TYPE as $k=>$v) {?>
<input type="radio" name="post[typeid]" value="<?php echo $k+1;?>" <?php if($k==$typeid-1) echo 'checked';?> id="typeid_<?php echo $k+1;?>"/> <label for="typeid_<?php echo $k+1;?>" id="t_<?php echo $k+1;?>"><?php echo $v;?></label>&nbsp;
<?php } ?>
</td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 楼盘名称</td>
<td><input name="post[title]" type="text" id="title" size="60" value="<?php echo $title;?>"/> <?php echo level_select('post[level]', '级别', $level);?>  <br/><span id="dtitle" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 物业类型</td>
<td><div id="catesch"></div><?php echo get_category_checkboxes('post[catid]',  $moduleid, $catid);?>

</td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 楼盘特点</td>
		<td >
<input name="post[tedian]" type="text" id="title" size="35" value="<?php echo $tedian;?>"/></td>
</tr>
<?php if($CP) { ?>
<script type="text/javascript">
var property_catid = <?php echo $catid;?>;
var property_itemid = <?php echo $itemid;?>;
var property_admin = 1;
</script>
<script type="text/javascript" src="<?php echo AJ_PATH;?>file/script/property.js"></script>
<?php if($itemid) { ?><script type="text/javascript">setTimeout("load_property()", 1000);</script><?php } ?>
<tbody id="load_property" style="display:none;">
<tr><td></td><td></td></tr>
</tbody>
<?php } ?>


<tr>
<td class="tl"><span class="f_hid">*</span> 所在地区</td>
<td ><?php echo ajax_area_select('post[areaid]', '请选择', $areaid);?> <span id="dareaid" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 新盘地址</td>
<td><input name="post[address]" type="text" size="30"  id="address" value="<?php echo $address;?>"/></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 物&nbsp;业&nbsp;费</td>
<td>
<input name="post[lp_costs]" type="text" id="title" size="15" value="<?php echo $lp_costs;?>"/>元(/㎡/月)
 </td>
</tr><tr>
<td class="tl"><span class="f_hid">*</span> 物业公司</td>
<td>
<input name="post[lp_company]" type="text" id="title" size="35" value="<?php echo $lp_company;?>"/>
 </td>
</tr>
<tr>

<td class="tl"><span class="f_hid">*</span> 地图标注</td>
<td>
<?php echo include AJ_ROOT.'/api/map/'.$AJ['map'].'/post.inc.php';?>

 </td>
</tr>

<tr>
<td class="tl"><span class="f_hid">*</span> 参考价格</td>
<td>
<input type="text" name="post[price]" value="<?php echo $price;?>"  class="sup_input"/>元/㎡
 </td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 产权</td>
<td>
<input type="text"  name="post[lp_year]" value="<?php echo $lp_year;?>" class="sup_input" />年
 </td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 售楼电话</td>
<td>
<input  name="post[telephone]" type="text"  value="<?php echo $telephone;?>"  class="sup_input"/>(格式:028-88888888)
 </td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 售楼地址</td>
<td>
<input  name="post[sell_address]" type="text" class="sup_input" value="<?php echo $sell_address;?>" size="35" />
 </td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 公交线路</td>
<td>
<input  name="post[lp_bus]" type="text" value="<?php echo $lp_bus;?>"  class="sup_input"/>
 </td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 教育</td>
<td>
<input  name="post[lp_edu]" type="text" class="sup_input" value="<?php echo $lp_edu;?>" size="35" />
 </td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 医院</td>
<td>
<input type="text" name="post[lp_hospital]" value="<?php echo $lp_hospital;?>"  class="sup_input"/>
 </td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 银行</td>
<td>
<input  name="post[lp_bank]" type="text" class="sup_input" value="<?php echo $lp_bank;?>" size="30" />
 </td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span>规划面积</td>
<td>
<input type="text" name="post[lp_totalarea]" value="<?php echo $lp_totalarea;?>"  class="sup_input"/>㎡
 </td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 建筑面积</td>
<td>
<input  name="post[lp_area]" type="text" class="sup_input" value="<?php echo $lp_area;?>" size="25" />㎡
 </td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span>规划户数</td>
<td>
<input type="text" name="post[lp_number]" value="<?php echo $lp_number;?>"  class="sup_input"/>户
 </td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span>车位数</td>
<td>
<input  name="post[lp_car]" type="text" class="sup_input" value="<?php echo $lp_car;?>" size="25" />
 </td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 容积率</td>
<td>
<input type="text" name="post[lp_volume]" value="<?php echo $lp_volume;?>"  class="sup_input"/>%
 </td>
</tr><tr>
<td class="tl"><span class="f_hid">*</span> 绿化率</td>
<td>
<input  name="post[lp_green]" type="text" class="sup_input" value="<?php echo $lp_green;?>" size="25" />%
 </td>
</tr>
<td class="tl"><span class="f_hid">*</span> 开盘时间</td>
<td>
<?php echo dcalendar('post[selltime]', $selltime);?>
 </td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span>交房时间</td>
<td>
<?php echo dcalendar('post[completion]', $completion);?>
 </td>
</tr>


<?php echo $FD ? fields_html('<td class="tl">', '<td>', $item) : '';?>
<tr>
<td class="tl"><span class="f_hid">*</span> 详细说明</td>
<td><textarea name="post[content]" id="content" class="dsn"><?php echo $content;?></textarea>
<?php echo deditor($moduleid, 'content', $MOD['editor'], '98%', 350);?><span id="dcontent" class="f_red"></span>
</td>
</tr>
<?php
if($MOD['swfu'] && AJ_EDITOR == 'fckeditor') { 
	include AJ_ROOT.'/api/swfupload/editor.inc.php';
}
?>
<tr>
<td class="tl"><span class="f_hid">*</span> 新盘缩略图</td>
<td>
	<input type="hidden" name="post[thumb]" id="thumb" value="<?php echo $thumb;?>"/>
	
	<table width="360">
	<tr align="center" height="120" class="c_p">
	<td width="120"><img src="<?php echo $thumb ? $thumb : AJ_SKIN.'image/waitpic.gif';?>" id="showthumb" title="预览图片" alt="" onclick="if(this.src.indexOf('waitpic.gif') == -1){_preview(Dd('showthumb').src, 1);}else{Dalbum('',<?php echo $moduleid;?>,<?php echo $MOD['thumb_width'];?>,<?php echo $MOD['thumb_height'];?>, Dd('thumb').value, true);}"  width="100" height="100"/></td>
	
	</tr>
	<tr align="center" class="c_p">
	<td><span onclick="Dalbum('',<?php echo $moduleid;?>,<?php echo $MOD['thumb_width'];?>,<?php echo $MOD['thumb_height'];?>, Dd('thumb').value, true);" class="jt"><img src="<?php echo $MODULE[2]['linkurl'];?>image/img_upload.gif" width="12" height="12" title="上传"/></span>&nbsp;&nbsp;<img src="<?php echo $MODULE[2]['linkurl'];?>image/img_select.gif" width="12" height="12" title="选择" onclick="selAlbum('');"/>&nbsp;&nbsp;<span onclick="delAlbum('', 'wait');" class="jt"><img src="<?php echo $MODULE[2]['linkurl'];?>image/img_delete.gif" width="12" height="12" title="删除"/></span></td>
	
	</tr>
	</table>
</td>
</tr>


<tbody id="d_member" style="display:<?php echo $username ? '' : 'none';?>">
<tr>
<td class="tl"><span class="f_red">*</span> 会员名</td>
<td><input name="post[username]" type="text"  size="20" value="<?php echo $username;?>" id="username"/> <a href="javascript:_user(Dd('username').value);" class="t">[资料]</a> <span id="dusername" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 会员推荐房源</td>
<td>
<input type="radio" name="post[elite]" value="1" <?php if($elite == 1) echo 'checked';?>/> 是&nbsp;&nbsp;&nbsp;
<input type="radio" name="post[elite]" value="0" <?php if($elite == 0) echo 'checked';?>/> 否
</td>
</tr>
</tbody>
<tr>
<td class="tl"><span class="f_hid">*</span> 加入分销平台</td>
<td>
<input type="radio" name="post[isfx]" value="1" <?php if($isfx == 1) echo 'checked';?> onclick="if(this.checked) Dd('yongjin').style.display='';"/> 是&nbsp;&nbsp;&nbsp;
<input type="radio" name="post[isfx]" value="0" <?php if($isfx == 0) echo 'checked';?>/> 否
</td>
</tr>
<tr id="yongjin" style="display:<?php echo $isfx==1 ? '' : 'none';?>">
<td class="tl"><span class="f_hid">*</span> 推荐佣金</td>
<td><input name="post[yongjin]" type="text"  size="40" value="<?php echo $yongjin;?>"/></td>
</tr>

<tr id="yongjin" style="display:<?php echo $isfx==1 ? '' : 'none';?>">
<td class="tl"><span class="f_hid">*</span> 活动有效期</td>
<td><?php echo dcalendar('post[totime]', $totime);?>&nbsp;
<select onchange="Dd('posttotime').value=this.value;">
<option value="">快捷选择</option>
<option value="">长期有效</option>
<option value="<?php echo timetodate($AJ_TIME+86400*3, 3);?>">3天</option>
<option value="<?php echo timetodate($AJ_TIME+86400*7, 3);?>">一周</option>
<option value="<?php echo timetodate($AJ_TIME+86400*15, 3);?>">半月</option>
<option value="<?php echo timetodate($AJ_TIME+86400*30, 3);?>">一月</option>
<option value="<?php echo timetodate($AJ_TIME+86400*182, 3);?>">半年</option>
<option value="<?php echo timetodate($AJ_TIME+86400*365, 3);?>">一年</option>
</select>&nbsp;
<span id="dposttotime" class="f_red"></span> 不选表示长期有效</td>
</tr>
<tr id="yongjin" style="display:<?php echo $isfx==1 ? '' : 'none';?>">
<td class="tl"><span class="f_hid">*</span> 推荐次数</td>
<td><input name="post[star0]" type="text" size="10" value="<?php echo $star0;?>"/></td>
</tr>
<tr id="yongjin" style="display:<?php echo $isfx==1 ? '' : 'none';?>">
<td class="tl"><span class="f_hid">*</span> 预约次数</td>
<td><input name="post[star1]" type="text" size="10" value="<?php echo $star1;?>"/></td>
</tr>
<tr id="yongjin" style="display:<?php echo $isfx==1 ? '' : 'none';?>">
<td class="tl"><span class="f_hid">*</span> 成交次数</td>
<td><input name="post[star4]" type="text" size="10" value="<?php echo $star4;?>"/></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 信息状态</td>
<td>
<input type="radio" name="post[status]" value="3" <?php if($status == 3) echo 'checked';?>/> 通过
<input type="radio" name="post[status]" value="2" <?php if($status == 2) echo 'checked';?>/> 待审
<input type="radio" name="post[status]" value="1" <?php if($status == 1) echo 'checked';?> onclick="if(this.checked) Dd('note').style.display='';"/> 拒绝
<input type="radio" name="post[status]" value="4" <?php if($status == 4) echo 'checked';?>/> 过期
<input type="radio" name="post[status]" value="0" <?php if($status == 0) echo 'checked';?>/> 删除
</td>
</tr>
<tr id="note" style="display:<?php echo $status==1 ? '' : 'none';?>">
<td class="tl"><span class="f_red">*</span> 拒绝理由</td>
<td><input name="post[note]" type="text"  size="40" value="<?php echo $note;?>"/></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 添加时间</td>
<td><input type="text" size="22" name="post[addtime]" value="<?php echo $addtime;?>"/></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 浏览次数</td>
<td><input name="post[hits]" type="text" size="10" value="<?php echo $hits;?>"/></td>
</tr>

<tr>
<td class="tl"><span class="f_hid">*</span> 内容收费</td>
<td><input name="post[fee]" type="text" size="5" value="<?php echo $fee;?>"/><?php tips('不填或填0表示继承模块设置价格，-1表示不收费<br/>大于0的数字表示具体收费价格');?>
</td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 内容模板</td>
<td><?php echo tpl_select('show', $module, 'post[template]', '默认模板', $template, 'id="template"');?><?php tips('如果没有特殊需要，一般不需要选择<br/>系统会自动继承分类或模块设置');?></td>
</tr>
<?php if($MOD['show_html']) { ?>
<tr>
<td class="tl"><span class="f_hid">*</span> 自定义文件路径</td>
<td><input type="text" size="50" name="post[filepath]" value="<?php echo $filepath;?>" id="filepath"/>&nbsp;<input type="button" value="重名检测" onclick="ckpath(<?php echo $moduleid;?>, <?php echo $itemid;?>);" class="btn"/>&nbsp;<?php tips('可以包含目录和文件 例如 aijiacms/house.html<br/>请确保目录和文件名合法且可写入，否则可能生成失败');?>&nbsp; <span id="dfilepath" class="f_red"></span></td>
</tr>
<?php } ?>
</table>
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></div>
</form>
<?php load('clear.js'); ?>
<?php if($action == 'add') { ?>
<form method="post" action="?">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>

</form>
<?php } ?>
<script type="text/javascript">
function _p() {
	if(Dd('tag').value) {
		Ds('reccate');
	}
}
function check() {
	var l;
	var f;
	f = 'catid_1';
	if(Dd(f).value == 0) {
		Dmsg('请选择所属行业', 'catid', 1);
		return false;
	}
	f = 'title';
	l = Dd(f).value.length;
	if(l < 2) {
		Dmsg('标题最少2字，当前已输入'+l+'字', f);
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
			Dmsg('请选择所在地区', 'areaid', 1);
			return false;
		}
		f = 'truename';
		l = Dd(f).value.length;
		if(l < 2) {
			Dmsg('请填写联系人', f);
			return false;
		}
		f = 'mobile';
		l = Dd(f).value.length;
		if(l < 7) {
			Dmsg('请填写手机', f);
			return false;
		}
	}
	<?php echo $FD ? fields_js() : '';?>
	<?php echo $CP ? property_js() : '';?>
	if(Dd('property_require') != null) {
		var ptrs = Dd('property_require').getElementsByTagName('option');
		for(var i = 0; i < ptrs.length; i++) {		
			f = 'property-'+ptrs[i].value;
			if(Dd(f).value == 0 || Dd(f).value == '') {
				Dmsg('请填写或选择'+ptrs[i].innerHTML, f);
				return false;
			}
		}
	}
	return true;
}
</script>

<script type="text/javascript">Menuon(<?php echo $menuid;?>);</script>
<?php include tpl('footer');?>