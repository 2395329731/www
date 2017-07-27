<?php
defined('AJ_ADMIN') or exit('Access Denied');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=<?php echo AJ_CHARSET;?>"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="admin/template/css/left.css" type="text/css" rel="stylesheet" />
<title>左侧菜单</title>
<script src="admin/template/js/jquery.min.js"></script>
<script language="javascript" type="text/javascript" charset="utf-8" src="admin/template/js/admin.js"></script>
</head>

<body oncontextmenu="return false" ondragstart="return false" onSelectStart="return false">
	<div class="div_bigmenu">
		<div class="div_bigmenu_nav_down" id="nav_1" onclick="javascript:lefttoggle(1);">常用操作</div>
		<ul id="ul_1">
			<?php
		foreach($mymenu as $menu) {
	?>
	<li><dd onclick="c(this);"><a href="<?php echo substr($menu['url'], 0, 1) == '?' ? $menu['url'] : AJ_PATH.'api/redirect.php?url='.$menu['url'].'" target="_blank';?>" target='main' ><?php echo set_style($menu['title'], $menu['style']);?></a></dd></li>
	<?php
		}
	?>
		
		</ul>
	</div>
	
	
</body>
</html>
