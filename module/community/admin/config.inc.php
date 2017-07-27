<?php
defined('IN_AIJIACMS') or exit('Access Denied');
$MCFG['module'] = 'community';
$MCFG['name'] = '小区';
$MCFG['author'] = 'aijiacms.com';
$MCFG['homepage'] = 'www.aijiacms.com';
$MCFG['copy'] = false;
$MCFG['uninstall'] = true;
$MCFG['moduleid'] = 18;

$RT = array();
$RT['file']['index'] = '小区管理';
$RT['file']['html'] = '更新网页';

$RT['action']['index']['add'] = '添加小区';
$RT['action']['index']['edit'] = '修改小区';
$RT['action']['index']['delete'] = '删除小区';
$RT['action']['index']['check'] = '审核小区';
$RT['action']['index']['expire'] = '过期小区';
$RT['action']['index']['reject'] = '未通过小区';
$RT['action']['index']['recycle'] = '回收站';
$RT['action']['index']['move'] = '移动小区';
$RT['action']['index']['level'] = '信息级别';

$CT = 1;
?>