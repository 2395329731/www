<?php
/*
	 
	This is NOT a freeware, use is subject to license.txt
*/
require 'common.inc.php';
$table = $AJ_PRE.'announce';
if($itemid) {
	$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");
	$item or mobile_msg($L['msg_not_exist']);
	extract($item);	
	$content = video5($content);
	$adddate = timetodate($addtime, 3);
	if(!$islink) $db->query("UPDATE {$table} SET hits=hits+1 WHERE itemid=$itemid");
	$back_link = 'announce.php';
	$foot = '';
	$head_title = $title.$AJ['seo_delimiter'].$L['announce_title'].$AJ['seo_delimiter'].$head_title;
} else {
	$lists = array();
	$result = $db->query("SELECT * FROM {$table} WHERE totime=0 OR totime>$AJ_TIME ORDER BY listorder DESC,itemid DESC LIMIT 10");
	while($r = $db->fetch_array($result)) {
		$r['date'] = timetodate($r['addtime'], 3);
		$lists[] = $r;
	}
	$db->free_result($result);
	$back_link = 'more.php';
	$foot = 'more';
	$head_title = $L['announce_title'].$AJ['seo_delimiter'].$head_title;
}
include template('announce', 'mobile');
if(AJ_CHARSET != 'UTF-8') toutf8();
?>