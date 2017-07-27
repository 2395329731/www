<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
$table = $AJ_PRE.'member';
$url = "file=$file";
$condition = "companyid='$userid' AND groupid !=4";

$demo_url = userurl($username, $url.'&page={aijiacms_page}', $domain);
$pagesize =intval($menu_num[$menuid]);
if(!$pagesize || $pagesize > 100) $pagesize = 33;
$offset = ($page-1)*$pagesize;
$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $condition", 'CACHE');
$items = $r['num'];
$itemsale = $db->count($table, $condition, $CFG['db_expires']);
$pages = home_pages($items, $pagesize, $demo_url, $page);
$lists = array();
if($items) {
	$result = $db->query("SELECT * FROM {$table} WHERE $condition ORDER BY userid DESC LIMIT $offset,$pagesize");
while($r = $db->fetch_array($result)) {
       
		$r['alt'] = $r['title'];
		$title= $r['title'];
		
		
		$r['title'] = set_style($r['title'], $r['style']);
		$lists[] = $r;
	}
	$db->free_result($result);
}
include template('agency', $template);


?>