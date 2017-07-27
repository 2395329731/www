<?php

require '../common.inc.php';
$map_mid=explode(",",$map_mid);
		foreach($map_mid as $key =>$value){
		   $lan=$map_mid['0'];
		   $lat=$map_mid['1'];
		   }
	 
if($AJ['city']){
$mainarea = get_mainarea($cityid);
}else{
$mainarea = get_mainarea(0);
}
	
include template('newhouse', 'map');

?>