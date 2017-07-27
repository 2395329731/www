<?php
/*
	[aijiacms System] Copyright (c) 2008-2011 aijiacms.com
	This is NOT a freeware, use is subject to license.txt
*/
//header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
require '../common.inc.php';
$map_mid=explode(",",$map_mid);
		foreach($map_mid as $key =>$value){
		   $lan=$map_mid['0'];
		   $lat=$map_mid['1'];
		   }
$area=$db->pre.'area';
$sql1 = "SELECT * FROM $area where parentid=0 ";		
   $result = mysql_query($sql1);
	while($r = mysql_fetch_array($result)) {
	$cityid=$r['areaid'];
	}	 		   
$sql = "SELECT * FROM $area where parentid=$cityid ";
 $str='[';

	$result = mysql_query($sql);
	while($r = mysql_fetch_array($result)) {
	$arr=$r['map'];
	$map=explode(",",$arr);
		foreach($map as $key =>$value){
		  $x =$map['0'];
		   $y=$map['1']; 
		   }
		  
		   $a='{name:"'.$r['areaname'].'",'.'aid:"'.$r['areaid'].'",'.' x:"'.$x.'", y:"'.$y.'"},';
		 
	 
		$str .=$a;
	}
	$len=strlen($str); 
	if($len==1){
	 $quyu=substr($str,0,$len); }
	 else
	{$quyu=substr($str,0,$len-1);}  
	//$s=substr($str,0,$len-1); 
	$quyu .=']';

	
		include template('index', 'map');

?>