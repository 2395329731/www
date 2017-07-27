<?php
require 'common.inc.php';
$head_title = $L['channel_title'].$AJ['seo_delimiter'].$head_title;
$foot = 'channel';
include template('channel', 'mobile');
if(AJ_CHARSET != 'UTF-8') toutf8();
?>