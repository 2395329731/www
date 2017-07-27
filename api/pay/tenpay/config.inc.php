<?php
defined('IN_AIJIACMS') or exit('Access Denied');
$partner = trim($PAY[$bank]['partnerid']);
$key = trim($PAY[$bank]['keycode']);
$return_url = $receive_url;
$notify_url = AJ_PATH.'api/pay/'.$bank.'/'.($PAY[$bank]['notify'] ? $PAY[$bank]['notify'] : 'notify.php');
?>