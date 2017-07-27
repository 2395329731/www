<?php
require 'common.inc.php';
isset($auth) or $auth = '';
$addr = $auth ? decrypt($auth, AJ_KEY.'MAP') : '';
include AJ_ROOT.'/api/map/baidu/config.inc.php';
$map_key or $map_key = 'waKl9cxyGpfdPbon7PXtDXIf';
$head_title = $L['map_title'].$AJ['seo_delimiter'].$head_title;
$foot = '';
include template('map', 'mobile');
if(AJ_CHARSET != 'UTF-8') toutf8();
?>