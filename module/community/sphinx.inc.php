<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
$tags = $ids = $_tags = $tbs = $PPT = array();//PPT
if($AJ_QST) {
	if($kw) {
		if(strlen($kw) < $AJ['min_kw'] || strlen($kw) > $AJ['max_kw']) message(lang($L['word_limit'], array($AJ['min_kw'], $AJ['max_kw'])), $MOD['linkurl'].'search.php');
		if($AJ['search_limit'] && $page == 1) {
			if(($AJ_TIME - $AJ['search_limit']) < get_cookie('last_search')) message(lang($L['time_limit'], array($AJ['search_limit'])), $MOD['linkurl'].'search.php');
			set_cookie('last_search', $AJ_TIME);
		}
		$replacef = explode(' ', $kw);
		$replacet = array_map('highlight', $replacef);
	}
	require AJ_ROOT.'/include/sphinx.class.php';
	$sx = new SphinxClient();
	if($MOD['sphinx_host'] && $MOD['sphinx_port']) $sx->SetServer($MOD['sphinx_host'], $MOD['sphinx_port']);
	$sx->SetArrayResult(true);
	$sx->SetMatchMode(SPH_MATCH_PHRASE);
	$sx->SetRankingMode(SPH_RANK_NONE);
	$sx->SetSortMode(SPH_SORT_EXTENDED, 'sorttime desc');
	$sx->SetFilter('status', array(3));
	if($catid) $sx->SetFilter('catid', explode(',', $CAT['arrchildid']));
	if($areaid) $sx->SetFilter('areaid', explode(',', $ARE['arrchildid']));
	$sx->SetLimits($offset, $pagesize);
	$_kw = convert($kw, AJ_CHARSET, 'utf-8');
	$r = $sx->Query($_kw, $MOD['sphinx_name']);
	$items = $r['total_found'];
	$time = $r['time'];
	$pages = pages($items, $page, $pagesize);
	foreach($r['matches'] as $k=>$v) {
		$ids[$v['id']] = $v['id'];
	}		
	if($ids) {
		$condition = "itemid IN (".implode(',', $ids).")";
		$result = $db->query("SELECT ".$MOD['fields']." FROM {$table} WHERE {$condition}");
		while($r = $db->fetch_array($result)) {
			$r['adddate'] = timetodate($r['addtime'], 5);
			$r['editdate'] = timetodate($r['edittime'], 5);
			$r['alt'] = $r['title'];
			$r['title'] = set_style($r['title'], $r['style']);
			if($kw) $r['title'] = str_replace($replacef, $replacet, $r['title']);
			if($kw) $r['introduce'] = str_replace($replacef, $replacet, $r['introduce']);
			$r['linkurl'] = $MOD['linkurl'].$r['linkurl'];
			$_tags[$r['itemid']] = $r;
		}
		$db->free_result($result);
		foreach($ids as $id) {
			$tags[] = $_tags[$id];
		}
		if($page == 1 && $kw) keyword($kw, $items, $moduleid);
	}
}
$showpage = 1;
$datetype = 5;
$seo_file = 'search';
include AJ_ROOT.'/include/seo.inc.php';
include template('search', $module);
?>