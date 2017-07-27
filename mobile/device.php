<?php
require 'common.inc.php';
set_cookie('mobile', 'pc', $AJ_TIME + 30*86400);
$foot = '';
$head_title = $L['device_title'].$AJ['seo_delimiter'].$head_title;
include template('device', 'mobile');
if(AJ_CHARSET != 'UTF-8') toutf8();
?>