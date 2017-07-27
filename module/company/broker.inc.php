<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
$condition = "groupid=6";
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
		$page = $g;
	}
	else
	{
 	$areaid = intval($_GET['r']);
	$ord = intval($_GET['n']);
	$page = intval($_GET['g']);
	$keyword = trim($_GET['keyword']);
	$k = trim($_GET['k']);
	}
	if(!empty($keyword))
	{
		$keyword1 = iconv('gbk', 'utf-8', $keyword);//rewrite 只支持UTF-8编码的中文
		$lst1.= "-k".htmlentities(urlencode($keyword1));
		$condition.=" and  (`truename` like '%$keyword%' or `username` like '%$keyword%' )";
	}
	if(!empty($k))
	{
		//$keyword = iconv('utf-8','gbk' , $k);
		$lst1.= "-k".htmlentities(urlencode($k));
		$condition.=" and  (`truename` like '%$keyword%' or `username` like '%$keyword%' )";
	}
if(!empty($areaid))
	{
		$lst = "-r".$areaid;
		$condition .= $ARE['child'] ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$bid";
	}
	
	if(!empty($ord))
	{
		if($ord=='2')
		{
		    $order = " order by credit desc";
			$order_name = "积分从大到小";
		}
		elseif($ord=='3')
		{
				$order = " order by credit ASC";
			$order_name = "积分从小到大";
		}

		else
		{
			$order = " order by  logintime desc";
			$order_name = "默认排序";
		}
		$lst.= "-n".$ord;
	}
	else
	{
		$order = " order by  logintime desc";
		$order_name = "默认排序";
	}

$page = max($page,1);
$pagesize = 10;
$offset = ($page-1)*$pagesize;
$items = $db->count($table_member, $condition, $CFG['db_expires']);
verify();
$pages = housepages($items, $page, $lst,$pagesize);
$tags = array();
if($items) {
	$result = $db->query("SELECT * FROM {$table_member} WHERE {$condition} $order LIMIT {$offset},{$pagesize}", ($CFG['db_expires'] && $page == 1) ? 'CACHE' : '', $CFG['db_expires']);
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
$head_title = $title.'房产经纪人';
include template('broker', $module);

?>