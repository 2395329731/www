<?php
defined('IN_AIJIACMS') or exit('Access Denied');
if(strlen($captcha) < 4) exit('1');
$session = new dsession();
if(!isset($_SESSION['captchastr'])) exit('2');
$captcha = convert($captcha, 'UTF-8', AJ_CHARSET);
if($_SESSION['captchastr'] != md5(md5(strtoupper($captcha).AJ_KEY.$AJ_IP))) exit('3');
exit('0');
?>