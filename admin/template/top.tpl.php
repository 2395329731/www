<?php
	defined('AJ_ADMIN') or exit('Access Denied');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>头部</title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link rel="stylesheet" type="text/css" href="admin/template/css/top.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script language="javascript" type="text/javascript" charset="utf-8" src="admin/template/js/topmenu.js"></script>
<script language="javascript" type="text/javascript">

var displayBar=true;
function switchBar(obj)
{
	if (document.all) //IE
	{
		if (displayBar)
		{
			parent.frame.cols="0,*";
			displayBar=false;
			obj.value="关闭左边菜单";
		}
		else{
			parent.frame.cols="210,*";
			displayBar=true;
			obj.value="打开左边菜单";
		}
	}
	else //Firefox 
	{  
		if (displayBar)
		{
			self.top.document.getElementById('frame').cols="0,*";
			displayBar=false;
			obj.value="打开左边菜单";
		}
		else{
			self.top.document.getElementById('frame').cols="210,*";
			displayBar=true;
			obj.value="关闭左边菜单";
		}
	}
}
</script>
<script language="javascript" type="text/javascript">
function ad(ele)
{
var es = document.getElementById("navtit").getElementsByTagName("span");
for(var i=0;i<es.length;i++)
{
es[i].className = "";//设置所有tab为默认样式
}
ele.className = "hover"//激活当前点击tab
}
</script>
</head>

<body oncontextmenu="return false" ondragstart="return false" onSelectStart="return false">
<div class="top_box">
    <div class="top_logo"></div>
    <div class="top_nav">
         <div class="top_nav_sm">
		 
		 <span style="float:right; padding-right:12px"> [<a href="http://www.lan-zhong.com" target='main'>揽众信息技术</a>]</span>
		 
		您好！<?php echo $_username;?> [<?php echo $_admin == 1 ? ($CFG['founderid'] == $_userid ? '网站创始人' : '超级管理员') : ($_aid ? '<span class="f_blue">'.$AREA[$_aid]['areaname'].'站</span>管理员' : '普通管理员'); ?>]  &nbsp;&nbsp;&nbsp;&nbsp; <span onclick="changeMenu(this);"><a href="?action=start" onclick="goindex()"><i>后台首页</i></a></span>|
		 <a href="./" target="_blank">网站首页</a> 
		<!--  <a href="http://www.aijiacms.com" target="_blank">官方网站</a> | <a href="http://bbs.aijiacms.com" target="_blank">技术论坛</a> | <a href="http://help.aijiacms.com" target="_blank">帮助文档</a> -->  &nbsp; 
		</div>
		<?php if($_admin == 2) {
?> <div class="top_nav_xm">
             <div class="navtit" id="navtit">
			
           
			<span class="hover" ><a href="?action=main" target="main"><i>系统首页</i></a></span>
			<span ><a href="?action=cache" target="main"><i>更新缓存</i></a></span>
			<span ><a href="?action=password" target="main"><i>修改密码</i></a></span>
			<span ><a href="?action=main" target="main"><i>网站首页</i></a></span>
	
		
				
             </div>
         </div>
    </div><?php } else { ?>
         <div class="top_nav_xm">
             <div class="navtit" id="navtit">
			
              <span  class="hover" onclick="ad(this)"><a href="?file=left&action=setting"  target='left'><i>系统设置</i></a></span>
			  <?php
	foreach($MODULE as $v) {
		if($v['moduleid'] > 3) {
			$menuinc = AJ_ROOT.'/module/'.$v['module'].'/admin/menu.inc.php';
			if(is_file($menuinc)) {
				extract($v);
				include $menuinc;
			
				echo '<span onclick="ad(this)"><a href="?file=left&menu='.$moduleid.'" target="left"><i>'.$name.'管理</i></a></span>';
				
			}
		}
	}
	
	?>
		 <span  onclick="ad(this)"><a href="?file=left&action=fenxiao"  target='left'><i>分销设置</i></a></span>
				
             </div>
         </div>
    </div>
	<?php } ?>
    <div class="top_bar"><input onClick="switchBar(this)" type="button" value="关闭左边菜单" name="SubmitBtn" class="bntof"/> 
    <div class="top_she"> 
	<?php if($_admin == 2) {
?> <a href="javascript:void(0);" onClick="self.top.location.href='?file=logout'">安全注销</a> <?php } else { ?>
		<a href="javascript:void(0);" onClick="self.top.location.href='?file=logout'">安全注销</a>
		<a href="?action=password" target='main'>修改密码</a>
		<a href="?file=count" target='main'>统计信息</a>
		<a href="?file=left&action=changedata" target='left'>更新数据</a>
		<a href="?file=left&menu=3" target='left'>扩展管理</a>
		 <a href="?file=left&action=member" target='left'>会员管理</a>
		 <?php } ?>
    </div>
    </div>
</div>

</body>
</html>
