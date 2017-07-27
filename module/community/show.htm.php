<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
if(!$MOD['show_html'] || !$itemid) return false;
$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");
if(!$item || $item['status'] < 3) return false;
extract($item);
$CAT = get_cat($catid);
$content_table = content_table($moduleid, $itemid, $MOD['split'], $table_data);
$t = $db->get_one("SELECT content FROM {$content_table} WHERE itemid=$itemid");
$content = $t['content'];
if($MOD['keylink']) $content = keylink($content, $moduleid);

$CP = $MOD['cat_property'] && $CAT['property'];
if($CP) {
	require_once AJ_ROOT.'/include/property.func.php';
	$options = property_option($catid);
	$values = property_value($moduleid, $itemid);
}
if($AJ['city']){
$mainarea = get_mainarea($cityid);
}else{
$mainarea = get_mainarea(0);}
//价格图

$hsall=$AJ_PRE.'sale_5';
if($AJ['city']){

$ARE = $db->get_one("SELECT child,arrchildid FROM {$db->pre}area WHERE areaid=$cityid");
}else{

$ARE = $db->get_one("SELECT child,arrchildid FROM {$db->pre}area");
}
$condition = 'status=3 and houseid='.$itemid.' ';
 $condition .= $ARE['child'] ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$cityid";
  $pa= mktime(0,0,0,date('m')-0,date('d'),date('Y'));
   $la=date("m",$pa);
    $one = $db->get_one("select sum(t.price/t.houseearm) as sum_p,count(*) as sum_c from $hsall as t  where  price <>''and houseearm <>'' and {$condition} ");
 $paa= intval($one['sum_p']*10000/$one['sum_c']);
    $pb= mktime(0,0,0,date('m')-1,date('d'),date('Y'));
   $lb=date("m",$pb);
    $two = $db->get_one("select sum(t.price/t.houseearm) as sum_p,count(*) as sum_c from $hsall as t where  addtime >=$pb and price <>''and houseearm <>''  and {$condition} ");
   $pab= intval($two['sum_p']*10000/$two['sum_c']);
   
    $pc= mktime(0,0,0,date('m')-2,date('d'),date('Y'));
   $lc=date("m",$pc);
    $three = $db->get_one("select sum(t.price/t.houseearm) as sum_p,count(*) as sum_c from $hsall as t where addtime >=$pc and price <>''and houseearm <>''  and {$condition} ");
  $pac= intval($three['sum_p']*10000/$three['sum_c']);
   $pd= mktime(0,0,0,date('m')-3,date('d'),date('Y'));
   $ld=date("m",$pd);
    $four = $db->get_one("select sum(t.price/t.houseearm) as sum_p,count(*) as sum_c from $hsall as t where  addtime >=$pd and price <>'' and houseearm <>'' and {$condition} ");
  $pad= intval($four['sum_p']*10000/$four['sum_c']);
   $pe= mktime(0,0,0,date('m')-4,date('d'),date('Y'));
   $le=date("m",$pe);
    $five = $db->get_one("select sum(t.price/t.houseearm) as sum_p,count(*) as sum_c from $hsall as t where  addtime >=$pe and price <>'' and houseearm <>''  and {$condition} ");
   $pae= intval($five['sum_p']*10000/$five['sum_c']);
   
   $pad= intval($four['sum_p']*10000/$four['sum_c']);
   $percent_change = round(($paa-$pab)/$pab*100,2);
   
   $lineprice="$pae,$pad,$pac,$pab,$paa";
   
  $linedate="\"".$le."\",\"".$ld."\",\"".$lc."\",\"".$lb."\",\"".$la."\"";
   
 Copy_Line_Text($itemid,$lineprice,$linedate);
//同区域楼盘  10条记录
$hsall=$db->pre.'sale';
	$tqy =$db->query("SELECT itemid,title,price,areaid,linkurl FROM  {$table} WHERE  $areaid=areaid and $itemid != itemid and status=3 ORDER BY itemid DESC LIMIT 0,10");
	while($tqys=$db->fetch_array($tqy)){
	           $itemids=$tqys['itemid'];
	          $sum_array = $db->query('select sum( t.price/t.houseearm ) as sum_p,count(*) as sum_c from '.$hsall.' as t where houseid='.$itemids.'');
		 $sum_arrays=$db->fetch_array($sum_array);
		  $avg_price = intval($sum_arrays['sum_p']*10000/$sum_arrays['sum_c']);
	
		 $avg_pricess=$sum_arrays['avg_price'];
		  $tqys['avg_price']=$avg_price;
		
		
		$same_quyu_list[]=$tqys;
	}


	//出售房源  10条记录

$pagesize =10;
	if(!$pagesize || $pagesize > 100) $pagesize = 30;
	$offset = ($page-1)*$pagesize;
	$r = $db->get_one("SELECT COUNT(*) AS num FROM $hsall   WHERE  houseid = $itemid");
	$items = $r['num'];
	$itemsale=$items;
	$pages = pages($r['num'], $page, $pagesize);
	$tjw =$db->query("SELECT * FROM  $hsall WHERE  houseid = $itemid  ORDER BY itemid DESC LIMIT 0,6");
	
	while($tjws=$db->fetch_array($tjw)){
		 
		$hsall_list[]=$tjws;
	}
	//出租房源  10条记录
$hrent=$db->pre.'rent';
$pagesize =10;
	if(!$pagesize || $pagesize > 100) $pagesize = 30;
	$offset = ($page-1)*$pagesize;
	$r = $db->get_one("SELECT COUNT(*) AS num FROM $hrent   WHERE  houseid = $itemid");
	$items = $r['num'];
	$itemrent=$items;
	$pages = pages($r['num'], $page, $pagesize);
	$tjw =$db->query("SELECT * FROM  $hrent WHERE  houseid = $itemid  ORDER BY itemid DESC LIMIT 0,6");
	
	while($tjws=$db->fetch_array($tjw)){
		 
		$hrent_list[]=$tjws;
	}
	
$adddate = timetodate($addtime, 3);
$editdate = timetodate($edittime, 3);
$todate = $totime ? timetodate($totime, 3) : 0;
$expired = $totime && $totime < $AJ_TIME ? true : false;
$fileurl = $linkurl;
$linkurl = $MOD['linkurl'].$linkurl;
$thumbs = get_albums($item);
$albums =  get_albums($item, 1);
$amount = number_format($amount, 0, '.', '');
$fee = get_fee($item['fee'], $MOD['fee_view']);
$user_status = 3;
$seo_file = 'show';
include AJ_ROOT.'/include/seo.inc.php';
$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : 'show');
$aijiacms_task = "moduleid=$moduleid&html=show&itemid=$itemid";
ob_start();
include template($template, $module);
$data = ob_get_contents();
ob_clean();
$filename = AJ_ROOT.'/'.$MOD['moduledir'].'/'.$fileurl;
if($AJ['pcharset']) $filename = convert($filename, AJ_CHARSET, $AJ['pcharset']);
file_put($filename, $data);
return true;
?>