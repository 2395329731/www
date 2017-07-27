<?php
require('../common.inc.php');
$condition = "status=3 and isnew=1 ";
$purposes = $_POST['item_0'];
$price = $_POST['item_1'];
$regionid = $_POST['item_2'];
$limit = intval($_POST['limit']);
if(!empty($regionid))
{
if(!empty($_POST['item_3']))
{
$regionid = intval($_POST['item_3']);
$arrchildid = get_arrchildids($areaid);
$condition.=" and areaid in (".$arrchildid.")";
}
else
{
$condition .= $ARE['child'] ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$bid";
}
}
$character = $_POST['item_4'];
$price = preg_match ( '/([0-9]+),([0-9]+)/',$price,$matches ) ?$matches : '';
if (isset($price) &&!empty($price))
{
$minprice = $price[1];
$maxprice = $price[2];
if(isset($minprice) &&!empty($minprice))
{
$condition.=" and price >'$minprice'";
}
if(isset($maxprice) &&!empty($maxprice))
{
$condition.=" and price  <'$maxprice'";
}
}
if (isset($purposes) &&!empty($purposes))
{
$condition .= " AND FIND_IN_SET('$purposes',`catid`)" ;
}
if (isset($character) &&!empty($character))
{
$condition .= " AND FIND_IN_SET('$character',`lpts`)" ;
}
$order = "itemid desc";
$newhouse=$db->pre.'newhouse_6';
$result = $db->query("SELECT * FROM $newhouse WHERE {$condition} ");
while($r = $db->fetch_array($result)) {
	$tags[] = $r;
		}
		
if($tags)
{
$num=0;
$json = array();
foreach($tags AS $k=>$v) {
$num++;
//$typename = get_typename($v['type']);
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
$r = array('BuildingName'=>$v['title'],'BuildingID'=>$v['id'],'BuildingUrl'=>$v['url'],'BuildDefaultPic'=>$v['thumb'],'Address'=>$v['address'],'AvgPrice'=>$v['price'],'AvgPriceUnit'=>$priceunit
);
$json[] = JSON($r);
}
$json_str ="{\"totalCount\":\"$num\",\"Rows\":[";
$json_str .= implode(',',$json);
$json_str .= "]}";
echo $json_str;
}
else
{
$json_str ="{\"totalCount\":\"0\",\"Rows\":[";
$json_str .= "]}";
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