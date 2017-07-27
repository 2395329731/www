<?php
defined('AJ_ADMIN') or exit('Access Denied');
file_copy(AJ_ROOT.'/api/ajax.php', AJ_ROOT.'/'.$dir.'/ajax.php');
install_file('index', $dir, 1);
install_file('list', $dir, 1);
install_file('show', $dir, 1);
install_file('search', $dir, 1);
install_file('private', $dir, 1);
install_file('view', $dir, 1);
?>