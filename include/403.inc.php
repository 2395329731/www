<?php
defined('IN_AIJIACMS') or exit('Access Denied');
if($AJ_BOT) dhttp(403, $AJ_BOT);
$head_title = lang('message->without_permission');
exit(include template('noright', 'message'));
?>