<?php

//defined('IN_AIJIACMS') or exit('Access Denied');

include '../../common.inc.php';

$biao=$AJ_PRE.'newhouse_6';
$type = trim($_GET['type']);
$x1 = $_GET['minY'];
$x2 = $_GET['maxY'];
$y1 = $_GET['minX'];
$y2 = $_GET['maxX'];
if($type=='zufang')
{
$table=$AJ_PRE.'rent_7';
$tableb='rent_7';
}
else
{
$table=$AJ_PRE.'sale_5';
$tableb='sale_5';
}

$newcode = intval($_POST['newcode']);
$newcode_list = $_POST['newcode_list'];
$keyword = safe_replace(trim($_GET['keyword']));
$condition = "status=3 and map<>''";
$price = intval($_GET['price']);
$roomtype = intval($_GET['roomtype']);
$area_range = intval($_GET['area']);
$areaid = intval($_GET['areaid']);
$circleid = intval($_GET['circleid']);


$project = intval($_GET['project']);

$year = intval($_GET['houseage']);

if (isset($keyword) &&!empty($keyword))
{
$condition.=" and `title` like '%$keyword%'";
}



$result = $db->query("SELECT * FROM $biao WHERE $condition ORDER BY itemid DESC");
while($r = $db->fetch_array($result)) {
	$tags[] = $r;
		}
if($tags)
{
$num=0;
$json = array();
foreach($tags AS $k=>$v) {
$map = explode(',',$v['map']);
foreach($map as $key =>$value){
		  $lngX =$map['0'];
		   $latY=$map['1']; 
		   }

if(($lngX>$x1) &&($lngX<$x2) &&($latY>$y1) &&($latY<$y2))
{
$num++;
$title = $v['title'];
$title = unicode_encode($title);

if (isset($project) &&!empty($project))
{
$conditions.=" and `catid` = '$project'";

}
	if (isset($areaid) &&!empty($areaid))
{$conditions .= $ARE['child'] ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
}
if (isset($circleid) &&!empty($circleid))$conditions .= " AND areaid=$circleid";
if (isset($price) &&!empty($price))
{
 $mix=mixprice($price,'range',$tableb);
		$max=salemaxprice($price,'range',$tableb);
		if($mix){$mix=$mix;}
		else
		{$mix=0;}
		if($max){$conditions.=" and $mix<=price AND price<$max ";}
		else
		{$conditions.=" and $mix <= price ";}
}
if (isset($roomtype) &&!empty($roomtype))
{
$conditions.=" and `room` = '$roomtype'";
}
if (isset($area_range) &&!empty($area_range))
{
if($area_range==1)
		{   $conditions.=' AND houseearm<40';
			
		}
		elseif($area_range==2)
		{   $conditions.=" AND houseearm>40  AND houseearm<60";
			
		}
		elseif($area_range==3)
		{   $conditions.=' AND 60<=houseearm AND houseearm<80';
			
		}
		elseif($area_range==4)
		{   $conditions.=' AND 80<=houseearm AND houseearm<100';
			
		}
		elseif($area_range==5)
		{	$conditions.=' AND 100<=houseearm AND houseearm<120';
			
		}
		elseif($area_range==6)
		{   $conditions.=' AND 120<=houseearm AND houseearm<150';
			
		}
		elseif($area_range==7)
		{   $conditions.=' AND 150<=houseearm';
			
		}
}
if (isset($year) &&!empty($year))
{
if($year==1)
		{  	$conditions.=" and `houseyear`<='2000'";
			
		}
		elseif($year==2)
		{  $conditions.=" and `houseyear`>'2000'";
			
		}
		elseif($year==3)
		{  $conditions.=" and `houseyear`>'2000' and `houseyear`<='2010'";
		
		}
		elseif($year==4)
		{ 
		$conditions.=" and `houseyear`>'2010'";
		
			}

}
$housenums = $db->count($table, 'houseid ='.$v['itemid'].'' .$conditions.'');
if($housenums)
{
$r = array('communityid'=>$v['itemid'],'communityname'=>$title,'housenums'=>$housenums,'sellprice'=>get_avg_price($v['itemid']),'bmapx'=>$lngX,'bmapy'=>$latY);
$json[] = JSON($r);
}

else
{
continue;
}
}
}
if($num>0)
{
$json_str ="{\"xiaoqu\":[";
$json_str .= implode(',',$json);
$json_str .= "]}";
}
else
{
$json_str ="{\"xiaoqu\":null}";
}
echo $json_str;
}
else
{
$json_str ="{\"xiaoqu\":null}";
echo $json_str;
}
function arrayRecursive(&$array,$function,$apply_to_keys_also = false)
{
foreach ($array as $key =>$value) {
if (is_array($value)) {
arrayRecursive($array[$key],$function,$apply_to_keys_also);
}else {
$array[$key] = $function($value);
}
if ($apply_to_keys_also &&is_string($key)) {
$new_key = $function($key);
if ($new_key != $key) {
$array[$new_key] = $array[$key];
unset($array[$key]);
}
}
}
}
function JSON($array) {
arrayRecursive($array,'urlencode',true);
$json = json_encode($array);
return urldecode($json);
}
function unicode_encode($name)
{
$name = urldecode($name);
$name = iconv('UTF-8','UCS-2',$name);
$len = strlen($name);
$str = '';
for ($i = 0;$i <$len -1;$i = $i +2)
{
$c = $name[$i];
$c2 = $name[$i +1];
if (ord($c) >0)
{
$str .= '\u'.base_convert(ord($c),10,16).str_pad(base_convert(ord($c2),10,16),2,0,STR_PAD_LEFT);
}
else
{
$str .= $c2;
}
}
return $str;
}

?>