<?php
/*
	[Aijiacms System] Copyright (c) 2011-2015 www.aijiacms.com
	This is NOT a freeware, use is subject to license.txt
*/
defined('AJ_ADMIN') or exit('Access Denied');
$menus = array (
array('信息统计', '?file='.$file),
array('统计报表', '?file='.$file.'&action=stats'),
);
switch($action) {
	case 'js':
		$db->halt = 0;
		$today = strtotime(timetodate($AJ_TIME, 3).' 00:00:00');
		//

		$num = $db->count($AJ_PRE.'finance_charge', "status=0");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("charge").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($AJ_PRE.'finance_cash', "status=0");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("cash").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($AJ_PRE.'mall_order', "status=5");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("trade").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($AJ_PRE.'group_order', "status=4");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("group").innerHTML="'.$num.'";}catch(e){}';

		//待受理客服中心
		$num = $db->count($AJ_PRE.'ask', "status=0");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("ask").innerHTML="'.$num.'";}catch(e){}';

		


		$num = $db->count($AJ_PRE.'guestbook', "edittime=0");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("guestbook").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($AJ_PRE.'comment', "status=2");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("comment").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($AJ_PRE.'link', "status=2 AND username=''");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("link").innerHTML="'.$num.'";}catch(e){}';

		
		$num = $db->count($AJ_PRE.'news', "status=2");//待审核公司新闻
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("news").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($AJ_PRE.'honor', "status=2");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("honor").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($AJ_PRE.'link', "status=2 AND username<>''");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("comlink").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($AJ_PRE.'keyword', "status=2");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("keyword").innerHTML="'.$num.'";}catch(e){}';

		foreach(array('company', 'truename', 'mobile', 'email') as $v) {
			$num = $db->count($AJ_PRE.'validate', "type='$v' AND status=2");//待审核认证
			$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
			echo 'try{document.getElementById("v'.$v.'").innerHTML="'.$num.'";}catch(e){}';
		}

		$num = $db->count($AJ_PRE.'member_check', "1");//待审核资料修改
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("edit_check").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($AJ_PRE.'ad', "status=2");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("ad").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($AJ_PRE.'spread', "status=2");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("spread").innerHTML="'.$num.'";}catch(e){}'; 

		
		$num = $db->count($AJ_PRE.'quote_price', "status=2");//待审核报价
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("quote_price").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($AJ_PRE.'upgrade', "status=2");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("member_upgrade").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($AJ_PRE.'alert', "status=2");//待审核房源提醒
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("alert").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($AJ_PRE.'member');//会员
		echo 'try{document.getElementById("member").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($AJ_PRE.'company', "vip>0");//VIP会员
		echo 'try{document.getElementById("member_vip").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($AJ_PRE.'member', "groupid=4");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("member_check").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($AJ_PRE.'member', "regtime>$today");
		echo 'try{document.getElementById("member_new").innerHTML="'.$num.'";}catch(e){}';

		foreach($MODULE as $m) {
			if($m['moduleid'] < 5 || $m['islink']) continue;
			if($m['moduleid'] == 18) {$table = $AJ_PRE.'newhouse_6';}else
			{$table = get_table($m['moduleid']);}
			if($m['moduleid'] == 6) {
			//ALL
			$num = $db->count($table, 'isnew=1', 60);
			echo 'try{Dd("m_'.$m['moduleid'].'").innerHTML="'.$num.'";}catch(e){}';
			//PUB
			$num = $db->count($table, "isnew=1 and status=3", 60);
			echo 'try{Dd("m_'.$m['moduleid'].'_1").innerHTML="'.$num.'";}catch(e){}';
			//CHECK
			$num = $db->count($table, "isnew=1 and status=2", 60);
			$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
			echo 'try{Dd("m_'.$m['moduleid'].'_2").innerHTML="'.$num.'";}catch(e){}';
			//NEW
			$num = $db->count($table, "isnew=1 and addtime>$today", 30);
			echo 'try{Dd("m_'.$m['moduleid'].'_3").innerHTML="'.$num.'";}catch(e){}';
              }else
			  {
           //ALL
			$num = $db->count($table, '1');
			echo 'try{Dd("m_'.$m['moduleid'].'").innerHTML="'.$num.'";}catch(e){}';
			//PUB
			$num = $db->count($table, "status=3");
			echo 'try{Dd("m_'.$m['moduleid'].'_1").innerHTML="'.$num.'";}catch(e){}';
			//CHECK
			$num = $db->count($table, "status=2");
			$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
			echo 'try{Dd("m_'.$m['moduleid'].'_2").innerHTML="'.$num.'";}catch(e){}';
			//NEW
			$num = $db->count($table, "addtime>$today", 30);
			echo 'try{Dd("m_'.$m['moduleid'].'_3").innerHTML="'.$num.'";}catch(e){}';
			
			}
			
			

			if($m['moduleid'] == 9) {
				$table = $AJ_PRE.'resume';
				//ALL
				$num = $db->count($table, '1');
				echo 'try{Dd("m_resume").innerHTML="'.$num.'";}catch(e){}';
				//PUB
				$num = $db->count($table, "status=3");
				echo 'try{Dd("m_resume_1").innerHTML="'.$num.'";}catch(e){}';
				//CHECK
				$num = $db->count($table, "status=2");
				$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
				echo 'try{Dd("m_resume_2").innerHTML="'.$num.'";}catch(e){}';
				//NEW
				$num = $db->count($table, "addtime>$today", 30);
				echo 'try{Dd("m_resume_3").innerHTML="'.$num.'";}catch(e){}';
			}
		}
	break;
	case 'stats':
		$year = isset($year) ? intval($year) : date('Y', $AJ_TIME);
		$year or $year = date('Y', $AJ_TIME);
		$month = isset($month) ? intval($month) : 0;
		if($mid == 1 || $mid == 3) $mid = 0;
		if($mid == 4) $mid = 2;
		include tpl('count_stats');
	break;
	default:
		$year = isset($year) ? intval($year) : date('Y', $AJ_TIME);
		$year or $year = date('Y', $AJ_TIME);
		$month = isset($month) ? intval($month) : 0;
		if($mid == 1 || $mid == 3) $mid = 0;
		if($mid == 4) $mid = 2;
		include tpl('count');
	break;
}
?>