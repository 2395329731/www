<?php
defined('AJ_ADMIN') or exit('Access Denied');
$edition = edition(1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=<?php echo AJ_CHARSET;?>"/>
<title>管理中心 - <?php echo $AJ['sitename']; ?> - Powered By AIJIACMS   <?php echo $edition;?> V<?php echo AJ_VERSION; ?> R<?php echo AJ_RELEASE;?> <?php echo AJ_CHARSET;?> <?php echo strtoupper(AJ_LANG);?></title>
<meta name="robots" content="noindex,nofollow"/>
<meta name="generator" content="AIJIACMS   - www.aijiacms.com"/>
<meta http-equiv="x-ua-compatible" content="IE=8"/>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo AJ_STATIC;?>favicon.ico"/>
<link rel="bookmark" type="image/x-icon" href="<?php echo AJ_STATIC;?>favicon.ico"/>
</head>
<noscript><br/><br/><br/><center><h1>您的浏览器不支持JAVASCRIPT,请更换支持JAVASCRIPT的浏览器</h1></center></noscript>
<noframes><br/><br/><br/><center><h1>您的浏览器不支持框架,请更换支持框架的浏览器</h1></center></noframes>
<script type="text/javascript" src="<?php echo AJ_STATIC;?>file/script/config.js"></script>
<frameset rows="96,*,4"  frameborder="no" border="0" framespacing="0" name="fra"> 
<frame src="?action=top" noresize="noresize" id="topFrame" frameborder="0" 
name="topFrame" marginwidth="0" marginheight="0" scrolling="no">
	<frameset rows="*" cols="185,*" id="frame" framespacing="0" frameborder="no" border="0">
		<frame name="left" noresize scrolling="yes" src="?action=left">
		<frame name="main" noresize scrolling="yes" src="?action=main">
	</frameset>
</frameset>
</html>