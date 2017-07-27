<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
$itemid or dheader($MOD['linkurl']);
$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");
if($item && $item['status'] > 2) {
	if($MOD['show_html'] && is_file(AJ_ROOT.'/'.$MOD['moduledir'].'/'.$item['linkurl'])) {
		@header("HTTP/1.1 301 Moved Permanently");
		dheader($MOD['linkurl'].$item['linkurl']);
	}
	extract($item);
} else {
	$head_title = lang('message->item_not_exists');
	@header("HTTP/1.1 404 Not Found");
	exit(include template('show-notfound', 'message'));
}
$CAT = get_cat($catid);
if(!check_group($_groupid, $MOD['group_show']) || !check_group($_groupid, $CAT['group_show'])) {
	$head_title = lang('message->without_permission');
	exit(include template('noright', 'message'));
}
$content_table = content_table($moduleid, $itemid, $MOD['split'], $table_data);
$t = $db->get_one("SELECT content FROM {$content_table} WHERE itemid=$itemid");
$content = $t['content'];
if($MOD['keylink']) $content = keylink($content, $moduleid);

$CP = $MOD['cat_property'] && $CAT['property'];
if($CP) {
	require AJ_ROOT.'/include/property.func.php';
	$options = property_option($catid);
	$values = property_value($moduleid, $itemid);
}




$adddate = timetodate($addtime, 3);
$editdate = timetodate($edittime, 3);
//$selltime = timetodate($selltime, 3);
//$completion = timetodate($completion, 3);

if($map){
$map_mid = $map;
}else{
$map_mid=$map_mid ;}
$map=explode(",",$map_mid);
		foreach($map as $key =>$value){
		  $x =$map['0'];
		   $y=$map['1']; 
		   }

$itype = explode('|', trim($MOD['inquiry_type']));
$iask = explode('|', trim($MOD['inquiry_ask']));
$todate = $totime ? timetodate($totime, 3) : 0;
$expired = $totime && $totime < $AJ_TIME ? true : false;
$linkurl = $MOD['linkurl'].$linkurl;
$thumbs = get_albums($item);
$albums =  get_albums($item, 1);
$amount = number_format($amount, 0, '.', '');
$fee = get_fee($item['fee'], $MOD['fee_view']);
$update = '';
if(check_group($_groupid, $MOD['group_contact'])) {
	if($fee) {
		$user_status = 4;
		$aijiacms_task = "moduleid=$moduleid&html=show&itemid=$itemid";
	} else {
		$user_status = 3;
		$member = $item['username'] ? userinfo($item['username']) : array();
		if($item['totime'] && $item['totime'] < $AJ_TIME && $item['status'] == 3) {
			$update .= ",status=4";
			$db->query("UPDATE {$table}_search SET status=4 WHERE itemid=$itemid and isnew=1");
		}
	
	}
} else {
	$user_status = $_userid ? 1 : 0;
	if($_username && $item['username'] == $_username) {
		$member = userinfo($item['username']);
		$user_status = 3;
	}
}
switch($at) {
	case 'sale':
	$head_title = $title.'-二手房';
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
		$eprice = $e;
		$marea = $m;
		$range = $p;
		$hu = $i;
		$source = $u;
		$ord = $n;
		$area = $c;
		$page = $g;
	}
	else
	{
	$eprice = trim($_GET['e']);
	$marea = trim($_GET['m']);
	$range = intval($_GET['p']);
	$hu = intval($_GET['i']);
	$source = intval($_GET['u']);
	$ord = intval($_GET['n']);
	$area = intval($_GET['c']);
	$page = intval($_GET['g']);

	}
	$condition = 'status=3 and houseid = '.$itemid.' ';

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
					$range_name = $maxprice."万以下";
				}
				else
				{
					$range_name = $minprice."-".$maxprice."万";
				}
			}
		}
		else
		{
			$minprice = $eprice;
			$lst.= "-e".$eprice;
			$condition.=" and `price`>$eprice";
			$range_name = $eprice."万以上";
		}
		$lstaddr.= "<em>".$range_name."<a href=\"list".deal_str($lst,'e').".html\"></a></em>";
	}
	
	if(!empty($range))
	{
		$lst.= "-p".$range;
		$mix=mixprice($range,'range','sale_5');
		$max=salemaxprice($range,'range','sale_5');
		if($mix){$mix=$mix;}
		else
		{$mix=0;}
		if($max){$condition.=" and $mix<=price AND price<$max ";}
		else
		{$condition.=" and $mix <= price ";}
		$range_arr = getbox_name('range','sale_5');
		$range_name=$range_arr[$range];
		$lstaddr.= "<em>".$range_name."<a href=\"list".deal_str($lst,'p').".html\"></a></em>";
	}

	if(!empty($hu))
	{
		$lst.= "-i".$hu;
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
			$condition.=" and typeid=0";
		}
		elseif($source==2)
		{
			$condition.=" and typeid=1";
		}
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
		$lstaddr.= "<em>".$area_name."<a href=\"list".deal_str($lst,'m').".html\"></a></em>";
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
			$order = " order by price/houseearm desc";
			$order_name = "单价从高到低";
		}
		elseif($ord=='5')
		{
			$order = " order by price/houseearm ASC";
			$order_name = "单价从低到高";
		}
		elseif($ord=='6')
		{
				$order = " order by price desc";
			$order_name = "总价从高到低";
		}
		elseif($ord=='7')
		{
				$order = " order by price ASC";
			$order_name = "总价从低到高";
		}
		else
		{
			$order = " order by ".$MOD['order'];
			$order_name = "默认排序";
		}
		$lst.= "-n".$ord;
	}
	else
	{
		$order = " order by ".$MOD['order'];
		$order_name = "默认排序";
	}
	$tags = array();
$hsall=$db->pre.'sale_5';
$pagesize =10;
    $page = max($page,1);
	if(!$pagesize || $pagesize > 100) $pagesize = 30;
	$offset = ($page-1)*$pagesize;
	$r = $db->get_one("SELECT COUNT(*) AS num FROM $hsall   WHERE  {$condition}");
	$items = $r['num'];
	$pages = housepages($items, $page, $lst,$pagesize);
$result = $db->query("SELECT * FROM $hsall WHERE {$condition} $order LIMIT {$offset},{$pagesize}", ($CFG['db_expires'] && $page == 1) ? 'CACHE' : '', $CFG['db_expires']);
while($r = $db->fetch_array($result)) {
		$r['adddate'] = timetodate($r['addtime'], 5);
		$r['editdate'] = timetodate($r['edittime'], 5);
		$r['danjia']=floor($r['price']*10000/$r['houseearm']);
		$r['alt'] = $r['title'];
		$r['title'] = set_style($r['title'], $r['style']);
		$r['linkurl'] = $MODULE[5][linkurl].$r['linkurl'];
		
		$tags[] = $r;
	}
	$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : 'sale');
	break;
	case 'rent':
	case 'sale':
	$head_title = $title.'-二手房';
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
		$eprice = $e;
		$marea = $m;
		$range = $p;
		$hu = $i;
		$source = $u;
		$ord = $n;
		$area = $c;
		$page = $g;
	}
	else
	{
	$eprice = trim($_GET['e']);
	$marea = trim($_GET['m']);
	$range = intval($_GET['p']);
	$hu = intval($_GET['i']);
	$source = intval($_GET['u']);
	$ord = intval($_GET['n']);
	$area = intval($_GET['c']);
	$page = intval($_GET['g']);

	}
	$condition = 'status=3 and houseid = '.$itemid.' ';

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
					$range_name = $maxprice."万以下";
				}
				else
				{
					$range_name = $minprice."-".$maxprice."万";
				}
			}
		}
		else
		{
			$minprice = $eprice;
			$lst.= "-e".$eprice;
			$condition.=" and `price`>$eprice";
			$range_name = $eprice."万以上";
		}
		$lstaddr.= "<em>".$range_name."<a href=\"list".deal_str($lst,'e').".html\"></a></em>";
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
		$lstaddr.= "<em>".$range_name."<a href=\"list".deal_str($lst,'p').".html\"></a></em>";
	}

	if(!empty($hu))
	{
		$lst.= "-i".$hu;
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
			$condition.=" and typeid=0";
		}
		elseif($source==2)
		{
			$condition.=" and typeid=1";
		}
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
		$lstaddr.= "<em>".$area_name."<a href=\"list".deal_str($lst,'m').".html\"></a></em>";
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
			$order = " order by price/houseearm desc";
			$order_name = "单价从高到低";
		}
		elseif($ord=='5')
		{
			$order = " order by price/houseearm ASC";
			$order_name = "单价从低到高";
		}
		elseif($ord=='6')
		{
				$order = " order by price desc";
			$order_name = "总价从高到低";
		}
		elseif($ord=='7')
		{
				$order = " order by price ASC";
			$order_name = "总价从低到高";
		}
		else
		{
			$order = " order by ".$MOD['order'];
			$order_name = "默认排序";
		}
		$lst.= "-n".$ord;
	}
	else
	{
		$order = " order by ".$MOD['order'];
		$order_name = "默认排序";
	}
	$tags = array();
$hsall=$db->pre.'rent_7';
$pagesize =10;
    $page = max($page,1);
	if(!$pagesize || $pagesize > 100) $pagesize = 30;
	$offset = ($page-1)*$pagesize;
	$r = $db->get_one("SELECT COUNT(*) AS num FROM $hsall   WHERE  {$condition}");
	$items = $r['num'];
	$pages = housepages($items, $page, $lst,$pagesize);
$result = $db->query("SELECT * FROM $hsall WHERE {$condition} $order LIMIT {$offset},{$pagesize}", ($CFG['db_expires'] && $page == 1) ? 'CACHE' : '', $CFG['db_expires']);
while($r = $db->fetch_array($result)) {
		$r['adddate'] = timetodate($r['addtime'], 5);
		$r['editdate'] = timetodate($r['edittime'], 5);
		$r['danjia']=floor($r['price']*10000/$r['houseearm']);
		$r['alt'] = $r['title'];
		$r['title'] = set_style($r['title'], $r['style']);
		$r['linkurl'] = $MODULE[7][linkurl].$r['linkurl'];
		
		$tags[] = $r;
	}
	$head_title = $title.'-租房';
	$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : 'rent');
	break;
	case 'price':
	$head_title = $title.'-价格走势';
	$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : 'jiage');
	break;
	case 'map':
	$head_title = $title.'-交通配套';
	$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : 'map');
	break;

	default:
	$at='index';
include AJ_ROOT.'/include/update.inc.php';
$seo_file = 'show';
include AJ_ROOT.'/include/seo.inc.php';
$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : 'show');
}
include template($template, $module);
?>