<?php
define('AJ_REWRITE', true);
require '../config.inc.php';
require '../../common.inc.php';
$file = 'homepage';
require AJ_ROOT.'/module/'.$module.'/index.inc.php';
?>