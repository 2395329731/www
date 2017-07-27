<?php
defined('IN_AIJIACMS') or exit('Access Denied');
$area_title = convert($area_title, 'UTF-8', AJ_CHARSET);
$area_extend = isset($area_extend) ? decrypt($area_extend, AJ_KEY.'ARE') : '';
$areaid = isset($areaid) ? intval($areaid) : 0;
$area_deep = isset($area_deep) ? intval($area_deep) : 0;
$area_id= isset($area_id) ? intval($area_id) : 1;
echo get_area_select($area_title, $areaid, $area_extend, $area_deep, $area_id);
?>