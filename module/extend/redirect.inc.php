<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
$url = isset($url) ? fix_link($url) : AJ_PATH;
if(isset($username)) {
	if(check_name($username)) {
		$r = $db->get_one("SELECT linkurl FROM {$AJ_PRE}company WHERE username='$username'");
		$url = $r ? $r['linkurl'] : userurl($username);
	}
} else if(isset($aid)) {
	$aid = intval($aid);
	if($aid) {
		$r = $db->get_one("SELECT url,key_moduleid,key_id,typeid FROM {$AJ_PRE}ad WHERE aid=$aid AND fromtime<$AJ_TIME AND totime>$AJ_TIME");
		if($r) {
			$url = ($r['key_moduleid'] && $r['typeid'] > 5) ? 'redirect.php?mid='.$r['key_moduleid'].'&itemid='.$r['key_id'] : $r['url'];
			$db->query("UPDATE {$AJ_PRE}ad SET hits=hits+1 WHERE aid=$aid");
		}
	}
} else if($mid) {
	if(isset($MODULE[$mid]) && $itemid) {
		if($mid == 2) $mid = 4;
		$condition = $mid == 4 ? "userid=$itemid" : "itemid=$itemid";
		$r = $db->get_one("SELECT linkurl FROM ".get_table($mid)." WHERE $condition");
		if($r) {
			$url = strpos($r['linkurl'], '://') === false ? $MODULE[$mid]['linkurl'].$r['linkurl'] : $r['linkurl'];
		}
	}
	if($mid == -9 && $itemid) $url = $MODULE[9]['linkurl'].rewrite('resume.php?itemid='.$itemid);
} else {
	check_referer() or $url = AJ_PATH;
}
dheader($url);
?>