<?php

//defined('IN_AIJIACMS') or exit('Access Denied');
include '../../common.inc.php';

$biao=$AJ_PRE.'newhouse_6';
$type = trim($_GET['type']);
$x1 = $_GET['minY'];
$x2 = $_GET['maxY'];
$y1 = $_GET['minX'];
$y2 = $_GET['maxX'];
$newcode = intval($_POST['newcode']);
$newcode_list = $_POST['newcode_list'];
$sql = 'status=3 and isnew=1';
$keyword = safe_replace(trim($_GET['keyword']));
$price = intval($_GET['price']);
$circleid = intval($_GET['circleid']);
$projecttype = intval($_GET['projecttype']);
if (isset($keyword) &&!empty($keyword))
{
$sql.=" and `title` like '%$keyword%'";
}
$opentime = $_POST['opentime'];
$sale = $_POST['sale'];
if (isset($sale) &&!empty($sale))
{
$sql.=" and `typeid` in ($sale)";
}
if (isset($price) &&!empty($price))
{
$mix=mixprice($price,'range','newhouse_6');
		$max=maxprice($price,'range','newhouse_6');
		if($mix){$mix=$mix;}
		else
		{$mix=0;}
		if($max){$sql.=" and $mix<=price AND price<$max ";}
		else
		{$sql.=" and $mix <= price ";}
}
$districts = $_POST['districts'];
$params = $_POST['params'];
$buildfeature = intval($_GET['buildfeature']);

$sort = $_POST['sort'];
if (isset($sort) &&!empty($sort))
{
if($sort=="pa")
{
$order = "price asc";
}
elseif($sort=="pd")
{
$order = "price desc";
}
}
if (isset($buildfeature) &&!empty($buildfeature))
{
$sql .= " AND FIND_IN_SET('$buildfeature',`lpts`)" ;
}
if (isset($projecttype) &&!empty($projecttype))
{
$sql .= " AND FIND_IN_SET('$projecttype',`catid`)" ;

}
	if (isset($areaid) &&!empty($areaid))
{$sql .= $ARE['child'] ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
}
if (isset($circleid) &&!empty($circleid))$sql .= " AND areaid=$circleid";
$result = $db->query("SELECT * FROM $biao WHERE $sql ORDER BY itemid DESC");
while($r = $db->fetch_array($result)) {
	$tags[] = $r;
		}
if($tags)
{
$num=0;
$json = array();
foreach($tags AS $k=>$v) {

if (isset($keyword) &&!empty($keyword))
{
$map = explode(',',$v['map']);
foreach($map as $key =>$value){
		  $lngX =$map['0'];
		   $latY=$map['1']; 
		   }
$num++;
if(($v['priceunit']=="0")||empty($v['priceunit']))
{
$priceunit = '元/平方米';
}
else
{
$priceunit = '元/套';
}
if(empty($v['price'])||($v['price']=='一房一价')||($v['price']==''))
{
$v['price'] = '一房一价';
$priceunit = '';
}
$title=str_replace('·', '%26%23183%3b', $v['title']);
$title = unicode_encode($title);
$address = iconv('GBK','UTF-8',$v['address']);
$address = unicode_encode($address);
$r = array('floorId'=>$v['itemid'],'floor'=>$title,'address'=>$address,'saleCount'=>$v['price'],'bmapx'=>$lngX,'bmapy'=>$latY,'sellSchedule'=>$v['typeid']);
$json[] = JSON($r);
}
else 
{
$map = explode(',',$v['map']);
foreach($map as $key =>$value){
		  $lngX =$map['0'];
		   $latY=$map['1']; 
		   }
if(($lngX>$x1) &&($lngX<$x2) &&($latY>$y1) &&($latY<$y2))
//if($lngX>0) 
{
$num++;
if(($v['priceunit']=="0")||empty($v['priceunit']))
{
$priceunit = '元/平方米';
}
else
{
$priceunit = '元/套';
}
if(empty($v['price'])||($v['price']=='一房一价')||($v['price']==''))
{
$v['price'] = '一房一价';
$priceunit = '';
}

$title=str_replace('·', '%26%23183%3b', $v['title']);
$title = unicode_encode($title);
//$address = iconv('GBK','UTF-8',$v['address']);
$address = unicode_encode($address);
$r = array('floorId'=>$v['itemid'],'floor'=>$title,'address'=>$address,'saleCount'=>$v['price'],'bmapx'=>$lngX,'bmapy'=>$latY,'sellSchedule'=>$v['typeid']);
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
$json_str ="{\"newHouses\":[";
$json_str .= implode(',',$json);
$json_str .= "]}";
}
else
{
$json_str ="{\"newHouses\":null}";
}
echo $json_str;
}
else
{
$json_str ="{\"newHouses\":null}";
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
$name = iconv('UTF-8','UCS-2BE',$name);
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