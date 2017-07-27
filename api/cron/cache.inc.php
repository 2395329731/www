<?php
defined('IN_AIJIACMS') or exit('Access Denied');
if($CFG['cache'] == 'file') $dc->expire();
?>