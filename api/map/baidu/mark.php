<?php
require '../../../common.inc.php';
include AJ_ROOT.'/api/map/baidu/config.inc.php';
$map = isset($map) ? $map : '';
preg_match("/^[0-9\.\,]{17,21}$/", $map) or $map = $map_mid;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Baidu Map - 双击标注位置</title>
<style type="text/css">
html{height:100%}
body{width :600px;height:400px;margin:0px;padding:0px}
#container{height:100%}
</style>
<script type="text/javascript">window.onerror=function(){return true;}</script>
<script type="text/javascript" src="<?php echo AJ_PATH;?>file/script/config.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.2&services=false"></script>
</head>
<body>
<div id="container"></div>
<script type="text/javascript">
var map = new BMap.Map("container");
var point = new BMap.Point(<?php echo $map;?>);
map.centerAndZoom(point, 15);
map.addControl(new BMap.NavigationControl());
map.addControl(new BMap.ScaleControl());
map.addOverlay(new BMap.Marker(point));
map.enableScrollWheelZoom(true);//鼠标滑动轮子可以滚动
map.enableDragging();
map.addEventListener("dblclick", function(e){
	
	try {
		window.parent.document.getElementById('map').value = e.point.lng+','+e.point.lat;
		window.parent.cDialog();
	} catch(e) {}
});
<?php if($map == $map_mid) { ?>
//自动定位
var localCity = new BMap.LocalCity();
localCity.get(function (r) {
	map.centerAndZoom(r.center, 16);
});
<?php } ?>
</script>
</body>
</html>