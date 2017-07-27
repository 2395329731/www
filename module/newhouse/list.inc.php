<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
$typeid = isset($typeid) && isset($TYPE[$typeid]) ? intval($typeid) : 99;
$param = $_GET['param'];//2012/8/7

if(!empty($param)&&stristr($param,'-')!=false)
	{
		$param_arr = explode('-', $param);
		foreach($param_arr as $_v) {
				if($_v) 
				{
				if(preg_match ( '/([a-z])([0-9A-Z_]+)/', $_v, $matchs))
					{
						$$matchs[1] = trim($matchs[2]);
					}
				}
			}
		$areaid = $r;
		$bid = $b;
		$range = $p;
		$catid = $t;
		$fitment = $f;
		$buildtype = $j;
		$lpts = $l;
		$letter = $e;
		$opentime = $o;
		$typeid = $h;
		$ord = $n;
		$page = $g;
		$k = $k;

		
	}
	else
	{
 	$areaid = intval($_GET['r']);
	$bid = intval($_GET['b']);
	$range = intval($_GET['p']);
	$catid = intval($_GET['t']);
	$fitment = intval($_GET['f']);
	$buildtype = intval($_GET['j']);
	$lpts = intval($_GET['l']);
	$letter = trim($_GET['e']);
	$opentime = intval($_GET['o']);
	$typeid = intval($_GET['h']);
	$ord = intval($_GET['n']);
	$page = intval($_GET['g']);
	$keyword = trim($_GET['keyword']);
	$k = trim($_GET['k']);
	$kw=$k;
	}
	
if($MOD['list_html']) {
	$html_file = listurl($CAT, $page);
	if(is_file(AJ_ROOT.'/'.$MOD['moduledir'].'/'.$html_file)) {
		@header("HTTP/1.1 301 Moved Permanently");
		dheader($MOD['linkurl'].$html_file);
	}
}
if(!check_group($_groupid, $MOD['group_list']) || !check_group($_groupid, $CAT['group_list'])) {
	$head_title = lang('message->without_permission');
	exit(include template('noright', 'message'));
}
$CP = $MOD['cat_property'] && $CAT['property'];
if($MOD['cat_property'] && $CAT['property']) {
	require AJ_ROOT.'/include/property.func.php';
	$PPT = property_condition($catid);
}
unset($CAT['moduleid']);
extract($CAT);

$maincat = get_maincat($child ? $catid : $parentid, $moduleid);

$condition = 'status=3 and isnew=1';
$sorder  = array($L['order'], $L['order_auto'], $L['price_dsc'], $L['price_asc'], $L['vip_dsc'], $L['vip_asc'], $L['selltime_dsc'], $L['selltime_asc'], $L['minamount_dsc'], $L['minamount_asc']);
$dorder  = array($MOD['order'], '', 'price DESC', 'price ASC', 'vip DESC', 'vip ASC', 'selltime DESC', 'selltime ASC', 'minamount DESC', 'minamount ASC');
isset($order) && isset($dorder[$order]) or $order = 0;

$areaids=$_GET['areaid'];


		if(!empty($keyword))
	{
		$keyword1 = iconv('gbk', 'utf-8', $keyword);//rewrite 只支持UTF-8编码的中文
		$lst1.= "-k".htmlentities(urlencode($keyword1));
		$condition.=" and (`title` like '%$keyword%' or `address` like '%$keyword%' )";
	}
	if(!empty($k))
	{
		//$keyword = iconv('utf-8','gbk' , $k);
		$lst1.= "-k".htmlentities(urlencode($k));
		$condition.=" and (`title` like '%$k%'  or `address` like '%$k%'  or `pinyin` like '%$k%'  )";
	}
 	if(!empty($areaid))
	{
		$lst = "-r".$areaid;
	}
    if(!empty($bid))
	{
		$lst.= "-b".$bid;
	}
	if(!empty($areaid) && !empty($bid))
	{
		$condition .= $ARE['child'] ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$bid";
	}
	elseif(!empty($areaid) && empty($bid))//区域顶级
	{
		$arrchildid = get_arrchildids($areaid);
		$condition.=" and areaid in (".$arrchildid.")";
	}
	if(!empty($range))
	{
		$lst.= "-p".$range;
		$mix=mixprice($range,'range','newhouse_6');
		$max=maxprice($range,'range','newhouse_6');
		if($mix){$mix=$mix;}
		else
		{$mix=0;}
		if($max){$condition.=" and $mix<=price AND price<$max ";}
		else
		{$condition.=" and $mix <= price ";}
	}
	if(!empty($catid))
	{
		$lst.= "-t".$catid;
		$condition .= " AND FIND_IN_SET('$catid',`catid`)" ;
		
	}
	if(!empty($fitment))
	{
		$lst.= "-f".$fitment;
		$condition .= " AND FIND_IN_SET('$fitment',`fitment`)" ;
	}
	if(!empty($buildtype))
	{
		$lst.= "-j".$buildtype;
		$condition .= " AND FIND_IN_SET('$buildtype',`buildtype`)" ;
	}
	if(!empty($lpts))
	{
		$lst.= "-l".$lpts;
		$condition .= " AND FIND_IN_SET('$lpts',`lpts`)" ;
	}
	if(!empty($letter) && preg_match('/^[a-zA-Z]+$/i',$letter))
	{
		$lst.= "-e".$letter;
		$condition.=" and `letter` like '%$letter%'";
	}
	if(!empty($opentime))
	{
		$lst.= "-o".$opentime;
		if($opentime=='1')
		{
			$condition.=" and DATE_FORMAT(selltime,'%Y%m') = DATE_FORMAT(CURDATE(),'%Y%m')";//本月
		}
		elseif($opentime=='2')
		{
			$condition.=" and DATE_FORMAT(selltime,'%Y%m') = DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL 1 MONTH),'%Y%m')";//下月
		}
		elseif($opentime=='3')
		{
			$condition.=" and DATE_FORMAT(selltime,'%Y%m') = DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL 3 MONTH),'%Y%m')";//三月内
		}
		elseif($opentime=='4')
		{
			$condition.=" and DATE_FORMAT(selltime,'%Y%m') = DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL 6 MONTH),'%Y%m')";//六月内
		}
		elseif($opentime=='5')
		{
			$condition.=" and DATE_FORMAT(selltime,'%Y%m') = DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 3 MONTH),'%Y%m')";//前三月
		}
		elseif($opentime=='6')
		{
			$condition.=" and DATE_FORMAT(selltime,'%Y%m') = DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 6 MONTH),'%Y%m')";//前六月
		}
	}
	if(!empty($typeid))
	{  $lst.= "-h".$typeid;
		$condition .= " AND typeid=$typeid" ;
		
	}
	if(!empty($ord))
	{
		if($ord=='1')
		{
			$order=" order by price desc";
		}
		elseif($ord=='2')
		{
			$order=" order by price asc";
		}
		elseif($ord=='3')
		{
			$order=" order by selltime asc";
		}
		elseif($ord=='4')
		{
			$order="order by selltime desc";
		}
		$lst.= "-n".$ord;
	}
	else
	{
		$order = " order by ".$MOD['order'];
	}

$areaids=$_GET['areaid'];
if($AJ['city']){
	
	
	$ARE = $AREA[$cityid];
	$condition .= $ARE['child'] ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
$mainarea = get_mainarea($cityid);
$mainareas = get_mainarea2($areaids);
}else{
$mainarea = get_mainarea(0);
$mainareas = get_mainarea3($areaids);}

$page = max($page,1);
$pagesize = $MOD['pagesize'];
$offset = ($page-1)*$pagesize;
$items = $db->count($table, $condition, $CFG['db_expires']);
$total = ceil($items/$pagesize);
verify();
$pages = housepages($items, $page, $lst,$pagesize);
$tags = array();
if($items) {
   // $order = $dorder[$order] ? " ORDER BY $dorder[$order]" : '';
	$result = $db->query("SELECT ".$MOD['fields']." FROM {$table} WHERE {$condition} {$order} LIMIT {$offset},{$pagesize}", ($CFG['db_expires'] && $page == 1) ? 'CACHE' : '', $CFG['db_expires']);
	
	while($r = $db->fetch_array($result)) {
		$r['adddate'] = timetodate($r['addtime'], 5);
		$r['editdate'] = timetodate($r['edittime'], 5);
		$r['alt'] = $r['title'];
		$r['tedian'] = $r['tedian'];
		//if($lazy && isset($r['thumb']) && $r['thumb']) $r['thumb'] = AJ_SKIN.'image/lazy.gif" original="'.$r['thumb'];
		$r['buildtype'] = $r['buildtype'];
		$r['telephone'] = $r['telephone'];
		$r['title'] = set_style($r['title'], $r['style']);
		$r['linkurl'] = $MOD['linkurl'].$r['linkurl'];
		
		$tags[] = $r;
	}
	$db->free_result($result);
}
$showpage = 1;
$datetype = 5;

$seo_file = 'list';
include AJ_ROOT.'/include/seo.inc.php';
if($EXT['wap_enable']) $head_mobile = $EXT['wap_url'].'index.php?moduleid='.$moduleid.'&catid='.$catid.($page > 1 ? '&page='.$page : '');
$template = $CAT['template'] ? $CAT['template'] : ($MOD['template_list'] ? $MOD['template_list'] : 'list');
include template($template, $module);
?>