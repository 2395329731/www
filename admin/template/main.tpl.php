<?php
defined('IN_AIJIACMS') or exit('Access Denied');
include tpl('header');

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>管理首页</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script type="text/javascript" src="file/script/common.js"></script>
<script type="text/javascript" src="file/script/config.js"></script>
</head>
<body oncontextmenu="return false" ondragstart="return false" onSelectStart="return false">
<div id="tips_update" style="display:none;">

<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td>
<div style="padding:20px 30px 20px 20px;display: none;" title="当前版本V<?php echo AJ_VERSION; ?> 更新时间<?php echo AJ_RELEASE;?>"><img src="admin/image/tips_update.gif" width="32" height="32" align="absmiddle"/>&nbsp;&nbsp; <span class="f_red">您的当前软件版本有新的更新，请注意升级</span>&nbsp;&nbsp;最新版本：V<span id="last_v"><?php echo AJ_VERSION; ?></span> 更新时间：<span id="last_r"><?php echo AJ_RELEASE; ?></span>&nbsp;&nbsp;
<input type="button" value="检查更新" class="btn" onclick="window.open('http://bbs.aijiacms.com')"> </div>

</td>
</tr>
</table>
</div>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="javascript:void(0);" class="on" onclick="$('#main-lang-1').toggle();">系统信息</a></li>			
		</ul>
	</div>
	<div class="main" id="main-lang-1">
	<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">管理级别</td>
<td width="30%">&nbsp;<?php echo $_admin == 1 ? ($CFG['founderid'] == $_userid ? '网站创始人' : '超级管理员') : ($_aid ? '<span class="f_blue">'.$AREA[$_aid]['areaname'].'站</span>管理员' : '普通管理员'); ?></td>
<td class="tl">登录次数</td>
<td width="30%">&nbsp;<?php echo $user['logintimes']; ?> 次</td>
</tr>
<tr>
<td class="tl">站内信件</td>
<td>&nbsp;<a href="<?php echo $MODULE[2]['linkurl'].'message.php';?>" target="_blank">收件箱[<?php echo $_message ? '<strong class="f_red">'.$_message.'</strong>' : $_message;?>]</a></td>
<td class="tl">登录时间</td>
<td>&nbsp;<?php echo timetodate($user['logintime'], 5); ?> </td>
</tr>
<tr>
<td class="tl">账户余额</td>
<td>&nbsp;<?php echo $_money; ?></td>
<td class="tl">会员<?php echo $AJ['credit_name'];?></td>
<td>&nbsp;<?php echo $_credit; ?> </td>
</tr>
<?php if($_admin == 1) { ?>
<form action="?">
<tr>
<td class="tl">后台搜索</td>
<td colspan="2">
<input type="hidden" name="file" value="search"/>
<input type="text" style="width:98%;color:#444444;" name="kw" value="请输入关键词" onfocus="if(this.value=='请输入关键词')this.value='';"/></td>
<td>&nbsp;<input type="submit" name="submit" value="搜 索" class="btn"/>
</td>
</tr>
</form>
<?php } ?>
<form method="post" action="?">
<tr>
<td class="tl">工作便笺</td>
<td colspan="2">
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<textarea name="note" style="width:98%;height:50px;overflow:visible;color:#444444;"><?php echo $note;?></textarea></td>
<td>&nbsp;<input type="submit" name="submit" value="保 存" class="btn"/>
</td>
</tr>
</form>
</table>
<?php if($_admin == 1) { ?>

	<table width="100%" border="0" cellspacing="1" cellpadding="0" class="mainlist">
		<tr>
			<td width="47%">管理员登录用户名：<?php echo $_username;?> </td>
			<td width="53%">登录时间： <?php echo timetodate($user['logintime'], 5); ?> 登录ip：<?php echo $user['loginip']; ?></td>
		</tr>
		<tr>
			<td>服务器时间： <?php echo timetodate($AJ_TIME, 'Y-m-d H:i:s l');?></td>
			<td>服务器信息： <?php echo PHP_OS.'&nbsp;'.$_SERVER["SERVER_SOFTWARE"];?> [<?php echo gethostbyname($_SERVER['SERVER_NAME']);?>:<?php echo $_SERVER["SERVER_PORT"];?>] <a href="?file=doctor" class="t">[系统体检]</a></td>
		</tr>
		<tr>
			<td>数据库版本： MySQL <?php echo $db->version();?></td>
			<td>安装时间： <?php echo $install;?></td>
		</tr>
      
        <tr>
			<td>是否支持图形处理： <?php echo extension_loaded('gd')&&function_exists('imagecreate')?'支持GD图形处理库':'不支持GD图形处理库';?></td>
			<td>上次备份： <a href="?file=database" title="点击备份数据库"><?php echo $backtime;?><?php if($backdays > 5) { ?> (<span class="f_red"><?php echo $backdays;?></span>天以前)<?php } ?></a></td>
		</tr>
		
    </table> 
	<?php } ?>
	</div>
    
    
<div class="tab" style="display: none;">
		<ul>
			<li><a href="javascript:void(0);" class="on" onclick="$('#main-lang-2').toggle();">补丁信息</a></li>			
		</ul>
</div>

	<div class="main" id="main-lang-2"  style="display: none;">
	<table width="100%" border="0" cellspacing="1" cellpadding="0" class="mainlist">
	
          <tr>
            <td colspan="2"><script type="text/javascript" src="http://bbs.aijiacms.com/api.php?mod=js&bid=4"></script></td>
          </tr>
		  
    </table>

	</div>
	

		<div class="tab">
		<ul>
			<li><a href="javascript:void(0);" class="on" onclick="$('#main-lang-3').toggle();">版权信息</a></li>			
		</ul>
	</div>
        <div class="main" id="main-lang-3">
	<table width="100%" border="0" cellspacing="1" cellpadding="0" class="mainlist">
		<tr  style="display: none;">
			<td width="14%">软件版本</td>
			<td width="86%"><span id="copyright" style="color:#FF0000"></span> aijiacms Version <?php echo AJ_VERSION;?> Release <?php echo AJ_RELEASE;?> <?php echo strtoupper(AJ_CHARSET);?> <?php echo strtoupper(AJ_LANG);?>
			
         </td>
		</tr>
		
		
		<tr>
			<td>官方网站</td>
			<td><a href="http://www.lan-zhong.com" target="_blank">http://www.lan-zhong.com</a> <a href="http://www.lan-zhong.com" target="_blank">技术支持</a> </td>
		</tr>
	</table>
	</div>
	</div>




<script type="text/javascript" src="<?php echo $notice_url;?>"></script>
<script type="text/javascript">
var aijiacms_release = <?php echo AJ_RELEASE;?>;
var aijiacms_version = <?php echo AJ_VERSION;?>;
if(typeof aijiacms_lastrelease != 'undefined') {
	var lastrelease = parseInt(aijiacms_lastrelease.replace('-', '').replace('-', ''));
	if(aijiacms_lastversion >= aijiacms_version && aijiacms_release < lastrelease) {
		Dd('tips_update').style.display = '';
		Dd('last_v').innerHTML = aijiacms_lastversion;
		Dd('last_r').innerHTML = aijiacms_lastrelease;
	}
}
</script>
</body>
</html>