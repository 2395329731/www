<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/extend/common.inc.php';
require AJ_ROOT.'/include/post.func.php';

    $r = $db->get_one("SELECT sid FROM {$AJ_PRE}pinfen WHERE moduleid=6 AND itemid=2");
			$price_voter = $_POST['doscr'];
			$itemid=$_POST['itemid'];
			//$price_voter=20;
		
				$db->query("INSERT INTO aijiacms_pinfen (moduleid,itemid,price_voter) VALUES ('6','$itemid','$price_voter')");
			$price_score=$r['price_voter'];
			echo $price_score;
	
?>