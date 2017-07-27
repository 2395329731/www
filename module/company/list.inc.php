<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
if($MOD['list_html']) {
	$html_file = listurl($CAT, $page);
	if(is_file(AJ_ROOT.'/'.$MOD['moduledir'].'/'.$html_file)) d301($MOD['linkurl'].$html_file);
}
if(!check_group($_groupid, $MOD['group_list']) || !check_group($_groupid, $CAT['group_list'])) include load('403.inc');
unset($CAT['moduleid']);
extract($CAT);
$maincat = get_maincat($child ? $catid : $parentid, $moduleid);

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
		$ord = $n;
		$source = $u;
		$page = $g;
	}
	else
	{
 	$areaid = intval($_GET['r']);
	$ord = intval($_GET['n']);
	$page = intval($_GET['g']);
	$source = intval($_GET['u']);
	$keyword = trim($_GET['keyword']);
	$k = trim($_GET['k']);
	}
	if(empty($source))$condition = "groupid>5 ";
	if(!empty($source))
	{
		$lst.= "-u".$source;
		if($source==1)
		{
			$condition.=' groupid=6';
			$head_title = "经纪人";
		}
		elseif($source==2)
		{
				$condition.=' groupid=7 ';
			$head_title = "中介";
		}

	}
	if(!empty($keyword))
	{
		$keyword1 = iconv('gbk', 'utf-8', $keyword);//rewrite 只支持UTF-8编码的中文
		$lst1.= "-k".htmlentities(urlencode($keyword1));
		$condition.=" and  (`company` like '%$keyword%' or `address` like '%$keyword%' )";
	}
	if(!empty($k))
	{
		//$keyword = iconv('utf-8','gbk' , $k);
		$lst1.= "-k".htmlentities(urlencode($k));
		$condition.=" and  (`company` like '%$k%'  or `address` like '%$k%' )";
	}
if(!empty($areaid))
	{
		$lst = "-r".$areaid;
			$condition .= $ARE['child'] ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
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
verify();
$pages = housepages($items, $page, $lst,$pagesize);
$tags = array();
$tags = $_tags = $ids = array();
if($items) {
	$result = $db->query("SELECT * FROM {$table} WHERE {$condition} ORDER BY ".$MOD['order']." LIMIT {$offset},{$pagesize}", ($CFG['db_expires'] && $page == 1) ? 'CACHE' : '', $CFG['db_expires']);
	while($r = $db->fetch_array($result)) {
		if($lazy && isset($r['thumb']) && $r['thumb']) $r['thumb'] = AJ_SKIN.'image/lazy.gif" original="'.$r['thumb'];
		$tags[] = $r;
	}
}
$showpage = 1;
$seo_file = 'list';
include AJ_ROOT.'/include/seo.inc.php';
if($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'].mobileurl($moduleid, $catid, 0, $page);
$template = $CAT['template'] ? $CAT['template'] : 'list';
include template($template, $module);
?>