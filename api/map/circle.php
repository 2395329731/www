<?php
include '../../common.inc.php';
$areaid = intval($_GET['areaid']);
$areaid = intval($areaid);
 $area=$db->pre.'area';
$result = $db->query("SELECT * FROM $area WHERE parentid=$areaid ORDER BY areaid DESC");
while($r = $db->fetch_array($result)) {
	$tags[] = $r;
		}

$str.= '<a href="javascript:;" pid="0"  zoom="14">不限</a>';
foreach($tags AS $k=>$v) {
if($v['parentid'] == $areaid) {
$str.='<a href="javascript:;" pid="'.$v['areaid'].'"  zoom="14">'.$v['areaname'].'</a>';
}
}
$str.='</select>';
echo $str;

?>