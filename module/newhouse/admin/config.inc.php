<?php
defined('IN_AIJIACMS') or exit('Access Denied');
$MCFG['module'] = 'newhouse';
$MCFG['name'] = '新房';
$MCFG['author'] = 'aijiacms.com';
$MCFG['homepage'] = 'www.aijiacms.com';
$MCFG['copy'] = true;
$MCFG['uninstall'] = true;
$MCFG['moduleid'] = 0;

$RT = array();
$RT['file']['index'] = '新房管理';
$RT['file']['html'] = '更新网页';

$RT['action']['index']['add'] = '添加新房';
$RT['action']['index']['edit'] = '修改新房';
$RT['action']['index']['delete'] = '删除新房';
$RT['action']['index']['check'] = '审核新房';
$RT['action']['index']['expire'] = '过期新房';
$RT['action']['index']['reject'] = '未通过新房';
$RT['action']['index']['recycle'] = '回收站';
$RT['action']['index']['move'] = '移动新房';
$RT['action']['index']['level'] = '信息级别';

$CT = 1;
?>