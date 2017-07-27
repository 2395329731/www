<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
$fileroot = AJ_ROOT.'/'.$MOD['moduledir'].'/';
$filename = $fileroot.$AJ['index'].'.'.$AJ['file_ext'];
if(!$MOD['index_html']) {
	if(is_file($filename)) unlink($filename);
	return false;
}
if($AJ['rewrite']) {
	defined('AJ_REWRITE') or define('AJ_REWRITE', true);
	$_SERVER["SCRIPT_NAME"] = 'index.php';
	$_SERVER['QUERY_STRING'] = '';
} else {
	$GLOBALS['AJ_URL'] = $AJ_URL = 'index.php';
}
$typeid = 99;
$dtype = '';
$maincat = get_maincat(0, $moduleid);
if($AJ['city']){
$mainarea = get_mainarea($cityid);
}else{
$mainarea = get_mainarea(0);}
if($page == 1) $head_canonical = $MOD['linkurl'];
$condition = 'status=3 ';

	
if($catid) $condition .= $CAT['child'] ? " AND catid IN (".$CAT['arrchildid'].")" : " AND catid=$catid";	      
//$condition .= ($CAT['child']) ? " AND catid IN (".$CAT['arrchildid'].")" : " AND catid=$catid";

if($AJ['city']){
$mainarea = get_mainarea($cityid);
}else{
$mainarea = get_mainarea($areaid);}
$pagesize = $MOD['pagesize'];
$offset = ($page-1)*$pagesize;
$items = $db->count($table, $condition, $CFG['db_expires']);
$pages = pages($items, $page, $pagesize);
//$pages = listpages($CAT, $items, $page, $pagesize);
$tags = array();
$hsall=$db->pre.'sale_5';
$hrent=$db->pre.'rent_7';
if($items) {
	$result = $db->query("SELECT ".$MOD['fields']." FROM {$table} WHERE {$condition} ORDER BY ".$MOD['order']." LIMIT {$offset},{$pagesize}", ($CFG['db_expires'] && $page == 1) ? 'CACHE' : '', $CFG['db_expires']);
	while($r = $db->fetch_array($result)) {
		$r['adddate'] = timetodate($r['addtime'], 5);
		$r['editdate'] = timetodate($r['edittime'], 5);
		$r['alt'] = $r['title'];
		$r['tedian'] = $r['tedian'];
		$r['telephone'] = $r['telephone'];
		$r['title'] = set_style($r['title'], $r['style']);
		$r['linkurl'] = $MOD['linkurl'].$r['linkurl'];
		  $itemids=$r['itemid'];
	       $sum_array = $db->query("select sum( t.price/t.houseearm ) as sum_p,count(*) as sum_c from $hsall as t where status=3 and  price <>' ' and houseearm <>' 'and houseid=$itemids");
		 $sum_arrays=$db->fetch_array($sum_array);
		  $avg_price = intval($sum_arrays['sum_p']*10000/$sum_arrays['sum_c']);
		 $avg_pricess=$sum_arrays['avg_price'];
		  $r['avg_price']=$avg_price;
		    $pb= mktime(0,0,0,date('m')-1,date('d'),date('Y'));
		    $sum_arrayb = $db->query("select sum( t.price/t.houseearm ) as sum_p,count(*) as sum_c from $hsall as t where status=3 and price <>' ' and houseearm <>' 'and  houseid=$itemids and addtime >='.$pb.'");
		$sum_arraybs=$db->fetch_array($sum_arrayb);
		  $avg_priceb = intval($sum_arraybs['sum_p']*10000/$sum_arraybs['sum_c']);
		  $r['avg_priceb']=$avg_priceb;
		  $percent_change = round(($avg_priceb-$avg_price)/$avg_priceb*100,2);
		$r['percent_change']=$percent_change;
		
		$sales=$db->get_one("SELECT COUNT(*) AS num FROM $hsall WHERE status=3 and houseid=$itemids");
        $sales=$sales[num];
		$r['sales']=$sales;
		
		$rents=$db->get_one("SELECT COUNT(*) AS num FROM $hrent WHERE status=3 and houseid=$itemids");
        $rents=$rents[num];
		$r['rents']=$rents;
		  
		$tags[] = $r;
	}
	$db->free_result($result);
}
$showpage = 1;
$datetype = 5;
$seo_file = 'index';
include AJ_ROOT.'/include/seo.inc.php';
$aijiacms_task = "moduleid=$moduleid&html=index";
ob_start();
include template('index', $module);
$data = ob_get_contents();
ob_clean();
file_put($filename, $data);
return true;
?>