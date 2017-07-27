<?php
defined('AJ_ADMIN') or exit('Access Denied');
$MCFG['module'] = 'sale';
$MCFG['name'] = '出售';
$MCFG['author'] = 'aijiacms.com';
$MCFG['homepage'] = 'www.aijiacms.com';
$MCFG['copy'] = true;
$MCFG['uninstall'] = true;
$MCFG['moduleid'] = 0;

$RT = array();
$RT['file']['index'] = '出售管理';
$RT['file']['html'] = '更新网页';

$RT['action']['index']['add'] = '添加出售';
$RT['action']['index']['edit'] = '修改出售';
$RT['action']['index']['delete'] = '删除出售';
$RT['action']['index']['check'] = '审核出售';
$RT['action']['index']['expire'] = '过期出售';
$RT['action']['index']['reject'] = '未通过出售';
$RT['action']['index']['recycle'] = '回收站';
$RT['action']['index']['move'] = '移动出售';
$RT['action']['index']['level'] = '信息级别';

$CT = 1;
?>