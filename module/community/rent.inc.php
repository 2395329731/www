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
	//同区域楼盘  10条记录
$hsall=$db->pre.'sale_5';
	$tqy =$db->query("SELECT itemid,title,price,areaid,linkurl FROM  {$table} WHERE  $areaid=areaid and $itemid != itemid and status=3 ORDER BY itemid DESC LIMIT 0,10");
	while($tqys=$db->fetch_array($tqy)){
	           $itemids=$tqys['itemid'];
	          $sum_array = $db->query('select sum( t.price/t.houseearm ) as sum_p,count(*) as sum_c from '.$hsall.' as t where  status=3  and houseid='.$itemids.'');
		 $sum_arrays=$db->fetch_array($sum_array);
		  $avg_price = intval($sum_arrays['sum_p']*10000/$sum_arrays['sum_c']);
		 $avg_pricess=$sum_arrays['avg_price'];
		  $tqys['avg_price']=$avg_price;
		
		$same_quyu_list[]=$tqys;
	}
	
	

//$itemid=$_GET['itemid'];
$condition = 'status=3 and houseid = '.$itemid.' ';
	


//价目格范围
	if($p== 1){
			$condition.=' AND price<30';
		}
	if($p == 2){
			$condition.=" AND price>=30  AND price<50";
			
		}
	if($p == 3){
			$condition.=' AND 50<=price AND price<80';
			
		}
	if($p== 4){
			$condition.=' AND 80<=price AND price<100';
		}
	if($p == 5){
			$condition.=' AND 100<=price AND price<120';
		}
	if($p == 6){
			$condition.=' AND 120<=price AND price<150';
		}
	if($p == 7){
			$condition.=' AND 150<=price AND price<200';
		}
			//面积范围
	if($a== 1){
			$condition.=' AND houseearm<40';
		}
	if($a == 2){
			$condition.=" AND houseearm>40  AND houseearm<60";}
	if($a == 3){
			$condition.=' AND 60<=houseearm AND houseearm<80';
			
		}
	if($a== 4){
			$condition.=' AND 80<=houseearm AND houseearm<100';
		}
	if($a == 5){
			$condition.=' AND 100<=houseearm AND houseearm<120';
		}
	if($a == 6){
			$condition.=' AND 120<=houseearm AND houseearm<150';
		}
	if($a == 7){
			$condition.=' AND 150<=houseearm';
		}
		//户型范围
	if($r== 1){
			$condition.=' AND room=1';
		}
	if($r == 2){
			$condition.=" AND room=2";}
	if($r == 3){
			$condition.=' AND room=3';
			
		}
	if($r== 4){
			$condition.=' AND room=4';
		}
	if($r == 5){
			$condition.=' AND 5<=room ';
		}
   
	
$letter = $_GET['letter'];
if($letter){
	$condition .= " and letter like '".$letter."%'";
	
}
//list_order 排序转换
switch ($_GET['order']){
	
	case "ed":
		$order = " order by edittime desc";
		break;
		case "ea":
		$order = " order by edittime asc";
		break;
	case "pa":
		$order = " order by price asc";
		break;
	case "pd":
		$order = " order by price desc";
		break;
	case "ha":
		$order = " order by houseearm asc";
		break;
	case "hd":
		$order = " order by houseearm desc";
		break;
	default:
		$order = " order by itemid desc";
		break;
}
$tags = array();
$hsall=$db->pre.'rent_7';
$pagesize =10;
	if(!$pagesize || $pagesize > 100) $pagesize = 30;
	$offset = ($page-1)*$pagesize;
	$r = $db->get_one("SELECT COUNT(*) AS num FROM $hsall   WHERE  {$condition}");
	$items = $r['num'];
	$itemsale=$items;
	$pages = pages($r['num'], $page, $pagesize);
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
	$db->free_result($result);

$showpage = 1;
$datetype = 5;

$seo_file = 'list';
include AJ_ROOT.'/include/seo.inc.php';

$template = $CAT['template'] ? $CAT['template'] : 'rent';
include template($template, $module);
?>