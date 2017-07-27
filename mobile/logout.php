<?php
require 'common.inc.php';
if($_userid) set_cookie('auth', '');
dheader('my.php?reload='.$AJ_TIME);
?>