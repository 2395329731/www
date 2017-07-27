<?php
defined('AJ_ADMIN') or exit('Access Denied');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="admin/template/css/left.css" type="text/css" rel="stylesheet" />
<title>左侧菜单</title>
<script src="admin/template/js/jquery.min.js"></script>
<script language="javascript" type="text/javascript" charset="utf-8" src="admin/template/js/admin.js"></script>
</head>

<body oncontextmenu="return false" ondragstart="return false" onSelectStart="return false">
<?php if($action=='setting') { ?>
<div class="div_bigmenu">
<div class="div_bigmenu_nav_down" id="nav_1" onclick="javascript:lefttoggle(1);">系统设置</div>
		<ul id="ul_1">
		<?php
		include AJ_ROOT.'/admin/menu.inc.php';
		foreach($menu_system as $m) {
			echo '<li><a href="'.$m[1].' "  target="main">'.$m[0].'</a></li>';
		}
	?>
		</ul>
	</div>
	<div class="div_bigmenu">
<div class="div_bigmenu_nav_down" id="nav_2" onclick="javascript:lefttoggle(2);">系统工具</div>
		<ul id="ul_2">
		<?php
		include AJ_ROOT.'/admin/menu.inc.php';
		foreach($menu as $m) {
			echo '<li><a href="'.$m[1].' "  target="main">'.$m[0].'</a></li>';
		}
	?>
		</ul>
	</div>
<?php } ?>
<?php if($action=='changedata') { ?>
<div class="div_bigmenu">
<div class="div_bigmenu_nav_down" id="nav_1" onclick="javascript:lefttoggle(1);">更新数据</div>
		<ul id="ul_1">
		<li><a href="?action=html" target="main">生成首页</a></li>
		<li><a href="?action=cache" target="main">更新缓存</a></li>
		<li><a href="?moduleid=3&file=html" target="main">更新扩展</a></li>
		<li><a href="?file=html" onclick="return confirm('确定要开始更新全站页面吗？此操作比较耗费服务器资源和时间 ');" target="main">更新全站</a></li>
	
		</ul>
	</div>
<?php } ?>
<?php if($action=='fenxiao') { ?>
<div class="div_bigmenu">
<div class="div_bigmenu_nav_down" id="nav_1" onclick="javascript:lefttoggle(1);">分销平台</div>
		<ul id="ul_1">
		<?php
		include AJ_ROOT.'/admin/menu.inc.php';
		foreach($menu_fenxiao as $m) {
			echo '<li><a href="'.$m[1].' "  target="main">'.$m[0].'</a></li>';
		}
	?>
		</ul>
	</div>
<?php } ?>
<?php if($action=='member') { ?>
<div class="div_bigmenu">
<div class="div_bigmenu_nav_down" id="nav_1" onclick="javascript:lefttoggle(1);">会员管理</div>
		<ul id="ul_1">
		<?php
		$menuinc = AJ_ROOT.'/module/'.$MODULE[2]['module'].'/admin/menu.inc.php';
		if(is_file($menuinc)) {
			extract($MODULE[2]);
			include $menuinc;
		foreach($menu as $m) {
			echo '<li><a href="'.$m[1].' "  target="main">'.$m[0].'</a></li>';
		}
		}
	?>
		</ul>
	</div>
	<div class="div_bigmenu">
<div class="div_bigmenu_nav_down" id="nav_2" onclick="javascript:lefttoggle(2);">财务管理</div>
		<ul id="ul_2">
		<?php
		
		foreach($menu_finance as $m) {
			echo '<li><a href="'.$m[1].' "  target="main">'.$m[0].'</a></li>';
		}
		
	?>
		</ul>
	</div>
	<div class="div_bigmenu">
<div class="div_bigmenu_nav_down" id="nav_3" onclick="javascript:lefttoggle(3);">会员相关</div>
		<ul id="ul_3">
		<?php
		
		foreach($menu_relate as $m) {
			echo '<li><a href="'.$m[1].' "  target="main">'.$m[0].'</a></li>';
		}
	?>
		</ul>
	</div>
<?php } ?>
	<div class="div_bigmenu">
	<?php
	   $menu=_get('menu');
	foreach($MODULE as $v) {
		if($v['moduleid'] ==$menu) {
			$menuinc = AJ_ROOT.'/module/'.$v['module'].'/admin/menu.inc.php';
			if(is_file($menuinc)) {
				extract($v);
				include $menuinc; ?>
				
		<div class="div_bigmenu_nav_down" id="nav_1" onclick="javascript:lefttoggle(1);"><?php echo $name;?>管理</div>
		<ul id="ul_1">
		<?php 
				
					foreach($menu as $m) {
				echo '<li><a href="'.$m[1].' "  target="main">'.$m[0].'</a></li>';
					
				}
				
			}
		}
	}
	?>
	
	
		</ul>
	</div>
	
	
	
</body>
</html>
