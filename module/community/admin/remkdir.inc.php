<?php
defined('IN_AIJIACMS') or exit('Access Denied');
file_copy(AJ_ROOT.'/api/ajax.php', AJ_ROOT.'/'.$dir.'/ajax.php');
install_file('index', $dir, 1);
install_file('list', $dir, 1);
install_file('show', $dir, 1);
install_file('search', $dir, 1);
install_file('compare', $dir, 0);
install_file('inquiry', $dir, 1);
install_file('order', $dir, 1);
?>