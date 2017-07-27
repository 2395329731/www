<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
$r = $db->get_one("SELECT linkurl FROM {$table} WHERE vip>0 ORDER BY rand()");
$url = $r ? $r['linkurl'] : $MOD['linkurl'];
dheader($url);
?>