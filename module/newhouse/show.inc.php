<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
$itemid or dheader($MOD['linkurl']);
if(!check_group($_groupid, $MOD['group_show'])) include load('403.inc');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
if($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'].mobileurl($moduleid, 0, $itemid, $page);
$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");
if($item && $item['status'] > 2) {
	if($MOD['show_html'] && is_file(AJ_ROOT.'/'.$MOD['moduledir'].'/'.$item['linkurl'])) d301($MOD['linkurl'].$item['linkurl']);
	extract($item);
} else {
	include load('404.inc');
}
$CAT = get_cat($catid);
if(!check_group($_groupid, $MOD['group_show']) || !check_group($_groupid, $CAT['group_show'])) {
	$head_title = lang('message->without_permission');
	exit(include template('noright', 'message'));
}
verify();
$content_table = content_table($moduleid, $itemid, $MOD['split'], $table_data);
$t = $db->get_one("SELECT content FROM {$content_table} WHERE itemid=$itemid");
$content = $t['content'];
if($MOD['keylink']) $content = keylink($content, $moduleid);
$CP = $MOD['cat_property'] && $CAT['property'];
if($CP) {
	//require AJ_ROOT.'/include/property.func.php';
	//$options = property_option($catid);
	//$values = property_value($moduleid, $itemid);
}
//历史价格图


$buynum = $db->get_one("SELECT COUNT(*) AS num FROM {$AJ_PRE}message WHERE title='$title' AND typeid=1 AND status=3");
$buynum = $buynum['num'];

//意向登记
$message=$db->pre.'message';

		$result = $db->query("SELECT * FROM $message  where title='$title'and typeid=1 LIMIT 0,6");
	
		while($r = $db->fetch_array($result)) {
			$r['adddate'] = timetodate($r['addtime'], $L['message_list_date']);
			
		     
			$messages[] = $r;
		}

	//相册图楼盘  10条记录
$a=$db->pre.'photo_12';
$b=$db->pre.'photo_item_12';
$pagesize =8;
if($at=='huxing' && empty($catids)) $catids=24;
$cat=get_cat($catids);
if($catids) $condition .= $cat['child'] ? " AND catid IN (".$cat['arrchildid'].")" : " AND a.catid=$catids";
if($at!='huxing' && empty($catids))$condition .=	"AND a.catid!=24";
$r = $db->get_one("SELECT COUNT(*) AS num FROM $a a  LEFT JOIN $b b  ON b.item = a.itemid   where a.houseid=$itemid {$condition} ");  	
$picitems = $r['num'];
if(!$pagesize || $pagesize > 100) $pagesize = 30;
	$offset = ($page-1)*$pagesize;
	$pages = pages($r['num'], $page, $pagesize);
$tjw=$db->query("SELECT  a.itemid, houseid,linkurl,addtime,title,b.item,b.itemid,b.thumb,b.introduce ,b.mianji FROM $a a  LEFT JOIN $b b  ON b.item = a.itemid   where a.houseid=$itemid  {$condition} ORDER BY b.itemid desc LIMIT $offset,$pagesize");

 while($tjws=$db->fetch_array($tjw)){
 $tjws['title'] = $tjws['introduce'];
$tjws['linkurl'] = $MODULE[12][linkurl].$tjws['linkurl'];
	$pic_lists[]=$tjws;
		 }

$adddate = timetodate($addtime, 3);
$editdate = timetodate($edittime, 3);
//$selltime = timetodate($selltime, 3);
//$completion = timetodate($completion, 3);

$pricea=$price-500;
$priceb=$price+500;
$itype = explode('|', trim($MOD['inquiry_type']));
$iask = explode('|', trim($MOD['inquiry_ask']));
$todate = $totime ? timetodate($totime, 3) : 0;
$expired = $totime && $totime < $AJ_TIME ? true : false;
$linkurl = $MOD['linkurl'].$linkurl;
$thumbs = get_albums($item);
$albums =  get_albums($item, 1);
$amount = number_format($amount, 0, '.', '');
$fee = get_fee($item['fee'], $MOD['fee_view']);
if($map){
$map_mid = $map;
}else{
$map_mid=$map_mid ;}
$map=explode(",",$map_mid);
		foreach($map as $key =>$value){
		  $x =$map['0'];
		   $y=$map['1']; 
		   }
		  
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
$user = array();
if($_userid) {

	$user = userinfo($_username);
	//$company = $user['company'];
	$truename = $user['truename'];
	$telephones = $user['telephone'] ? $user['telephone'] : $user['mobile'];
	$email = $user['mail'] ? $user['mail'] : $user['email'];
	$qq = $user['qq'];
	$msn = $user['msn'];
}

$urlToEncode=$EXT[wap_url].'index.php?moduleid='.$moduleid.'&itemid='.$itemid;
switch($at) {
	case 'xiangce':
	$head_title = $title.'-楼盘相册';
	
	$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : 'xiangce');
	break;
	case 'jiage':
	$head_title = $title.'-楼盘价格走势';
	$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : 'jiage');
	break;
	case 'huxing':
	$head_title = $title.'-楼盘户型';
	$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : 'huxing');
	break;
	case 'zixun':
		//资讯  10条记录
$article=$db->pre.'article_8';
  $pagesize =10;
	if(!$pagesize || $pagesize > 100) $pagesize = 30;
	$offset = ($page-1)*$pagesize;
	$r = $db->get_one("SELECT COUNT(*) AS num FROM $article   WHERE  houseid = $itemid");
	$items = $r['num'];
	$pages = pages($r['num'], $page, $pagesize);


	$tjw =$db->query("SELECT * FROM  $article WHERE houseid=$itemid ORDER BY itemid DESC LIMIT $offset,$pagesize");
	
	while($tjws=$db->fetch_array($tjw)){
	$quyu = $tjws['houseid'];
		 $tjws['linkurl'] = $MODULE[8][linkurl].$tjws['linkurl'];
		 $qynames = $db->query("SELECT * FROM {$table} WHERE itemid=$quyu");
		 $qyname = $db->fetch_array($qynames);
		 $diqu=$qyname['title'];
		 $tjws[quyu]=$diqu;
	
		$new_lists[]=$tjws;	
	}

	$head_title = $title.'-楼盘动态';
	$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : 'zixun');
	break;
	
	case 'peitao':
	$head_title = $title.'-地图交通';
	$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : 'peitao');
	break;
	case 'dianping':
	$head_title = $title.'-楼盘点评';
	$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : 'dianping');
	break;
	case 'wenfang':
	$head_title = $title.'-楼盘问答';
	$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : 'wenfang');
	break;
	case 'xinxi':
	$head_title = $title.'-楼盘详细信息';
	$typeids=$typeid-1;
	$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : 'xinxi');
	break;
	default:
	$at='index';
	$seo_file = 'show';
	include AJ_ROOT.'/include/seo.inc.php';
	include AJ_ROOT.'/include/update.inc.php';
	
    $template = 'show';
    if($MOD['template_show']) $template = $MOD['template_show'];
   if($CAT['show_template']) $template = $CAT['show_template'];
   if($item['template']) $template = $item['template'];
    break;
}

include template($template, $module);
?>