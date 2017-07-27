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
		$letter = $j;
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
	$letter = trim($_GET['j']);
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
		$lstaddr.= "<i>".area_poss($areaid, ' ')."<a href=\"list".deal_str($lst,'r').".html\"></a></i>";
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
		$lstaddr.= "<i>".get_cats($catid, '6')."<a href=\"list".deal_str($lst,'t').".html\"></a></i>";
	}
	if(!empty($letter) && preg_match('/^[a-zA-Z]+$/i',$letter))
	{
		$lst.= "-j".$letter;
		$condition.=" and `letter` like '%$letter%'";
			$lstaddr.= "<i>".$letter."<a href=\"list".deal_str($lst,'j').".html\"></a></i>";
	}
  
if(!empty($ord))
	{
		if($ord=='1')
		{
			$order=" order by hits desc";
		}
		elseif($ord=='2')
		{
			$order=" order by hits asc";
		}
	
		$lst.= "-n".$ord;
	}
	else
	{
		$order = " order by ".$MOD['order'];
	}
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
$pages = housepages($items, $page, $lst,$pagesize);
$tags = array();
verify();
if($items) {
	$result = $db->query("SELECT ".$MOD['fields']." FROM {$table} WHERE {$condition} ORDER BY ".$MOD['order']." LIMIT {$offset},{$pagesize}", ($CFG['db_expires'] && $page == 1) ? 'CACHE' : '', $CFG['db_expires']);
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

$template = $CAT['template'] ? $CAT['template'] : 'list';
include template($template, $module);
?>