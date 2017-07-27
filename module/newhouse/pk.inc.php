<?php  


defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/newhouse/common.inc.php';
require AJ_ROOT.'/module/newhouse/newhouse.class.php';
require AJ_ROOT.'/include/post.func.php';

$condition = 'status=3 and isnew=1';
$biao=$AJ_PRE.'newhouse_6';
//$itemid = $_GET['id'];
echo $id;
$itemid='2,3';

$callback = trim($_GET['callback']);
//$itemid = implode(',', $itemid);
$tags = array();
$result = $db->query("SELECT * FROM $biao  WHERE itemid IN ($itemid) ORDER BY addtime DESC");
while($r = $db->fetch_array($result)) {
	$tags[] = $r;
		}
		
if($tags)
{ 
foreach($tags AS $k=>$v) {
//$v['title'] = iconv('GBK','UTF-8',$v['title']);
$v['title'] = unicode_encode($v['title']);
//$v['address'] = iconv('GBK','UTF-8',$v['address']);
$v['address'] = unicode_encode($v['address']);
$r = array('hid'=>$v['itemid'],'name'=>$v['title'],'address'=>$v['address']);
$json[] = JSON($r);
}
$json_str = implode(',',$json);
}

echo $callback."([".$json_str."])";
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