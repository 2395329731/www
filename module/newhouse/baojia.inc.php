<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
$head_title = '今日报价-'.$head_title.$AJ['seo_delimiter'].$MOD['name'];
$head_keywords =  '今日报价-'.$head_title.$AJ['seo_delimiter'].$MOD['name'];
$head_description =  '今日报价-'.$head_title.$AJ['seo_delimiter'].$MOD['name'];
include template('baojia', $module);
?>