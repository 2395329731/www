<?php
/*
	[Aijiacms System] Copyright (c) 2011-2015 www.aijiacms.com
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_AIJIACMS') or exit('Access Denied');
$currency = $MOD['fee_currency'];
$fee_unit = $currency == 'money' ? $AJ['money_unit'] : $AJ['credit_unit'];
$fee_name = $currency == 'money' ? $AJ['money_name'] : $AJ['credit_name'];
if(check_group($_groupid, $MOD['group_show'])) {
	if($fee) {
		if($MG['fee_mode']) {
			$user_status = 3;
		} else {
			$mid = isset($resume) ? -$moduleid : $moduleid;
			if($_userid) {
				if(check_pay($mid, $itemid)) {
					$user_status = 3;
				} else {
					$user_status = 2;
				}
			} else {
				$user_status = 0;
			}
		}
	} else {
		$user_status = 3;
	}
} else {
	$user_status = $_userid ? 1 : 0;
}
if($_username && $_username == $item['username']) $user_status = 3;
?>