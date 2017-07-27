<?php

defined('IN_HOUSE5') or exit('No permission resources.');
if($_POST['top']=="1")
{
$datas = getcache('3360','linkage');
$infos = $datas['data'];
$where_id = intval($parentid);
$num=0;
foreach($infos AS $k=>$v) {
if($v['parentid'] == 0) {
$num++;
$r = array('AreaID'=>$v['parentid'],'OrderID'=>$v['listorder'],'BusiName'=>$v['name'],'BusiAreaID'=>$v['linkageid']
);
$json[] = JSON($r);
}
}
$json_str ="{\"totalCount\":\"$num\",\"Rows\":[";
}
else
{
$parentid = $_POST['AreaID'];
$datas = getcache('3360','linkage');
$infos = $datas['data'];
$where_id = intval($parentid);
$num=0;
foreach($infos AS $k=>$v) {
if($v['parentid'] == $where_id) {
$num++;
$r = array('AreaID'=>$v['parentid'],'OrderID'=>$v['listorder'],'BusiName'=>$v['name'],'BusiAreaID'=>$v['linkageid']
);
$json[] = JSON($r);
}
}
$json_str ="{\"totalCount\":\"$num\",\"Rows\":[";
}
$json_str .= implode(',',$json);
$json_str .= "]}";
echo $json_str;
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

?>