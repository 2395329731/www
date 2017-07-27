<?php
defined('IN_AIJIACMS') or exit('Access Denied');
dheader(AJ_PATH.'api/pay/weixin/qrcode.php?auth='.encrypt($orderid.'|'.$charge_title.'|'.$AJ_IP, AJ_KEY.'QRPAY'));
?>