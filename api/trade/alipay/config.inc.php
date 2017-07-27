<?php
/*
	[Aijiacms System] Copyright (c) 2011-2015 www.aijiacms.com
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_AIJIACMS') or exit('Access Denied');
$api = $AJ['trade_tp'] ? 2 : 1;
$aliapy_config['partner']      = $AJ['trade_id'];
$aliapy_config['key']          = $AJ['trade_pw'];
$aliapy_config['seller_email'] = $AJ['trade_ac'];
$aliapy_config['return_url']   = AJ_PATH.'api/trade/alipay/'.$api.'/return.php';
$aliapy_config['notify_url']   = AJ_PATH.'api/trade/alipay/'.$api.'/'.($AJ['trade_nu'] ? $AJ['trade_nu'] : 'notify.php');
$aliapy_config['sign_type']    = 'MD5';
$aliapy_config['input_charset']= strtolower(AJ_CHARSET);
$aliapy_config['transport']    = 'http';
?>