<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
$MTYPE = get_type('product-'.$_userid);
require AJ_ROOT.'/include/post.func.php';
include load($module.'.lang');
include load('my.lang');
require AJ_ROOT.'/module/rent/rent.class.php';
$do = new rent($moduleid);
$MOD = cache_read('module-7.php');
//require MD_ROOT.'/rent.class.php';
$action = $_REQUEST['action'];

$user = userinfo($_username);
$sql = $_userid ? "username='$_username'" : "ip='$AJ_IP'";
if($action == 'save') {
	
		    $credit = intval($_POST['buy_day'])*$MOD['credit_hot'];
			credit_add($_username, -$credit);
			credit_record($_username, -$credit, 'system', '租房置顶', $post['title']);
			//foreach($itemid as $v) {
			$itemid=$_POST['itemid'];
			$to_time = $_POST['buy_day']*86400+$AJ_TIME;
			$do->renttop($itemid,$to_time);
		//}	
			
			dalert('置顶成功', $forward);
}
else
{}
	
include template(renttop, $module);
?>