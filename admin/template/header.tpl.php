<?php
defined('AJ_ADMIN') or exit('Access Denied');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=<?php echo AJ_CHARSET;?>"/>
<title>管理中心 - <?php echo $AJ['sitename']; ?> - Powered By AIJIACMS   V<?php echo AJ_VERSION; ?> R<?php echo AJ_RELEASE;?></title>
<meta name="robots" content="noindex,nofollow"/>
<meta name="generator" content="AIJIACMS - www.aijiacms.com"/>
<meta http-equiv="x-ua-compatible" content="IE=8"/>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo AJ_STATIC;?>favicon.ico"/>
<link rel="bookmark" type="image/x-icon" href="<?php echo AJ_STATIC;?>favicon.ico"/>
<?php if(!AJ_DEBUG) { ?><script type="text/javascript">window.onerror= function(){return true;}</script><?php } ?>
<link rel="stylesheet" href="admin/image/style.css" type="text/css"/>
<script type="text/javascript" src="<?php echo AJ_STATIC;?>lang/<?php echo AJ_LANG;?>/lang.js"></script>
<script type="text/javascript" src="<?php echo AJ_STATIC;?>file/script/config.js"></script>
<script type="text/javascript" src="<?php echo AJ_STATIC;?>file/script/jquery.js"></script>
<script type="text/javascript" src="<?php echo AJ_STATIC;?>file/script/common.js"></script>
<script type="text/javascript" src="<?php echo AJ_STATIC;?>file/script/admin.js"></script>
</head>
<body>
<div id="msgbox" onmouseover="closemsg();" style="display:none;"></div>
<?php dmsg();?>