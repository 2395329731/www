<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
if($AJ_BOT || $_POST) dhttp(403);
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
if(!check_group($_groupid, $MOD['group_search'])) include load('403.inc');
require AJ_ROOT.'/include/post.func.php';
include load('search.lang');
$MS = cache_read('module-2.php');
$modes = explode('|', $L['choose'].'|'.$MS['com_mode']);
$types = explode('|', $L['choose'].'|'.$MS['com_type']);
$sizes = explode('|', $L['choose'].'|'.$MS['com_size']);
$vips = array($L['vip_level'], VIP, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
$thumb = isset($thumb) ? intval($thumb) : 0;
//$vip = isset($vip) ? intval($vip) : 0;
$mincapital = isset($mincapital) ? dround($mincapital) : '';
$mincapital or $mincapital = '';
$maxcapital = isset($maxcapital) ? dround($maxcapital) : '';
$maxcapital or $maxcapital = '';
if(!$areaid && $cityid && strpos($AJ_URL, 'areaid') === false) {
	$areaid = $cityid;
	$ARE = $AREA[$cityid];
}
isset($mode) && isset($modes[$mode]) or $mode = 0;
isset($type) && isset($types[$type]) or $type = 0;
isset($size) && isset($sizes[$size]) or $size = 0;
isset($vip) && isset($vips[$vip]) or $vip = 0;
$category_select = ajax_category_select('catid', $L['all_category'], $catid, $moduleid);
$area_select = ajax_area_select('areaid', $L['all_area'], $areaid);
$mode_select = dselect($modes, 'mode', '', $mode);
$type_select = dselect($types, 'type', '', $type);
$size_select = dselect($sizes, 'size', '', $size);
$vip_select = dselect($vips, 'vip', '', $vip);
$tags = array();
if($AJ_QST) {
	if($kw) {
		if(strlen($kw) < $AJ['min_kw'] || strlen($kw) > $AJ['max_kw']) message(lang($L['word_limit'], array($AJ['min_kw'], $AJ['max_kw'])), $MOD['linkurl'].'search.php');
		if($AJ['search_limit'] && $page == 1) {
			if(($AJ_TIME - $AJ['search_limit']) < get_cookie('last_search')) message(lang($L['time_limit'], array($AJ['search_limit'])), $MOD['linkurl'].'search.php');
			set_cookie('last_search', $AJ_TIME);
		}
	}
	$fds = $MOD['fields'];
	$condition = "groupid>5 AND catids<>''";
	if($keyword) $condition .= " AND keyword LIKE '%$keyword%'";
	if($mode) $condition .= " AND mode LIKE '%$modes[$mode]%'";
	if($type) $condition .= " AND type='$types[$type]'";
	if($size) $condition .= " AND size='$sizes[$size]'";
	if($catid) $condition .= " AND catids LIKE '%,".$catid.",%'";
	if($areaid) $condition .= ($ARE['child']) ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
	if($thumb) $condition .= " AND thumb<>''";
	if($vip) $condition .= $vip == 1 ? " AND vip>0" : " AND vip=$vip-1";
	if($mincapital)  $condition .= " AND capital>$mincapital";
	if($maxcapital)  $condition .= " AND capital<$maxcapital";
	$pagesize = $MOD['pagesize'];
	$offset = ($page-1)*$pagesize;
	$items = $db->count($table, $condition, $AJ['cache_search']);
	$pages = pages($items, $page, $pagesize);
	if($items) {
		$order = $MOD['order'] ? " ORDER BY ".$MOD['order'] : '';
		$result = $db->query("SELECT $fds FROM {$table} WHERE {$condition}{$order} LIMIT {$offset},{$pagesize}", $AJ['cache_search'] && $page == 1 ? 'CACHE' : '', $AJ['cache_search']);
		if($kw) {
			$replacef = explode(' ', $kw);
			$replacet = array_map('highlight', $replacef);
		}
		while($r = $db->fetch_array($result)) {
			if($lazy && isset($r['thumb']) && $r['thumb']) $r['thumb'] = AJ_SKIN.'image/lazy.gif" original="'.$r['thumb'];
			if($kw) $r['company'] = str_replace($replacef, $replacet, $r['company']);
			$tags[] = $r;
		}
		$db->free_result($result);
		if($page == 1 && $kw) keyword($kw, $items, $moduleid);
	}
}
$showpage = 1;
$seo_file = 'search';
include AJ_ROOT.'/include/seo.inc.php';
if($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'].($kw ? 'index.php?moduleid='.$moduleid.'&kw='.encrypt($kw, AJ_KEY.'KW') : 'search.php?action=mod'.$moduleid);
include template('search', $module);
?>