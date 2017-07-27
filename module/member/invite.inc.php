<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
$reason = $L['invite_title'];
$userurl = '';
if(isset($user) && check_name($user)) {
	$c = $db->get_one("SELECT linkurl,username FROM {$AJ_PRE}company WHERE username='$user'");
	if($c) {
		$userurl = $c['linkurl'];
		$user = $username = $c['username'];
		$could_credit = true;
		if($MOD['credit_ip'] <= 0) $could_credit = false;
		if($could_credit) {
			$r = $db->get_one("SELECT itemid FROM {$AJ_PRE}finance_credit WHERE note='$AJ_IP' AND addtime>$AJ_TIME-86400");
			if($r) $could_credit = false;
		}
		if($could_credit && $MOD['credit_maxip'] > 0) {
			$r = $db->get_one("SELECT SUM(amount) AS total FROM {$AJ_PRE}finance_credit WHERE username='$username' AND addtime>$AJ_TIME-86400 AND reason='$reason'");
			if($r['total'] > $MOD['credit_maxip']) $could_credit = false;
		}
		if($could_credit) {
			credit_add($username, $MOD['credit_ip']);
			credit_record($username, $MOD['credit_ip'], 'system', $reason, $AJ_IP);
			set_cookie('inviter', encrypt($username, AJ_KEY.'INVITER'), $AJ_TIME + 30*86400);
		}
	} else {
		dheader(AJ_PATH);
	}
} else {
	dheader(AJ_PATH);
}
$goto = isset($goto) ? trim($goto) : '';
$URI = AJ_PATH;
if($goto == 'register') {
	$URI = $MODULE[2]['linkurl'].$AJ['file_register'];
} else if($goto == 'homepage') {
	if($userurl) $URI = $userurl;
}
dheader($URI);
?>