<?php

//defined('IN_AIJIACMS') or exit('Access Denied');
include '../../common.inc.php';

$biao=$AJ_PRE.'newhouse_6';
$id = intval($_GET['floorId']);
if($_GET['floorId']){
$result = $db->query("SELECT * FROM $biao WHERE status=3 and itemid=$id ORDER BY itemid DESC");
while($r = $db->fetch_array($result)) {
	$tags[] = $r;
		}
		foreach($tags AS $k=>$v) {
		
		   if(empty($v['price'])||($v['price']=='一房一价')||($v['price']==''))
{
$price = '一房一价';

}
else
{$price = $v['price'].'元/平方米';
}
$title = $v['title'];
$title=str_replace('·', '%2E', $title);
$v['address']=dsubstr($v['address'], 38, '');
$address  = $v['address'] ? " ".$v['address']."" : " <br>";
$v['kfs'] = $v['kfs'] ? " ".$v['kfs']."" : " <br>";
$v['telephone'] = $v['telephone'] ? " ".$v['telephone']."" : " <br>";
$v['selltime'] = $v['selltime'] ? " ".$v['selltime']."" : " <br>";
$catname = search_cats($v[catid], '6') ? " ".search_cats($v[catid], '6')."" : " <br>";
//$address = unicode_encode($address);
$linkurl = $v['linkurl'];
$r = array('floorId'=>$v['itemid'],'floor'=>$title,'address'=>$address,'averageprice'=>$price,'floorUse'=>$catname,'companyid'=>$r['developer'],'company'=>$v['kfs'],'issuePic'=>imgurl($v[thumb]),'aliasname'=>$linkurl,'openQuotation'=>$v['selltime'],'phone'=>$v['telephone'],'sellSchedule'=>$v['typeid']);
}
$json[] = JSON($r);


$json_str = implode(',',$json);
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