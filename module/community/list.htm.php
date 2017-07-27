<?php
defined('IN_AIJIACMS') or exit('Access Denied');
if(!$MOD['list_html'] || !$catid) return false;
$CAT or $CAT = get_cat($catid);
if(!$CAT) return false;
unset($CAT['moduleid']);
extract($CAT);
$CP = $MOD['cat_property'] && $CAT['property'];
if($MOD['cat_property'] && $CAT['property']) {
	require_once AJ_ROOT.'/include/property.func.php';
	$PPT = property_condition($catid);
}
$maincat = get_maincat($child ? $catid : $parentid, 6);

if($AJ['city']){
$mainarea = get_mainarea($cityid);
}else{
$mainarea = get_mainarea(0);}
if($page == 1) {
	$condition = 'status=3 ';
	$condition .= ($CAT['child']) ? " AND catid IN (".$CAT['arrchildid'].")" : " AND catid=$catid";
	$items = $db->count($table, $condition);
	if($items != $CAT['item']) {
		$CAT['item'] = $items;
		$db->query("UPDATE {$AJ_PRE}category SET item=$items WHERE catid=$catid");
	}
} else {
	$items = $CAT['item'];
}
$pagesize = $MOD['pagesize'];
$showpage = 1;
$datetype = 5;
$template = $CAT['template'] ? $CAT['template'] : 'list';
$total = max(ceil($items/$MOD['pagesize']), 1);
if(isset($fid) && isset($num)) {
	$page = $fid;
	$topage = $fid + $num - 1;
	$total = $topage < $total ? $topage : $total;
}
for(; $page <= $total; $page++) {
	$offset = ($page-1)*$pagesize;
	$pages = listpages($CAT, $items, $page, $pagesize);
	$tags = array();
$hsall=$db->pre.'sale_5';
$hrent=$db->pre.'rent_7';
$null="' '";
	$result = $db->query("SELECT ".$MOD['fields']." FROM {$table} WHERE {$condition} ORDER BY ".$MOD['order']." LIMIT {$offset},{$pagesize}");
	while($r = $db->fetch_array($result)) {
		$r['adddate'] = timetodate($r['addtime'], 5);
		$r['editdate'] = timetodate($r['edittime'], 5);
		$r['alt'] = $r['title'];
		$r['title'] = set_style($r['title'], $r['style']);
		$r['linkurl'] = $MOD['linkurl'].$r['linkurl'];
			  $itemids=$r['itemid'];
	       $sum_array = $db->query('select sum( t.price/t.houseearm ) as sum_p,count(*) as sum_c from '.$hsall.' as t where houseid='.$itemids.'  and price <>'.$null.' and houseearm <>'.$null.'');
		 $sum_arrays=$db->fetch_array($sum_array);
		  $avg_price = intval($sum_arrays['sum_p']*10000/$sum_arrays['sum_c']);
		 $avg_pricess=$sum_arrays['avg_price'];
		  $r['avg_price']=$avg_price;
		    $pb= mktime(0,0,0,date('m')-1,date('d'),date('Y'));
		    $sum_arrayb = $db->query('select sum( t.price/t.houseearm ) as sum_p,count(*) as sum_c from '.$hsall.' as t where houseid='.$itemids.' and price <>'.$null.' and houseearm <>'.$null.' and addtime >='.$pb.'');
		$sum_arraybs=$db->fetch_array($sum_arrayb);
		  $avg_priceb = intval($sum_arraybs['sum_p']*10000/$sum_arraybs['sum_c']);
		  $r['avg_priceb']=$avg_priceb;
		  $percent_change = round(($avg_priceb-$avg_price)/$avg_priceb*100,2);
		$r['percent_change']=$percent_change;
		
		$sales=$db->get_one("SELECT COUNT(*) AS num FROM $hsall WHERE houseid=$itemids");
        $sales=$sales[num];
		$r['sales']=$sales;
		
		$rents=$db->get_one("SELECT COUNT(*) AS num FROM $hrent WHERE houseid=$itemids");
        $rents=$rents[num];
		$r['rents']=$rents;
		$tags[] = $r;
	}
	$seo_file = 'list';
	include AJ_ROOT.'/include/seo.inc.php';
	$aijiacms_task = "moduleid=$moduleid&html=list&catid=$catid&page=$page";
	$filename = AJ_ROOT.'/'.$MOD['moduledir'].'/'.listurl($CAT, $page);
	ob_start();
	include template($template, $module);
	$data = ob_get_contents();
	ob_clean();
	if($AJ['pcharset']) $filename = convert($filename, AJ_CHARSET, $AJ['pcharset']);
	file_put($filename, $data);
	if($page == 1) {
		$indexname = AJ_ROOT.'/'.$MOD['moduledir'].'/'.listurl($CAT, 0);
		if($AJ['pcharset']) $indexname = convert($indexname, AJ_CHARSET, $AJ['pcharset']);
		file_copy($filename, $indexname);
	}
}
return true;
?>