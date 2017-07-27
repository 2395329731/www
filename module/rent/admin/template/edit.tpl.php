<?php
defined('AJ_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>

<script src="<?php echo AJ_SKIN;?>js/sea.js?v=3" type="text/javascript"></script>	
	<script>var AGENT_URL="<?php echo $MODULE[6]['linkurl'];?>";var JS_URL="";var IMG_URL="";</script>
<link href="<?php echo AJ_SKIN;?>user_jjr.css?v=3" rel="stylesheet" type="text/css" />
<link href="<?php echo AJ_SKIN;?>adminreset.css?v=3" rel="stylesheet" type="text/css" />
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
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<input type="hidden" name="post[mycatid]" value="<?php echo $mycatid;?>"/>
<input type="hidden" name="swf_upload" id="swf_upload"/>
<div class="tt"></div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl"><span class="f_red">*</span> 信息类型</td>
<td>
<?php foreach($TYPE as $k=>$v) {?>
<input type="radio" name="post[typeid]" value="<?php echo $k;?>" <?php if($k==$typeid) echo 'checked';?> id="typeid_<?php echo $k;?>"/> <label for="typeid_<?php echo $k;?>" id="t_<?php echo $k;?>"><?php echo $v;?></label>&nbsp;
<?php } ?>
</td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 房源标题</td>
<td><input name="post[title]" type="text"  size="60" value="<?php echo $title;?>"/> <?php echo level_select('post[level]', '级别', $level);?> <?php echo dstyle('post[style]', $style);?> <br/><span id="dtitle" class="f_red"></span></td>
</tr>
 <tr  id="villagenamecon">
            <td class="tl"><span class="f_red">*</span>小区名称：</td>
            <td><input type="text" class="txt" id="villagename" name="post[housename]" value="<?php echo $housename;?>"  >
					<input type="hidden" name="post[houseid]" id="cid" value="<?php echo $houseid;?>">
			
		<span class="gray9">请输入小区名称，如：“青园”或“qyxq”，然后在下面打开的列表中选择即可。</span>
						       
							
									</td>
          </tr>
		  <tr>
<td class="tl"><span class="f_red">*</span> 区域</td>
<td><div id="catesch"></div><?php echo ajax_area_select('post[areaid]', '请选择', $areaid);?> 地址: <input name="post[address]" value="<?php echo $address;?>" id="address" type="text"></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 房屋类型</td>
<td><div id="catesch"></div><?php echo category_select('post[catid]', '选择类型', $catid, $moduleid);?></td>
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
<td class="tl"><span class="f_hid">*</span> 户  型</td>
<td><select class="select" name="post[room]">
																		 						 <option value="1" <?php if($room == 1) echo 'selected';?>>1</option>
						 												 						 <option value="2" <?php if($room == 2) echo 'selected';?>>2</option>
						 												 						 <option value="3" <?php if($room == 3) echo 'selected';?>>3</option>
						 												 						 <option value="4" <?php if($room == 4) echo 'selected';?>>4</option>
						 												 						 <option value="5" <?php if($room == 5) echo 'selected';?>>5</option>
						 																		  <option value="6" <?php if($room == 6) echo 'selected';?>>5室以上</option>
						 						</select> 室<select class="select" name="post[hall]">
																		 						 <option value="0" <?php if($hall == 0) echo 'selected';?>>0</option>
						 												 						 <option value="1" <?php if($hall == 1) echo 'selected';?>>1</option>
						 												 						 <option value="2" <?php if($hall == 2) echo 'selected';?>>2</option>
						 												 						 <option value="3" <?php if($hall == 3) echo 'selected';?>>3</option>
						 												 						 <option value="4" <?php if($hall == 4) echo 'selected';?>>4</option>
						 												 						 <option value="5" <?php if($hall == 5) echo 'selected';?>>5</option>
						 												</select> 厅<select class="select" name="post[toilet]">
						 												 						 <option value="0" <?php if($toilet == 0) echo 'selected';?>>0</option>
						 												 						 <option value="1" <?php if($toilet == 1) echo 'selected';?>>1</option>
						 												 						 <option value="2" <?php if($toilet == 2) echo 'selected';?>>2</option>
						 												 						 <option value="3" <?php if($toilet == 3) echo 'selected';?>>3</option>
						 												 						 <option value="4" <?php if($toilet == 4) echo 'selected';?>>4</option>
						 												 						 <option value="5" <?php if($toilet == 5) echo 'selected';?>>5</option>
						 												 </select> 卫<select class="select" name="post[balcony]">
						 												 						 <option value="0" <?php if($balcony == 0) echo 'selected';?>>0</option>
						 												 						 <option value="1" <?php if($balcony == 1) echo 'selected';?>>1</option>
						 												 						 <option value="2" <?php if($balcony == 2) echo 'selected';?>>2</option>
						 												 						 <option value="3" <?php if($balcony == 3) echo 'selected';?>>3</option>
						 												 						 <option value="4" <?php if($balcony == 4) echo 'selected';?>>4</option>
						 												 						 <option value="5" <?php if($balcony == 5) echo 'selected';?>>5</option>
						 												 </select> 阳</td>
</tr>
<?php echo $FD ? fields_html('<td class="tl">', '<td>', $item) : '';?>
<tr>
<td class="tl"><span class="f_hid">*</span> 详细说明</td>
<td><textarea name="post[content]" id="content" class="dsn"><?php echo $content;?></textarea>
<?php echo deditor($moduleid, 'content', $MOD['editor'], '100%', 350);?><br/><span id="dcontent" class="f_red"></span>
</td>
</tr>

<tr>
<td class="tl"><span class="f_hid">*</span> 交通状况</td>
<td><input id="bus" type="text" class="input" name="post[bus]"  size="50" value="<?php echo $bus;?>" />			
</td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 地图标注</td>
<td>
<?php echo include AJ_ROOT.'/api/map/'.$AJ['map'].'/post.inc.php';?>
 </td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 联系人</td>
<td class="tr"><input name="post[truename]" type="text" id="truename" size="20" value="<?php echo $truename;?>" /> <span id="dtruename" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 联系手机</td>
<td class="tr"><input name="post[mobile]" id="mobile" type="text" size="30" value="<?php echo $mobile;?>"/> <span id="dmobile" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 电子邮件</td>
<td class="tr"><input name="post[email]" id="email" type="text" size="30" value="<?php echo $email;?>" /> <span id="demail" class="f_red"></span></td>
</tr>
  <tr>
<td class="tl"><span class="f_red">*</span> 标题图片</td>
<td><input name="post[thumb]" id="thumb" type="text" size="60" value="<?php echo $thumb;?>"/>&nbsp;&nbsp;<span onclick="Dthumb(<?php echo $moduleid;?>,Dd('level').value==2 ? 300 : <?php echo $MOD['thumb_width'];?>,Dd('level').value==2 ? 225 : <?php echo $MOD['thumb_height'];?>,Dd('thumb').value);" class="jt">[上传]</span>&nbsp;&nbsp;<span onclick="_preview(Dd('thumb').value);" class="jt">[预览]</span>&nbsp;&nbsp;<span onclick="Dd('thumb').value='';" class="jt">[删除]</span><span id="dthumb" class="f_red"></span></td>
</tr>
<?php
 
	include AJ_ROOT.'/api/swfupload/editor.inc.php';

?><tr>
<td class="tl"><span class="f_hid">*</span> 房源图片</td>
<td>
<input type="hidden" name="post[thumb]" value="<?php echo $thumb;?>"/>
<?php foreach($piclists as $k=>$v) { ?>
<div style="width:130px;float:left;">
	
	<table width="120">
	<tr align="center" height="110" class="c_p">
	<td width="120"><img src="<?php echo $v['thumb'];?>" width="100" height="100" id="showthumb<?php echo $v['itemid'];?>" title="预览图片" alt="" onclick="if(this.src.indexOf('waitpic.gif') == -1){_preview(this.src, 1);}else{Dphoto(<?php echo $v['itemid'];?>,<?php echo $moduleid;?>,100,100, Dd('thumb<?php echo $v['itemid'];?>').value, true);}"/></td>
	</tr>
	<tr align="center">
	<td height="20">
	<a href="?moduleid=<?php echo $moduleid;?>&action=item_delete&itemid=<?php echo $v['itemid'];?>" onclick="return _delete();"><img src="<?php echo $MODULE[2]['linkurl'];?>image/img_delete.gif" width="12" height="12" title="删除"/></a>&nbsp;

	&nbsp;<a href="?moduleid=<?php echo $moduleid;?>&action=item_index&itemid=<?php echo $v['itemid'];?>" onclick="return _index();">设为封面</a>
	</td>
	
	</tr>
	
	
	</table>
</div>
<?php } ?>
</td>
	</tr>

<tr>
<td class="tl"><span class="f_hid">*</span> 过期时间</td>
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
<tr>
<td class="tl"><span class="f_hid">*</span> 基本信息</td>
<td>
	<table width="100%">
	<tr>
	<td width="70">租金</td>
	<td><input name="post[price]" type="text" size="10" value="<?php echo $price;?>"/></td>
	</tr>
	<tr>
	<td>建筑面积</td>
	<td><input name="post[houseearm]" type="text" size="10" value="<?php echo $houseearm;?>"/></td>
	</tr>
	<tr>
	<td>房    龄</td>
	<td><input class="text" name="post[houseyear]" size="10" value="<?php echo $houseyear;?>">
							</td>
	</tr>
	<tr>
	<td>楼    层</td>
	<td>第
  <input class="input" name="post[floor1]" type="text" size="1" value="<?php echo $floor1;?>"   /> 层 /
	  共<input class="input" name="post[floor2]" type="text" size="1" value="<?php echo $floor2;?>" valid="required|isInt" errmsg="请输入楼层总数!|请输入整数！" /> 层</td>
	</tr>
	<tr>
	<td>产    权</td>
	<td><select name="post[cqxz]" id="{$k}">
    <option value="1"  selected=<?php if($cqxz == 1) echo 'selected';?>>私产</option>
    <option value="2" <?php if($cqxz == 2) echo 'selected';?>>公产</option>
	<option value="3" <?php if($cqxz == 3) echo 'selected';?>>商品房</option>
	<option value="4" <?php if($cqxz == 4) echo 'selected';?>>期房</option>
	<option value="5" <?php if($cqxz == 5) echo 'selected';?>>经济适用房</option>
	<option value="6" <?php if($cqxz == 6) echo 'selected';?>>使用权房</option>
	<option value="7" <?php if($cqxz == 7) echo 'selected';?>>房改房</option>
  </select>			</td>
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
<div class="tt">单页采编</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl"><span class="f_hid">*</span> 目标网址</td>
<td><input name="url" type="text" size="80" value="<?php echo $url;?>"/>&nbsp;&nbsp;<input type="submit" value=" 获 取 " class="btn"/>&nbsp;&nbsp;<input type="button" value=" 管理规则 " class="btn" onclick="window.open('?file=fetch');"/></td>
</tr>
</table>
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
	f = 'titles';
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
<div id="autoVn">
	
</div>
<script src="<?php echo AJ_SKIN;?>js/editor_user_min.js"></script>
<script type="text/javascript">
seajs.use("jjrfbcon",function(fb){
	fb.init("esf",{
  autoc:AGENT_URL + "house.php?action=xq",
  

	});
})
</script>
<script type="text/javascript">Menuon(<?php echo $menuid;?>);</script>
<?php include tpl('footer');?>