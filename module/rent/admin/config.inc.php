<?php
defined('IN_AIJIACMS') or exit('Access Denied');
$MCFG['module'] = 'rent';
$MCFG['name'] = '出租';
$MCFG['author'] = 'aijiacms.com';
$MCFG['homepage'] = 'www.aijiacms.com';
$MCFG['copy'] = true;
$MCFG['uninstall'] = true;
$MCFG['moduleid'] = 0;

$RT = array();
$RT['file']['index'] = '出租管理';
$RT['file']['html'] = '更新网页';

$RT['action']['index']['add'] = '添加出租';
$RT['action']['index']['edit'] = '修改出租';
$RT['action']['index']['delete'] = '删除出租';
$RT['action']['index']['check'] = '审核出租';
$RT['action']['index']['expire'] = '过期出租';
$RT['action']['index']['reject'] = '未通过出租';
$RT['action']['index']['recycle'] = '回收站';
$RT['action']['index']['move'] = '移动出租';
$RT['action']['index']['level'] = '信息级别';

$CT = 1;
?>