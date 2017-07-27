<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
$aijiacms_task = rand_task();
($mid > 3 && isset($MODULE[$mid]) && !$MODULE[$mid]['islink']) or $mid = 0;
$LETTER = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
$letter = isset($letter) ? strtolower($letter) : '';
in_array($letter, $LETTER) or $letter = '';
$head_title = $L['sitemap_title'];
if($mid) {
	$moduleid = $mid;
	$M = $MODULE[$mid];
	$head_title = $M['name'].$AJ['seo_delimiter'].$head_title;
	if($letter) {
		$action = 'letter';
		$CATALOG = array();
		$result = $db->query("SELECT * FROM {$AJ_PRE}category WHERE moduleid=$mid AND letter='$letter' ORDER BY listorder,catid ASC");
		while($r = $db->fetch_array($result)) {
			$CATALOG[] = $r;
		}
		$head_title = strtoupper($letter).$AJ['seo_delimiter'].$head_title;
	} else {
		$action = 'module';
	}
} else {
	$action = 'sitemap';
}
include template('sitemap', $module);
?>