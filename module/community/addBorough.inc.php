<?php 

defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/newhouse/common.inc.php';
require AJ_ROOT.'/include/post.func.php';

if ($action='getBoroughList') 
{
$result = $db->query("SELECT * FROM $biao ");

while ($rows = mysql_fetch_array($result)) {
			$rowss[] = $rows;
		}
		  
		}
$result1 = $db->query("SELECT areaid,areaname FROM {$db->pre}area WHERE parentid=$cityid ORDER BY listorder,areaid ASC", 'CACHE');
	while($r = $db->fetch_array($result1)) {
		$are[] = $r;
	}
	$maincat = get_maincat($child ? $catid : $parentid, $moduleid);
	if($AJ['city']){
$mainarea = get_mainarea($cityid);
}else{
$mainarea = get_mainarea(0);}	
include template(addBorough, $module);
?>