<?php 
defined('AJ_ADMIN') or exit('Access Denied');
$edition = edition(1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=<?php echo AJ_CHARSET; ?>" />
<meta name="robots" content="noindex,nofollow"/>
<title>管理员登录 - Powered By  <?php echo $edition;?></title>
<meta name="generator" content="www.aijiacms.com"/>
<link rel="stylesheet" href="admin/image/login.css" type="text/css" />
<script type="text/javascript" src="<?php echo AJ_STATIC;?>lang/<?php echo AJ_LANG;?>/lang.js"></script>
<script type="text/javascript" src="<?php echo AJ_STATIC;?>file/script/config.js"></script>
<script type="text/javascript" src="<?php echo AJ_STATIC;?>file/script/jquery.js"></script>
<script type="text/javascript" src="<?php echo AJ_STATIC;?>file/script/common.js"></script>
<style type="text/css" rel="stylesheet" >
	body {background:#F8F8F8;margin-top:150px;font-family:'Verdana','宋体';}
	form,input,table,tr,td{margin:0px; padding:0px}
	a {color:#175796;text-decoration:none;}
	a:hover {color:red;text-decoration:none;}
	label {font-size:12px;}
	table {background:#fff;border:3px solid #f0f0f0;width:450px; margin:0px auto}
	td,th {font-size:14px;color:#000;}
	th {background:#1A5A8D;height:50px;color:#fff;}
	td {padding:0;height:30px;}
	.input {width:150px;border:1px solid;border-color:#666 #ccc #ccc #666;font-size:14px;padding:3px;margin-top:5px;}
	.yzm {width:80px;border:1px solid;border-color:#666 #ccc #ccc #666;font-size:14px;padding:3px;margin-top:5px;}
	.button {padding:5px 10px; font-size:14px; cursor:pointer}
	.copyright {border-top:1px solid #ccc;color:#666;background:#fbfbfb;font-size:11px;text-align:center;padding:10px 0;}
</style>
</head>
</body>
<noscript><br/><br/><br/><center><h1>您的浏览器不支持JavaScript,请更换支持JavaScript的浏览器</h1></center></noscript>
<noframes><br/><br/><br/><center><h1>您的浏览器不支持框架,请更换支持框架的浏览器</h1></center></noframes>


<form method="post" action="?"  onsubmit="return Dcheck();">
		<input type="hidden" name="file" value="<?php echo $file;?>"/>
		<input name="forward" type="hidden" value="<?php echo $forward;?>"/>


	<table cellspacing="0" align="center">
		<tr><th colspan="2">管理员登录</th></tr>
		<tr>
			<td align="right">管理账号：</td>
			<td><input name="username" type="text" id="username" class="input" style="width:140px;" value="<?php echo $username;?>"/> </td>
		</tr>
			<td align="right">管理密码：</td>
			<td><input name="password" type="password" class="input" style="width:140px;" id="password"<?php if(isset($password)) { ?> value="<?php echo $password;?>"<?php } ?>/>&nbsp;
		<script type="text/javascript" src="<?php echo AJ_STATIC;?>file/script/keyboard.js"></script>
		<img src="<?php echo AJ_STATIC;?>file/image/keyboard.gif" title="密码键盘" alt="" class="c_p" onclick="_k('password', 'kb', this);"/>
		<div id="kb" style="display:none;"></div>
		<script type="text/javascript" src="<?php echo AJ_STATIC;?>file/script/md5.js"></script>
		<script type="text/javascript">init_md5();</script>
		</td>
		</tr>
			<?php if($AJ['captcha_admin']) { ?>		</tr>
			<td align="right">验 证 码：</td>
			<td><?php include template('captcha', 'chip');?></td>
		</tr><?php } ?>
		<tr>
			<td></td>
			<td style="padding:8px 0px">
			<input type="submit" name="submit" value="登 录" class="button" tabindex="4"/>&nbsp;&nbsp;<input type="button" value="退 出" class="button" onclick="top.window.location='<?php echo AJ_PATH;?>';"/>
			</td>
		</tr>
		<tr><td colspan="2" class="copyright">Powered by <strong><a href="http://www.aijiacms.com/" target="_blank">AijiaCMS <?php echo $edition;?></a></strong> &copy; 2011-<?php echo date('Y');?></td></tr>
		<?php if(strpos(get_env('self'), '/admin.php') !== false) { ?>
	<div style="margin:10px 40px 0 40px;border:#FF8D21 1px solid;background:#FFFFDD;padding:8px;"><img src="admin/image/notice.gif" align="absmiddle"/> 提示：为了系统安全，请修改后台文件名admin.php</div>
	<?php } ?>
	</table>
</form>
<script type="text/javascript">
if(Dd('password') == null) alert('看不到密码输入框？ 请检查file/cache目录是否可写');
if(Dd('username').value == '') {
	Dd('username').focus();
} else {
	Dd('password').focus();
}
function Dcheck() {
	if(Dd('username').value == '') {
		confirm('请填写会员名');
		Dd('username').focus();
		return false;
	}
	if(Dd('password').value == '') {
		confirm('请填写密码');
		Dd('password').focus();
		return false;
	}
	<?php if($AJ['captcha_admin']) { ?>
	if(!is_captcha(Dd('captcha').value)) {
		confirm('请填写验证码');
		Dd('captcha').focus();
		return false;
	}
	<?php } ?>
	return true;
}
</script>
</body>
</html>