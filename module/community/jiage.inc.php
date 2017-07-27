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
checkdomain();
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
    $one = $db->get_one("select sum( t.price/t.houseearm ) as sum_p,count(*) as sum_c from $hsall as t  where  price <>'' and houseearm <>''and  {$condition}  ");
   $paa= intval($one['sum_p']*10000/$one['sum_c']);
   
    $pb= mktime(0,0,0,date('m')-1,date('d'),date('Y'));
   $lb=date("m",$pb);
    $two = $db->get_one("select sum( t.price/t.houseearm ) as sum_p,count(*) as sum_c from $hsall as t where  addtime >=$pb and  price <>'' and houseearm <>''and {$condition}");
   $pab= intval($two['sum_p']*10000/$two['sum_c']);
   $percent_change = round(($paa-$pab)/$pab*100,2);
 
   
   //同区域楼盘  10条记录
$hsall=$db->pre.'sale_5';
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

$adddate = timetodate($addtime, 3);
$editdate = timetodate($edittime, 3);
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
		$AIJIACMS_task = "moduleid=$moduleid&html=jiage&itemid=$itemid";
	} else {
		$user_status = 3;
		$member = $item['username'] ? userinfo($item['username']) : array();
		if($item['totime'] && $item['totime'] < $AJ_TIME && $item['status'] == 3) {
			$update .= ",status=4";
			$db->query("UPDATE {$table}_search SET status=4 WHERE itemid=$itemid");
		}
		if($member) {
			foreach(array('groupid', 'vip','validated','company','truename','mobile','qq','msn','ali','skype') as $v) {
				if($item[$v] != $member[$v]) $update .= ",$v='".addslashes($member[$v])."'";
			}
			if($item['email'] != $member['mail']) $update .= ",email='$member[mail]'";
		}
	}
} else {
	$user_status = $_userid ? 1 : 0;
	if($_username && $item['username'] == $_username) {
		$member = userinfo($item['username']);
		$user_status = 3;
	}
}
include AJ_ROOT.'/include/update.inc.php';
$seo_file = 'show';
include AJ_ROOT.'/include/seo.inc.php';
$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : 'jiage');
include template($template, $module);
?>