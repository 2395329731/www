<?php
/*
	[aijiacms System] Copyright (c) 2008-2011 aijiacms.com
	This is NOT a freeware, use is subject to license.txt
*/
define('AJ_NONUSER', true);
require 'common.inc.php';
$URL = AJ_PATH;
if($moduleid > 3 && !$MODULE[$moduleid]['islink']) {
	if($kw) {
		$qstr = str_replace('moduleid='.$moduleid.'&', '', $_SERVER['QUERY_STRING']);
		$qstr = str_replace('moduleid='.$moduleid, '', $qstr);
		$spread = isset($spread) ? intval($spread) : 0;
		if($spread) {
			$r = $db->get_one("SELECT tid FROM {$AJ_PRE}spread WHERE mid=$moduleid AND word='$kw' AND fromtime<$AJ_TIME AND totime>$AJ_TIME ORDER BY price DESC,itemid ASC");
			if($r) {
				$id = $moduleid == 4 ? 'userid' : 'itemid';
				$t = $db->get_one("SELECT linkurl FROM ".get_table($moduleid)." WHERE `{$id}`=$r[tid]");
				if($t) dheader(strpos($t['linkurl'], '://') !== false ? $t['linkurl'] : $MOD['linkurl'].$t['linkurl']);
			}
			dheader($EXT['spread_url'].rewrite('index.php?kw='.urlencode($kw)));
		} else {
			$qstr = str_replace('spread=0', '', $qstr);
		}
		if($qstr) {
			if(substr($qstr, 0, 1) == '&') $qstr = substr($qstr, 1);
			$URL = $MOD['linkurl'].'search.php?'.$qstr;
		} else {
			$URL = $MOD['linkurl'].'search.php';
		}
	} else {
		$URL = $MOD['linkurl'].'search.php';
	}
}
dheader($URL);
?>