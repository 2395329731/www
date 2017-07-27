<?php
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
require AJ_ROOT.'/include/post.func.php';
$this_month = date('n', $AJ_TIME);
$this_year  = date('Y', $AJ_TIME);
$next_month = $this_month == 12 ? 1 : $this_month + 1;
$next_year  = $this_month == 12 ? $this_year + 1 : $this_year;
$next_time = strtotime($next_year.'-'.$next_month.'-1');
$spread_max = $MOD['spread_max'] ? $MOD['spread_max'] : 10;
$currency = $MOD['spread_currency'];
$unit = $currency == 'money' ? $AJ['money_unit'] : $AJ['credit_unit'];
if($action == 'list') {
	if($MOD['spread_list'] && $kw && in_array($mid, array(4, 5, 6))) {
		$condition = "mid=$mid AND status=3 AND word='$kw'";
		$r = $db->get_one("SELECT COUNT(*) AS num FROM {$AJ_PRE}spread WHERE $condition");
		$pages = pages($r['num'], $page, $pagesize);
		$i = $j = 0;
		$lists = array();
		$result = $db->query("SELECT DATE_FORMAT(FROM_UNIXTIME(fromtime),'%Y%m') as id,itemid,mid,tid,word,price,currency,company,username,addtime,fromtime,totime FROM {$AJ_PRE}spread WHERE $condition ORDER BY id DESC,price DESC,itemid DESC LIMIT $offset,$pagesize");
		while($r = $db->fetch_array($result)) {
			//print_r($r);exit;
			if($r['totime'] < $AJ_TIME) {
				$r['process'] = $L['status_expired'];
			} else if($r['fromtime'] > $AJ_TIME) {
				$r['process'] = $L['status_not_start'];
			} else {
				$r['process'] = $L['status_displaying'];
			}
			//$r['key'] = timetodate($r['fromtime'], 'Ym');
			if($j == 0) $i = $r['id'];
			$r['bg'] = $i == $r['id'] ? 0 : 1;
			if($i != $r['id']) $i = $r['id'];
			$j++;
			$lists[] = $r;
		}
		$head_title = $kw.$AJ['seo_delimiter'].$MODULE[$mid]['name'].$AJ['seo_delimiter'].$L['spread_title'];
		include template('spread', $module);
	} else {
		dheader('./');
	}
} else {
	$head_title = $L['spread_title'];
	if($kw) {
		$ukw = urlencode($kw);
		$p = $db->get_one("SELECT * FROM {$AJ_PRE}spread_price WHERE word='$kw'");
		if($p) {
			$sell_price = $p['sell_price'] ? $p['sell_price'] : $MOD['spread_sell_price'];
			$newhouse_price = $p['newhouse_price'] ? $p['newhouse_price'] : $MOD['spread_newhouse_price'];
			$rent_price = $p['rent_price'] ? $p['rent_price'] : $MOD['spread_rent_price'];
			$buy_price = $p['buy_price'] ? $p['buy_price'] : $MOD['spread_buy_price'];
			$company_price = $p['company_price'] ? $p['company_price'] : $MOD['spread_company_price'];
		} else {
			$sell_price = $MOD['spread_sell_price'];
			$newhouse_price = $MOD['spread_newhouse_price'];
			$rent_price = $MOD['spread_rent_price'];
			$buy_price = $MOD['spread_buy_price'];
			$company_price = $MOD['spread_company_price'];
		}
		$head_title = $kw.$AJ['seo_delimiter'].$head_title;
		$sell_record = array();
		$result = $db->query("SELECT * FROM {$AJ_PRE}spread WHERE mid=5 AND status=3 AND word='$kw' AND fromtime>=$next_time ORDER BY price DESC,itemid ASC");
		while($r = $db->fetch_array($result)) {
			$sell_record[] = $r;
		}
		$sell_count = count($sell_record);

		$buy_record = array();
		$result = $db->query("SELECT * FROM {$AJ_PRE}spread WHERE mid=16 AND status=3 AND word='$kw' AND fromtime>=$next_time ORDER BY price DESC,itemid ASC");
		while($r = $db->fetch_array($result)) {
			$buy_record[] = $r;
		}
		$buy_count = count($buy_record);
         $newhouse_record = array();
		$result = $db->query("SELECT * FROM {$AJ_PRE}spread WHERE mid=6 AND status=3 AND word='$kw' AND fromtime>=$next_time ORDER BY price DESC,itemid ASC");
		while($r = $db->fetch_array($result)) {
			$newhouse_record[] = $r;
		}
		$newhouse_count = count($newhouse_record);
		
		$rent_record = array();
		$result = $db->query("SELECT * FROM {$AJ_PRE}spread WHERE mid=7 AND status=3 AND word='$kw' AND fromtime>=$next_time ORDER BY price DESC,itemid ASC");
		while($r = $db->fetch_array($result)) {
			$rent_record[] = $r;
		}
		$rent_count = count($rent_record);
		$company_record = array();
		$result = $db->query("SELECT * FROM {$AJ_PRE}spread WHERE mid=4 AND status=3 AND word='$kw' AND fromtime>=$next_time ORDER BY price DESC,itemid ASC");
		while($r = $db->fetch_array($result)) {
			$company_record[] = $r;
		}
		$company_count = count($company_record);
	}	
	$item = $db->get_one("SELECT itemid FROM {$AJ_PRE}spread ORDER BY rand()");
	$aijiacms_task = "moduleid=$moduleid&html=spread&itemid=$item[itemid]";
	include template('spread', $module);
}
?>