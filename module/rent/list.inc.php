<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
if($MOD['list_html']) {
	$html_file = listurl($CAT, $page);
	if(is_file(AJ_ROOT.'/'.$MOD['moduledir'].'/'.$html_file)) d301($MOD['linkurl'].$html_file);
}
if(!check_group($_groupid, $MOD['group_list']) || !check_group($_groupid, $CAT['group_list'])) include load('403.inc');
$CP = $MOD['cat_property'] && $CAT['property'];
if($MOD['cat_property'] && $CAT['property']) {
	require AJ_ROOT.'/include/property.func.php';
	$PPT = property_condition($catid);
}
unset($CAT['moduleid']);
extract($CAT);
$maincat = get_maincat($child ? $catid : $parentid, $moduleid);
$typeid = isset($typeid) && isset($TYPE[$typeid]) ? intval($typeid) : 99;
$_GET = safe_replace($_GET);
$_POST = safe_replace($_POST);
$param = $_GET['param'];

	if(!empty($param)&&stristr($param,'-')!=false)
	{
		$param_arr = explode('-', $param);
	
		foreach($param_arr as $_v) {
				if($_v) 
				{
					if(preg_match ( '/([a-z])([0-9_]+)/', $_v, $matchs))
					{
						$$matchs[1] = trim($matchs[2]);
					}
				}
			}
		$areaid = $r;
		$bid = $b;
		$eprice = $e;
		$marea = $m;
		$range = $p;
		$catid = $t;
		$hu = $x;
		$zhuanxiu = $f;
		$year = $y;
		$source = $u;
		$floor = $l;
		$opentime = $o;
		$toward = $s;
		$hot = $h;
		$ord = $n;
		$area = $c;
		$page = $g;
		$kw=$k;
	}
	else
	{
 	$areaid = intval($_GET['r']);
	$bid = intval($_GET['b']);
	$eprice = trim($_GET['e']);
	$marea = trim($_GET['m']);
	$range = intval($_GET['p']);
	$catid = intval($_GET['t']);
	$hu = intval($_GET['x']);
	$zhuanxiu = intval($_GET['f']);
	$year = intval($_GET['y']);
	$floor = intval($_GET['l']);
	$source = intval($_GET['u']);
	$opentime = intval($_GET['o']);
	$toward = intval($_GET['s']);
	$hot = intval($_GET['h']);
	$ord = intval($_GET['n']);
	$area = intval($_GET['c']);
	$page = intval($_GET['g']);
	$keyword = trim($_GET['keyword']);
	$k = trim($_GET['k']);
	}
	$kw=$k;
	
	$condition = 'status=3';
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
		$condition.=" and (`title` like '%$k%'  or `address` like '%$k%' or `housename` like '%$k%' )";
	}
	
 	if(!empty($areaid))
	{
		$lst = "-r".$areaid;
		$lstaddr.= "<i>".area_poss($areaid, ' ')."<a href=\"list".deal_str($lst,'r').".html\"></a></i>";
	}
    if(!empty($bid))
	{
		$lst.= "-b".$bid;
		$lstaddr.= "<i>".area_poss($bid, ' ')."<a href=\"list".deal_str($lst,'b').".html\"></a></i>";
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
	if(!empty($catid))
	{
		$lst.= "-t".$catid;
		$condition .= " AND FIND_IN_SET('$catid',`catid`)" ;
		$lstaddr.= "<i>".get_cats($catid, '5')."<a href=\"list".deal_str($lst,'t').".html\"></a></i>";
	}
	if(!empty($eprice))
	{
		if(stripos($eprice,'_')!==false)
		{
			$pricearr = explode('_',$eprice);
			$minprice = intval($pricearr[0]);
			$maxprice = intval($pricearr[1]);
			if($maxprice>0)
			{
				$lst.= "-e".$eprice;
				$condition.=" and `price`>$minprice and `price`<=$maxprice";
				if($minprice==0)
				{
					$range_name = $maxprice."元以下";
				}
				else
				{
					$range_name = $minprice."-".$maxprice."元";
				}
			}
		}
		else
		{
			$minprice = $eprice;
			$lst.= "-e".$eprice;
			$condition.=" and `price`>$eprice";
			$range_name = $eprice."元以上";
		}
		$lstaddr.= "<i>".$range_name."<a href=\"list".deal_str($lst,'e').".html\"></a></i>";
	}
	
	if(!empty($range))
	{
		$lst.= "-p".$range;
			$mix=mixprice($range,'range','rent_7');
		$max=maxprice($range,'range','rent_7');
		if($mix){$mix=$mix;}
		else
		{$mix=0;}
		if($max){$condition.=" and $mix<=price AND price<$max ";}
		else
		{$condition.=" and $mix <= price ";}
		$range_arr = getbox_name('range','rent_7');
		$range_name=$range_arr[$range];
		$lstaddr.= "<i>".$range_name."<a href=\"list".deal_str($lst,'p').".html\"></a></i>";
	}

	if(!empty($hu))
	{
		$lst.= "-x".$hu;
		$condition.=" and `room`=$hu";
		if($hu==1)
		{
			$type_name="一室";
		}
		elseif($hu==2)
		{
			$type_name="二室";
		}
		elseif($hu==3)
		{
			$type_name="三室";
		}
		elseif($hu==4)
		{
			$type_name="四室";
		}
		else
		{
			$type_name="其他";
		}
		$lstaddr.= "<i>".$type_name."<a href=\"list".deal_str($lst,'x').".html\"></a></i>";
	}
	if(!empty($toward))
	{
		$lst.= "-s".$toward;
		$condition .= " AND FIND_IN_SET('$toward',`toward`)" ;
		$toward_arr = getbox_name('toward','rent_7');
		$toward_name=$toward_arr[$toward];
		$lstaddr.= "<i>".$toward_name."<a href=\"list".deal_str($lst,'s').".html\"></a></i>";
	}
	if(!empty($zhuanxiu))
	{
		$lst.= "-f".$fitment;
		$condition .= " AND FIND_IN_SET('$zhuanxiu',`zhuanxiu`)" ;
		$zhuanxiu_arr = getbox_name('zhuanxiu','rent_7');
		$zhuanxiu_name=$zhuanxiu_arr[$zhuanxiu];
		$lstaddr.= "<i>".$zhuanxiu_name."<a href=\"list".deal_str($lst,'f').".html\"></a></i>";
	}

	if(!empty($year))
	{
		$lst.= "-y".$year;
		if($year==1)
		{
			$condition.=" and `houseyear`<='2000'";
			$year_name = "2000年以前";
		}
		elseif($year==2)
		{
			$condition.=" and `houseyear`>'2000' and `houseyear`<='2005'";
			$year_name = "20000年以后";
		}
		elseif($year==3)
		{
			$condition.=" and `houseyear`>'2005' and `houseyear`<='2010'";
			$year_name = "2005年以后";
		}
		elseif($year==4)
		{
			$condition.=" and `houseyear`>'2010'";
			$year_name = "2010年以后";
		}
		$lstaddr.= "<i>".$year_name."<a href=\"list".deal_str($lst,'y').".html\"></a></i>";
	}
	if(!empty($floor))
	{
		$lst.= "-l".$floor;
		if($floor==1)
		{
			$condition.=" and `floor1`<='6'";
			$floor_name = "6层以下";
		}
		elseif($floor==2)
		{
			$condition.=" and `floor1`>'6' and `floor1`<='12'";
			$floor_name = "6-12层";
		}
		elseif($floor==3)
		{
			$condition.=" and `floor1`>'12' and `floor1`<='20'";
			$floor_name = "12-20层";
		}
		elseif($floor==4)
		{
			$condition.=" and `floor1`>'20'";
			$floor_name = "20层以上";
		}
			$lstaddr.= "<i>".$floor_name."<a href=\"list".deal_str($lst,'l').".html\"></a></i>";
	}
	if(!empty($source))
	{
		$lst.= "-u".$source;
		if($source==1)
		{
			$source_name = "个人";
			$condition.=" and typeid=0";
		}
		elseif($source==2)
		{
			$source_name = "中介";
			$condition.=" and typeid=1";
		}
	$lstaddr.= "<i>".$source_name."<a href=\"list".deal_str($lst,'u').".html\"></a></i>";
	}
	if(!empty($marea))
	{
		if(stripos($marea,'_')!==false)
		{
			$areaarr = explode('_',$marea);
			$minarea = intval($areaarr[0]);
			$maxarea = intval($areaarr[1]);
			if($maxarea>0)
			{
				$lst.= "-m".$marea;
				$condition.=" and `houseearm`>$minarea and `houseearm`<=$maxarea";
				if($minarea==0)
				{
					$area_name = $maxarea."平米以下";
				}
				else
				{
					$area_name = $minarea."-".$maxarea."平米";
				}
			}
		}
		else
		{
			$minarea = $marea;
			$lst.= "-m".$marea;
			$condition.=" and `houseearm`>$marea";
			$area_name = $marea."平米以上";
		}
		$lstaddr.= "<i>".$area_name."<a href=\"list".deal_str($lst,'m').".html\"></a></i>";
	}


	if(!empty($area))
	{
		$lst.= "-c".$area;
		if($area==1)
		{   $condition.=' AND houseearm<40';
			$area_name="40平米以下";
		}
		elseif($area==2)
		{   $condition.=" AND houseearm>40  AND houseearm<60";
			$area_name="40-60平米";
		}
		elseif($area==3)
		{   $condition.=' AND 60<=houseearm AND houseearm<80';
			$area_name="60-80平米";
		}
		elseif($area==4)
		{   $condition.=' AND 80<=houseearm AND houseearm<100';
			$area_name="80-100平米";
		}
		elseif($area==5)
		{	$condition.=' AND 100<=houseearm AND houseearm<120';
			$area_name="100-120平米";
		}
		elseif($area==6)
		{   $condition.=' AND 120<=houseearm AND houseearm<150';
			$area_name="120-150平米";
		}
		elseif($area==7)
		{   $condition.=' AND 150<=houseearm';
			$area_name="150平米以上";
		}
		$lstaddr.= "<i>".$area_name."<a href=\"list".deal_str($lst,'c').".html\"></a></i>";
	}
	if(!empty($opentime))
	{
		$lst.= "-o".$opentime;
		$fromdate = timetodate($AJ_TIME-$opentime*86400, 'Ymd');
		$condition .= " AND edittime>=$fromdate";
		$opentime_name= $opentime."天内";
		$lstaddr.= "<i>".$opentime_name."<a href=\"list".deal_str($lst,'o').".html\"></a></i>";
	}
	if(!empty($hot))
	{   
	   $lst.= "-h".$hot;
		if($hot==1)
		{   $condition.=' AND istop=1';
			
		}
		elseif($hot==2)
		{  $condition.=" and `level` > 0";
		
		}
	else
			   $condition.=' AND ishot=1';
			
	}
	if(!empty($ord))
	{
		if($ord=='2')
		{
		    $order = " order by houseearm desc";
			$order_name = "面积从大到小";
		}
		elseif($ord=='3')
		{
				$order = " order by houseearm ASC";
			$order_name = "面积从小到大";
		}
		elseif($ord=='4')
		{
				$order = " order by (price+0) desc";
			$order_name = "租金从高到低";
		}
		elseif($ord=='5')
		{
				$order = " order by (price+0) ASC";
			$order_name = "租金从低到高";
		}
		else
		{
			$order = " order by ".$MOD['order'];
			$order_name = "默认排序";
		}
		$lst.= "-n".$ord;
	}
		
$areaids=$_GET['areaid'];
if($AJ['city'] && empty($areaid)){
	
	
	$ARE = $AREA[$cityid];
	$condition .= $ARE['child'] ? " and areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";}
if($AJ['city']){
$mainarea = get_mainarea($cityid);
$mainareas = get_mainarea2($areaids);
}else{
$mainarea = get_mainarea(0);
$mainareas = get_mainarea3($areaids);}
$page = max($page,1);
$pagesize = $MOD['pagesize'];
$items = $db->count($table, $condition, $CFG['db_expires']);
$itemsale=$items;
$offset = ($page-1)*$pagesize;
verify();
$pages = housepages($items, $page, $lst,$pagesize);
$tags = array();
if($items) {
	$result = $db->query("SELECT ".$MOD['fields']." FROM {$table} WHERE {$condition} $order LIMIT {$offset},{$pagesize}", ($CFG['db_expires'] && $page == 1) ? 'CACHE' : '', $CFG['db_expires']);
	while($r = $db->fetch_array($result)) {
		$r['adddate'] = timetodate($r['addtime'], 5);
		$r['editdate'] = timetodate($r['edittime'], 5);
		if($lazy && isset($r['thumb']) && $r['thumb']) $r['thumb'] = AJ_SKIN.'image/lazy.gif" original="'.$r['thumb'];
		$r['alt'] = $r['title'];
		$r['title'] = set_style($r['title'], $r['style']);
		$r['linkurl'] = $MOD['linkurl'].$r['linkurl'];
		if($r['to_time'] < $AJ_TIME ) {
			$db->query("UPDATE {$table} SET istop=0 WHERE itemid=".$r['itemid']."");
		}
		if($r['hot_time'] < $AJ_TIME ) {
			$db->query("UPDATE {$table} SET ishot=0 WHERE itemid=".$r['itemid']."");
		}
		$tags[] = $r;
	}
	$db->free_result($result);
}
//右边浏览过房源
if($_COOKIE['RRecentlyGoods']){
	$browseHouse = browseHouse($_COOKIE['RRecentlyGoods']);
  
 }
$showpage = 1;
$datetype = 5;
$seo_file = 'list';
include AJ_ROOT.'/include/seo.inc.php';
if($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'].mobileurl($moduleid, $catid, 0, $page);
$template = $CAT['template'] ? $CAT['template'] : ($MOD['template_list'] ? $MOD['template_list'] : 'list');
include template($template, $module);
?>