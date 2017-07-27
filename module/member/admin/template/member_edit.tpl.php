<?php
defined('AJ_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
load('profile.js');
?>
<div class="tt">会员资料修改</div>
<form method="post" action="?" onsubmit="return Dcheck();" id="dform">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="userid" value="<?php echo $userid;?>"/>
<input type="hidden" name="username" value="<?php echo $username;?>"/>
<input type="hidden" name="gid" value="<?php echo $groupid;?>"/>
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<input type="hidden" name="member[regid]" value="<?php echo $regid;?>"/>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl"><span class="f_hid">*</span> 会员头像</td>
<td><img src="<?php echo useravatar($username, 'large');?>" style="margin:6px;" width="128" height="128"/></td>
</tr>

<tr>
<td class="tl"><span class="f_hid">*</span> 会员登录名</td>
<td><strong><?php echo $username;?></strong>&nbsp;&nbsp;<a href="?moduleid=<?php echo $moduleid;?>&username=<?php echo urlencode($username);?>&catid=1#editusername" class="t">[修改会员名]</a></td>
</tr>

<tr>
<td class="tl"><span class="f_hid">*</span> 昵称</td>
<td><strong><?php echo $passport;?></strong>&nbsp;&nbsp;<a href="?moduleid=<?php echo $moduleid;?>&passport=<?php echo urlencode($passport);?>&catid=2#editpassport" class="t">[修改昵称]</a></td>
</tr>

<tr>
<td class="tl"><span class="f_red">*</span> 会员组</td>
<td><?php echo group_select('member[groupid]', '会员组', $groupid, 'id="groupid"');?>&nbsp;<span id="dgroupid" class="f_red"></span></td>
</tr>
<?php if($userid != $_userid || $_founder) { ?>
<tr>
<td class="tl"><span class="f_hid">*</span> 登录密码</td>
<td><input type="password" size="20" name="member[password]" id="password" onblur="validator('password');" autocomplete="off"/>&nbsp;<span id="dpassword" class="f_red"></span> <span class="f_gray">如不更改,请留空</span></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 重复输入密码</td>
<td><input type="password" size="20" name="member[cpassword]" id="cpassword" autocomplete="off"/>&nbsp;<span id="dcpassword" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 支付密码</td>
<td><input type="password" size="20" name="member[payword]" id="payword" onblur="validator('payword');" autocomplete="off"/>&nbsp;<span id="dpayword" class="f_red"></span> <span class="f_gray">如不更改,请留空</span></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 重复支付密码</td>
<td><input type="password" size="20" name="member[cpayword]" id="cpayword" autocomplete="off"/>&nbsp;<span id="dcpayword" class="f_red"></span></td>
</tr>
<?php } ?>
<tr>
<td class="tl"><span class="f_red">*</span> Email</td>
<td><input type="text" size="30" name="member[email]" id="email" value="<?php echo $email;?>" onblur="validator('email');"/>&nbsp;<a href="#vv"><img src="<?php echo $MOD['linkurl'];?>image/<?php echo $vemail ? 'v' : 'u';?>_email.gif" width="16" height="16" title="<?php echo $vemail ? '已通过' : '未通过';?>邮件认证" align="absmiddle"/></a>&nbsp;<span id="demail" class="f_red"></span> <span class="f_gray">[不公开]</span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 真实姓名</td>
<td><input type="text" size="10" name="member[truename]" id="truename" value="<?php echo $truename;?>"/>&nbsp;<a href="#vv"><img src="<?php echo $MOD['linkurl'];?>image/<?php echo $vtruename ? 'v' : 'u';?>_truename.gif" width="16" height="16" title="<?php echo $vtruename ? '已通过' : '未通过';?>实名认证" align="absmiddle"/></a>&nbsp;<span id="dtruename" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 性别</td>
<td>
<input type="radio" name="member[gender]" value="1" <?php if($gender == 1) echo 'checked="checked"';?>/> 先生
<input type="radio" name="member[gender]" value="2" <?php if($gender == 2) echo 'checked="checked"';?>/> 女士
</td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 所在地区</td>
<td><?php echo ajax_area_select('member[areaid]', '请选择', $areaid);?>&nbsp;<span id="dareaid" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 部门</td>
<td><input type="text" size="20" name="member[department]" id="department" value="<?php echo $department;?>"/></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 职位</td>
<td><input type="text" size="20" name="member[career]" id="career" value="<?php echo $career;?>"/></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 手机号码</td>
<td><input type="text" size="20" name="member[mobile]" id="mobile" value="<?php echo $mobile;?>"/>&nbsp;<a href="#vv"><img src="<?php echo $MOD['linkurl'];?>image/<?php echo $vmobile ? 'v' : 'u';?>_mobile.gif" width="16" height="16" title="<?php echo $vmobile ? '已通过' : '未通过';?>手机认证" align="absmiddle"/></a></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> QQ</td>
<td><input type="text" size="20" name="member[qq]" id="qq" value="<?php echo $qq;?>"/></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 阿里旺旺</td>
<td><input type="text" size="20" name="member[ali]" id="ali" value="<?php echo $ali;?>"/></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> MSN</td>
<td><input type="text" size="30" name="member[msn]" id="msn" value="<?php echo $msn;?>"/></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> Skype</td>
<td><input type="text" size="20" name="member[skype]" id="skype" value="<?php echo $skype;?>"/></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 站内信提示音</td>
<td class="tr">
<div id="audition"></div>
<input type="radio" name="member[sound]" value="0" <?php if($sound==0) { ?>checked="checked"<?php } ?> id="sound_0"/><label for="sound_0"> 无</label>&nbsp;&nbsp;
<input type="radio" name="member[sound]" value="1" <?php if($sound==1) { ?>checked="checked"<?php } ?> id="sound_1"/> <a href="javascript:Inner('audition', sound('message_1'));Dd('sound_1').checked=true;void(0);" title="点击试听">提示音1</a>&nbsp;&nbsp;
<input type="radio" name="member[sound]" value="2" <?php if($sound==2) { ?>checked="checked"<?php } ?> id="sound_2"/> <a href="javascript:Inner('audition', sound('message_2'));Dd('sound_2').checked=true;void(0);" title="点击试听">提示音2</a>&nbsp;&nbsp;
<input type="radio" name="member[sound]" value="3" <?php if($sound==3) { ?>checked="checked"<?php } ?> id="sound_3"/> <a href="javascript:Inner('audition', sound('message_3'));Dd('sound_3').checked=true;void(0);" title="点击试听">提示音3</a>&nbsp;&nbsp;
</td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 开户银行</td>
<td>
<select name="member[bank]">
<option value="">开户银行</option>
<?php foreach($BANKS as $v) { ?>
<option value="<?php echo $v;?>" <?php if($bank == $v) { ?>selected<?php } ?>><?php echo $v;?></option>;
<?php } ?>
</select>
</td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 帐号类型</td>
<td>
<input type="radio" name="member[banktype]" value="0"<?php if($banktype == 0) { ?> checked<?php } ?>/> 对私
<input type="radio" name="member[banktype]" value="1"<?php if($banktype == 1) { ?> checked<?php } ?>/> 对公
</td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 开户网点</td>
<td><input type="text" size="50" name="member[branch]" id="branch" value="<?php echo $branch;?>"/></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 收款帐号</td>
<td><input type="text" size="30" name="member[account]" id="account" value="<?php echo $account;?>"/>&nbsp;<a href="#vv"><img src="<?php echo $MOD['linkurl'];?>image/<?php echo $vbank ? 'v' : 'u';?>_bank.gif" width="16" height="16" title="<?php echo $vbank ? '已通过' : '未通过';?>银行帐号认证" align="absmiddle"/></a></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> <?php echo $AJ['trade_nm'];?>帐号</td>
<td><input type="text" size="30" name="member[trade]" id="trade" value="<?php echo $trade;?>"/>&nbsp;<a href="#vv"><img src="<?php echo $MOD['linkurl'];?>image/<?php echo $vbank ? 'v' : 'u';?>_trade.gif" width="16" height="16" title="<?php echo $vbank ? '已通过' : '未通过';?><?php echo $AJ['trade_nm'];?>帐号认证" align="absmiddle"/></a></td>
</tr>
<?php echo $MFD ? fields_html('<td class="tl">', '<td>', $user, $MFD) : '';?>
</table>
<div class="tt"><span class="f_hid">*</span> 公司资料</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl"><span class="f_red">*</span> 公司名称</td>
<td><input type="text" size="60" name="member[company]" id="company" value="<?php echo $company;?>" onblur="validator('company');"/>&nbsp;<a href="#vv"><img src="<?php echo $MOD['linkurl'];?>image/<?php echo $vcompany ? 'v' : 'u';?>_company.gif" width="16" height="16" title="<?php echo $vcompany ? '已通过' : '未通过';?>工商认证" align="absmiddle"/></a></td>
</tr>

<tr>
<td class="tl"><span class="f_hid">*</span> 形象图片</td>
<td><input name="member[thumb]" type="text" size="60" id="thumb" value="<?php echo $thumb;?>"/>&nbsp;&nbsp;<span onclick="Dthumb(<?php echo $moduleid;?>,<?php echo $MOD['thumb_width'];?>,<?php echo $MOD['thumb_height'];?>, Dd('thumb').value);" class="jt">[上传]</span>&nbsp;&nbsp;<span onclick="_preview(Dd('thumb').value);" class="jt">[预览]</span>&nbsp;&nbsp;<span onclick="Dd('thumb').value='';" class="jt">[删除]</span><br/>
<span class="f_gray">建议使用LOGO、办公环境等标志性图片，最佳大小为<?php echo $MOD['thumb_width'];?>px*<?php echo $MOD['thumb_height'];?>px</span></td>
</tr>

<tr>
<td class="tl"><span class="f_red">*</span> 公司地址</td>
<td><input type="text" size="60" name="member[address]" id="address" value="<?php echo $address;?>"/>&nbsp;<span id="daddress" class="f_red"></span></td>
</tr>

<tr>
<td class="tl"><span class="f_hid">*</span> 邮政编码</td>
<td><input type="text" size="8" name="member[postcode]" id="postcode" value="<?php echo $postcode;?>"/></td>
</tr>

<tr>
<td class="tl"><span class="f_red">*</span> 公司电话</td>
<td><input type="text" size="20" name="member[telephone]" id="telephone" value="<?php echo $telephone;?>"/>&nbsp;<span id="dtelephone" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 公司传真</td>
<td><input type="text" size="20" name="member[fax]" id="fax" value="<?php echo $fax;?>"/></td>
</tr><tr>
<td class="tl"><span class="f_hid">*</span> 公司Email</td>
<td><input type="text" size="30" name="member[mail]" id="mail" value="<?php echo $mail;?>"/> <span class="f_gray">[公开]</span></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 公司网址</td>
<td><input type="text" size="30" name="member[homepage]" id="homepage" value="<?php echo $homepage;?>"/></td>
</tr>

<tr>
<td class="tl"><span class="f_red">*</span> 公司介绍</td>
<td><textarea name="member[content]" id="content" class="dsn"><?php echo $content;?></textarea>
<?php echo deditor($moduleid, 'content', $MOD['editor'], '100%', 300);?><br/><span id="dcontent" class="f_red"></span></td>
</tr>
<?php echo $CFD ? fields_html('<td class="tl">', '<td>', $user, $CFD) : '';?>
</table>
<div class="tt">资料认证</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl"><span class="f_hid">*</span> 企业资料是否通过认证</td>
<td>
<input type="radio" name="member[validated]" value="1" <?php if($validated) echo 'checked';?>/> 是&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="member[validated]" value="0" <?php if(!$validated) echo 'checked';?>/> 否
<?php tips('一般由第三方认证机构或网站对会员总体资料的认证');?><a name="vv"></a>
</td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 认证名称或机构</td>
<td><input type="text" name="member[validator]" size="30" value="<?php echo $validator;?>"/></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 认证日期</td>
<td><?php echo dcalendar('member[validtime]', $validtime);?></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 邮件认证</td>
<td>
<input type="radio" name="member[vemail]" value="1" <?php if($vemail) echo 'checked';?>/> 是&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="member[vemail]" value="0" <?php if(!$vemail) echo 'checked';?>/> 否
<?php tips('开启邮件发送后，此项由会员自行认证');?>
</td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 手机认证</td>
<td>
<input type="radio" name="member[vmobile]" value="1" <?php if($vmobile) echo 'checked';?>/> 是&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="member[vmobile]" value="0" <?php if(!$vmobile) echo 'checked';?>/> 否
<?php tips('开启短信发送后，此项由会员自行认证');?>
</td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 银行认证</td>
<td>
<input type="radio" name="member[vbank]" value="1" <?php if($vbank) echo 'checked';?>/> 是&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="member[vbank]" value="0" <?php if(!$vbank) echo 'checked';?>/> 否
<?php tips('一般在会员提现之后，由网站进行付款认证，认证之后会员的收款信息将不可修改');?>
</td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> <?php echo $AJ['trade_nm'];?>帐号认证</td>
<td>
<input type="radio" name="member[vtrade]" value="1" <?php if($vtrade) echo 'checked';?>/> 是&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="member[vtrade]" value="0" <?php if(!$vtrade) echo 'checked';?>/> 否
<?php tips('会员通过支付宝担保交易之后，系统自动认证');?>
</td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 实名认证</td>
<td>
<input type="radio" name="member[vtruename]" value="1" <?php if($vtruename) echo 'checked';?>/> 是&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="member[vtruename]" value="0" <?php if(!$vtruename) echo 'checked';?>/> 否
<?php tips('一般由会员在线提交身份证或其他证件电子文档或传真件，由网站进行认证');?>
</td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 公司认证</td>
<td>
<input type="radio" name="member[vcompany]" value="1" <?php if($vcompany) echo 'checked';?>/> 是&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="member[vcompany]" value="0" <?php if(!$vcompany) echo 'checked';?>/> 否
<?php tips('一般由会员在线提交营业执照、组织机构代码证等电子文档或传真件，由网站进行认证');?>
</td>
</tr>
</table>
<div class="tt">高级设置</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl"><span class="f_hid">*</span> 主页风格目录</td>
<td><input type="text" size="20" name="member[skin]" value="<?php echo $skin;?>"/></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 主页模板目录</td>
<td><input type="text" size="20" name="member[template]" value="<?php echo $template;?>"/></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 绑定域名</td>
<td><input type="text" size="30" name="member[domain]" id="domain" value="<?php echo $domain;?>"/><?php tips('例如 www.aijiacms.com 不带http<br/>同时需要会员将此域名IP指向本站服务器');?></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 域名ICP备案号</td>
<td><input type="text" size="30" name="member[icp]" id="icp" value="<?php echo $icp;?>"/></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 站内信黑名单</td>
<td><input type="text" size="60" name="member[black]" id="black" value="<?php echo $black;?>"/></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 客服专员</td>
<td><input type="text" size="20" name="member[support]" id="support" value="<?php echo $support;?>"/> <a href="javascript:_user(Dd('support').value);" class="t">[资料]</a> <?php tips('填写客服会员名，填写后会员可以看到此客服的联系方式，以便提供一对一服务');?></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 推荐注册人 </td>
<td><input type="text" size="20" name="member[inviter]" id="inviter" value="<?php echo $inviter;?>"/> <a href="javascript:_user(Dd('inviter').value);" class="t">[资料]</a> <?php tips('推荐此会员注册的会员名，系统自动记录，一般无须填写');?></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 会员资料是否完整</td>
<td>
<input type="radio" name="member[edittime]" value="1"<?php if($edittime) echo ' checked';?>/> 是&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="member[edittime]" value="0"<?php if(!$edittime) echo ' checked';?>/> 否&nbsp;&nbsp;
<span class="f_gray">如果选择是，系统将不再提示会员完善资料</span>
</td>
</tr>
</table>
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn">&nbsp;&nbsp;<input type="button" value=" 前 台 " class="btn" onclick="window.open('?moduleid=<?php echo $moduleid;?>&action=login&userid=<?php echo $userid;?>');"/>&nbsp;&nbsp;<input type="button" value=" 返 回 " class="btn" onclick="history.back(-1);"/></div>
</form>
<?php load('clear.js'); ?>
<script type="text/javascript">
var vid = '';
function validator(id) {
	if(!Dd(id).value) return false;
	vid = id;
	makeRequest('moduleid=<?php echo $moduleid;?>&action=member&job='+id+'&value='+Dd(id).value+'&userid=<?php echo $userid;?>', AJPath, 'dvalidator')
}
function dvalidator() {    
	if(xmlHttp.readyState==4 && xmlHttp.status==200) {
		Dd('d'+vid).innerHTML = xmlHttp.responseText ? xmlHttp.responseText : '';
	}
}
function Dcheck() {
	if(Dd('groupid').value == 0) {
		Dmsg('请选择会员组', 'groupid');
		return false;
	}
	<?php if($userid != $_userid) { ?>
	if(Dd('password').value != '') {
		if(Dd('cpassword').value == '') {
			Dmsg('请重复输入密码', 'cpassword');
			return false;
		}
		if(Dd('password').value != Dd('cpassword').value) {
			Dmsg('两次输入的密码不一致', 'password');
			return false;
		}
	}
	if(Dd('payword').value != '') {
		if(Dd('cpayword').value == '') {
			Dmsg('请重复输入支付密码', 'cpayword');
			return false;
		}
		if(Dd('payword').value != Dd('cpayword').value) {
			Dmsg('两次输入的支付密码不一致', 'payword');
			return false;
		}
	}
	<?php } ?>
	if(Dd('email').value == '') {
		Dmsg('请填写电子邮箱', 'email');
		return false;
	}
	if(Dd('truename').value == '') {
		Dmsg('请填写真实姓名', 'truename');
		return false;
	}
	if(Dd('areaid_1').value == 0) {
		Dmsg('请选择所在地', 'areaid');
		return false;
	}
	<?php echo $MFD ? fields_js($MFD) : '';?>
	<?php if($groupid > 5) { ?>
	<?php echo $CFD ? fields_js($CFD) : '';?>
	if(Dd('company').value == '') {
		Dmsg('请填写公司名称', 'company');
		return false;
	}
	
	
	if(Dd('address').value.length < 2) {
		Dmsg('请填写公司地址', 'address');
		return false;
	}
	if(Dd('telephone').value.length < 6) {
		Dmsg('请填写公司电话', 'telephone');
		return false;
	}
	if(FCKLen('content') < 10) {
		Dmsg('公司介绍最少10字，当前已经输入'+FCKLen('content')+'字', 'content');
		return false;
	}
	<?php } ?>
	return true;
}
</script>
<script type="text/javascript">Menuon(1);</script>
<?php include tpl('footer');?>