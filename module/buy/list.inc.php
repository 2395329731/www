<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
//if(!$CAT || $CAT['moduleid'] != $moduleid) include load('404.inc');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
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
		$catid = $t;
		$hu = $x;
		$source = $u;
		$area = $c;
		$page = $g;
		$ord = $n;
		$opentime = $o;
	}
	else
	{
 	$areaid = intval($_GET['r']);
	$bid = intval($_GET['b']);
	$catid = intval($_GET['t']);
	$hu = intval($_GET['x']);
	$source = intval($_GET['u']);
	$area = intval($_GET['c']);
	$page = intval($_GET['g']);
	$ord = intval($_GET['n']);
	$opentime = intval($_GET['o']);
	$keyword = trim($_GET['keyword']);
	$k = trim($_GET['k']);
	}
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
		$condition.=" and (`title` like '%$k%'  or `address` like '%$k%' )";
	}
 	if(!empty($areaid))
	{
		$lst = "-r".$areaid;
		$lstaddr.= "<em>".area_poss($areaid, ' ')."<a href=\"list".deal_str($lst,'r').".html\"></a></em>";
	}
    if(!empty($bid))
	{
		$lst.= "-b".$bid;
		//$lstaddr.= "<em>".area_pos($areaid, ' ')."<a href=\"list".deal_str($lst,'r').".html\"></a></em>";
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
		$lstaddr.= "<em>".get_cats($catid, '5')."<a href=\"list".deal_str($lst,'t').".html\"></a></em>";
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
		$lstaddr.= "<em>".$type_name."<a href=\"list".deal_str($lst,'i').".html\"></a></em>";
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
	$lstaddr.= "<em>".$source_name."<a href=\"list".deal_str($lst,'u').".html\"></a></em>";
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
		$lstaddr.= "<em>".$area_name."<a href=\"list".deal_str($lst,'c').".html\"></a></em>";
	}
	if(!empty($opentime))
	{
		$lst.= "-o".$opentime;
		$fromdate = timetodate($AJ_TIME-$opentime*86400, 'Ymd');
		$opentime_name= $opentime."天内";
		$lstaddr.= "<em>".$opentime_name."<a href=\"list".deal_str($lst,'o').".html\"></a></em>";
	}
if(!empty($ord))
	{
		if($ord=='2')
		{
		    $order = " order by houseearm desc";
			
		}
		elseif($ord=='3')
		{
				$order = " order by houseearm ASC";
			
		}
		elseif($ord=='4')
		{
				$order = " order by price desc";
			
		}
		elseif($ord=='5')
		{
				$order = " order by price ASC";
			
		}
		
		$lst.= "-n".$ord;
	}
	else
	{
		$order = " order by ".$MOD['order'];
		$order_name = "默认排序";
	}

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
if($AJ['city']){
$mainarea = get_mainarea($cityid);
}else{
$mainarea = get_mainarea(0);}

$page = max($page,1);
$pagesize = $MOD['pagesize'];
$offset = ($page-1)*$pagesize;
$items = $db->count($table, $condition, $CFG['db_expires']);
verify();
$pages = housepages($items, $page, $lst,$pagesize);
$tags = array();
if($items) {
	$result = $db->query("SELECT ".$MOD['fields']." FROM {$table} WHERE {$condition}  $order LIMIT {$offset},{$pagesize}", ($CFG['db_expires'] && $page == 1) ? 'CACHE' : '', $CFG['db_expires']);
	while($r = $db->fetch_array($result)) {
		$r['adddate'] = timetodate($r['addtime'], 5);
		$r['editdate'] = timetodate($r['edittime'], 5);
		if($lazy && isset($r['thumb']) && $r['thumb']) $r['thumb'] = AJ_SKIN.'image/lazy.gif" original="'.$r['thumb'];
		$r['alt'] = $r['title'];
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

$template = $CAT['template'] ? $CAT['template'] : ($MOD['template_list'] ? $MOD['template_list'] : 'list');
include template($template, $module);
?>