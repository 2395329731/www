<?php
include '../../common.inc.php';
$communityid = intval($_GET['communityid']);
$condition = "status=3 and houseid=$communityid";
if($_GET['curpage'])
	{$page = intval($_GET['curpage']);}
	else
{$page = 1;}
	$perpage = 6;	
if(in_array($_GET['priceorder'],array('ASC','DESC')))
{
$order = 'order by price '.$_GET['priceorder'];

}

elseif(in_array($_GET['areaorder'],array('ASC','DESC')))
{
$order = 'order by houseearm '.$_GET['areaorder'];

}
elseif(in_array($_GET['neworder'],array('ASC','DESC')))
{
$order = 'order by edittime '.$_GET['neworder'];

}
elseif(in_array($_GET['hotorder'],array('ASC','DESC')))
{
$order = 'order by hits '.$_GET['hotorder'];

}
else
{
$order = 'order by itemid desc';
}
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
$price = intval($_GET['price']);
$roomtype = intval($_GET['roomtype']);
$area_range = intval($_GET['area']);
$areaid = intval($_GET['areaid']);
$circleid = intval($_GET['circleid']);
$project = intval($_GET['project']);
$year = intval($_GET['houseage']);
	if (isset($areaid) &&!empty($areaid))
{$condition .= $ARE['child'] ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
}
if (isset($circleid) &&!empty($circleid))$condition .= " AND areaid=$circleid";

if (isset($price) &&!empty($price))
{
	    $mix=mixprice($price,'range',$tableb);
		$max=salemaxprice($price,'range',$tableb);
		if($mix){$mix=$mix;}
		else
		{$mix=0;}
		if($max){$condition.=" and $mix<=price AND price<$max ";}
		else
		{$condition.=" and $mix <= price ";}
}
if (isset($roomtype) &&!empty($roomtype))
{
$condition.=" and `room` = '$roomtype'";
}
if (isset($area_range) &&!empty($area_range))
{
if($area_range==1)
		{   $conditions.=' AND houseearm<40';
			
		}
		elseif($area_range==2)
		{   $condition.=" AND houseearm>40  AND houseearm<60";
			
		}
		elseif($area_range==3)
		{   $condition.=' AND 60<=houseearm AND houseearm<80';
			
		}
		elseif($area_range==4)
		{   $condition.=' AND 80<=houseearm AND houseearm<100';
			
		}
		elseif($area_range==5)
		{	$condition.=' AND 100<=houseearm AND houseearm<120';
			
		}
		elseif($area_range==6)
		{   $condition.=' AND 120<=houseearm AND houseearm<150';
			
		}
		elseif($area_range==7)
		{   $condition.=' AND 150<=houseearm';
			
		}
}
if (isset($project) &&!empty($project))
{
$condition.=" and `catid` = '$project'";
}
if (isset($year) &&!empty($year))
{
if($year==1)
		{  	$condition.=" and `houseyear`<='2000'";
			
		}
		elseif($year==2)
		{  $condition.=" and `houseyear`>'2000'";
			
		}
		elseif($year==3)
		{  $condition.=" and `houseyear`>'2000' and `houseyear`<='2010'";
		
		}
		elseif($year==4)
		{ 
		$condition.=" and `houseyear`>'2010'";
		
			}

}



$r = $db->get_one("SELECT COUNT(*) AS num FROM $table   WHERE  $condition");
$num = $r['num'];
	
$pages = ceil($num / $perpage);
$offset = ($page-1)*$perpage;
$rs = $db->query("SELECT * FROM $table where $condition $order LIMIT $offset,$perpage  ");
while($r = $db->fetch_array($rs)) {
	$key_array[] = $r;
		}
if($key_array)
{
$json = array();
foreach($key_array AS $k=>$v) {
	$v['title']=dsubstr($v[title], 38, '..');
$title = unicode_encode($v['title']);

$v['thumb']=imgurl($v['thumb']);
$titlepic = str_replace('/','\/',$v['thumb']);

$r = array('hid'=>$v['itemid'],'title'=>$title,'titlepic'=>$titlepic,'room'=>$v['room'],'hall'=>$v['hall'],'housename'=>$v['housename'],'floor'=>$v['floor1'],'totalfloor'=>$v['floor2'],'price'=>$v['price'],'area'=>$v['houseearm'],'pictag'=>$pictag);
$json[] = JSON($r);
}
if($num>0)
{
if($type=='zufang')
{	
$json_str = "{\"price\":{\"1\":{\"fid\":\"1\",\"name\":\"500\u5143\u4ee5\u4e0b\",\"nums\":3},\"3\":{\"fid\":\"2\",\"name\":\"600-700\u5143\",\"nums\":13},\"4\":{\"fid\":\"3\",\"name\":\"700-800\u5143\",\"nums\":14},\"5\":{\"fid\":\"4\",\"name\":\"800-1000\u5143\",\"nums\":22},\"6\":{\"fid\":\"5\",\"name\":\"100-1200\u5143\",\"nums\":2},\"7\":{\"fid\":\"6\",\"name\":\"1200-1500\u5143\",\"nums\":2},\"8\":{\"fid\":\"7\",\"name\":\"2000\u5143\u4ee5\u4e0a\",\"nums\":1}},\"room\":{\"1\":{\"fid\":\"1\",\"name\":\"\u4e00\u5ba4\",\"nums\":5},\"2\":{\"fid\":\"2\",\"name\":\"\u4e8c\u5ba4\",\"nums\":29},\"3\":{\"fid\":\"3\",\"name\":\"\u4e09\u5ba4\",\"nums\":30},\"4\":{\"fid\":\"4\",\"name\":\"\u56db\u5ba4\",\"nums\":5},\"5\":{\"fid\":\"5\",\"name\":\"\u5176\u5b83\",\"nums\":4}}";
}
else
 {
$json_str = "{\"price\":{\"1\":{\"fid\":\"1\",\"name\":\"30\u4e07\u4ee5\u4e0b\",\"nums\":3},\"3\":{\"fid\":\"3\",\"name\":\"40-50\u4e07\",\"nums\":13},\"4\":{\"fid\":\"4\",\"name\":\"50-60\u4e07\",\"nums\":14},\"5\":{\"fid\":\"5\",\"name\":\"60-80\u4e07\",\"nums\":22},\"6\":{\"fid\":\"6\",\"name\":\"80-100\u4e07\",\"nums\":2},\"7\":{\"fid\":\"7\",\"name\":\"100-150\u4e07\",\"nums\":2},\"8\":{\"fid\":\"8\",\"name\":\"150-200\u4e07\",\"nums\":1}},\"room\":{\"1\":{\"fid\":\"1\",\"name\":\"\u4e00\u5ba4\",\"nums\":5},\"2\":{\"fid\":\"2\",\"name\":\"\u4e8c\u5ba4\",\"nums\":29},\"3\":{\"fid\":\"3\",\"name\":\"\u4e09\u5ba4\",\"nums\":30},\"4\":{\"fid\":\"4\",\"name\":\"\u56db\u5ba4\",\"nums\":5},\"5\":{\"fid\":\"5\",\"name\":\"\u5176\u5b83\",\"nums\":4}}";
}
$json_str .=",\"house\":[";
$json_str .= implode(',',$json);
$json_str .= "],\"communityid\":".$communityid.",\"curpage\":".$page.",\"totalpage\":".$pages.",\"nums\":\"".$num."\"}";
}
else
{
$json_str ="{\"house\":null}";
}
echo $json_str;
}
else
{
$json_str ="{\"house\":null,\"communityid\":".$communityid.",\"curpage\":".$page.",\"totalpage\":".$pages.",\"nums\":\"".$num."\"}";
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