<?php
define('AJ_REWRITE', true);
require '../common.inc.php';
login();
$head_title = '已赚取的佣金--分销平台';

$_status = array('未结算', '<span style="color:red;">已结算</span>');
		
		if($page > 1 && $sum) {
			$items = $sum;
		} else {
			$r = $db->get_one("SELECT COUNT(*) AS num FROM {$AJ_PRE}finance_amount WHERE username='$_username'");
			$items = $r['num'];
		}
		$pages = pages($items, $page, $pagesize);
		$asks = array();
		$result = $db->query("SELECT * FROM {$AJ_PRE}finance_amount WHERE username='$_username' ORDER BY itemid DESC LIMIT $offset,$pagesize");
		while($r = $db->fetch_array($result)) {
			
			$r['dstatus'] = $_status[$r['status']];
		
			$amount[] = $r;
		}
		if($_userid) {
	$nums = array();
	for($i = 0; $i < 2; $i++) {
		$r = $db->get_one("SELECT Sum(amount) AS amount FROM {$AJ_PRE}finance_amount WHERE username='$_username' AND status=$i");
		$nums[$i] = $r['amount'];
	}
	//$nums[0] = count($MTYPE);
}
		include template('amount', 'mobile');

	

?>