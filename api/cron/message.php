<?php
defined('IN_AIJIACMS') or exit('Access Denied');
$condition = 'isread=0 AND issend=0 AND status=3';
if($AJ['message_time']) {
	$time = $AJ_TIME - $AJ['message_time']*60;
	$condition .= " AND addtime<$time";
}
if($AJ['message_type']) $condition .= " AND typeid IN ($AJ[message_type])";
$msg = $db->get_one("SELECT * FROM {$AJ_PRE}message WHERE $condition ORDER BY itemid ASC");
if($msg) {
	$db->query("UPDATE {$AJ_PRE}message SET issend=1 WHERE itemid=$msg[itemid]");
	$user = $db->get_one("SELECT groupid,email,send FROM {$AJ_PRE}member WHERE username='$msg[touser]'");
	if($user) {
		if($user['send']) {
			if(check_group($user['groupid'], $AJ['message_group'])) {
				extract($msg);
				$NAME = $L['message_type'];
				$member_url = $MODULE[2]['linkurl'];
				$content = ob_template('message', 'mail');
				send_mail($user['email'], '['.$NAME[$typeid].']'.$title, $content);
				if($AJ['message_weixin']) send_weixin($msg['touser'], $title.$L['message_weixin']);
			}
		}
	}
}
?>