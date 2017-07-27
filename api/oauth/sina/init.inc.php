<?php
defined('IN_AIJIACMS') or exit('Access Denied');
$OAUTH = cache_read('oauth.php');
$site = 'sina';
$OAUTH[$site]['enable'] or dheader($MODULE[2]['linkurl'].$AJ['file_login']);
$session = new dsession();
define("WB_AKEY", $OAUTH[$site]['id']);
define("WB_SKEY", $OAUTH[$site]['key']);
define("WB_CALLBACK_URL", AJ_PATH.'api/oauth/'.$site.'/callback.php');
require AJ_ROOT.'/api/oauth/'.$site.'/saetv2.ex.class.php';
?>